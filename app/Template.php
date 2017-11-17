<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
  protected $connection='mongodb';
  
    //
    public $id;

    public $name;

    public $description;

    public function __construct($id,$name){
        $this->id = $id;
      $this->name = $name;
    }
}
