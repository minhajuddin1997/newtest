<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\model\service;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function search_service($id,$text){
        $companys=$this->searchAlgo($text,$id);
        //DB::insert("INSERT INTO search_log(search_text,user_id) VALUES (?,?)",[$text,$id]);
        return response()->json($companys);
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
       $comnpany=User::whereIn('id',$companyId)->get();
        return $comnpany;
    }

//    public function delete_logs($id,$text){
//        $logs=DB::table('search_log')->where([[]])->delete($id);
//        return array('success',"Deleted Successfully.");
//    }

}
