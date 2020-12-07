<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Administration\Models\User;
use Zivot\Mongodb\Passport\Passport;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function unauthorized(){
        return response()->json([
            'status' => false,
            'message' => 'Must be logged to access this route.'
        ]);
    }

    /**
     * Login the user.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function login(Request $request){
        if($request->getMethod() == "POST"){
            $input = $request->all();
            $validator = $this->validator($input);

            if($validator->fails()){
                $error = $validator->messages()->get('*');
                return response()->json([
                    'status' => false,
                    'message' => $error
                ]);
            }

            try {
                $remember_me = (isset($input['remember_me']) && $input['remember_me']) ? $input['remember_me'] : false;
                $username = $input['username'];
                $password = $input['password'];

                // Implementing authentication by username or email
                $authByValue = 'username';
                if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
                    $authByValue = 'email';
                }

                // Convert password to plaintext if is Base64
                if($this->isBase64($password)){ $password = base64_decode($password); }

                // Try to authenticate the user
                if(Auth::attempt([$authByValue => $username, 'password' => $password])) {
                    // Avoiding user multiple session and removing old tokens
                    if(config('administration.avoid_multiple_session')){
                        $storedUser = User::where('username', $username)->orWhere('email', $username)->first();
                        if(isset($storedUser->logged) && $storedUser->logged){
                            $this->clearUserTokens($storedUser);
                        }
                    }

                    $user = Auth::user();

                    // Increase the expiration time for the refresh_token
                    if ($remember_me){
                        Passport::personalAccessTokensExpireIn(Carbon::now()->addDays(30));
                    }

                    $token = $user->createToken($user->email.'-'.now());
                    $user->withAccessToken($token);
                    $user->logged = true;
                    $user->save();
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'User not found'
                    ]);
                }

                if(isset($token)){
                    return response()->json([
                        'status' => true,
                        'message' => 'User successfully authenticated',
                        'token' => $token->accessToken,
                        'user' => $user
                    ]);
                }
            } catch (\Exception $e){
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage()
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Unexpected error trying to login user'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'GET method is not supported for this route'
        ]);
    }

    /**
     * Logout the user.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function logout(Request $request){
        if(Auth::check()){
            $user = Auth::user();
            $this->clearUserTokens($user);

            return response()->json([
                'status' => true,
                'message' => 'User successfully logged out'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to logout current user'
        ]);
    }

    /**
     * Get a validator for an incoming login request.
     *
     * @param  array $data
     * @param  string $validator
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, string $validator = "username")
    {
        $validation = ['required', 'string'];
        if(filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {
            $validation[] = array_merge($validation, ['email', 'exists:users,email']);
        }

        return Validator::make($data, [
            $validator => $validation,
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Clear all tokens for an user.
     *
     * @param  User $user
     * @return void
     */
    private function clearUserTokens(User $user){
        if($user->logged){
            $user->logged = false;
            $user->save();
        }

        if($user->token()){
            $user->token()->revoke();
        }
        if($user->tokens){
            $user->tokens->each(function($token, $key) {
                $token->delete();
            });
        }
    }
}
