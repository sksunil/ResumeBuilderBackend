<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DA extends Model
{
    //
    public $expertise;

    public $programming_languages;

    public $tools;

    public $technical_electives;




    public function __construct($expertise,$programming_languages,$tools,$technical_electives){
      $this->expertise = $expertise;
      $this->programming_languages = $programming_languages;
      $this->tools =$tools;
      $this->technical_electives = $technical_electives;

    }
}
