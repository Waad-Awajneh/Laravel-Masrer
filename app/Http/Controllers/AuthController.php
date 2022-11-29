<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Traits\AuthResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;


class AuthController extends Controller
{
    use AuthResponse;






    public function login(Request $request)
    {

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = User::where("email", $request->email)->first();

            return $this->success([
                'user' => $user,
                'access_token' => $user->createToken('Token ' . $user->id)->plainTextToken,
                'token_type' => 'Bearer',
            ]);
        } else {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
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
            'phone_number' => 'required|min:10',
            'address' => 'required',
            'profile_Img' => 'required',
            'cover_Img' => 'required',
        ]);


        $validateUser['password'] = Hash::make($request->password);
        // error_log($validateUser->error);
        $user = User::create($validateUser);

        return $this->success([
            'user' => $user,
            'access_token' => $user->createToken('Token ' . $user->id)->plainTextToken,
            'token_type' => 'Bearer',
        ]);
        // } catch (\Throwable $th) {
        //     $this->error($th->getMessage(), 'error', 500);
        // }
    }
}
