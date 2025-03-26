@extends('admin.all.layout')
@section('content')
@auth('admin')
<span style="color: red">Logged in as Super Admin</span>
@endauth
@auth('web')
@foreach(auth()->user()->roles as $value)
<span style="color: red">{{ $value->key }}</span>
@endforeach
@endauth
@endsection
