<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    //
    public $name;

    public $description;

    public $start;

    public $end;

    public $team_size;

    public $guide;


    public function __construct($name,$description,$start,$end,$team_size,$guide){
      $this->name = $name;
      $this->description = $description;
      $this->start = $start;
      $this->end = $end;
      $this->team_size = $team_size;
      $this->guide = $guide;
    }
}
