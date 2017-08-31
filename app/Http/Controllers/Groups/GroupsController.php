<?php

namespace App\Http\Controllers\Groups;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Group;
use App\GroupUsers;
use App\User;
use App\Message;
use App\SendMessage;
use App\PollGroups;
use App\Pool;

class GroupsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function viewCreateGroup($id=0)
    {
        $listMembers = User::getAllActiveMembers()->get();
        $data = [];
        $alreadyGrpMembers = [];
        $pendingGrpMembers = [];

        if($id!=0){
            $data = Group::getGroup($id)->where('creator_id', $this->getUserId())->first();
            $alreadyGrpMembers = GroupUsers::getGroupMembers($id)->get();
            $pendingGrpMembers = GroupUsers::getPendingGroupMembers($id)->get();
        }

        return view('groups.create-group', ['data' => $data, 'listMembers' => $listMembers, 'groupMembers' => $alreadyGrpMembers, 'pendingGroupMembers' => $pendingGrpMembers]);
    }


    public function createGroup(Request $request, $id=0)
    {
        $data = $request->except('_token', 'search');
        $user_id =  Auth::user()['id'];
        $group = Group::getGroup($id)->first();
        $alreadyGrpMembers = GroupUsers::getGroupMembers($id)->get();


        if($id==0)
        {
            if(!empty($data['members'])){
                $invited = $data['members'];
            }
            else{
                return redirect()->back()->with('creategrp_failed', 'Вашата група не беше създадена успешно поради липса на потребители.');
            }

            $data = Group::create(['title' => $data['title'], 'description' => $data['description'], 'creator_id' => Auth::user()['id'], 'category' => $data['category'], 'status' => 'active']);
            $id = $data->id;
            $message = Message::create(['author_id' => Auth::user()['id'], 'content' => 'Вие бяхте поканен за група '.$data['title'], 'type' => 'invite']);
            GroupUsers::create(['user_id' => Auth::user()['id'], 'group_id' => $id, 'status' => 'active', 'rank' => 'owner']);
            foreach($invited as $row){
                GroupUsers::create(['user_id' => $row, 'group_id' => $id, 'status' => 'pending', 'rank' => 'member']);
                SendMessage::create(['members_id' => $row, 'message_id' => $message['id'], 'invite_flag' => 'pending']);
            }
        }

        else
        {
            if($group['creator_id'] == $user_id){
                if(isset($data['members']) || isset($data['currmembers'])){
                    if(isset($data['currmembers'])){
                        $currmembers = $data['currmembers'];
                    }
                    $oldMembers = [];

                    foreach($alreadyGrpMembers as $row){
                        array_push($oldMembers, $row->user_id);
                    }
                    if(isset($data['currmembers']) && isset($currmembers)){
                        $removedMembers = array_diff($oldMembers, $currmembers);
                    }
                    if(isset($removedMembers)){
                        if($removedMembers)
                        {
                            $message = Message::create(['author_id' => Auth::user()['id'], 'content' => 'Вие бяхте премахнат от група '.$data['title'], 'type' => 'message']);
                            foreach($removedMembers as $row3){
                                GroupUsers::where('user_id', $row3)->delete();
                                SendMessage::create(['members_id' => $row3, 'message_id' => $message['id'], 'invite_flag' => 'none']);
                            }
                        }
                    }


                    if(isset($data['members'])){
                        $newmembers = $data['members'];
                        if(isset($currmembers)){
                            $addedMembers = array_diff($newmembers, $currmembers);
                        }
                        if(isset($addedMembers)){
                            if($addedMembers)
                            {
                                $message = Message::create(['author_id' => Auth::user()['id'], 'content' => 'Вие бяхте поканен за група '.$data['title'], 'type' => 'invite']);
                                foreach($addedMembers as $row2){
                                    GroupUsers::create(['user_id' => $row2, 'group_id' => $id, 'status' => 'pending', 'rank' => 'member']);
                                    SendMessage::create(['members_id' => $row2, 'message_id' => $message['id'], 'invite_flag' => 'pending']);
                                }
                            }
                        }
                    }
                    unset($data['members']);
                    unset($data['currmembers']);
                }

                if($data){
                    Group::where('id', $id)->where('creator_id', $user_id)->update($data);
                }


                return redirect('groups/create/'.$id);
            }
        }
        return redirect('groups/create/'.$id)->with('success', 'Created successfully');
    }



    public function viewExactGroup($id=0)
    {
        $pollsData = Group::getAllGroupPolls()->get();
        $getGrpUsers = GroupUsers::getAllGroupUsers($id)->get();
        $group = Group::getGroup($id)->first();
        $groupOwner = GroupUsers::getGroupOwner($id)->first();

        return view('groups.view-group', ['group' => $group, 'pollsData' => $pollsData, 'groupUsers' => $getGrpUsers, 'authId' => Auth::id(), 'grpOwner' => $groupOwner]);
    }







    public function listMineGroups(){
        $getGroups = Group::getMineGroups(Auth::user()['id'])->get();
        return view('groups.list-minegroups', ['groupsData' => $getGroups]);
    }


    public function listPartGroups(){
        $getGroups = Group::getPartGroups(Auth::user()['id'])->get();
        return view('groups.list-partgroups', ['groupsData' => $getGroups]);
    }









    public function viewDeleteGroup($id=0){
        $data = [];
        if($id!=0){
            $data = Group::getGroup($id)->where('creator_id', Auth::user()['id'])->first();
        }
        return view('groups.delete-group', ['groupData' => $data]);
    }

    public function deleteGroup($id=0){
        $data = Group::getGroup($id)->where('creator_id', Auth::user()['id'])->first();
        if(!$data){
            return redirect()->back();
        }
        else{
            Group::getGroup($id)->where('id', $id)->delete();
            return redirect('home')->with('success', 'Group deleted successfully');
        }
    }










    private function getUserId(){
        $user = Auth::user();
        return $user->id;
    }
}
