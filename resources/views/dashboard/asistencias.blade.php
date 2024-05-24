@extends('layouts.app')
@section('content')
<div class="container mt-2">
  <form action="{{route('pdfAssistGeneral')}}" method="GET">
    @csrf
    <select name="selectedYear" id="selectedYear">
      <option selected hidden>Selecciona Año</option>
      <option value="Todos">Todos</option>
      <option value="Primero">Primero</option>
      <option value="Segundo">Segundo</option>
      <option value="Tercero">Tercero</option>
      <option value="Cuarto">Cuarto</option>
      <option value="Quinto">Quinto</option>
    </select>
    <input type="submit" value="Generar Informe de asistencias" class="btn btn-primary">
  </form>
</div>
<div class="row justify-content-center mt-3">
  <div class="col-md-12">
    <div class="container">
      <div class="card">
        <div class="card-header"><strong>Asistencias Registradas</strong>
          <div class="float-end">
            <a href="{{ route('/dashboard') }}" class="btn btn-primary btn-sm">&larr; Volver</a>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th scope="col">Id del registro (de asistencia)</th>
                <th scope="col">DNI del alumno</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Grupo</th>
                <th scope="col">Año </th>
                <th scope="col">Registrada el</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($results as $row)
        <tr>
          <td>{{ $row["id"] }}</td>
          <td>{{ $row["dni"] }}</td>
          <td>{{ $row["nombre"] }}</td>
          <td>{{ $row["apellido"] }}</td>
          <td>{{ $row["grupo"] }}</td>
          <td>{{ $row["año"] }}</td>
          <td>{{ $fecha = date('d/m/Y H:i', strtotime($row["registrada"])) }}</td>
        </tr>
      @empty
    <td colspan="6">
      <span class="text-danger">
      <strong>No hay asistencias!</strong>
      </span>
    </td>
  @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection