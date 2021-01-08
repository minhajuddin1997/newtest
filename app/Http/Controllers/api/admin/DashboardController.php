<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\model\service;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\model\connections;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConnectionMail;

class DashboardController extends Controller
{
    public function search_service_company($id,$text){
        $companys=$this->searchAlgo($text,$id);
        //DB::insert("INSERT INTO search_log(search_text,user_id) VALUES (?,?)",[$text,$id]);
        return response()->json($companys);
    }

    public function search_services($company_id){
        $services=service::where('user_id',$company_id)->get();
        return response()->json($services);
    }

    public function search_logs($id){
        $logs=DB::table('search_log')->select("search_text")->where([['user_id','=',$id]])->distinct('search_text')->get();
        return response()->json($logs);
    }

    protected function searchAlgo($text,$id){
//         $services=DB::table('services')
//            ->where('title','like','%'.$text.'%')
//            ->where([['user_id','<>',$id],['required_offered','=',1]])
//            ->leftJoin('users','users.id','user_id')
//            ->leftJoin('category','category.id','category_id')
//            ->select('users.company_name','users.profile_picture','category.name as category_name','services.*')->get();
       $companyId=[];
       $services=DB::table('services')
           ->where('title','like','%'.$text.'%')
           ->where([['user_id','<>',$id],['required_offered','=',1]])
           ->get('user_id');
       foreach ($services as $service){
           array_push($companyId,$service->user_id);
       }
       $comnpany=User::whereIn('id',$companyId)->where([["status","=",1],["profile_status","=","Approved"],["id","<>",1]])->get();
        return $comnpany;
    }

    public function search_companies($text){
        $company=DB::table('users')
        ->where('company_name','like','%'.$text.'%')
        ->get();
        return response()->json($company);
    }

    public function create_connection(){
        $company_1 = request()->get('company_1');
        $company_2 = request()->get('company_2');
        $connection=connections::whereIn("company_1",[$company_1, $company_2])
                    ->whereIn("company_2",[$company_2, $company_1])
                    ->get();
        if(!count($connection)) {
            connections::create([
                "company_1" => $company_1,
                "company_2" => $company_2,
                "status" => 0
            ]);
            $user=User::find($company_1);
            Mail::to("muhammad.minhaj@technado.co")->send(new ConnectionMail($user));
            return "Request For The Connection Has Been Sent.";
        }else{
            return "You Are Already Connected.";
        }

    }
//    public function delete_logs($id,$text){
//        $logs=DB::table('search_log')->where([[]])->delete($id);
//        return array('success',"Deleted Successfully.");
//    }

}
