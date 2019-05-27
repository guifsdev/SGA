@extends('layouts.master')

@section('title', 'SGA - Gerenciamento de Eventos')

@section('nav_title', 'Gerenciamento de Eventos')


@section('content')

@include('partials.menu')

<event-list :events-prop="{{$events}}"></event-list>
@endsection