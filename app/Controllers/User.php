<?php

namespace App\Controllers;

use App\Models\Students_model;
use App\Models\Teachers_model;
use App\Models\Courses_model;
//To show the user profile and update the user email address
class User extends BaseController
{
    protected $helpers = ['form', 'url'];

    public function index()
    {
        $studentsModel = new Students_model();
        $teachersModel = new Teachers_model();
        $courseModel = new Courses_model();
        $session = session();
        $username = $session->get('username');
        

        $user = $studentsModel->where('username', $username)->first();
        $role = 'student';
 
        $course_names = $studentsModel->getPurchasedCoursesIDsByName($username);

        if (!$user) {
            $user = $teachersModel->where('username', $username)->first();
            $role = 'teacher';
            $course_names = $courseModel->getCoursesByTeacher($username);
        }

        if(empty($course_names)) {
            $course_names = "The course list is empty now";
        } else {
            $course_names_copy = array();
            foreach($course_names as $c){
                $course_names_copy[]  = $courseModel->getCourseInfoByID($c);
            }
            $course_names = $course_names_copy;
        }



        $data = [
            'user' => $user,
            'role' => $role,
            'course_names' => $course_names
        ];

            echo view("template/header");
            echo view("user_profile", $data);
            echo view("template/footer");
        
    }
    //update the user information: email address
    public function update_information()
    {
        $error = "<div class=\"alert alert-danger\" role=\"alert\"> Not validate email </div> ";
        $success = "<div class=\"alert alert-success\" role=\"alert\"> Email updated successfully! </div>";
        $studentsModel = new Students_model();
        $teachersModel = new Teachers_model();
        $courseModel = new Courses_model();
        $session = session();
        $username = $session->get('username');
       
        $user = $studentsModel->where('username', $username)->first();
        $role = 'student';
        
        if (!$user) {
            $user = $teachersModel->where('username', $username)->first();
            $role = 'teacher';
        }
        
        if (strtolower($this->request->getMethod()) !== 'post') {            
            echo view('template/header');
            echo view('user_profile', ['error' => $error, 'user' => $user, 'role' => $role]);
            echo view('template/footer');
        }
        //confirm the email address is avaliable
        $rules = [
            'email' => 'required|valid_email',
        ];   

        if (! $this->validate($rules)) {

            echo view('template/header');
            echo view('user_profile', ['error' => $error, 'user' => $user, 'role' => $role]);
            echo view('template/footer');
        }else{
            $dataToUpdate = [
                'email' => $this->request->getPost('email'),
            ];
            // If the user is student
            if ($role == 'student') {
                $studentsModel->update_Info($user['id'],$dataToUpdate);
                $user = $studentsModel->where('username', $username)->first();
                $course_names = $studentsModel->getPurchasedCoursesIDsByName($username);

            } else {
                $teachersModel->update_Info($user['id'],$dataToUpdate);
                $user = $teachersModel->where('username', $username)->first();
                $course_names = $courseModel->getCoursesByTeacher($username);
            }

            if(empty($course_names)) {
                $course_names = "The course list is empty now";
            }
            echo view('template/header');
            echo view('user_profile', ['success' => $success, 'user' => $user, 'role' => $role, 'course_names' => $course_names]);
            echo view('template/footer');
        }
        
    }
}

   
    
