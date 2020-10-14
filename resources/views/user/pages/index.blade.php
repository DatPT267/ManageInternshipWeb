@extends('user.layout.index')
@section('content')
    <h1 style="text-align: center">XIN CHÀO, <strong>{{ Auth::user()->name }}</strong></h1>
@endsection
