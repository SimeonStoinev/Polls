@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        {{ Form::open(array('url' => '/messages' , 'method' => 'post', 'class' => 'creategrp_msg')) }}

        <h2>Напиши съобщение</h2>
        <div id="users_keeper">
            <span class="addition">До:</span><br/>
            <label style="width: 100%;">
                <input class="search_input form-control" type="text" placeholder="Търсене..." name="search"/>
                <button class="core-btn searchUsers_button" type="button">Търси</button>
            </label>
            <br/>

            @if(!empty($allMembers))

                @foreach($allMembers as $row)
                    <label class="checkbox_keeper" style="display: none;">
                        <input name="members[]" type="checkbox" value="{{ $row->id }}"/>
                        <span class="after_chkbox">{{ $row->name }}, {{ $row->email }}</span>
                        <button class="close_searchedResult" type="button">X</button>
                    </label>
                @endforeach

            @endif
        </div>
        <label class="label_content">
            <span class="addition">Съдържание:</span><br/>
            <textarea class="form-control" name="msgcontent" maxlength="500" required="required"></textarea>
        </label>
        <br/>
        <button type="submit" class="core-btn" value="Submit">Изпрати</button>

        {{ Form::close() }}
    </div>
    <style>
        form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-75%);
            margin-top: 1%;
        }
        .addition{
            font-size: 18px;
            color: #111;
            font-weight: bold;
            vertical-align: middle;
        }
        .checkbox_keeper{
            width: auto;
            padding: 0;
            vertical-align: middle;
            text-align: left;
        }
        input[type=checkbox]{
            vertical-align: middle !important;
            margin: -1px 1px 0 0 !important;
        }
        .after_chkbox{
            color: #000;
            font-size: 16px;
            display: inline;
        }
        .label_content{
            width: 350px;
            height: 300px;
            margin-bottom: 8%;
        }
        .label_content > textarea{
            resize: none;
            border-radius: 2px;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection