<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SendMessage;
use App\Pool;
use App\Helper\Paging;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page=1)
    {
        $allItems = Pool::getAllForAllPolls()->count();
        $paging = Paging::create($allItems, 6, $page, url('/home/'), 2);
        $currPage = $page;
        $allPages = ceil( $allItems / 6 );
        $data = Pool::getAllForAllPolls()->offset($paging['skip'])->limit($paging['perPage'])->get();

        return view('home', ['data' => $data, 'allUnreadRecievedMsg' => SendMessage::getAllUnreadRecievedMsg(), 'currUser' => Auth::user(), 'paging' => $paging['paging'], 'mainPage' => 1, 'currPage' => $currPage, 'allPages' => $allPages]);
    }
}
