@extends('layouts.app')
@section('content')
    <img src="{{url('css/img/information-icon-27.png')}}" id="trigger_info" style="position: absolute;right: 1.5%;">
    <span id="group_info">
        Категория -
        @if($group->category == 'news') Новини @endif
        @if($group->category == 'school') Училище @endif
        @if($group->category == 'work') Работа @endif
        @if($group->category == 'entertainment') Забавление @endif
        @if($group->category == 'celebrities') Знаменитости @endif
        @if($group->category == 'politics') Политика @endif
        @if($group->category == 'business') Бизнес @endif
        @if($group->category == 'music') Музика @endif
        @if($group->category == 'others') Друга @endif
        <br/>
        Създател - {{ $grpOwner['name'] }}
        <br/>
        <span>Описание - {{ $group->description }} </span>
    </span>
    <div class="container">
        <h2 style="font-weight: bold;">{{ $group->title }}</h2>

        <div class="row">
            <div class="col-md-10 groupPoll_keeper">
                <ul class="grid">
                    <li class="grid-sizer"></li>
                    <li class="gutter-sizer"></li>
                    @foreach($pollsData as $row)
                        <li class="eachpool grid-item">
                            <form class="pool" action="{{url('/')}}" method="post">
                                <div class="itemPool">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <section class="front">
                                        <h2 class="question">{{ $row->question }}</h2>
                                        <?php $c = 0; ?>
                                        @foreach(json_decode($row->answers) as $row2)
                                            <?php $c++; ?>
                                            <label class="input-group-addon">
                                                <div class="gradient">
                                                    <div><div></div></div>
                                                </div>
                                                <span>
                                                   <input type="radio" name="radiob" value="a{{ $c-1 }}"/>
                                                </span>
                                                <span class="after_radio">{{ $row2 }}</span>
                                            </label>
                                        @endforeach
                                        <div style="width: 100%;position: relative;margin-top: 15px;">
                                            @if($row->creator_id == Auth::id())

                                            @else
                                                <button class="get_id" name="submit" type="button" onclick="submit_vote($(this).parent().parent().parent().parent() , <?php echo $row->id ?>)">Гласувай</button>
                                            @endif
                                            <button class="view_results" type="button" onclick="get_results($(this).parent().parent().parent() ,<?php echo $row->id ?>)">Виж резултатите</button>
                                            <span class="from">От: {{ $row->name }}</span>
                                        </div>
                                    </section>
                                </div>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-2 rightlisting">
                <h3 style="margin-top: 0;padding-left: 5px;">Участници:</h3>
                <ul id="inGrp_listing">
                    @foreach($groupUsers as $row)
                        @if($row->user_id == $authId)
                            <li class="me">{{ $row->name }}, {{ $row->email }}</li>
                        @else
                            <li>{{ $row->name }}, {{ $row->email }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <style>
        .rightlisting{
            margin-top: .8%;
            border-left: 1px solid rgba(0,0,0,.25);
        }
        #inGrp_listing{
            padding: 3px 0 3px 5px;
            list-style: none;
        }
        #inGrp_listing>.me{
            color: #000;
            font-weight: 600;
            text-shadow: 1px 1px 1px rgba(0,167,157,.2);
            font-size: 16px;
            padding-bottom: 10px;
        }
        .core-btn{
            margin: 10px 0 2px 0;
        }
    </style>
@endsection