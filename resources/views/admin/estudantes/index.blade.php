@extends('layouts.master')

@section('nav_title', 'Estudantes')


@section('content')
@include('partials.menu')

<div class="container" style="max-width: 100%">

  <active-students-updater></active-students-updater>

  <hr>
  <table class="table table-sm">
    <thead>
      <tr>
        <th scope="col">Nome</th>
        <th scope="col">CPF</th>
        <th scope="col">Matrícula</th>
        <th scope="col">Email</th>
        <th scope="col">CR</th>
        <th scope="col">CHA</th>
        <th scope="col">CHT</th>
      </tr>
    </thead>
    <tbody>
      @foreach($students as $student)
      <tr>
        <td>{{$student->nome}}</td>
        <td>{{$student->cpf}}</td>
        <td>{{$student->matricula}}</td>
        <td>{{$student->email}}</td>
        <td>{{$student->cr}}</td>
        <td>{{$student->cha}}</td>
        <td>{{$student->cht}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $students->links() }}
</div>
@endsection