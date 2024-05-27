@extends('layouts.app')
@section('content')
<div class="row justify-content-center mt-3">
  <div class="col-md-8">
    <div class="container">
      <div class="card">
        <div class="card-header">
          <div class="float-start">
            <strong>Selecciona un grado y el formato que desees para emitir un informe completo de asistencias y
              condiciones.</strong>
          </div>
          <div class="float-end">
            <a href="{{ route('students.index') }}" class="btn btn-primary btn-sm">&larr; Volver</a>
          </div>
        </div>
        <div class="card-body">
          <div class="container">
            <form action="{{route('routeFormat')}}" method="GET">
              @csrf
              <div class="row align-items-center">
                <div class="col-sm d-flex align-items-center">
                  <div class="m-2">
                    <select name="selectedYear" id="selectedYear" class="w-100 rounded">
                      <option selected hidden>Opciones</option>
                      <option value="Todos">Todos</option>
                      <option value="Primero">Primero</option>
                      <option value="Segundo">Segundo</option>
                      <option value="Tercero">Tercero</option>
                      <option value="Cuarto">Cuarto</option>
                      <option value="Quinto">Quinto</option>
                      <option value="Sexto">Sexto</option>
                    </select>
                  </div>
                  <div class="m-2">
                    <input type="radio" id="pdf" name="formFormat" value="pdf">
                    <label for="pdf">PDF</label><br>
                  </div>
                  <div class="">
                    <input type="radio" id="excel" name="formFormat" value="excel">
                    <label for="excel">EXCEL</label><br>
                  </div>
                </div>
              </div>
                <div class="col-sm ml-2">
                  <input type="submit" value="Generar" class="btn btn-primary">
                </div>
            </form>
          </div>
        </div>
      </div>
      @endsection