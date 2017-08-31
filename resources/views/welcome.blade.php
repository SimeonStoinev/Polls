@extends('layouts.app')
@section('content')
        <div class="container">
            <ul class="grid">
                <li class="grid-sizer"></li>
                <li class="gutter-sizer"></li>
                @foreach($data as $row)
                    @include('frontend.li-poll')
                @endforeach
            </ul>
            <div class="paging">
                @if($currPage < 2)

                @else
                    <a href="{{ $currPage-1 }}"><span class="pageDown"></span></a>
                @endif

                <?php echo $paging ?>

                @if($allPages == $currPage)

                @else
                    <a href="{{ $currPage+1 }}"><span class="pageUp"></span></a>
                @endif
            </div>
        </div>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>
    <script>
    </script>
@endsection