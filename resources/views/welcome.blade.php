@extends('layouts.auth')

@section('content')
    @auth
        <form method="POST" action="{{ route('logOut') }}">
            @method("DELETE")
            @csrf
            <button type="submit">Выйти</button>
        </form>
    @endauth
@endsection
