@extends('layouts.master')

@section('title', 'SGA - Gerenciamento de Eventos')

@section('nav_title', 'Criar Eventos')

@section('content')

@include('partials.menu')
<event-create></event-create>
@endsection

@section('custom_scripts')
<!-- <script type="text/javascript" src="{{ asset('js/my_functions.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/manage_events.js') }}"></script> -->
@endsection