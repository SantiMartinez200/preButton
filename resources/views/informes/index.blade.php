@extends('layouts.app')
@section('content')
<div class="row justify-content-center mt-3">
<div class="col-md-8">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="float-start">
          <strong>Selecciona un grado para emitir un informe completo de asistencias y condiciones.</strong>
        </div>
        <div class="float-end">
          <a href="{{ route('students.index') }}" class="btn btn-primary btn-sm">&larr; Volver</a>
        </div>
      </div>
      <div class="card-body">
        <div class="container">
          <form action="{{route('pdfAssistGeneral')}}" method="GET">
            @csrf
            <div class="row align-items-center">
              <div class="col-sm">
                <select name="selectedYear" id="selectedYear" class="form-control">
                  <option selected hidden>Selecciona Año</option>
                  <option value="Todos">Todos</option>
                  <option value="Primero">Primero</option>
                  <option value="Segundo">Segundo</option>
                  <option value="Tercero">Tercero</option>
                  <option value="Cuarto">Cuarto</option>
                  <option value="Quinto">Quinto</option>
                </select>
              </div>
              <div class="col-sm">
                <input type="submit" value="Generar" class="btn btn-primary">
              </div>
              <div class="col"></div>
              <div class="col"></div>
            </div>
          </form>
        </div>
      </div>
    </div>
    @endsection