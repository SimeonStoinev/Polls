@extends('layouts.app')

@section('content')
    <div class="container">
        <?php $id_item =''; if(isset($id)) { $id_item = $id; } ?>
        {{ Form::open(array('url' => '/polls/create/'.$id_item , 'method' => 'post', 'id' => 'createPoll_form'))}}
        @include('frontend.errors',['session_error' => 'question_error', 'name_error' => 'quetion'])


        @if( isset( $answers ))
            @if($status == 'draft')
                <div class="row">
                    <label>
                        <input class="col-md-12" type="text" name="question" value="{{ $question }}" placeholder="Въпрос" pattern=".{6,}" title="Въпросът трябва да съдържа 6 или повече символа." required="required"/>
                    </label>
                </div>
                <?php $c = 1;?>
                <ol id="answers">
                    @foreach($answers as $row)
                        <li class="col-md-12 keeper sortable">
                            <div class="handle"></div>
                            <label class="col-md-11 create_answers">
                                <input class="col-md-12" type="text" name="answers[]" value="{{ $row }}"/>
                            </label>
                            <button class="glyphicon glyphicon-minus" type="button"></button>
                        </li>
                    @endforeach
                </ol>

                <br/><br/>

                <button class="core-btn" type="submit">Обнови</button>
                <button class="core-btn" type="reset">Изчисти</button>
                <a href="/polls/delete/{{$id_item}}">
                    <button class="core-btn" type="button">Изтрий</button>
                </a>

                <span class="span_status">Статус:</span>
                <label class="select_menu">
                    <select name="status" class="select_for">
                        <option value="active">Активен</option>
                        <option value="closed" name="closed">Затворен</option>
                        <option value="draft" name="draft" selected>Скица</option>
                    </select>
                </label>

                <span class="span_for">Достъп:</span>
                <label id="sel_for" class="select_menu">
                    <select name="for_users" id="filter_for" class="select_for">
                        <option value="all" @if($for_users == 'all') selected @endif>Всички</option>
                        <option value="public" @if($for_users == 'public') selected @endif>Публичен</option>
                        <option value="group" @if($for_users == 'group') selected @endif>Група</option>
                    </select>
                </label>


                <label id="groups" @if($for_users == 'group') style="display: inline-block !important;" @endif>
                    <select name="for_groups" class="select_for">
                        <option value="">===</option>
                        @foreach(\App\Group::getPartGroups(Auth::id())->get() as $row )
                            <option value="{{ $row->group_id }}" @if($groupData != null) @if($row->group_id == $groupData->group_id) selected @endif @endif>{{ $row->title }}</option>
                        @endforeach
                    </select>
                </label>




                <button class="glyphicon glyphicon-plus" type="button"></button>

                @if($for_users == 'public')
                    <span class="poll_link">
                        Линк към анкетата: <a href="{{ '/poll/'.$slug }}" target="_blank">{{ '/poll/'.$slug }}</a>
                    </span>
                @endif


            @elseif($status == 'active')

                <h2 class="question">{{ $question }}</h2>
                <ol id="answers">
                    <?php $c = 1;?>
                    @foreach($answers as $row)
                        <li class="col-md-12 keeper activePoll_answers">
                            Отговор {{ $c }} - <span> {{ $row }} </span>
                        </li>
                        <?php $c++;?>
                    @endforeach
                </ol>

                <button class="core-btn" type="submit">Обнови</button>
                <a href="/polls/delete/{{$id_item}}">
                    <button class="core-btn" type="button">Изтрий</button>
                </a>
                <span class="span_status">Статус:</span>

                <label class="select_menu">
                    <select name="status" class="select_for">
                        <option value="active" selected>Активен</option>
                        <option value="closed" name="closed">Затворен</option>
                    </select>
                </label>
                @if($for_users == 'group')
                        До група: <a href="{{ '/group/'.$groupData->group_id }}" style="font-weight: bold;" target="_blank"> {{ $groupData->title }} </a>
                @endif
                @if($for_users == 'public')
                    <span class="poll_link">
                        Линк към анкетата: <a href="{{ '/poll/'.$slug }}" target="_blank">{{ '/poll/'.$slug }}</a>
                    </span>
                @endif

            @else

                <h2 class="question">{{ $question }}</h2>
                <ol id="answers">
                    <?php $c = 1;?>
                    @foreach($answers as $row)
                        <li class="col-md-12 keeper activePoll_answers">
                           Отговор {{ $c }} - <span> {{ $row }} </span>
                        </li>
                        <?php $c++;?>
                    @endforeach
                </ol>

                <a href="/polls/delete/{{$id_item}}">
                    <button class="core-btn" type="button">Изтрий</button>
                </a>

                @if($for_users == 'public')
                    <span class="poll_link">
                        Линк към анкетата: <a href="{{ '/poll/'.$slug }}" target="_blank">{{ '/poll/'.$slug }}</a>
                    </span>
                @endif

            @endif


        @else

            <h2>Създай анкета</h2>

            <div class="row">
                <label>
                    <input class="col-md-12" type="text" name="question" placeholder="Въпрос" pattern=".{6,}" title="Въпросът трябва да съдържа 6 или повече символа." required="required"/>
                </label>
            </div>
            <ol id="answers">
                <li class="col-md-12 keeper sortable">
                    <div class="handle"></div>
                    <label class="col-md-11 create_answers">
                        <input class="col-md-12" type="text" name="answers[]" placeholder="Отговор 1"/>
                    </label>
                    <button class="glyphicon glyphicon-minus" type="button"></button>
                </li>

                <li class="col-md-12 keeper sortable">
                    <div class="handle"></div>
                    <label class="col-md-11 create_answers">
                        <input class="col-md-12" type="text" name="answers[]" placeholder="Отговор 2"/>
                    </label>
                    <button class="glyphicon glyphicon-minus" type="button"></button>
                </li>
            </ol>

            <br/><br/>

            <button class="core-btn" type="submit">Създай</button>
            <button class="core-btn" type="reset">Изчисти</button>
            <span class="for">Достъп:</span>
            <label id="sel_for">
                    <select name="for_users" id="filter_for" class="select_for">
                        <option value="all">Всички</option>
                        <option value="public">Публичен</option>
                        <option value="group">Група</option>
                    </select>
            </label>
            <label id="groups">
                <select name="for_groups" class="select_for">
                    <option value="">===</option>
                    @foreach(\App\Group::getPartGroups(Auth::id())->get() as $row )
                        <option value="{{ $row->group_id }}">{{ $row->title }}</option>
                    @endforeach
                </select>
            </label>
            <button class="glyphicon glyphicon-plus" type="button"></button>
        @endif

        {{ Form::close() }}
    </div>
    <style>

        .container form{
            position: relative;
        }
        .container label {
            display: block;
        }
        .container label input {
            margin: 6px 0 4px 0;
            box-shadow: 1px 1px 1px #c7dfff;
            border: 2px #ebebeb solid;
            width: 100%;
        }
        .glyphicon-minus {
            display: none;
            margin-top: .2%;
            top: 0;
        }
        .glyphicon-plus{
            height: 42px;
            top: -1px;
        }
        .glyphicon-plus, .glyphicon-minus{
            transition: all .45s;
            background: rgba(0,167,157,.7);
            padding: 9px 1px;
            border-radius: 4px;
            color: rgba(255,255,255,1);
            outline: none;
            border: none !important;
            width: 50px;
        }
        .glyphicon-plus:hover, .glyphicon-minus:hover{
            background-color: rgba(0,150,140,.8) ;
        }
        .showMinus .glyphicon-minus {
            display: inline-block;
        }
        #answers{
            padding: 0;
        }
        .keeper {
            padding-left: 3%;
            list-style: none;
        }

        #groups.show_groups{
            display: none!important;
        }
        #sel_for, .select_menu, #groups{
            display: inline-block !important;
            margin-right: 3px;
            width: 100px;
        }
        .select_for{
            width: 100%;
            height: 41px;
            border-radius: 4px;
            color: rgba(255,255,255,1);
            background: rgba(0,167,157,.7);
            transition: all .45s;
            outline: none;
            border: none !important;
            font-size: 16px;
        }
        .select_for:hover{
            background-color: rgba(0,150,140,.8) ;
        }
        .select_for option{
            border: none !important;
            padding: 3px 0;
        }
        .for, .span_for, .span_status{
            font-size: 18px;
            color: #111;
            font-weight: bold;
            vertical-align: middle;
            padding: 0 3px 0 10px;
        }
        .handle{
            float: left;
            border-radius: 80%;
            margin-top: .3%;
            height: 30px;
            width: 35px;
            background: rgba(0,167,157,.7);
            transition: all .45s;
            text-align: center;
        }
        .handle:hover{
            background: rgba(0,150,140,.8);
        }
        .dragged{
            position: absolute;
            opacity: .9;
            -webkit-transform: scale(1.05);
            -moz-transform: scale(1.05);
            -ms-transform: scale(1.05);
            -o-transform: scale(1.05);
            transform: scale(1.05);
        }
        a:hover{
            text-decoration: none !important;
        }
        .activePoll_answers{
            font-size: 16px;
            padding: 6px 0 0 0;
        }
        .activePoll_answers > span{
            color: rgba(0, 167, 157, 1);
            font-size: 18px;
            text-shadow: 1px 1px 1px rgba(50,50,50,.5);
        }
        .poll_link > a{
            text-decoration: underline !important;
            font-weight: bold;
        }
    </style>
@endsection