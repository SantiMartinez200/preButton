<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YearController extends Controller
{
  public static function getYears()
  {
    $years = Year::all();
    return $years;
  }

  public function returnToReports(){
    $years = $this->getYears();
    return view('informes.index',compact('years'));
  }

  public function returnToSign()
  {
    $years = $this->getYears();
    return view('students.sign', compact('years'));
  }


}
