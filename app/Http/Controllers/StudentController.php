<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Param;
use App\Models\Year;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Mockery\Undefined;

class StudentController extends Controller
{

  public function index(): View
  {
    return view('students.index', [
      'students' => Student::latest()->paginate(10),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(): View
  {
    $years = Year::all();
    return view('students.create', compact('years'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreStudentRequest $request): RedirectResponse
  {
    $val = $request->birthday;
    $onlyYear = date('Y', strtotime($val));
    $thisYear = date('Y');
    if (($thisYear - $onlyYear) < 17) {
      return redirect()->route('students.create')
        ->with('status', 'La fecha de nacimiento es inválida, solo mayores a 18');
    } else {
      Student::create($request->all());
      return redirect()->route('students.index')
        ->withSuccess('Se ha añadido un nuevo estudiante correctamente.');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Student $student): View
  {
    $getAllAssists = DB::table('assists')
      ->join('students', 'assists.student_id', '=', 'students.id')
      ->select(DB::raw('count(*) as assist_count'))
      ->where('students.dni_student', 'LIKE', $student->dni_student)
      ->get();
    $val = $getAllAssists[0]->assist_count;
    //get params and calculate student status
    $params = Param::all();
    $calculate = ($val) / ($params[0]->total_classes) * 100;
    $status = 'undefined';
    if ($val > 0) {
      if ($calculate >= $params[0]->promote) {
        $status = "Promoción";
      } elseif (($calculate < $params[0]->promote) && ($calculate >= $params[0]->regular)) {
        $status = "Regular";
      } elseif (($calculate < $params[0]->regular)) {
        $status = "Libre";
      }
    } else {
      $status = "Indefinido";
    }
    return view('students.show', [
      'student' => $student,
      'assist' => $val,
      'status' => $status,
      'average' => $calculate
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Student $student): View
  {
    $studentYear = $student->year;
    $years = Year::all();
    return view('students.edit', [
      'student' => $student,
      'studentYear' => $studentYear,
      'years' => $years
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
  {
    $val = $request->birthday;
    $onlyYear = date('Y', strtotime($val));
    //$thisYear = Carbon::now()->format('Y');
    $thisYear = date('Y');
    if (($thisYear - $onlyYear) < 17) {
      return redirect()->back()
        ->with('status', 'La fecha de nacimiento es inválida, solo mayores a 18');
    } else {
      $student->update($request->all());
      return redirect()->back()
        ->withSuccess('El estudiante se actualizó correctamente.');
    }

  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Student $student): RedirectResponse
  {
    $deleteAssists = DB::table('assists')
      ->where('student_id', '=', $student->id)
      ->delete();
    $student->delete();
    return redirect()->route('students.index')
      ->withSuccess('El estudiante se eliminó correctamente.');
  }

  public function find($id)
  {
    $student = Student::find($id);
    $cant = $student->assists;
    return view('students.assists', compact('cant', 'student'));
  }

  public function findThis(Request $request)
  {
    $student = DB::table('students')
      ->select('*')
      ->where('dni_student', '=', $request->dni_student)
      ->get();
    $yearStudent = DB::table('years')
      ->select('*')
      ->join('students', 'years.id', '=', 'students.year_id')
      ->where('students.dni_student', '=', $request->dni_student)
      ->get();
    $years = Year::all();
    return view('students.sign', [
      'student' => $student,
      'yearStudent' => $yearStudent,
      'years' => $years,
      'requestDni' => $request->dni_student
    ]);
  }

  public function getStudentsPerYear(request $request){
    $sas = Year::find($request);
    $years = Year::all();
    $students = Student::all();
    $getStudentsWithYear = [];
    foreach ($students as $eachStudent) {
      if ($eachStudent->year_id == $request->selectedYear) {
        $addYear = Year::find($sas[0]->id)->year;
        array_push($getStudentsWithYear, [$eachStudent,$addYear]);
      }
    }

    $todayDate = Carbon::now()->toDateString();
    ;
    $todayDate = $todayDate . "%";
    $condition = false;

    $getStudentsPerYear = [];

    foreach ($getStudentsWithYear as $eachStudent) {
      $studentDate = DB::table('assists')
        ->select()
        ->where('student_id', '=', $eachStudent[0]["id"])
        ->where('created_at', 'LIKE', $todayDate)
        ->get();
      if ($studentDate->IsEmpty()) {
        $condition = true; //Cargar asistencia.
        array_push($eachStudent, $condition);
        array_push($getStudentsPerYear, $eachStudent);
      } else {
        $condition = false; //No cargar la asistencia
        array_push($eachStudent, $condition);
        array_push($getStudentsPerYear, $eachStudent);
      }
    }

    return view('students.sign', [
      'students' => $getStudentsPerYear,
      'years' => $years,
      'sas' => $sas
    ]);
   
  }

  public static function validateButton($id)
  {
   
  }
}
