<?php

namespace App\Http\Controllers\api\admin;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\model\connections;
use App\model\messages;
use App\User;

class MessagesController extends Controller
{
    public function messages($connection_id){
        $messages=messages::where('connection_id',$connection_id)
            ->join('users','users.id','company_messages.fromId')
            ->select('company_messages.*','users.id as user_id','users.profile_picture')
            ->orderBy('created_at','asc')
            ->get();
        return response()->json($messages);
    }

    public function add_new_message(){
        $message=messages::create([
            'fromId'=>request('from'),
            'toId'=>request('to'),
            'message'=>request("message"),
            'connection_id'=>request('connection_id')
        ]);
        $user=User::find(request()->get('from'));
        $message->user_id=$user->id;
        $message->profile_picture=$user->profile_picture;
        event(new MessageEvent($message,request()->get('connection_id')));
    }

    public function get_connections($status,$id){
        $connections_companys=connections::where([['company_1',$id],['status','=',$status]])->orWhere([['company_2','=',$id],['status','=',$status]])->get();
        $c_ids=[];
        for ($i=0; $i<count($connections_companys); $i++){
            $c_id=$connections_companys[$i]->company_1==$id?$connections_companys[$i]->company_2:$connections_companys[$i]->company_1;
            array_push($c_ids,$c_id);
        }
        $connections=User::whereIn('id',$c_ids)->where('status',1)->get();
        for ($i=0; $i<count($connections); $i++){
            $connections[$i]->connection_id=$connections_companys[$i]->id;
            $connections[$i]->count=messages::where([['connection_id','=',$connections_companys[$i]->id],['fromId','=',$connections[$i]->id],['toId','=',$id],['viewed_status','=',0]])->count();
        }
        return response()->json($connections);
    }

    public function viewed_status_update($toId, $fromId ,$connection_id){
        messages::where([['toId','=',$fromId],['fromId','=',$toId],['connection_id','=',$connection_id],['viewed_status','=',0]])
            ->update([
                'viewed_status' => 1
            ]);
    }

    public function connection_update($id){
        connections::find($id)->update([
            'status'=>1
        ]);
        return;
    }

}
