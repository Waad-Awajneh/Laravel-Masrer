<?php

namespace App\Http\Controllers;



use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\AuthResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
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
                'user' => new UserResource($user),
                'access_token' => $user->createToken('Token ' . $user->id)->plainTextToken,
                'token_type' => 'Bearer',
            ]);
        } else {

            throw ValidationException::withMessages([

                'email' => "Invalid email or password",
            ]);
        }
    }





    public function register(Request $request)
    {

        // dd($request);
        //TODO: handle Photo (binary file)
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

        // $profile_Img = DefaultProfileImage::create("Name Surname", 256, '#000', '#FFF');

        // $img = DefaultProfileImage::create("Name Surname");

        // $validateUser['profile_Img']
        //     = $img->encode();
        $validateUser['password'] = Hash::make($request->password);
        // dd($validateUser);
        $user = User::create($validateUser);

        return $this->success([
            'user' => new UserResource($user),
            'access_token' => $user->createToken('Token ' . $user->id)->plainTextToken,
            'token_type' => 'Bearer',
        ]);
        // } catch (\Throwable $th) {
        //     $this->error($th->getMessage(), 'error', 500);
        // }
    }
}
