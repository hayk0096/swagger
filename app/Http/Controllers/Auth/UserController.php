<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/users",
     *     summary="Get list of users",
     *     tags={"Users"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/User")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     * )
     */
    public function index()
    {
        return \response()->json([
            "description" => "response message",
            "token" => "token string",
            "userObject" => [
                [
                    "firstName" => "John",
                    "lastName" => "Lennon",
                    "age" => 22,
                    "gender" => "female",
                    "email" => "lennon@gmail.com"
                ]
            ]
        ], 200);
    }


    /**
     * @SWG\Post(
     *     path="/create",
     *     description="Return a user's first and last name",
     *     @SWG\Parameter(
     *         name="firstname",
     *         name="firstname",
     *         in="query",
     *         type="string",
     *         description="Your first name",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="lastname",
     *         in="query",
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
        return response()->json([
            "description" => "response message",
            "token" => "token string",
            "userObject" => []
        ], 200);
//        $userData = $request->only([
//            'firstname',
//            'lastname',
//        ]);
//        if (empty($userData['firstname']) && empty($userData['lastname'])) {
//            return new \Exception('Missing data', 404);
//        }
//        return $userData['firstname'] . ' ' . $userData['lastname'];
    }


    /**
     * @SWG\Get(
     *     path="/users/{user_id}",
     *     summary="Get user by id",
     *     tags={"Users"},
     *     description="Get user by id",
     *     @SWG\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="User id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/User"),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="User is not found",
     *     )
     * )
     */
    public function show($user_id)
    {

    }

}