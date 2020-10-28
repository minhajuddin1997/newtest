<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\model\files;
use App\model\payment;
use App\model\service;
use App\model\tasks;
use App\model\work;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class WorksController extends Controller
{
    //
    public function index($id){
        $works=work::where("company_1",$id)
            ->orWhere("company_2",$id)
            ->get();

        foreach ($works as $work) {
            if ($work->company_1 == $id) {
                $work->user = User::find($work->company_2);
                $work->payment = payment::where("work_id", $work->id)->first();
                $work->payment->payment_status = DB::table("payment_status")->where("id", $work->payment->payment_status)->first();
            }else{
                $work->user = User::find($work->company_1);
                $work->payment = payment::where("work_id", $work->id)->first();
                $work->payment->payment_status = DB::table("payment_status")->where("id", $work->payment->payment_status)->first();
            }
        }
        return response()->json($works);
    }

    public function workData($id){
        $work=work::find($id);
        $work_services=DB::table("work_services")->select('*')->where("work_id",$id)->get();
        $sender=User::find($work_services->first()->sender_id);
        $receiver=User::find($work_services->first()->receiver_id);
        $services_id= $work_services->where("sender_id",$sender->id)->pluck("service_id");
        $requested_services=service::find($services_id);
        $offered_services=service::find($work_services->where("sender_id","<>",$sender->id)->pluck("service_id"));
        $payment=payment::where("work_id",$id)->first();
        $data=array("sender"=>$sender,"receiver"=>$receiver,"requested_services"=>$requested_services,"offered_services"=>$offered_services,
                    "payment"=>$payment);
        return response()->json($data);
    }

    //On Going: Get Companies
    public function getCompanies($id){
        $work_user_id=work::select("id","company_1","company_2")
            ->where([["company_1","=",$id],["status","=",0]])
            ->orWhere([["company_2",$id],["status","=",0]])
            ->distinct()->get();
        $companies=array();
        foreach ($work_user_id as $company){
            if($company->company_1==$id){
                $user=User::find($company->company_2);
                $user->work_id=$company->id;
                array_push($companies,$user);
            }
            else if($company->company_2==$id){
                $user=User::find($company->company_1);
                $user->work_id=$company->id;
                array_push($companies,$user);
            }
        }
        return response()->json($companies);
    }

    //On Going: Get Selected Company Services
    public function getCompaniesServices($id){
        $work_services= DB::table("work_services")
                            ->select("work_services.id as work_service_id",
                                "work_services.status as work_service_status",
                                "services.id as service_id",
                                "services.title as service_title",
                                "work_services.sender_id as sender_id",
                                "work_services.receiver_id as receiver_id"
                                )
                            ->join("services","work_services.service_id","=","services.id")
                            ->where("work_id",$id)
                            ->get();
        return response()->json(["services"=>$work_services,"user"=>User::find($work_services->first()->sender_id)]);
    }

    //Work Tasks
    public function getServiceTasks($work_service_id){
        $tasks=tasks::where("work_service_id",$work_service_id)->get();
        return response()->json(["tasks"=>$tasks,"service"=>$this->getService($work_service_id)->first()]);
    }

    //Create Tasks
    public function create_task($work_service_id){
        $validator=$this->validator(request()->all());
        if($validator->fails()){
            return array("status"=>0,"errors"=>$validator->getMessageBag());
        }
        tasks::create([
            "task"=>request()->get("task"),
            "due_date"=>request()->get("due_date"),
            "work_service_id"=>$work_service_id,
            "user_id"=>request()->get("user_id"),
            "progress"=>request()->get("progress"),
            "status"=>request()->get("status")
        ]);
        return array("status"=>1,"success"=>"Task Created Successfully");
    }

    //Update Tasks
    public function update_task_progress($id){
        $validator=Validator::make(request()->all(),[
                                "progress" => "numeric | min:0 | max:100",
                                "status" => "numeric"]);
        if($validator->fails()){
            return array("status"=>0,"errors"=>$validator->getMessageBag());
        }
        tasks::find($id)->update([
            "progress"=>request()->get("progress"),
            "status"=>request()->get("status")
        ]);
        return array("status"=>1,"success"=>"Progress Updated Successfully");
    }

    //Work Files
    public function getServiceFiles($work_service_id){
        $files=DB::table("service_files")
            ->join("users","service_files.user_id","=","users.id")
            ->select("service_files.*","users.company_name")
            ->where("work_service_id",$work_service_id)
            ->get()->groupBy(function($date) {
                return \Carbon\Carbon::parse($date->created_at)->format('F d, yy');
            });
        return response()->json(["files"=>$files,"service"=>$this->getService($work_service_id)]);
    }

    //Upload Files
    public function upload_files($work_service_id){

        $file = request()->file('file');
//        list($type,) = explode(";", $file);
//        list(,$file) = explode(",",$file);
//        $file=base64_decode($file);
        $uploadPath="assets/admin/uploads/services/files/";
//        $ext = explode("/",$fi)[1];
        $fileName=time().".".$file->getClientOriginalExtension();
        $filePath=$uploadPath.$fileName;
        $file->move(public_path($uploadPath),$fileName);
//        file_put_contents(public_path($filePath),$file);
        files::create([
            "title" => request()->get("title"),
            "file_path" => $filePath,
            "file_size" => request()->get("size"),
            "work_service_id" => $work_service_id,
            "user_id" => request()->get("user_id")
        ]);
        return "File Uploaded Successfully";
    }

    //Delete File
    public function delete_files($id)
    {
        $file=files::find($id);
        if(File::exists($file->file_path)){
            File::delete($file->file_path);
        }
        $file->delete();
        return "File Deleted Successfully";
    }
    //Helper
    public function getService($work_service_id){
        return DB::table("services")
            ->join("work_services","services.id","=","work_services.service_id")
            ->where("work_services.id",$work_service_id)
            ->select("services.*")
            ->get();
    }

    //Validator
    public function validator($data){
        return Validator::make($data, [
            "task" => "required | min:5",
            "due_date" => "required"
        ]);
    }

}
