<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    //
    public $name;

    public $institute;



    public $end_year;

    public $score;



    public function __construct($name,$institute,$end_year,$score){
      $this->name = $name;
      $this->institute = $institute;
      $this->end_year = $end_year;
      $this->score = $score;

    }
}
