<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\model\category;
use App\model\service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index($id){
        $services_offered=service::where([["user_id","=",$id],["required_offered","=",1]])->get();
        $services_required=service::where([["user_id","=",$id],["required_offered","=",0]])->get();
        $category=category::all();
        return response()->json(["services_offered"=>$services_offered,"services_required"=>$services_required,"category"=>$category]);
    }

    public function insert(){
        if(request()->ajax()) {
            $imagePath = '';
            if (!empty(request()->get('titleImage'))) {
                $uploadPath = 'assets/admin/uploads/images';
                list($type, $image) = explode(';', request()->get('titleImage'));
                list(, $image) = explode(',', $image);
                $profile_picture = base64_decode($image);
                $image = rand() . '.' . explode('/', $type)[1];
                $imagePath = $uploadPath . '/' . $image;
                file_put_contents(public_path($imagePath), $profile_picture);
            }
            service::create([
                "title" => request()->get('title') ?? '',
                "title_image" => $imagePath,
                "description" => request()->get('description') ?? '',
                "deliverables" => json_encode(explode(",", request()->get('deliverables'))) ?? '',
                "amount" => request()->get('amount') ?? '',
                "required_offered" => request()->get('required_offered') ?? '',
                "status" => request()->get('status') ?? '',
                "user_id" => request()->get('user_id') ?? '',
                "category_id" => request()->get('category_id') ?? '',
            ]);
            return array("success", "Service Created Successfully.");
        }
    }


    public function update(){
        if(request()->ajax()) {
            $service=service::find(request()->get("id"));
            $image_path = $service->title_image;
            if(!empty(request()->get('titleImage'))){
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $uploadPath='assets/admin/uploads/images';
                list($type,$image)=explode(';',request()->get('titleImage'));
                list(,$image)=explode(',',$image);
                $profile_picture=base64_decode($image);
                $image=rand().'.'.explode('/',$type)[1];
                $imagePath=$uploadPath.'/'.$image;
                file_put_contents(public_path($imagePath),$profile_picture);
            }
            $service->update([
                "title" => request()->get('title') ?? '',
                "title_image" => $image_path,
                "description" => request()->get('description') ?? '',
                "deliverables" => json_encode(explode(",", request()->get('deliverables'))) ?? '',
                "amount" => request()->get('amount') ?? '',
                "required_offered" => request()->get('required_offered') ?? '',
                "status" => request()->get('status') ?? '',
                "user_id" => request()->get('user_id') ?? '',
                "category_id" => request()->get('category_id') ?? '',
            ]);
            return array("success", "Service Updated Successfully.");
        }
    }

    public function delete($id){
        service::find($id)->delete();
        return array("success", "Service Deleted Successfully.");
    }


}
