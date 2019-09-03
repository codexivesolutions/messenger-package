<?php
namespace App\helpers;
use Illuminate\Http\Request;
use Notifications\TestNoti;
use App\User;
use Illuminate\Support\Arr;

class CommonHelper
{
    public static function group_message()
    {
        $array1 = array();
        $users = User::get();
        for ($i=0; $i < count($users); $i++) {
            $userData = User::find($users[$i]->id); 
            foreach ($userData->notifications as $notification) { 
                if($notification->data['type'] == 'group')
                {
                    $array1[] = $notification;
                }
            }
        }
        return $array1;
    }
    public static function group_messangers()
    {
        $msg = "";
        $user = auth()->user();
        $noty = collect(Self::group_message());	
        foreach ($noty->sortBy('created_at') as $notification) 
        { 
            if($notification->notifiable_id !== $user->id)
            {
                $notification->markAsRead(); 
                $msg .= "<li class='replies'>";            
                $msg .= '<img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>'.$notification->data['msg'].'</p>';            
                $msg .= "</li>";
            }
            else
            {
                $notification->markAsRead(); 
                $msg .= "<li class='send'>";            
                $msg .= '<img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>'.$notification->data['msg'].'</p>';            
                $msg .= "</li>"; 
            }    
        }
       return $msg;
    }
    public static function messangers($receiver_id)
    {
        $msg = "";
        $user = auth()->user();
        $noty = collect(Self::heirarchy_noty($receiver_id));	
        foreach ($noty->sortBy('created_at') as $notification) 
        { 
            if($notification->notifiable_id == $receiver_id && $notification->data['user_id'] == $user->id)
            {
                $notification->markAsRead(); 
                $msg .= "<li class='replies'>";            
                $msg .= '<img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>'.$notification->data['msg'].'</p>';            
                $msg .= "</li>";
            }
            elseif($notification->notifiable_id == $user->id &&  $notification->data['user_id'] == $receiver_id)
            {
                $notification->markAsRead(); 
                $msg .= "<li class='send'>";            
                $msg .= '<img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>'.$notification->data['msg'].'</p>';            
                $msg .= "</li>";  
            }    
        }
       return $msg;
    }
    public static function heirarchy_noty($receiver_id)
    {
        $array1 = array();
        $user = auth()->user();
        $userData = User::find($receiver_id); 
        $noty = array($userData->notifications);
        $userdata = User::find($user->id);
         $noty1 = array($userdata->notifications);
         $noty2 = array_merge($noty,$noty1);
		foreach ($noty2 as $notification) { 
            foreach ($notification as $notify) 
            {
                if($notify->data['type'] == 'single')
                {
                    $array1[] = $notify;
                }
            }
        }
       return $array1;
    }
    public static function last_noty($receiver_id)
    {
        $array1 = array();
        $user = auth()->user();
        $userData = User::find($receiver_id); 
        $noty = array($userData->notifications);
        $userdata = User::find($user->id);
         $noty1 = array($userdata->notifications);
         $noty2 = array_merge($noty,$noty1);
		foreach ($noty2 as $notification) { 
            foreach ($notification as $notify) 
            {
                if($notify->notifiable_id == $receiver_id && $notify->data['user_id'] == $user->id)
                {
                    if($notify->data['type'] == 'single')
                    {
                        $array1[] = $notify;
                    }
                }
                elseif($notify->notifiable_id == $user->id &&  $notify->data['user_id'] == $receiver_id)
                { 
                    if($notify->data['type'] == 'single')
                    {
                        $array1[] = $notify;
                    }   
                }
            }
        }    
        $array2 = collect($array1)->sortByDesc('created_at')->first();
       return $array2;
    }  
}
