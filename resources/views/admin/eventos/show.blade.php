@extends('layouts.master')

@section('title', 'SGA - Gerenciamento de Eventos')

@section('nav_title', 'Evento')

@section('content')
@include('partials.menu')
<event :event-prop="{{$event}}"></event>
@endsection