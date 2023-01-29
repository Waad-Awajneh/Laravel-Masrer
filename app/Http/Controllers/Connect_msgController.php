<?php

namespace App\Http\Controllers;
use App\Http\Traits\AuthResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Connect_msg;
class Connect_msgController extends Controller
{use AuthResponse;
    public function store(Request $request,User $user)
    {
// dd($request);


        $validateUser = $request->validate([
            'name' => 'required|string',
            'event_date' => 'required|date',
            'email' => 'required|email',
            'phone_number' => 'required|digits:10|numeric',
            'address' => 'required',
            'connect_msg' => 'string',


        ]);

        $post = Connect_msg::create([
            'name' => $request->name,
            'event_date' => $request->event_date,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'connect_msg' =>$request->connect_msg,
            "contact_method"=>$request->contact_method,

            'user_id' => Auth::user()->id,
            "weddingP_id"=> $user->id
        ]);

        // $user = Connect_msg::create($validateUser);


             return $this->success('', 'message created successfully', 201);

    }
}
