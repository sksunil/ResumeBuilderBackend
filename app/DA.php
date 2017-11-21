<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DA extends Model
{
    //
    public $experties;

    public $programming_language;

    public $tools;

    public $technical_electives;




    public function __construct($experties,$programming_language,$tools,$technical_electives){
      $this->experties = $experties;
      $this->programming_language = $programming_language;
      $this->tools =$tools;
      $this->technical_electives = $technical_electives;

    }
}
