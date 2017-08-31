@extends('layouts.app')
@section('content')
    <div class="container">
        <?php $id_item =''; if(isset($data->id)) { $id_item = $data->id; } ?>
        {{ Form::open(array('url' => '/groups/create/'.$id_item , 'method' => 'post' , 'class' => 'main_form creategrp_msg'))}}


        @if( isset( $data->title ))

                @if($data->status == 'active')
                        <h2 style="display: block;margin-top: 35%">Редактирай група</h2>

                        <label class="label_title">
                            <span class="addition">Заглавие:</span>
                            <br/>
                            <input class="form-control" type="text" name="title" value="{{ $data->title }}" pattern=".{6,}" title="Заглавието трябва да съдържа 6 или повече символа." required="required"/>
                        </label>
                        <br/>
                        <label class="label_descript">
                            <span class="addition">Описание:</span>
                            <br/>
                            <textarea class="form-control" name="description" maxlength="600" required="required">{{ $data->description }}</textarea>
                        </label>
                        <br/>

                        <div id="select_keeper">
                            <label>
                                <span class="addition">Категория:</span><br/>
                                <select name="category" class="select_for">
                                    <option value="news" @if($data->category == 'news') selected @endif>Новини</option>
                                    <option value="school" @if($data->category == 'school') selected @endif>Училище</option>
                                    <option value="work" @if($data->category == 'work') selected @endif>Работа</option>
                                    <option value="entertainment" @if($data->category == 'entertainment') selected @endif>Забавление</option>
                                    <option value="celebrities" @if($data->category == 'celebrities') selected @endif>Знаменитости</option>
                                    <option value="politics" @if($data->category == 'politics') selected @endif>Политика</option>
                                    <option value="business" @if($data->category == 'business') selected @endif>Бизнес</option>
                                    <option value="music" @if($data->category == 'music') selected @endif>Музика</option>
                                    <option value="others" @if($data->category == 'others') selected @endif>Друга</option>
                                </select>
                            </label>
                            <label>
                                <span class="addition">Статус:</span><br/>
                                <select name="status" class="select_for">
                                    <option value="active" selected>Активна</option>
                                    <option value="closed">Затворена</option>
                                </select>
                            </label>
                        </div>
                        <br/>

                        <div id="users_keeper">
                            <span class="addition">Поканете хора в групата:</span><br/>
                            <label style="width: 100%;">
                                <input class="search_input form-control" type="text" placeholder="Търсене..." name="search"/>
                                <button class="core-btn searchUsers_button" type="button">Търси</button>
                            </label>
                            <br/>

                            @if(!empty($listMembers))

                                @foreach($listMembers as $row)
                                    <label class="checkbox_keeper" style="display: none;">
                                        <input name="members[]" type="checkbox" value="{{ $row->id }}"/>
                                        <span class="after_chkbox">{{ $row->name }}, {{ $row->email }}</span>
                                        <button class="close_searchedResult" type="button">X</button>
                                    </label>
                                @endforeach

                            @endif

                            @if(Session::has('creategrp_failed'))
                                <label style="font-size: 12px;color: #a94442;;">{{ Session::get('creategrp_failed') }}</label>
                                <br/>
                            @endif
                        </div>

                        @if(json_decode($groupMembers) != [])

                            <label>
                                <span class="addition">Активни членове на групата:</span><br/>


                                @foreach($groupMembers as $row)
                                    <label class="checkbox_keeper">
                                        <input name="currmembers[]" type="checkbox" value="{{ $row->user_id }}" checked/>
                                        <span class="after_chkbox">{{ $row->name }}, {{ $row->email }}</span>
                                    </label>
                                    <br/>
                                @endforeach

                            </label>
                            <br/>
                        @endif

                        @if(json_decode($pendingGroupMembers) != [])

                            <label>
                                <span class="addition">Изчаква се потвърждение от:</span><br/>

                                @foreach($pendingGroupMembers as $row)
                                    <label class="checkbox_keeper">
                                        <span class="after_chkbox">{{ $row->name }}, {{ $row->email }}</span>
                                    </label>
                                    <br/>
                                @endforeach

                            </label>
                            <br/>
                        @endif


                        <button class="core-btn" type="submit">Обнови</button>
                        <button class="core-btn" type="reset">Изчисти</button>
                        <a href="/groups/delete/{{$data->id}}">
                            <button class="core-btn" type="button">Изтрий</button>
                        </a>


                @else

                    <h2 style="display: block;margin-top: 35%">Редактирай група</h2>

                    <label class="label_title">
                        <span class="addition">Заглавие:</span>
                        <br/>
                        <input class="form-control" type="text" name="title" value="{{ $data->title }}" pattern=".{6,}" title="Заглавието трябва да съдържа 6 или повече символа." required="required"/>
                    </label>
                    <br/>
                    <label class="label_descript">
                        <span class="addition">Описание:</span>
                        <br/>
                        <textarea class="form-control" name="description" maxlength="600" required="required">{{ $data->description }}</textarea>
                    </label>
                    <br/>

                    <div id="select_keeper">
                        <label>
                            <span class="addition">Категория:</span><br/>
                            <select name="category" class="select_for">
                                <option value="news" @if($data->category == 'news') selected @endif>Новини</option>
                                <option value="school" @if($data->category == 'school') selected @endif>Училище</option>
                                <option value="work" @if($data->category == 'work') selected @endif>Работа</option>
                                <option value="entertainment" @if($data->category == 'entertainment') selected @endif>Забавление</option>
                                <option value="celebrities" @if($data->category == 'celebrities') selected @endif>Знаменитости</option>
                                <option value="politics" @if($data->category == 'politics') selected @endif>Политика</option>
                                <option value="business" @if($data->category == 'business') selected @endif>Бизнес</option>
                                <option value="music" @if($data->category == 'music') selected @endif>Музика</option>
                                <option value="others" @if($data->category == 'others') selected @endif>Друга</option>
                            </select>
                        </label>
                        <label>
                            <span class="addition">Статус:</span><br/>
                            <select name="status" class="select_for">
                                <option value="active">Активна</option>
                                <option value="closed" selected>Затворена</option>
                            </select>
                        </label>
                    </div>
                    <br/>

                    <button class="core-btn" type="submit">Обнови</button>
                    <button class="core-btn" type="reset">Изчисти</button>
                    <a href="/groups/delete/{{$data->id}}">
                        <button class="core-btn" type="button">Изтрий</button>
                    </a>

                @endif

        @else

        <h2>Създай група</h2>

        <label class="label_title">
            <span class="addition">Заглавие:</span>
            <br/>
            <input class="form-control" type="text" name="title" pattern=".{6,}" title="Заглавието трябва да съдържа 6 или повече символа." required="required"/>
        </label>
        <br/>
        <label class="label_descript">
            <span class="addition">Описание:</span>
            <br/>
            <textarea class="form-control" name="description" maxlength="600" required="required"></textarea>
        </label>
        <br/>

        <label>
            <span class="addition">Категория:</span><br/>
            <select name="category" class="select_for">
                <option value="news">Новини</option>
                <option value="school">Училище</option>
                <option value="work">Работа</option>
                <option value="entertainment">Забавление</option>
                <option value="celebrities">Знаменитости</option>
                <option value="politics">Политика</option>
                <option value="business">Бизнес</option>
                <option value="music">Музика</option>
                <option value="others">Друга</option>
            </select>
        </label>
        <br/>
        <div id="users_keeper">
            <span class="addition">Поканете хора в групата:</span><br/>
            <label style="width: 100%;">
                <input class="search_input form-control" type="text" placeholder="Търсене..." name="search"/>
                <button class="core-btn searchUsers_button" type="button">Търси</button>
            </label>
            <br/>

            @if(!empty($listMembers))

                @foreach($listMembers as $row)
                    <label class="checkbox_keeper" style="display: none;">
                        <input name="members[]" type="checkbox" value="{{ $row->id }}"/>
                        <span class="after_chkbox">{{ $row->name }}, {{ $row->email }}</span>
                        <button class="close_searchedResult" type="button">X</button>
                    </label>
                @endforeach

            @endif
            @if(Session::has('creategrp_failed'))
                <label style="font-size: 12px;color: #a94442;;">{{ Session::get('creategrp_failed') }}</label>
                <br/>
            @endif
        </div>


        <button class="core-btn" type="submit">Създай</button>
        <button class="core-btn" type="reset">Изчисти</button>

        @endif
        {{ Form::close() }}
    </div>
    <style>
        .main_form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-60%);
            margin-top: 1%;
        }
        .label_title{
            width: 400px;
            height: 30px;
            margin-bottom: 1.5%;
        }
        .label_descript{
            width: 400px;
            height: 350px;
            margin: 1% 0 8% 0;
         }
        .label_descript > textarea{
            resize: none;
        }
        .label_title > input, .label_descript > textarea{
            border-radius: 2px;
            width: 100%;
            height: 100%;
        }
        .select_for{
            width: 150px;
            height: 41px;
            border-radius: 4px;
            color: rgba(255,255,255,1);
            background-color: rgba(0,167,157,.7);
            transition: all .45s;
            outline: none;
            border: none !important;
            font-size: 16px;
            cursor: pointer;
        }
        .select_for:hover{
            background-color: rgba(0,150,140,.8) ;
        }
        .select_for option{
            border: none !important;
            padding: 3px 0;
            cursor: pointer;
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
    </style>
    <script>

    </script>
@endsection