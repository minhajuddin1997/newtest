<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Mail\NewCompanyMail;
use App\model\role;
use App\User;
use App\model\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;
class ProfileController extends Controller
{
    //Getting Users List
    public function index(){
        $vendors=User::where("role_id",2)->paginate(10);
        $response=[
            'pagination' => [
                'total' => $vendors->total(),
                'per_page' => $vendors->perPage(),
                'current_page' => $vendors->currentPage(),
                'last_page' => $vendors->lastPage(),
                'from' => $vendors->firstItem(),
                'to' => $vendors->lastItem()
            ],
            "profile_status"=>["Approved", "On Hold", "Not Accepted"],
            "data"=>$vendors
        ];
        return response()->json($response);
    }

    //Get Auth User
    public function view($id){
            $user=User::find($id);
            $user->permissions=role::find($user->role_id)->permissions;
            return $user;
    }

    //Profile Update
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

    //Update Company info
    public function updateCompanyInfo($id){
        if(request()->ajax()){
            $user=User::find($id);
            $user->privacy_policy=request()->get('privacy_policy') ?? '';
            $user->terms_and_conditions=request()->get('terms_and_conditions') ?? '';
            $user->how_to_use=request()->get('how_to_use') ?? '';
            $user->save();
            return array('success','Information Updated Successfully');
        }
    }

    //Update Profile Status
    public function updateProfileStatus($id){
        if(request()->ajax()){
            $user=User::find($id);
            $user->status=request()->get('status') ?? $user->status;
            $user->profile_status=request()->get('profile_status') ?? $user->profile_status;
            $user->save();
            return array('success','Status Changed Successfully');
        }
    }

    //Add User
    public function insert(){
        if(request()->ajax()) {
            $validator = Validator::make(request()->all(), [
                'email' => 'required | email |unique:users,email',
                'company_name' => 'required',
                'contact_number' => 'required'
            ]);
            if ($validator->fails()) {
                return array('error', $validator->errors());
            }else {
                $email=request()->get("email");
                $password=Str::random(rand(12,18));
                User::create([
                    'role_id' => 2,
                    'company_name' => request()->get("company_name") ?? "",
                    'contact_number' => request()->get("contact_number") ?? "",
                    'email' => request()->get("email") ?? "",
                    'password' => Hash::make($password) ?? ""
                ]);
                Mail::to($email)->send(new NewCompanyMail($email,$password));
                return array('success', 'Profile Created Successfully. An Email Will Be Sent To The Following Company.');
            }
        }
    }

    //delete User
    public function delete($id){
        if(request()->ajax()){
            $user=User::find($id);
            $user->delete();
            return array('success','Company Profile Deleted Successfully');
        }
    }

    public function get_company_profile($id){
        $res=DB::table("company_messages")->select('*')->where("fromId",$id)->count();
        $res1=DB::table("company_messages")->select('*')->where("toId",$id)->count();
        $data = array(
            'to'=>$res1,
            'from'=>$res,
        );
        return response()->json($data);
    }


}
