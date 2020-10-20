<?php

namespace App\Http\Controllers\api\admin;

use App\Events\ExchangeRequest;
use App\Http\Controllers\Controller;
use App\model\agreement;
use App\model\exchange_requests;
use App\model\payment;
use App\model\service;
use App\model\work;
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
        $exchange_notifications=$this->getRequests($receiver_id);
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
            "status"=>-1,
            "rejection_message"=>$message
        ]);
        $exchange_notifications=$this->getRequests($request->receiver_id);
        event(new ExchangeRequest($request->receiver_id, $exchange_notifications));
        $sender=User::find($request->sender_id);
        Notification::send($sender,new ExchangeRejectNotification($sender->company_name, $message));
        return "Request For Exchange Has Been Rejected Successfully";
    }

    //Delete Request
    public function deleteRequest($id){
        $request=exchange_requests::find($id);
        $request->delete();
        DB::table("requested_services")->where("exchange_request_id",$id)->delete();
        return "Request Deleted Successfully.";
    }

    //Find Request
    public function findRequest($id){
        $request=exchange_requests::find($id);
        $request->user=User::find($request->sender_id);
        return response()->json($request);
    }

    //View Requested Services
    public function view_requested_services($id){
        $services=DB::table("requested_services")->where("exchange_request_id",$id)
                  ->join("services","services.id","requested_services.service_id")
                  ->select("services.*","requested_services.exchange_request_id as request_id")
                  ->get();
        return response()->json($services);
    }

    //View Offer Services
    public function view_offer_services($id){
        $request=exchange_requests::find($id);
        $services=service::where([["user_id",'=',$request->sender_id],["required_offered","=",1]])->get();
        return response()->json($services);
    }

    //View Agreement
    public function view_agreement(){
        $agreement=agreement::where("display_status",1)->orderBy('created_at')->first();
        return response()->json($agreement);
    }

    //Save Work And Payments
    public function saveWork(){
        $name_on_card=request()->get("nameOnCard");
        $card_cvc=request()->get("cardCVC");
        $card_number=request()->get("cardNumber");
        $card_valid_date=request()->get("cardValidDate");
        $payment_status=request()->get("status");
        //if it already exist or not
        if($payment_id=request()->get("paymentId")) {
            $payment = payment::where("id",$payment_id)->update([
                "name_on_card" => $name_on_card,
                "card_cvc" => $card_cvc,
                "card_number" => $card_number,
                "card_valid_date" => $card_valid_date,
                "payment_method" => $payment_status == "Not Verified" ? "Not Available" : "Credit Card",
                "payment_status" => DB::table("payment_status")->where("status", $payment_status)->first()->id,
            ]);

            return response()->json("ThankYou, You Will Be Notified Soon.");
        }
        else {
            $requested_services=request()->get("requestedServices");
            $exchange_services=request()->get("exchangeServices");
            $sender=request()->get('sender');
            $receiver=request()->get('receiver');
            $amount=request()->get('amount');
            $paidTo=request()->get("paidTo");
            $paidBy=request()->get("paidBy");
            $work = work::create([
                "company_1" => $sender["id"],
                "company_2" => $receiver["id"],
                "status" => 0
            ]);
            foreach ($requested_services as $service) {
                DB::table("work_services")->insert([
                    "service_id" => $service["id"],
                    "sender_id" => $sender["id"],
                    "receiver_id" => $receiver["id"],
                    "status" => 0,
                    "work_id" => $work["id"]
                ]);
            }
            foreach ($exchange_services as $service) {
                DB::table("work_services")->insert([
                    "service_id" => $service["id"],
                    "sender_id" => $receiver["id"],
                    "receiver_id" => $sender["id"],
                    "status" => 0,
                    "work_id" => $work["id"]
                ]);
            }

            payment::create([
                "amount" => $amount,
                "payment_method" => $payment_status == "Not Verified" ? "Not Available" : "Credit Card",
                "payment_status" => DB::table("payment_status")->where("status", $payment_status)->first()->id,
                "work_id" => $work->id,
                "paid_by" => $paidBy,
                "paid_to" => $paidTo,
                "card_number" => $card_number,
                "name_on_card" => $name_on_card,
                "card_cvc" => $card_cvc,
                "card_valid_date" => $card_valid_date,
            ]);

            $request = exchange_requests::find(\request()->get('requestId'));
            $request->status = 1;
            $request->save();
        }

        $exchange_notifications=$this->getRequests($receiver["id"]);
        event(new ExchangeRequest($receiver["id"], $exchange_notifications));

        return response()->json("ThankYou, You Will Be Notified Soon.");
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
