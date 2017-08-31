<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Poll Smith</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.2/jquery.fullPage.css"/>
    <style>

    </style>

    <!-- Scripts -->
    <script src="/js/masonry.pkgd.min.js"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>

<body>
<nav id="mainNav">
    <a id="logo"  href=" @if(Auth::guest()) {{  url('/') }} @else {{ url('/home') }} @endif "><img src="{{url('css/img/logoPollSmith.png')}}"></a>
    <ul class="nav navbar-nav navbar-right">
        @if (Auth::guest())
            <li><a class="actionBut" href="{{ url('/login') }}">Влез</a></li>
            <li><a class="regBut" href="{{ url('/register') }}">Регистрация</a></li>
        @else

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    Анкети <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">

                    <li><a href="{{ url('/polls/create') }}">Създай анкета</a></li>
                    <li><a href="{{ url('/polls/mine') }}">Моите анкети</a></li>
                    <li><a href="{{ url('/polls/voted') }}">Гласувани</a></li>

                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    Групи <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">

                    <li><a href="{{ url('/groups/create') }}">Създай група</a></li>
                    <li><a href="{{ url('/groups/mine') }}">Моите групи</a></li>
                    <li><a href="{{ url('/groups/participate') }}">Участие в групи</a></li>

                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    Съобщения <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">

                    <li><a href="{{ url('messages') }}">Напиши съобщение</a></li>

                    <li class="position-left">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Получени
                        </a>
                        <ul class="dropdown-menu-left" role="menu">
                            <li><a href="{{ url('/messages/recieved/read') }}" style="list-style: none;text-decoration:none;">Прочетени</a></li>
                            <li><a href="{{ url('/messages/recieved/unread') }}" style="list-style: none;text-decoration:none;">Непрочетени</a></li>
                        </ul>
                    </li>

                    <li class="position-left">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Изпратени
                        </a>
                        <ul class="dropdown-menu-left  position-left" role="menu">
                            <li><a href="{{ url('/messages/sent/read') }}" style="list-style: none;text-decoration:none;">Прочетени</a></li>
                            <li><a href="{{ url('/messages/sent/unread') }}" style="list-style: none;text-decoration:none;">Непрочетени</a></li>
                        </ul>
                    </li>

                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('profile') }}">Профил</a></li>
                    @if (Auth::user()->rank!='member')
                        <li><a href="{{ url('listing/members') }}">Потребители</a></li>
                        @if(Auth::user()->rank!='admin')
                            <li><a href="{{ url('listing/admins') }}">Админи</a></li>
                        @endif
                    @endif
                    <li>
                        <a href="{{ url('/logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Излез
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>

        @endif
    </ul>
</nav>
@if ( Auth::guest() && isset($mainPage))
<div id="welcome">
    <div>
        {{--<h1 class="slogon">Не можете да вземете решение ? Ние сме тук за да ви помогнем. Направете <a href="#">регистрация</a> , ако имате такава просто влезте в системата и създайте анкета и я споделете.</h1>--}}
        <h1 class="slogon">Не можете да вземете решение? PollSmith е тук да ви помогне. Направете анкета и я споделете!</h1>
    </div>
</div>
@endif
    <div id="app" @if ( Auth::guest() && Request::url() == url('')) style="padding-top: 5.5%;" @else style="padding-top: 100px"  @endif>

        @yield('content')

    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script src="{{ url('js/jquery-sortable.js') }}"></script>
    <script>
        var $ =  jQuery.noConflict();
        checkAnswers();
            $('.glyphicon-plus').on('click', function () {
                if($('.keeper').size() < 10){
                    $('.keeper').last().after(
                        '<li class="col-md-12 keeper sortable"><div class="handle"></div><label class="col-md-11 create_answers"><input class="col-md-12" type="text" name="answers[]"/>'
                        +
                        '</label><button class="glyphicon glyphicon-minus" type="button"></button></li>');
                    $('.create_answers input').each(function(index){
                        index++;
                        $(this).attr("placeholder", "Отговор " + index);
                    });
                    checkAnswers();
                    deleteItem();
                }
                else{
                    alert('Maks otgovori sa 10')
                }
            });
            function checkAnswers() {
                var items = $('.keeper');
                if (items.size() == 2) {
                    $('.keeper').removeClass('showMinus');
                }
                else {
                    $('.keeper').addClass('showMinus');
                }
            }
            checkAnswers();
            function deleteItem() {
                $('.glyphicon-minus').on('click', function () {
                    if($('.keeper').size() > 2){
                        $(this).parent('.keeper').remove();
                        $('.create_answers input').each(function( index ) {
                            index++;
                            $(this).attr("placeholder", "Отговор " + index);
                        });
                        checkAnswers();
                    }
                    else{
                        $('.keeper').removeClass('showMinus');
                    }
                })
            }
            function sortableItems() {
                $("#answers").sortable(
                    {
                        handle: '.handle'
                    }
                );
            }
            sortableItems();


        $('.input-group-addon').on('click', function () {
            $(this).parent('.front').find('.selectedAnswer').removeClass('selectedAnswer');
            $(this).addClass('selectedAnswer');
        });

        var M =  $('.grid').masonry({
            itemSelector: '.grid-item',
            columnWidth: '.grid-sizer',
            gutter:'.gutter-sizer',
            fitWidth: true,
            percentPosition: true
        });

        function  removeError(){
            $('.alert button' ).on('click', function(){
                $(this).parent().fadeOut(600, function(){ $(this).remove(); });
                M.masonry();
            });
        }

        function setResults(results , el ){
            $('label .gradient > div', el ).each( function(i){
                var p = Math.ceil( ( results['a'+i] / results.allItems  ) * 100  ) + '%';
                console.log(p);
                if( p === "NaN%" ){
                    $('div', this).html('0%');
                }
                else{
                    $(this).css('left' , p);
                    $('div', this).html(p);
                }
                console.log('test:', Math.ceil( ( results['a'+i] / results.allItems  ) * 100  ) + '%' );

            });
        }



        function submit_vote(el,id){
            if ($('input:checked', el).size() > 0) {
                $.ajax({
                    url: el.attr('action'),
                    type: "POST",
                    data: {
                        id: id,
                        answer: $('input:checked', el).val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {

                        $('.already_voted',el).remove();
                        $('.front h2',el).after( data.error );

                        if( typeof data.error !== "undefined" ){
                            removeError();
                            console.log('error:', data.error);
                        }
                        if( typeof data.results !== "undefined" ){
                            setResults(data.results , el );

                            console.log('success:', data.results );
                        }
                        M.masonry();
                    }
                });
            }
            else {
                $('.already_voted',el).remove();
                $('.front h2',el).after( ' <p class="alert alert-danger already_voted">Вие не сте избрали отговор!<button type="button">X</button></p>' );
                removeError();
                M.masonry();

            }

        }
        function get_results(el, id){

            $.ajax({
                url: "{{ url('/results') }}/"+id,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {

                    $('.front h2',el).after( data.error );

                    if( typeof data.error !== "undefined" ){
                        removeError();
                        console.log('error:', data.error);
                    }
                    if( typeof data.results !== "undefined" ){
                        setResults(data.results , el );

                        console.log('success:', data.results );
                    }
                    M.masonry();
                }
            });
        }


        $('.searchUsers_button').on('click', function(){
            var searched_user = $(this).siblings('.search_input').val();
            $(this).parent().parent().find('.after_chkbox:contains('+searched_user+')').parent().css('display', 'block');
        });
        $('.close_searchedResult').on('click', function(){
            $(this).siblings('input').prop('checked', false).parent().fadeOut(500, function(){ $(this).css('display', 'none'); });
        });

        /*$('#groups').addClass('show_groups');

        $('#filter_for').on('change', function(){
           var selected = $(this).val();
            if(selected === 'group'){
                $('#groups').removeClass('show_groups');
            }
            else{
                $('#groups').addClass('show_groups');
            }
        });*/

        /*$('#createPoll_form').on('submit', function(el){
           if(!$(this).hasClass('removed')){
               $(this).addClass('removed');
           }

        });*/


    </script>

</body>
</html>
