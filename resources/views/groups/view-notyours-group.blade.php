@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="table-responsive row">
            <table class="table">
                <thead class="table-striped">
                <tr>
                    <th>{{ $groupData->id }}</th>
                    <th>{{ $groupData->title }}</th>
                    <th>{{ $groupData->description }}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <style>
    </style>
@endsection