@extends('admin.all.layout')
@section('content')

@auth('admin')
<span style="color: red"> {{ app()->currentLocale() }} {{ __('custom.testf',['name'=>'Sanju Awal'])}}   </span>
@endauth

@auth('web')
@foreach(auth()->user()->roles as $value)
<span style="color: red">{{ $value->key }}</span>
@endforeach
@endauth

@endsection
