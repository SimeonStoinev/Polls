@extends('layouts.app')

@section('content')
    <div class="container">
    {{ Form::open(array('url' => '/profile/'.$userData->id , 'method' => 'post')) }}

        <ul class="container">
            <li class="profile"><span>Username:</span> {{ $userData->name }}</li>
            <li class="profile"><span>Email:</span> {{ $userData->email }}</li>
        </ul>

        <input name="user_id" type="hidden" value="{{ $userData->id }}"/>

        @if(!empty($getMessage) && $getMessage['invite_flag'] == 'accepted')
            <button class="btn btn-primary" type="submit">Remove Friendship</button>
        @else
            <button class="btn btn-primary" type="submit">Send Friend Request</button>
        @endif

    {{ Form::close() }}
    </div>
    <style>
        form{
            margin-top: 1%;
        }
        .container .profile{
            list-style: none;
            font-size: 20px;
            color: #434243;
            display: block;
        }
        .container .profile>span{
            font-size: 18px;
            color: #777;
            opacity: .85;
        }
        .container .profile>a{
            font-size: 20px;
            opacity: .9;
            -webkit-transition: .2s;
            -moz-transition: .2s;
            -ms-transition: .2s;
            -o-transition: .2s;
            transition: .2s;
        }
        .container .profile>a:hover{
            opacity: 1.1;
        }
    </style>
@endsection