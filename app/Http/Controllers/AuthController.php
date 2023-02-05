<?php

namespace App\Http\Controllers;



use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\AuthResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResourceAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use A6digital\Image\Facades\DefaultProfileImage;


class AuthController extends Controller
{
    use AuthResponse;


    public function login(Request $request)
    {

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = User::where("email", $request->email)->first();

            return $this->success([
                'user' => new UserResourceAuth($user),
                'access_token' => $user->createToken('Token ' . $user->id)->plainTextToken,
                'token_type' => 'Bearer',
            ]);
        } else {

            throw ValidationException::withMessages([

                'email' => "Invalid email or password",
            ]);
        }
    }



    // public function SignUpOrLogin(Request $request)
    // {
    //     // $user = User::where("email", $request->email)->first();

    //     if ($user) {
    //         // return response()->json([
    //         //     'SignUpOrLogin' => 'login'

    //         // ]);
    //         return true
    //     } else {
    //         return false;
    //         // return response()->json([
    //         //     'SignUpOrLogin' => 'signup'

    //         // ]);
    //     }
    // }





    public function register(Request $request)
    {


        // try {
        $validateUser = $request->validate([
            'name' => 'required|string',
            'gender' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone_number' => 'required|digits:10|numeric',
            'address' => 'required',
            'profile_Img' => '',
            // 'cover_Img' => 'required',
        ]);


        $validateUser['password'] = Hash::make($request->password);
        // dd($validateUser);
        $user = User::create($validateUser);

        return $this->success([
            'user' => new UserResource($user),
            'access_token' => $user->createToken('Token ' . $user->id)->plainTextToken,
            'token_type' => 'Bearer',
        ]);
        // } catch () {


        // }
    }

    public function googleRegister(Request $request)
    {


        $validateUser = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => ['required', Password::defaults()],
            'profile_Img' => 'string',

        ]);

        $validateUser['password'] = Hash::make($request->password);

        $user = User::create($validateUser);

        return $this->success([
            'user' => new UserResource($user),
            'access_token' => $user->createToken('Token ' . $user->id)->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }

    public function googleLogin(Request $request)
    {
        $user = User::where("email", $request->email)->first();

        if ($user) {
            return $this->success([
                'signUp' => true,
                'user' => new UserResourceAuth($user),
                'access_token' => $user->createToken('Token ' . $user->id)->plainTextToken,
                'token_type' => 'Bearer',
            ]);
        } else {
            AuthController::googleRegister($request);
        }
    }
}
