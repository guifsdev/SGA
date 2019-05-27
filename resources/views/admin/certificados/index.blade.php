@extends('layouts.master')
@section('title', 'SGA - Gerenciamento de Certificados')
@section('nav_title', 'Certificados')


@section('content')
@include('partials.menu')
<certificates-list :certificates-prop="{{$certificates}}">
</certificates-list>
@endsection