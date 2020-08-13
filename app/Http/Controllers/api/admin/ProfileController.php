<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    //

    public function update(){
        if(request()->ajax()){
            $validator= Validator::make(request()->all(), [
                'email' => 'required | email',
                'password' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'contact_number' => 'required'
            ]);
            if($validator->fails()){
                return array('error',$validator->errors());
            }else {
                $id = request()->get('id');
                $user=User::find($id);
                $imagePath=$user->profile_picture;
                if(!empty(request()->get('profile_picture'))){
                    $image_path = $user->profile_picture;
                    if (\File::exists($image_path)) {
                        \File::delete($image_path);
                    }
                    $uploadPath='assets/admin/uploads/images';
                    list($type,$image)=explode(';',request()->get('profile_picture'));
                    list(,$image)=explode(',',$image);
                    $profile_picture=base64_decode($image);
                    $image=rand().'.'.explode('/',$type)[1];
                    $imagePath=$uploadPath.'/'.$image;
                    file_put_contents(public_path($imagePath),$profile_picture);
                }
                $user->update([
                    "first_name" => request()->get('first_name') ?? "",
                    "last_name" => request()->get('last_name') ?? "",
                    "contact_number" => request()->get('contact_number') ?? "",
                    "company_name" => request()->get('company_name') ?? "",
                    "email" => request()->get('email') ?? "",
                    "password" => Hash::make(request()->get('password')) ?? "",
                    "description" => request()->get('description') ?? "",
                    "privacy_policy" => request()->get('privacy_policy') ?? "",
                    "how_to_use" => request()->get('how_to_use') ?? "",
                    "terms_and_conditions" => request()->get('terms_and_conditions') ?? "",
                    "address" => request()->get('address') ?? "",
                    "website" => request()->get('website') ?? "",
                    "profile_picture" => $imagePath ?? ""
                ]);
                return array('success',['Profile Updated Successfully.',$imagePath]);
            }
        }
    }
}
