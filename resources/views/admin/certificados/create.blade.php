@extends('layouts.master')

@section('nav_title', 'Criar certificados')

@section('content')
@include('partials.menu')
<certificates-emit 
	:events-prop="{{$events}}"
	:templates-prop="{{$templates}}"
	:certificates-prop="{{$certificates}}"></certificates-emit>
@endsection