<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resume;
use App\Student;
use App\Project;
use App\Degree;
use App\Position;
use App\Internship;
use App\Award;
use App\Hobby;
use App\Template;
use App\DA;
use App\Skills;
use JWTAuth;


use Illuminate\Support\Facades\DB;

class ResumeController extends Controller
{


    protected $fillable = ['name','email','address','dob'];


    public function store(Request $request){                   //insert method

      if(! $user = JWTAuth::parseToken()->authenticate()){
      return response()->json(['message' => 'User not Found'] , 404);
    }

      $data = $request->only('_id','data');
      $resume = $data['data']['resume'];
       $user_id = $data['_id'];




       $name = $resume['info']['name'];
       $email = $resume['info']['email'];
       $address = $resume['info']['address'];
       $dob = $resume['info']['dob'];



       $user = new Resume;
      $user->{'data.resume.info.name'} = $name;
      $user->{'data.resume.info.email'} = $email;
      $user->{'data.resume.info.address'} = $address;
      $user->{'data.resume.info.dob'} = $dob;

      $templates = $data['data']['template'];
      $user->{'data.template'} = $this->getTemplates($templates);

     $degrees = $resume['degree'];
     $user->{'data.resume.degree'} = $this->getDegrees($degrees);

     $internships = $resume['internship'];
     $user->{'data.resume.internship'} = $this->getInternship($internships);

     $projects = $resume['project'];
     $user->{'data.resume.project'} = $this->getProjects($projects);

     $positions = $resume['position'];
     $user->{'data.resume.position'} = $this->getPositions($positions);


     $awards = $resume['award'];
     $user->{'data.resume.award'} = $this->getAwards($awards);

     $hobbies = $resume['hobby'];
     $user->{'data.resume.hobby'} = $this->getHobby($hobbies);

     $skills = $resume['skill'];
     $user->{'data.resume.skill'} = $this->getSkills($skills);


      $das = $resume['da'];
      $user->{'data.resume.da'} = $this->getDAdetails($das);

     $user->save();
     return "success";

    }


    public function index(){                                  //display method

    try {

          if (! $user = JWTAuth::parseToken()->authenticate()) {
                 return response()->json(['user_not_found'], 404);
          }
    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        return response()->json(['token_expired'], $e->getStatusCode());
    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        return response()->json(['token_invalid'], $e->getStatusCode());
    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
        return response()->json(['token_absent'], $e->getStatusCode());
      }
    $user = JWTAuth::parseToken()->toUser();
    $email = $user->email;

    $resume = Resume::where('data.resume.info.email', '='  , $email)->project(['_id' => 0])->get();
    // $data = json_decode($resume, true);
    //
    //
    //
    // if(empty($data)){
    //   return 'user data not found';
    // }
    return $resume;

    }

    public function destroy(Request $request)                                   //Delete method
    {
      try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                   return response()->json(['user_not_found'], 404);
            }
      } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
          return response()->json(['token_expired'], $e->getStatusCode());
      } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
          return response()->json(['token_invalid'], $e->getStatusCode());
      } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
          return response()->json(['token_absent'], $e->getStatusCode());
        }
        $id = $request->id;
      $user = JWTAuth::parseToken()->toUser();
      $email = $user->email;

      $resume = Resume::where(['data.resume.info.email' => $email])->get();

   $template = $resume['0']['data']['template'][$id];

    Resume::where('data.template.id.['.$id.']')->delete();



      return "Templates removed";

    }


    public function update(Request $request){                    //Update method

      try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                   return response()->json(['user_not_found'], 404);
            }
      } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
          return response()->json(['token_expired'], $e->getStatusCode());
      } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
          return response()->json(['token_invalid'], $e->getStatusCode());
      } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
          return response()->json(['token_absent'], $e->getStatusCode());
        }


        if(empty($request->all())){
          return 'empty';
        }


      $user = JWTAuth::parseToken()->toUser();
      $email = $user->email;

       $resume = Resume::where(['data.resume.info.email' => $email])->update($request->all());


         return "update successful";


    }

    public function userTemplates(){

      try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                   return response()->json(['user_not_found'], 404);
            }
      } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
          return response()->json(['token_expired'], $e->getStatusCode());
      } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
          return response()->json(['token_invalid'], $e->getStatusCode());
      } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
          return response()->json(['token_absent'], $e->getStatusCode());
      }
      $user = JWTAuth::parseToken()->toUser();
      $email = $user->email;
      $resume = Resume::where('data.resume.info.email', '='  , $email)->project(['_id' => 0])->get();
      $data = json_decode($resume, true);


      if(empty($data)){
        return 'No templates';
      }
      $template = $resume['0']['data'];

      return empty($template['template']) ?  'No templates': $template['template'];

    }

    protected function getTemplates($templates){
      $userTemplates = [];
      if (count($templates) > 0) {
          foreach ($templates as $template) {
              $userTemplates[] = new Template(
                  $template['id']


              );
          }
    }
    return $userTemplates;


    }
    protected function getProjects($projects)
    {
          $userProjects = [];
          if (count($projects) > 0) {
               foreach ($projects as $project) {
                  $userProjects[] = new Project(
                        $project['name'],
                      $project['description'],
                      $project['start'],
                     $project['end'],
                       $project['team_size'],
                     $project['guide']
                  );
                }
            }
                    return $userProjects;
      }




    protected function getInternship($internships)
    {
          $userInternship = [];
          if (count($internships) > 0) {
              foreach ($internships as $internship) {
                   $userInternship[] = new Internship(
                      $internship['name'],
                     $internship['description'],
                       $internship['start'],
                      $internship['end'],
                     $internship['team_size'],
                     $internship['guide']
                  );
                }
            }
                  return $userInternship;
    }




    protected function getDegrees($degrees)
    {
         $userDegrees = [];

        if(count($degrees) > 0){
          foreach($degrees as $degree){
              $userDegrees[] = new Degree(
                  $degree['name'],
                  $degree['institute'],
                   $degree['year'],

                  $degree['score']
              );
            }
        }
              return $userDegrees;
    }




    protected function getPositions($positions)
    {
          $userPositions = [];
          if(count($positions) > 0){
            foreach($positions as $position){

              $userPositions[] = new Position(
                 $position['name']
              );
            }
        }

          return $userPositions;
    }

    protected function getAwards($awards)
    {
          $userAwards = [];

            if(count($awards) > 0){
            foreach($awards as $award){
              $userAwards[] = new Award(
                $award['name']

              );
            }
        }

          return $userAwards;
    }

    protected function getHobby($hobbies)
    {
          $userhobbies = [];

        if(count($hobbies) > 0){
             foreach($hobbies as $hobby){
              $userhobbies[] = new Hobby(
                  $hobby['name']
              );
            }
        }
          return $userhobbies;
    }

    protected function getDAdetails($daDetails){


        $userdetails = new DA(
            $daDetails['expertise'],
            $daDetails['programming_languages'],
            $daDetails['tools'],
            $daDetails['technical_electives']

        );
        return $userdetails;
    }

    protected function getSkills($skills){
        $userSkills = [];

        if(count($skills) > 0){
             foreach($skills as $skill){
        $userSkills[] = new Skills(
            $skill['name']
        );
    }
}
        return $userSkills;
    }
}
