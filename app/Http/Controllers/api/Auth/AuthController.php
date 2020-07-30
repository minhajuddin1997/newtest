<?php


namespace App\Http\Controllers\api\Auth;



use App\Http\Controllers\Controller;
use App\model\role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(){
        if(request()->ajax()){
            $validator = $this->validator(request()->all());
            $user=User::where('email','=',request()->get('email'))->first();
            $user->permissions=json_decode(role::find($user->role_id)->permissions);
            if($validator->fails()){
                return array('error',$validator->errors());
            }
            DB::table("oauth_access_tokens")->where('user_id','=',$user->id)->delete();
            if(Hash::check(request()->get('password'),$user->password)){
                $token = $user->createToken('auth-api');
                return array('success',[$token->accessToken,$token->token->expires_at,$user]);
            }
            else{
                return array('error',"These credentials do not match our records.");
            }
        }
    }

    public function logout(){
        if(request()->ajax()){
            $user=User::where('email','=',request()->get('email'))->first();
            if($user){
                DB::table("oauth_access_tokens")->where('user_id','=',$user->id)->delete();
                return 1;
            }
        }
    }

    public function validator($data){
        return $validator= Validator::make($data, [
            'email' => 'required |email',
            'password' => 'required',
        ]);
    }

}
