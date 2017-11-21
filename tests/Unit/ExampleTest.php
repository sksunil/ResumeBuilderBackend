<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use app\Http\Controllers\ResumeController;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
     public function indexTest(){
          $con=new ResumeController();
          $obj= $con->index();
          echo $obj;
         $this->assertEquals($email,  'Hhdjfhdfjdfdwfdfahasdad@gmail.com');
     }
}
