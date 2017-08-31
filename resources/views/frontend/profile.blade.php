@extends('layouts.app')
@section('content')
    <div class="container">
        <ul class="profile_info">
            <li><span>Потребителско име:</span> {{ $name }}</li>
            <li><span>Е-майл:</span> {{ $email }}</li>
            <li><a href="/profile/edit/{{ $id }}">Редактирайте профила си</a></li>
        </ul>
    </div>
    <style>
        .profile_info{
            margin-top: 1%;
            text-align: center;
        }
        .profile_info>li{
            list-style: none;
            font-size: 20px;
            color: #434243;
            display: block;
        }
        .profile_info>li>span{
            font-size: 18px;
            color: #777;
            opacity: .85;
        }
        .profile_info>li>a{
            text-decoration: none;
            font-size: 20px;
            color: #000;
            text-shadow: 1px 1px 1px #999;
            -webkit-transition: .2s;
            -moz-transition: .2s;
            -ms-transition: .2s;
            -o-transition: .2s;
            transition: .2s;
        }
        .profile_info>li>a:hover{
            text-decoration: none;
            color: #000;
            text-shadow: 1px 1px 2px rgba(40, 122, 237, 0.2);
        }
    </style>
@endsection