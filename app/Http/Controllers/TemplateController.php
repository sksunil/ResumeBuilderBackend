<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;

use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
{
    //
    protected $fillable = ['id','name','description'];
    public function setUp(){

      $templates = [];

      for ($i=0; $i<5 ; $i++) {
        # code...
        $templates[$i] = new Template($i,'Template');
      }

      $templates[0]->{'description'} = 'THIS IS DAIICT';
      $templates[1]->{'description'} = 'THIS IS DAIICT1';
      $templates[2]->{'description'} = 'THIS IS DAIICT2';
      $templates[3]->{'description'} = 'THIS IS DAIICT3';
      $templates[4]->{'description'} = 'THIS IS DAIICT4';

      DB::table('templates')->insert($templates);
      $template = DB::table('templates')->get();
      return $template;
    }




}
