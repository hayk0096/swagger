<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @SWG\Post(
     *     path="/api/users/signup",
     *     description="Return a user's first and last name",
     *     @SWG\Parameter(
     *         name="lastName",
     *         in="query",
     *         type="string",
     *         description="Your first name",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="lastName",
     *         in="formData",
     *         type="string",
     *         description="Your last name",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "firstName" => "required|min:3|max:15",
            "lastName" => "required|min:5|max:20",
            "email" => "required|unique:users|email",
            "password" => "required|min:6",
            "password_confirm" => "required|same:password",
            "phoneNumber" => "required",
            "billingAddress" => "required",
            "billingCity" => "required",
            "billingCountry" => "required",
            "billingPostalCode" => "required|numeric",
            "companyName" => "required",
            "companyVAT" => "required",
            "userType" => "required"
        ]);

        if ($validator->fails()){
            return response()->json([
                "description" => 'Please check below errors',
                "errors" => $validator->errors()
            ], 400);
        }

        $newUser = User::create([
            "firstName" => $request->firstName,
            "lastName" => $request->lastName,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "phoneNumber" => $request->phoneNumber,
            "billingAddress" => $request->billingAddress,
            "billingCity" => $request->billingCity,
            "billingCountry" => $request->billingCountry,
            "billingPostalCode" => $request->billingPostalCode,
            "companyName" => $request->companyName,
            "companyVAT" => $request->companyVAT,
            "userType" => $request->userType
        ]);

        return response()->json([
            "description" => "New user '$request->userType' created",
            "userObject" => $newUser
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required|min:6"
        ]);

        if ($validator->fails()){
            return response()->json([
                "description" => 'Please check below errors',
                "errors" => $validator->errors()
            ], 400);
        }

        $user = User::where('email', $request->email)->get();
        if ($user == null || count($user) == 0){
            return response()->json([
                "description" => 'Please register before sign in'
            ], 400);
        }

        if (Auth::guard('web')->attempt(['email' => $request->email,'password' => $request->password], $request->remember)){
            $token = Str::random(32);
            User::where('email', $request->email)->update(['access_token' => $token]);
            $user = User::where('email', $request->email)->first();
            return response()->json([
                "description" => "You are logged in",
                "token" => $user->access_token,
                "userObject" => $user
            ], 200);
        } else {
            return response()->json([
                "description" => "Your password was wrong"
            ], 400);
        }
    }

}