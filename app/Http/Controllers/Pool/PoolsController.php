<?php

namespace App\Http\Controllers\Pool;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PollRequest;
use Illuminate\Support\Facades\Auth;
use App\Pool;
use App\Votes;
use App\PollGroups;
use App\SendMessage;


class PoolsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }




    public function viewCreatePoll($id=0)
    {
        $data = [];
        $groupPollId = '';
        if($id!=0){
            $data = $this->jsonIn( Pool::where('id', $id)->where('creator_id', $this->getUserId())->first() );
            $groupPollId = PollGroups::getPollIdGroupInfo($id)->first();
        }
        return view('frontend.create-poll', $data, ['groupData' => json_decode($groupPollId)]);
    }


    public function createPoll(Request $request, $id=0)
    {
        $data = $request->except('_token','');
        $user_id =  Auth::user()['id'];
        $poll = Pool::getPoll($id)->first();
        $slug_2ndPart = '-'.$this->getUserId().'-'.str_random(32);

        if($id==0)
        {
            $jsonAnswers = $data['answers'];
            unset($data['for_groups']);

            $data = Pool::create(['question' => $data['question'], 'answers' => json_encode($jsonAnswers), 'creator_id' => $this->getUserId(), 'status' => 'draft', 'for_users' => $data['for_users'], 'slug' => date('d-m-Y').$slug_2ndPart]);
            $id = $data->id;

            if($data->for_users == 'group'){
                PollGroups::create(['group_id' => $request->get('for_groups'), 'pool_id' => $id]);
            }
        }
        else{
            if($poll['creator_id'] == $user_id ){

                if($poll->status == 'active'){
                    unset($data['id']);
                    unset($data['question']);
                    unset($data['answers']);
                }

                elseif($poll->status == 'closed' || $poll->status == 'banned'){
                    $data = [];
                }

                if($data){
                    if($poll->status == 'draft'){
                        $data['answers'] = json_encode($data['answers']);
                    }
                    if($request->get('for_users') == 'group'){
                        PollGroups::where('pool_id', $id)->update(['group_id' => $request->get('for_groups')]);
                    }
                    unset($data['for_groups']);
                    Pool::where('id', $id)->where('creator_id', $user_id)->update($data);
                    return redirect('polls/create/'.$id)->with('success', 'Updated successfully');
                }
            }
            else{
                return view('frontend.view-notyours-poll', ['pollData' => $poll]);
            }
        }

        return redirect('polls/create/'.$id)->with('success', 'Created successfully');
    }





    public function viewDeletePoll($id=0){
        $data = [];
        if($id!=0){
            $data = Pool::getPoll($id)->where('creator_id', Auth::user()['id'])->first();
        }
        return view('frontend.delete-poll', ['pollData' => $data]);
    }

    public function deletePoll($id=0){
        $data = Pool::getPoll($id)->where('creator_id', Auth::user()['id'])->first();
        if(!$data){
            return redirect()->back();
        }
        else{
            Pool::getPoll($id)->where('id', $id)->delete();
            return redirect('/home')->with('success', 'Poll deleted successfully');
        }
    }


    public function minePolls(){
        $pollsId = [];
        $allItemsPerPoll = [];
        foreach(Pool::getMinePolls()->get() as $key => $row){
            $pollsId[$key] = Votes::getVotes($row->id);
        }
        $getAllVotesPerPoll = $pollsId;
        foreach($getAllVotesPerPoll as $key2 => $row2){
            $allItemsPerPoll[$key2] = $row2->allItems;
        }

        return view('frontend.mine-polls', ['pollsData' => Pool::getMinePolls()->get(), 'allItemsPerPoll' => $allItemsPerPoll]);
    }


    public function votedPolls(){
        return view('frontend.voted-polls', ['items' => Votes::getVotedPolls()->get()]);
    }




    private function jsonIn($data){
        $filtered = json_encode($data);
        $filtered = json_decode($filtered);
        if(is_object($filtered)){

            foreach($filtered as $key=>$row){

                $json = json_decode($row);
                if(!is_null($json)){
                    $data[$key] = $json;
                }
            }
        }
        return $data;
    }

    private function getUserId(){
        $user = Auth::user();
        return $user->id;
    }
}