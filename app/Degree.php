<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    //
    public $name;

    public $institute;



    public $year;

    public $score;



    public function __construct($name,$institute,$year,$score){
      $this->name = $name;
      $this->institute = $institute;
      $this->year = $year;
      $this->score = $score;

    }
}
