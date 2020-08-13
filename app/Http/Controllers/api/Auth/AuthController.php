<?php


namespace App\Http\Controllers\api\Auth;



use App\Http\Controllers\Controller;
use App\model\role;
use App\User;
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

    public function register(){
        if(request()->ajax()){
            $validator=$this->register_validator(request()->all());
            if($validator->fails()){
                return array('error',$validator->errors());
            }else {
                $uploadPath='assets/admin/uploads/images';
                list($type,$image)=explode(';',request()->get('profile_picture'));
                list(,$image)=explode(',',$image);
                $profile_picture=base64_decode($image);
                $image=rand().'.'.explode('/',$type)[1];
                $imagePath=$uploadPath.'/'.$image;
                file_put_contents(public_path($imagePath),$profile_picture);
                $vendor = User::create([
                    'role_id' => 2,
                    'first_name' => request()->get('first_name'),
                    'last_name' => request()->get('last_name'),
                    'email' => request()->get('email'),
                    'password' => Hash::make(request()->get('password')),
                    'contact_number' => request()->get('contact_number'),
                    'profile_picture' => $imagePath,
                    'profile_status' => 'On Hold'
                ]);
                $vendor->permissions=json_decode(role::find($vendor->role_id)->permissions);
                $token = $vendor->createToken('auth-api');
                return array('success', [$token->accessToken, $token->token->expires_at, $vendor]);
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
            'password' => 'required'
        ]);
    }

    public function register_validator($data){
        return $validator= Validator::make($data, [
            'email' => 'required | email | unique:users,email',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'contact_number' => 'required'
        ]);
    }


}
