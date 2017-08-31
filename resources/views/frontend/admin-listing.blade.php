@extends('layouts.app')

@section('content')
    <div class="container">
        {{ Form::open(array('url' => '/listing/admins' , 'method' => 'post'))}}

        <Form action="/listing/admins">
            <label>
                <input type="text" placeholder="Search..." name="search" required/>
                <button class="core-btn" type="submit">Search</button>
            </label>
        </Form>

        <ul id="userlist">
            @if(!empty($searchData))

                @foreach($searchData as $row)
                    <li id="searchedUser">
                        {{ Form::open(array('url' => '/listing/admins' , 'method' => 'post'))}}

                        <input type="hidden" value="{{$row->id}}" name="id"/>
                        Резултати от търсенето: <br/>
                        <label>{{ $row->name }}</label> <br/>
                        <label>{{ $row->email }}</label> <br/>
                        <label>
                            Status
                            <?php $items2 = ["pending", "active", "banned"]; ?>
                            <select name="status">
                                <?php foreach($items2 as $row2): ?>
                                <option value="{{ $row2 }}" <?php echo ($row->status == $row2 )?'selected':''; ?>>{{ ucfirst($row2) }}</option>
                                <?php endforeach; ?>
                            </select>
                        </label> <br/>
                        @if(Auth::user()->rank=='owner')
                            <label>
                                Rank
                                <?php $items3 = ["member", "admin"]; ?>
                                <select name="rank">
                                    <?php foreach($items3 as $row3): ?>
                                    <option value="{{ $row3 }}" <?php echo ($row->rank == $row3 )?'selected':''; ?>>{{ ucfirst($row3) }}</option>
                                    <?php endforeach; ?>
                                </select>
                            </label> <br/>
                        @endif
                        <br/>
                        <button class="core-btn" type="submit">Edit User {{ $row->id }}</button>
                        <br/><br/>

                        {{ Form::close() }}
                    </li>
                    <br/><br/>
                @endforeach

            @endif


            @foreach($allAdmins as $row)
                <li>
                    {{ Form::open(array('url' => '/listing/admins' , 'method' => 'post'))}}

                        <input type="hidden" value="{{$row->id}}" name="id"/>
                        <label>{{ $row->name }}</label> <br/>
                        <label>{{ $row->email }}</label> <br/>
                        <label>
                            Status
                            <?php $items2 = ["pending", "active", "banned"]; ?>
                            <select name="status">
                                <?php foreach($items2 as $row2): ?>
                                <option value="{{ $row2 }}" <?php echo ($row->status == $row2 )?'selected':''; ?>>{{ ucfirst($row2) }}</option>
                                <?php endforeach; ?>
                            </select>
                        </label> <br/>
                        <label>
                            Rank
                            <?php $items3 = ["member", "admin"]; ?>
                            <select name="rank">
                                <?php foreach($items3 as $row3): ?>
                                <option value="{{ $row3 }}" <?php echo ($row->rank == $row3 )?'selected':''; ?>>{{ ucfirst($row3) }}</option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <br/>
                        <button class="core-btn" type="submit">Edit Admin {{ $row->id }}</button>

                    {{ Form::close() }}
                </li>
            @endforeach
        </ul>

        {{ Form::close() }}
    </div>
    <style>
        #userlist>li{
            list-style: none;
            display: inline-block;
            width: 20%;
        }
    </style>
@endsection