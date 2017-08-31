<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pool;
use App\Votes;
use Illuminate\Support\Facades\Auth;
use App\Helper\Paging;


class WelcomeController extends Controller
{
    public function __construct()
    {
        if (Auth::check()) {
            $this->middleware('auth');
        }
    }


    public function index($page=1)
    {
        $allItems = Pool::getAllPolls()->count();
        $paging = Paging::create($allItems, 6, $page, url('/'), 2);
        $currPage = $page;
        $allPages = ceil( $allItems / 6 );
        $data = Pool::getAllPolls()->offset($paging['skip'])->limit($paging['perPage'])->get();

        return view('welcome', ['data' => $data, 'paging' => $paging['paging'], 'mainPage' => 1, 'currPage' => $currPage, 'allPages' => $allPages ]);
    }


    public function votePollAjax(Request $request)
    {
        $data = $request->except('_token');

        if (!Auth::check()) {
            $content = '<p class="alert alert-danger already_voted">Не сте логнат и не можете да гласувате!<button type="button" >X</button></p>';

            return ['error' => $content];
        }

        if ($data['id'] && $data['answer']) {
            if (!Votes::where('pool_id', $data['id'])->where('user_id', Auth::user()['id'])->count()) {
                Votes::create(['pool_id' => $data['id'], 'user_id' => Auth::user()['id'], $data['answer'] => 1]);
                $results = json_decode(Votes::getVotes($data['id']));

                return ['results' => $results];
            }
            else {
                $results = json_decode(Votes::getVotes($data['id']));
                $content = '<p class="alert alert-danger already_voted">Вие вече сте гласували за тази анкета! <button type="button">X</button></p>';

                return ['results' => $results, 'error' => $content];
            }
        }
    }


    public function resultsPollAjax(Request $request, $id = '')
    {
        if (empty($id)) {
            abort(404);
        }

        $results = json_decode(Votes::getVotes($id));

        return ['results' => $results];


        /*if (Auth::check()) {
            $results =   json_decode(Votes::getVotes($id ));

            return ['results' => $results];
        }
        $results =   json_decode(Votes::getVotesPublic( $id ));

        if( $results ){
          return  ['error' => '<p class="alert alert-danger already_voted">Някаква грешка!</p>'];
        }

        return ['results' =>  $results];*/
    }


    public function viewExactPublicPoll($slug = '')
    {
        $pollData = Pool::getPublicPoll($slug)->first();
        if(!$pollData){
            abort(404);
        }
        else{

            return view('frontend.poll-public-anonVotes', ['pollData' => $pollData, 'auth_id' => Auth::user()['id']]);
        }
    }

    public function voteExactPublicPoll(Request $request)
    {
        $data = $request->except('_token');

        if( Votes::where('pool_id',$data['id'])->where('ip_address',$request->ip() )->where('user_agent',$request->header('User-Agent'))->count() == 0 ){
            Votes::create(['pool_id' => $data['id'], 'user_id' => 0 , $data['answer'] => 1, 'ip_address' => $request->ip(), 'user_agent' => $request->header('User-Agent')]);
            $results = json_decode(Votes::getVotes($data['id']));
            return ['results' => $results];
        }

        $content = '<p class="alert alert-danger already_voted">Вие вече сте гласували за тази анкета! <button type="button">X</button></p>';
        return ['error' => $content];
    }
}