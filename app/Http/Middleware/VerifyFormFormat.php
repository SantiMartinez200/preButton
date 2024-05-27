<?php

namespace App\Http\Middleware;

use App\Http\Controllers\PdfController;
use App\Http\Controllers\ExcelController;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyFormFormat
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
   if ($request->formFormat == "pdf") {
      return redirect()->action(
        [PdfController::class, 'pdfAssistGeneral'],
        ['request' => $request->selectedYear]
      );
   }elseif($request->formFormat == "excel"){
     return redirect()->action(
       [ExcelController::class, 'excelAssistGeneral'],
       ['request' => $request->selectedYear]
      );
   }
    return $next($request);
  }

}
