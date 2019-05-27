@extends('layouts.master')

@section('title', 'SGA - Editar Evento')

@section('nav_title', 'Editar Evento')

@section('content')
@include('partials.menu')

<event-edit :event-props="{{$event}}"></event-edit>
@endsection

@section('custom_scripts')
<!-- <script type="text/javascript" src="{{ asset('js/my_functions.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/manage_events.js') }}"></script> -->
@endsection