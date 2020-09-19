@extends('layouts.app')

@section('content')
    <home></home>
@endsection

@section("script")
    <script>
        window.token = "{!! auth()->user()->createToken('authToken')->accessToken !!}"
    </script>
@endsection
