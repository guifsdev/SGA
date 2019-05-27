@extends('layouts.master')
@section('nav_title', 'Certificados')


@section('content')
@include('partials.menu')
<certificates-list :certificates-prop="{{$certificates}}">
</certificates-list>
@endsection