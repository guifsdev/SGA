@extends('layouts.master')

@section('content')
<certificates-validator :result-prop="{{$result}}"></certificates-validator>
@endsection