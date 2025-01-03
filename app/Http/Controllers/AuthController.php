<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\bg_BG\PhoneNumber;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function Register(Request $request){
     $request->validate([
         'firstName'=>['required','max:55','string'],
         'lastName'=>['required','max:55','string'],
         'userName'=>['required','max:55','string'],
         'photo'=>['required','max:55','string'],
            'phone'=>['required','max:4000'],
            'location' =>['required','max:55','string'],
            'password'=>[
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ]);
        $user=User::query()->create([
            'firstName'=>$request->firstName,
            'lastName'=>$request->lastName,
            'password'=>bcrypt($request->password),
            'photo'=>$request->photo,
            'phone'=>$request->phone,
            'location'=>$request->location,
            'userName'=>$request->userName,
        ]);
        if(!$user){
            return response()->json([
                'success'=>false,
                'message'=>'Registeration failed',
            ]);
        }
            $accessToken=$user->createToken('Personal Access Token')->accessToken;
            $user['remember_token']=$accessToken;
            return response()->json([
                'user'=>$user,
                'access_token'=>$accessToken,
            ]);

    }
    public function login(Request $request){
        $loginData=$request->validate([
            'phone'=>'required|exists:users,phone',
            'password'=>'required'
        ]);
        if(!auth()->attempt($loginData)){
        return response()->json([
            'errors'=>[
                'message'=>'could not sing you in with those credentials',
            ],
        ],422);
        }
        $user=$request->user();

        $accessToken=$user->createToken('Personal Access Token');
        $user['remember_token']=$accessToken;
        if($request->remember_me){
        $accessToken->token->expires_at=Carbon::now()->addWeeks(1);
        }
        $accessToken->token->save();
        return response()->json([
            'data'=>$user,
            'access_token'=>$accessToken->accessToken,
            'token_type'=>'Bearer',
            'expires_at'=>Carbon::parse($accessToken->token->expires_at)->toDateString(),
        ]);

    }
    public function logout(){
        $user = Auth::user();
         if ($user){
           $user->token()->revoke();
             return response()->json([ 'success' => 'Logged out successfully' ], 200);
            }

              return response()->json([ 'error' => 'No authenticated user found' ], 401);
    }
}
