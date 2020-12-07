<?php

namespace Modules\Administration\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function index(Request $request){
        return response()->json([
            'status' => true,
            'profile' => 'user can access',
            'message' => 'User is logged',
            'user' => Auth::user(),
            'owner' => Auth::user()->ownerOfFunds[0]->wallets[0]->getAmount(),
            'funds' => Auth::user()->funds(),
        ]);

        return response()->json([
            'status' => false,
            'message' => ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request){
        return response()->json([
            'status' => false,
            'message' => ''
        ]);
    }

    /**
     * Display the specific resource.
     *
     * @param  string $id
     * @return JsonResponse
     */
    public function show(string $id){
        return response()->json([
            'status' => false,
            'message' => ''
        ]);
    }

    /**
     * Update the specific resource.
     *
     * @param  Request $request
     * @param  string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id){
        return response()->json([
            'status' => false,
            'message' => ''
        ]);
    }

    /**
     * Delete the specific resource.
     *
     * @param  string $id
     * @return JsonResponse
     */
    public function delete(string $id){
        return response()->json([
            'status' => false,
            'message' => ''
        ]);
    }
}
