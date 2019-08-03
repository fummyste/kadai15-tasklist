@extends('layouts.app')

@section('content')

<h1>{{$user->name}}の登録情報</h1>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{$user->id}}</td>
        </tr>
        <tr>
            <th>名前</th>
            <td>{{$user->name}}</td>
        </tr>
        <tr>
            <th>メール</th>
            <td>{{$user->email}}</td>
        </tr>
    </table>

@endsection