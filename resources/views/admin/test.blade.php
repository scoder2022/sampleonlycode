@extends('admin.all.layout')
@section('content')
@include('sweetalert::alert')
@auth('admin')
<span style="color: red">logged in as super admin</span>
@endauth
@auth('web')
@foreach(auth()->user()->roles as $value)
<span style="color: red">{{ $value->key }}</span>
@endforeach
@endauth
@endsection
