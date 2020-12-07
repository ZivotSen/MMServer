<?php

namespace App\Http\Controllers;

use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Modules\Administration\Models\User;
use Modules\Administration\Models\UserSpecificFields;
use Modules\Funds\Models\FundsHolder;
use Modules\Funds\Models\UserFundsHolder;
use Modules\Funds\Models\Wallet;

class RegisterController extends Controller
{
    use Helper;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('update');
    }

    /**
     * Register a new user.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function register(Request $request){
        if($request->getMethod() == "POST"){
            $input = $request->all();

            return response()->json([
                'status' => true,
                'message' => $input,
            ]);

            // To make password_confirmation dynamically declared (but could belongs to the view model)
            if(key_exists('password', $input)){
                $input['password_confirmation'] = $input['password'];
            }

            $client = DB::connection('mongodb')->getMongoClient();
            $session = $client->startSession();
            $session->startTransaction([]);

            try {
                $errors = array(); // Array of recollected errors to be throw

                // Validating User instance
                $user = new User;
                if(!$user->isValid($input)){
                    $errors = array_merge($errors, $user->getErrors());
                }
                $user->createFromTransaction($input, $session);

                // Default User Specific Fields input
                $additional = new UserSpecificFields;
                $specificInput = [
                    'user_id' => $user->getInsertedID(),
                ];

                // Default Fund Holder input
                $fundInput = [
                    'name' => "{$user->name} Funds",
                    'owner_user_id' => $user->getInsertedID(),
                ];

                // Validating Funds Holder instance
                $fund = new FundsHolder;
                if(!$fund->isValid($fundInput)){
                    $errors = array_merge($errors, $fund->getErrors());
                }
                $additional->createFromTransaction($specificInput, $session);
                $fund->createFromTransaction($fundInput, $session);

                // Building relation with the User and its new Funds
                $userFundsRelation = [
                    'user_id' => $user->getInsertedID(),
                    'funds_holder_id' => $fund->getInsertedID()
                ];

                // Creating relationship
                $relation = new UserFundsHolder;

                // throw new \Exception("Testing transactions");

                $relation->createFromTransaction($userFundsRelation, $session);

                // Building relation with the Funds and new Wallet
                $saveWallet = [
                    'funds_holder_id' => $fund->getInsertedID(),
                    'primary' => true,
                ];
                $wallet = new Wallet;
                $wallet->createFromTransaction($saveWallet, $session);

                if(!empty($errors)){
                    throw new \Exception(json_encode($errors));
                }

                $session->commitTransaction();

                return response()->json([
                    'status' => true,
                    'message' => "User successfully registered",
                    'user' => $user,
                ]);
            } catch (\Exception $e){
                $session->abortTransaction();
                $errors = $e->getMessage();

                if($this->isJSON($e->getMessage())){
                    $errors = $this->getJSONDecoded($e->getMessage());
                }

                return response()->json([
                    'status' => false,
                    'message' => $errors,
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Unexpected error'
        ]);
    }

    /**
     * Update the password for the user.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        if($request->getMethod() == "POST"){
            $input = $request->all();

            // Validate the new password length...
            if(key_exists('password', $input)){
                $input['password_confirmation'] = $input['password'];
            }
            $validator = Validator::make($input, [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            if($validator->fails()){
                $error = $validator->messages()->get('*');
                return response()->json([
                    'status' => false,
                    'message' => $error
                ]);
            }

            $user = $request->user()->fill([
                'password' => Hash::make($request->get('password'), [
                    'rounds' => 12,
                ])
            ])->save();

            return response()->json([
                'status' => true,
                'message' => "Password successfully updated",
                'user' => $user,
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Unexpected error'
        ]);
    }
}
