<?php

namespace App\Controllers;

use App\Models\Courses_model;
use App\Models\Students_model;
use App\Models\Teachers_model;
use App\Models\Upload_model;
use App\Models\Comments_model;
use App\Models\Rating_model;

class CourseShow extends BaseController
{
    protected $helpers = ['form', 'url', 'session'];
    public function index($course_id)
    {
        $session = session();
        $commentError = $session->get('commentError');
        $ratingError = $session->get('ratingError');
        
        //if course_id or course not exist, return to the home page
        if($course_id == NULL){
            return redirect()->to('/');
        } else {
            $courseModel = new Courses_model();
            $courses = $courseModel->find(['id' => $course_id]);
            if($courses == null){
                return redirect()->to('/');
            } else {
                //get the course name and teacher name
                $teacher_name = $courses[0]['teacher_name'];
                $course_name = $courses[0]['title'];

                //to show the result of rating score and times of evaluation
                $ratingModel = new Rating_model();
                $averageRating = $ratingModel->getAverageScoreByCourse($course_name);
                $totalRatingPeople = $ratingModel->getTotallPeopleByCourse($course_name);

                //insure the course name and course id for rating or commenting
                $session->set('current_course_name', $course_name);
                $session->set('current_course_id', $course_id);

                //show the comments for this course
                $commentModel = new Comments_model();
                $comments = $commentModel -> getAllCommentsByCourse($course_name);

                //if there is no comment
                if(empty($comments)){
                    $comments = NULL;
                }

                $uploadModel = new Upload_model();
                $cover_files = $uploadModel-> where('course_name', $course_name)->where('teacher_name', $teacher_name)->where('is_cover', true)->findAll();
                //if there is no cover picture
                if (empty($cover_files)) {
                    $cover_filename = NULL;
                } else {
                    $cover_filename = $cover_files[0]['file_name'];
                }
                //get the files except cover picture
                $other_files = $uploadModel->where('course_name', $course_name)->where('teacher_name', $teacher_name)->where('is_cover', false)->findAll();
                //consider files is empty
                if (empty($other_files)) {
                    $other_files = NULL;
                } 
                $data=[
                    'courses' => $courses,
                    'cover_filename' => $cover_filename,
                    'other_files' => $other_files,
                    'commentError' => $commentError,
                    'comments' => $comments,
                    'ratingError' => $ratingError,
                    'averageRating' => $averageRating,
                    'totalRatingPeople' => $totalRatingPeople
                ];

                echo view("template/header");
                echo view("course_profile", $data);
                echo view("template/footer");
            }
        } 
    }

    public function add_comment(){
        $session = session();
        $course_id = $session->get('current_course_id');
        $username = $session->get('username');
        $password = $session->get('password');
        $check_islogin = FALSE;
        $commentError = "<div class=\"alert alert-danger\" role=\"alert\"> Add Commment After Login </div> ";
 
        //check log in or not.
        if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
            $check_islogin = TRUE;
        }
        else {
            if ($username && $password) {
                $check_islogin = TRUE;
            } else {
                $check_islogin = FALSE;
            }
        }
        if (strtolower($this->request->getMethod()) !== 'post') { 
            $session->set('commentError', $commentError);           
            return redirect()->to('course_profile/'.$course_id);
        }

        if($check_islogin){
            $commentError = null;
            $session->set('commentError', $commentError); 
            //add comment
            $commentToAdd = [
                'course_name' => $session->get('current_course_name'),
                'username' => $username,
                'comment' => $this->request->getPost('comment')
            ];
            //return to the current course page
            $commentModel = new Comments_model();
            $commentModel->addComment($commentToAdd);
            return redirect()->to('course_profile/'.$course_id);

        } else {
            $session->set('commentError', $commentError); 
            return redirect()->to('course_profile/'.$course_id);
        }
    }

    public function add_rating(){
        $session = session();
        $course_id = $session->get('current_course_id');
        $username = $session->get('username');
        $password = $session->get('password');
        $check_islogin = FALSE;
        $ratingError = "<div class=\"alert alert-danger\" role=\"alert\"> Add Rating Score After Login </div> ";
 
        //check it is log in or not
        if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
            $check_islogin = TRUE;
        }
        else {
            
            if ($username && $password) {
                $check_islogin = TRUE;
            } else {
                $check_islogin = FALSE;
            }
        }
        if (strtolower($this->request->getMethod()) !== 'post') { 
            $session->set('ratingError', $ratingError);           
            return redirect()->to('course_profile/'.$course_id);
        }

        if($check_islogin){
            $ratingError = null;
            $session->set('ratingError', $ratingError); 
            //add rating
            $ratingToAdd = [
                'course_name' => $session->get('current_course_name'),
                'username' => $username,
                'score' => $this->request->getPost('ratingScore')
            ];

            $ratingModel = new Rating_model();
            $ratingModel->addRating($ratingToAdd);
            return redirect()->to('course_profile/'.$course_id);

        } else {
            $session->set('ratingError', $ratingError); 
            return redirect()->to('course_profile/'.$course_id);
        }
    }

    public function add_favorite_course(){
        $session = session();
        $course_id = $session->get('current_course_id');
        $username = $session->get('username');
        $password = $session->get('password');

        $check_login = FALSE;
        $AddingShoppingCartError = "<div class=\"alert alert-danger\" role=\"alert\"> Add Courses After Login </div> ";

          //check log in or not.
        if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
            $check_login = TRUE;
        }
        else {
            if ($username && $password) {
                $check_login = TRUE;
            } else {
                $check_login = FALSE;
            }
        }
        if (strtolower($this->request->getMethod()) !== 'post') { 
            $session->set('AddingShoppingCartError', $AddingShoppingCartError);           
            return redirect()->to('course_profile/'.$course_id);
        }
        
        if($check_login){
            $student_name = $session->get('username'); 
            $studentModel = new Students_model();
            $students = $studentModel->where('username', $student_name)->find();
            $student = $students[0];

            //check whether the user is teacher or student
            if($student==null){
                //no student user
                $AddingShoppingCartError = "<div class=\"alert alert-danger\" role=\"alert\"> Only Students Can Add Course </div> ";
                $session->set('AddingShoppingCartError', $AddingShoppingCartError);   
                return redirect()->to('course_profile/'.$course_id);
            } else {
                //check whether the student has added the courses
                $favorite_courses_string=$student['favorite_courses'];
                $favorite_courses_array = explode(',',$favorite_courses_string);

                $purchased_courses_string=$student['purchased_courses'];
                $purchased_courses_array = explode(',',$purchased_courses_string);
                if(in_array($course_id, $purchased_courses_array)){
                    $AddingShoppingCartError = "<div class=\"alert alert-danger\" role=\"alert\">The Course Has Been Purchased</div> ";
                    $session->set('AddingShoppingCartError', $AddingShoppingCartError);   
                    return redirect()->to('course_profile/'.$course_id);
                } else {
                    if(in_array($course_id, $favorite_courses_array)){
                        $AddingShoppingCartError = "<div class=\"alert alert-danger\" role=\"alert\">The Course Has In The Shopping Cart</div> ";
                        $session->set('AddingShoppingCartError', $AddingShoppingCartError);   
                        return redirect()->to('course_profile/'.$course_id);
                    } else {
                        if($favorite_courses_string==""){
                            $new_favorite_courses_string = $course_id;
                        } else {
                            $new_favorite_courses_string = $favorite_courses_string.','.$course_id;
                        }
    
                        $dataToUpdate = [
                            'favorite_courses' => $new_favorite_courses_string
                        ];
                        $studentModel->update_Info($student['id'],$dataToUpdate);
    
                        $AddingShoppingCartError = "<div class=\"alert alert-success\" role=\"alert\"> Add Course To Shopping Cart Successfully </div>";
                        $session->set('AddingShoppingCartError', $AddingShoppingCartError);
                        return redirect()->to('course_profile/'.$course_id);
                    }
                }    
            }
        }else {
            $session->set('AddingShoppingCartError', $AddingShoppingCartError);           
            return redirect()->to('course_profile/'.$course_id);
        }
    }

}