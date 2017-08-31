<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\SendMessage;
use App\Message;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }





    public function viewUserProfile()
    {
        return view('frontend.profile', ['id' => Auth::user()['id'], 'name' => $this->currentUser()->name, 'email' => $this->currentUser()->email]);
    }


    public function viewExactProfile(Request $request, $id=0){
        $userData = User::getUser($id)->first();
        $data = $request->except('_token');


        if(!empty($data)){
            $message = Message::create(['author_id' => Auth::user()['id'], 'content' => Auth::user()['name'].' желае да се сприятели с вас.', 'type' => 'invite']);
            $sentMessage = SendMessage::create(['members_id' => $data['user_id'], 'message_id' => $message['id'], 'invite_flag' => 'pending']);
        }

        if(!empty($saveMsgId)){
            $getMessage = SendMessage::getMessage($saveMsgId)->first();
        }
        else{
            $getMessage = '';
        }


        if($id == Auth::user()['id'] || User::getUser($id)->first() == null){
            return view('errors.notfound-profile');
        }
        else{
            return view('frontend.view-exactprofile', ['userData' => $userData, 'getMessage' => $getMessage]);
        }
    }


    public function viewEditProfile() {
        return view('frontend.edit-profile', ['id' => Auth::user()['id'], 'name' => $this->currentUser()->name, 'email' => $this->currentUser()->email]);
    }


    public function editProfile(UserRequest $request, $id=0){
        $data = $request->except('_token', 'old_email', 'password_confirmation');

        if(!empty($data['password'])  &&  Hash::check($data['password'], $this->currentUser()->password)){
            var_dump('test');
            return redirect()->back()->with('same_password', 'Same Password');
        }

        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        User::getUser($id)->update($data);
        return redirect('/profile')->with('success', 'Your profile was edited successfully.');
    }




    public function viewDeleteUser($id=0){
        return view('frontend.delete-user');
    }

    public function deleteUser($id=0){
        $data = User::getUser(Auth::user()['id'])->where('id', Auth::user()['id']);
        if(!$data){
            return redirect()->back();
        }
        else{
            User::getUser(Auth::user()['id'])->where('id', Auth::user()['id'])->delete();
            return redirect('/')->with('success', 'User deleted successfully');
        }
    }




    public function viewMemberListing(Request $request, $string=''){
        if(Input::get('search') != ''){
            return redirect('listing/members/'.trim(Input::get('search')));
        }

        if($this->currentUser()->rank=='member'){
            return redirect('/')->with('no_permission', 'Nqmate prava, za da vidite tazi stranica');
        }

        $data = $request->except('_token', 'id', 'search');

        if($data){
            User::where('id', $request->get('id'))->update($data);
        }

        $getSearchData = User::searchUsers($string)->get();

        if($getSearchData){
            $data2 = $request->except('_token', 'id', 'search');
            User::where('id', $request->get('id'))->update($data2);
        }

        return view('frontend.member-listing', ['allMembers' => User::getAllMembers(), 'searchData' => $getSearchData]);
    }




    public function viewAdminListing(Request $request, $string=''){
        if(Input::get('search') != ''){
            return redirect('listing/admins/'.trim(Input::get('search')));
        }

        if($this->currentUser()->rank=='member' || $this->currentUser()->rank=='admin'){
            return redirect('/')->with('no_permission', 'Nqmate prava, za da vidite tazi stranica');
        }

        $data = $request->except('_token', 'id', 'search');

        if($data){
            User::where('id', $request->get('id'))->update($data);
        }

        $getSearchData = User::searchUsers($string)->get();

        if($getSearchData){
            $data2 = $request->except('_token', 'id', 'search');
            User::where('id', $request->get('id'))->update($data2);
        }

        return view('frontend.admin-listing', ['allAdmins' => User::getAllAdmins(), 'searchData' => $getSearchData]);
    }









    private function currentUser(){
        $user = Auth::user();
        return $user;
    }
}