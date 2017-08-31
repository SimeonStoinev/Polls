@extends('layouts.app')
@section('content')
    <div class="container">
        {{ Form::open(array('url' => '/polls/delete/'.$pollData->id , 'method' => 'post'))}}

            <span>Сигурни ли сте, че искате да изтриете вашата анкета?</span><br/>
            <button class="btn btn-danger" type="submit">Да!</button>
            <a href="{{ url('/polls/create/'.$pollData->id) }}">
                <button class="btn btn-primary" type="button">Не!</button>
            </a>

        {{ Form::close() }}
    </div>
    <style>
        form{
            margin-top: 1%;
            text-align: center;
        }
        .container label{
            display: block;
        }
        span{
            font-size: 16px;
        }
        .container label input{
            margin-bottom: 13px;
            box-shadow: 1px 1px 1px #c7dfff;
            border: 2px #ebebeb solid;
        }
    </style>
@endsection