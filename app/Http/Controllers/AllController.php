<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class AllController extends Controller
{
    public function pdfDownload()
    {
      $pdf = PDF::loadView('pdfFile');    //downlad templete
      $name='sunil';                     //downlad user name
      return $pdf->download($name.'.pdf');    //pdf name
    }
}
