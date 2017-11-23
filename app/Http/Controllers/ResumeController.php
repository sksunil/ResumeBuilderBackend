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

        $user = JWTAuth::parseToken()->toUser();


         $resume = new Resume;
         $resume->{'data.resume.info.name'} = $user->name;
         $resume->{'data.resume.info.email'} = $user->email;
         $resume->{'data.resume.info.dob'} = '21-Jan-1990';
         $resume->{'data.resume.info.address'} = '221 B Street,England,UK';
         $resume->{'data.resume.info.profession'} = 'Web Developer';
         $resume->{'data.resume.info.phone'} = '9823571245';


         //$templates = $data['data']['template'];
         //$resume->{'data.template'} = $this->getTemplates($templates);
        //
        // $degrees = $resume['degree'];
         $resume->{'data.resume.degree'} = $this->getDegrees();
        //
        // $internships = $resume['internship'];
          $resume->{'data.resume.internship'} = $this->getInternship();
        //
        // $projects = $resume['project'];
          $resume->{'data.resume.project'} = $this->getProjects();
        //
        // $positions = $resume['position'];
          $resume->{'data.resume.position'} = $this->getPositions();
        //
        //
        // $awards = $resume['award'];
           $resume->{'data.resume.award'} = $this->getAwards();
        //
        // $hobbies = $resume['hobby'];
          $resume->{'data.resume.hobby'} = $this->getHobby();

          $resume->{'data.resume.da'} = $this->getDAdetails();

          $resume->{'data.resume.skill'} = $this->getSkills();
        $resume->save();
        return "success";

        //return view('welcome');
    }


    public function index(){                                  //display method
    //$resume =  Resume::all();
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
      return 'user data not found';
    }
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
//  dd($template);
    //dd($id);
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

    // protected function getTemplates($templates){
    //   $userTemplates = [];
    //   if (count($templates) > 0) {
    //       foreach ($templates as $template) {
    //           $userTemplates[] = new Template(
    //               $template['id'],
    //               $template['name']
    //
    //           );
    //       }
    // }
    // return $userTemplates;
    //
    //
    // }
    protected function getProjects()
    {
          $userProjects = [];
                  $userProjects[] = new Project(
                   "Course Feedback System",
                   "A portal that enables students to provide truly anonymous and genuine course feedback to the university authorities; built using Laravel, AngularJS and MySQL.",
                   "1/7/2017",
                   "1/9/2017",
                   "8",
                   "John Wick"
                  );
                    return $userProjects;
      }




    protected function getInternship()
    {
          $userInternship = [];
          // if (count($internships) > 0) {
          //     foreach ($internships as $internship) {
                   $userInternship[] = new Internship(
                      "ABC company",
                      "Handled database and Web site programming tasks (primarily using Java, C++, HTML and SharePoint).",
                      "1/7/2017",
                      "1/9/2017",
                      "1",
                      "John Wick"
                  );
                  return $userInternship;
    }




    protected function getDegrees()
    {
         $userDegrees = [];
        //
        // if(count($degrees) > 0){
        //   foreach($degrees as $degree){
              $userDegrees[] = new Degree(
                  'Msc IT',
                  'DAIICT',
                  '2018',
                  '7.19'
              );
              return $userDegrees;
          }




    protected function getPositions()
    {
          $userPositions = [];

              $userPositions[] = new Position(
                 "Leader and organizer at freeCodeCamp, Ahmedabad"
              );


          return $userPositions;
    }

    protected function getAwards()
    {
          $userAwards = [];


              $userAwards[] = new Award(
                "Open-source contributions to many popular libraries like: yarn (2/2 PRs), yarn-docs (4/7 PRs), react-mdc (3/3 PRs), pugjs (1/1 PR) and more."

              );


          return $userAwards;
    }

    protected function getHobby()
    {
          $userhobbies = [];


              $userhobbies[] = new Hobby(
                  "Keeping up with open source communities and libraries."
              );

          return $userhobbies;
    }

    protected function getDAdetails(){


        $userdetails = new DA(
            "Full Stack Web Development",
             "Javascript, Java, PHP",
              "JQuery, VueJS, Postman, Git, Bulma, Firebase, MongoDB, MYSQL",
              "Cloud computing, Human Computer Interaction"
        );
        return $userdetails;
    }

    protected function getSkills(){
        $userSkills = [];

        $userSkills[] = new Skills(
            'UX & UI Design'
        );
        return $userSkills;
    }
}
