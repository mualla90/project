<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

class UserController extends Controller
{
    public function editUserProfile(Request $request){
        $user=Auth::user();
        // return $user;
        $validatedData=$request->validate([
            'firstName'=>['required','max:55','string'],
            'lastName'=>['required','max:55','string'],
            'userName'=>['required','max:55','string'],
            'photo'=>['required','max:55','string'],
            'phone'=>['required','max:10'],
            'address' =>['required','max:55','string'],
        ]);
        $user->update($validatedData);
        return response()->json([
            'user'=>$user,
            'message'=>'user profile successfully updated',
            'status'=>1,
        ]);
    }
}
