@extends('layouts.app')

@section('content')
    <div class="container">
        {{ Form::open(array('url' => '/profile/edit/'.$id , 'method' => 'post'))}}

        @include('frontend.errors', ['session_error' => 'name_error', 'name_error' => 'name'])
        <label>
            <input class="col-md-12" type="text" name="name" value="{{ $name }}" placeholder="Потребителско име"/>
        </label>

        @include('frontend.errors', ['session_error' => 'mail_error', 'name_error' => 'mail'])
        <label>
            <input class="col-md-12" type="text" name="email" value="{{ $email }}" placeholder="Е-майл"/>
            <input type="hidden" name="old_email" value="{{ $email }}"/>
        </label>

        @include('frontend.errors', ['session_error' => 'same_password', 'name_error' => 'password'])
        <label>
            <input class="col-md-12" type="password" name="password" value="" placeholder="Нова парола"/>
        </label>

        <label>
            <input class="col-md-12" type="password" name="password_confirmation" value="" placeholder="Повторете новата парола"/>
        </label>

        <button class="core-btn" type="submit">Обнови</button>
        <a href="/profile/delete/{{$id}}">
            <button class="core-btn" type="button">Изтрий</button>
        </a>

        {{ Form::close() }}
    </div>
    <style>
        form{
            margin-top: 1%;
        }
        .container label {
            display: block;
        }

        .container label input {
            margin-bottom: 13px;
            box-shadow: 1px 1px 1px #c7dfff;
            border: 2px #ebebeb solid;
            width: 100%;
        }
    </style>

@endsection