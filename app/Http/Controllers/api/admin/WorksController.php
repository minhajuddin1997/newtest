<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\model\payment;
use App\model\service;
use App\model\work;
use App\User;
use Illuminate\Http\Request;
use DB;

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
}
