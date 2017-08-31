<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Message;
use App\SendMessage;
use App\User;
use App\GroupUsers;
use App\Group;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }




    public function Messages(){
        return view('frontend.messages', ['allMembers' => User::getAllMembers(), 'currUser' => Auth::user()]);
    }


    public function postMessages(Request $request){
        $data = $request->except('_token');
        $messages = Message::create(['author_id' => Auth::user()['id'], 'content' => $data['msgcontent'], 'type' => 'message']);

        foreach($data['members'] as $row){
            SendMessage::create(['message_id' => $messages['id'] , 'members_id' => $row, 'invite_flag' => 'none']);
        }
        return redirect()->back()->with('success', 'Created successfully');
    }



    public function listReadRecievedMessages($page=1){
        return view('frontend.recieved-read-messages', ['allReadRecievedMsg' => SendMessage::getAllReadRecievedMsg(), 'currUser' => Auth::user()]);
    }


    public function listUnreadRecievedMessages($page=1){
        return view('frontend.recieved-unread-messages', ['allUnreadRecievedMsg' => SendMessage::getAllUnreadRecievedMsg(), 'currUser' => Auth::user()]);
    }




    public function listReadSentMessages($page=1){
        return view('frontend.sent-read-messages', ['allReadSentMsg' => SendMessage::getAllReadSentMsg(), 'currUser' => Auth::user()]);
    }


    public function listUnreadSentMessages($page=1){
        return view('frontend.sent-unread-messages', ['allUnreadSentMsg' => SendMessage::getAllUnreadSentMsg(), 'currUser' => Auth::user()]);
    }




    public function readMessage(Request $request, $id){
        $messageData = Message::getMessageForRead($id)->first();


        if(is_null($messageData)){
            return view('errors.notfound-message');
        }

        if(!$request->get('read_flag')){
            SendMessage::where('message_id' , $id)->where('members_id' , Auth::user()['id'])->update(['read_flag' => true]);
        }


        if($request->has('invite_flag')){
            SendMessage::where('message_id', $id)->where('members_id', Auth::user()['id'])->where('invite_flag', 'pending')->update(['invite_flag' => $request->get('invite_flag')]);


            /*if($request->has('invite_flag') == 'accepted'){
                $my =  $this->addToFriends(Auth::user()['id'], $request->get('from') );
                $other =  $this->addToFriends( $request->get('from'), Auth::user()['id'] );

                if($my && $other){
                    $messages['successRequestTry'] = 'Успешно се сприятелихте с ';
                }
                else{
                    $messages['errorRequestTry'] = 'Възникна грешка при опита да се спрятелите с ';
                }
            }*/
        }

        $data = SendMessage::getMessage($id)->first();
        if(json_decode($data)->invite_flag == 'declined'){
            GroupUsers::where('user_id', json_decode($data)->members_id)->delete();
        }
        if(json_decode($data)->invite_flag == 'accepted'){
            GroupUsers::where('user_id', json_decode($data)->members_id)->update(['status' => 'active']);
        }


        if(!$data){
            return view('errors.notfound-message');
        }
        return view('frontend.view-exactmsg',  $data);
    }



    /*private function addToFriends($user_id, $new_friends_id){
        $from = User::where('id', $user_id)->first();
        if(!is_null($from)){
            $friends = json_decode($from->friends, true);
            if(!is_null($friends)){
                if(!in_array($new_friends_id, $friends)){
                    array_push($friends, $new_friends_id);
                    User::where('id', $user_id )->update(['friends'=> json_encode($friends)]);
                    return true;
                }
            }
        }
        return false;
    }*/
}
