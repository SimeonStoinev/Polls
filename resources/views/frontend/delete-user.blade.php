@extends('layouts.app')
@section('content')
    <div class="container">
        <?php $id_item = '';if( isset( $id ) ) {$id_item = $id;} ?>
        {{ Form::open(array('url' => '/profile/delete/'.$id_item , 'method' => 'post'))}}

            <span>Сигурни ли сте, че искате да изтриете вашия профил?</span><br/>
            <button class="btn btn-danger" type="submit">Да!</button>
            <a href="/profile/edit/{{$id_item}}" class="btn btn-primary">Не!</a>

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
        .container label input{
            margin-bottom: 13px;
            box-shadow: 1px 1px 1px #c7dfff;
            border: 2px #ebebeb solid;
        }
    </style>
@endsection