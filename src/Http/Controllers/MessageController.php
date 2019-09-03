<?php

namespace codexivesolutions\messenger\Http\Controllers;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\helpers\CommonHelper;
use App\Notifications\TestNoti;

class MessageController extends Controller
{
   
    public function index()
    {  
        $users = User::get();
        return view('messenger::chat',compact('users'));
    }
    public function store(request $request)
    {
        
       if($request->type == 'single')
        {
           $user = auth()->user();
           $userData = User::find($user->id);
           $user->notify(new TestNoti(User::find($request->receiver_id),$request->msg,$request->type));
           return CommonHelper::messangers($request->receiver_id);
        }else{
            $user = auth()->user();
            $userData = User::find($user->id);
            $user->notify(new TestNoti(User::find($user->id),$request->msg,$request->type));
            return CommonHelper::group_messangers();
        }
    }
    public function get_message(request $request)
    {
        if($request->type == 'single')
        {
            return CommonHelper::messangers($request->receiver_id);
        }else {
            return CommonHelper::group_messangers();
        }
    }
    public function receiver_name(request $request)
    {
        $user = User::find($request->receiver_id);
        echo json_encode($user->name);
    }
}
