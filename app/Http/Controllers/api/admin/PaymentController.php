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

class PaymentController extends Controller
{
    //View Requested Services
    public function view_requested_services($id){
        $data=DB::table("payments")->where("payments.id",$id)
                  ->join("payment_status","payments.payment_status","payment_status.id")
                  ->select("payments.*", "payment_status.status")
                  ->get();
        return response()->json($data);
    }
    public function all($id){
        $pay=DB::table("payments")->where("del_status",0)
                  ->select("payments.*")
                  ->get();

        return response()->json($pay);
    }
    public function received($id){
        $pay=DB::table("payments")->where("paid_to",$id)
                  ->select("payments.*")
                  ->get();
        return response()->json($pay);
    }
    public function del_payment($id){
        $status=DB::table("payments")->where("payments.id",$id)
        ->update(['del_status' => 1]);
        return response()->json($status);
    }
}
