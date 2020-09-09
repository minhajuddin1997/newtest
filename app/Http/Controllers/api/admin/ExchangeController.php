<?php

namespace App\Http\Controllers\api\admin;

use App\Events\ExchangeRequest;
use App\Http\Controllers\Controller;
use App\model\exchange_requests;
use App\Notifications\ExchangeNotification;
use App\Notifications\ExchangeRejectNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ExchangeController extends Controller
{
    public function exchange_request(){
        $sender_id=request()->get('sender_id');
        $receiver_id=request()->get('receiver_id');
        $selected_services=json_decode( request()->get('selectedServices') );

        if($this->check_service_request($sender_id, $receiver_id, $selected_services)){
            return array("error","One of the Service in this is already been send to this company and waiting for approval");
        }

        $exchange_request=exchange_requests::create([
            "sender_id"=>$sender_id,
            "receiver_id"=>$receiver_id,
            "status"=>0
        ]);
        //Insertion For Requested Services
        foreach ( $selected_services as $service ){
            DB::table("requested_services")->insert([
                "exchange_request_id" => $exchange_request->id,
                "service_id" => $service->id
            ]);
        }
        $exchange_notifications=exchange_requests::where("receiver_id",$receiver_id)->get();
        event(new ExchangeRequest($receiver_id, $exchange_notifications));
        $receiver=User::find($receiver_id);
        $sender=User::select("company_name")->find($sender_id);
        Notification::send($receiver,new ExchangeNotification($receiver->company_name,$sender->company_name));
        return array("success","Your Request For Exchange Has Been Sent.");
    }

    public function getRequests($receiver_id){
//        ["status","=",0]
        $requests=exchange_requests::where([["receiver_id","=",$receiver_id]])->orderBy('status','asc')->get()->map(function($request){
            $request->user=User::find($request->sender_id);
            return $request;
        });

        return response()->json($requests);
    }

    public function getSendRequests($sender_id){
        $requests=exchange_requests::where("sender_id",$sender_id)->orderBy('status','asc')->get()->map(function($request){
            $request->user=User::find($request->receiver_id);
            return $request;
        });
        return response()->json($requests);
    }

    //Reject Request
    public function rejectRequest($id){
        $message=request()->get("message");
        $request=exchange_requests::find($id);
        $request->update([
            "status"=>-1
        ]);
        $exchange_notifications=exchange_requests::where("receiver_id",$request->receiver_id)->get();
        event(new ExchangeRequest($request->receiver_id, $exchange_notifications));
        $sender=User::find($request->sender_id);
        Notification::send($sender,new ExchangeRejectNotification($sender->company_name, $message));
        return "Request For Exchange Has Been Rejected Successfully";
    }

    //helper
    //Function to check weather the same service request has been sent
    public function check_service_request($sender_id, $receiver_id, $selected_services){
        foreach ($selected_services as $service){
            $check=DB::table("exchange_requests")
                ->join("requested_services","exchange_requests.id","=","requested_services.exchange_request_id")
                ->select("exchange_requests.sender_id","exchange_requests.receiver_id","requested_services.service_id","exchange_requests.status")
                ->where([["status","=",0],["sender_id","=",$sender_id],["receiver_id","=",$receiver_id],["service_id","=",$service->id]])->count();
            if($check){
                return true;
            }
        }
    }
}
