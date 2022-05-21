<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public function register(Request $request) {

        //In Controller Validation Request
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);
        if($validation->fails()) {
            return $this->sendResponse([
                "message" => $validation->errors()->first(),
            ], false);
        }

        //create user
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);

        //generate token
        $token = $user->createToken(time())->plainTextToken;

        //send common response
        return $this->sendResponse([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request) {

        //In Controller Validation Request
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if($validation->fails()) {
            return $this->sendResponse([
                "message" => $validation->errors()->first(),
            ], false);
        }

        // Check for valid user
        $user = User::where('email', $request['email'])->first();

        // matching password
        if(!$user || !Hash::check($request['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        //generate token
        $token = $user->createToken(time())->plainTextToken;

        //send common response
        return $this->sendResponse([
            'user' => $user,
            'token' => $token
        ]);
    }
}
