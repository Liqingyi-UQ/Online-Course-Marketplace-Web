<?php

namespace App\Controllers;

use App\Models\Students_model;
use App\Models\Courses_model;

class Shoppingcart extends BaseController
{
    protected $helpers = ['form', 'url'];

    public function index()
    {
        $studentsModel = new Students_model();
        $courseModel = new Courses_model();
        $session = session();
        $username = $session->get('username');
        
        $student = $studentsModel->where('username', $username)->first();
        $role = 'student';
 
        $courses_ids = $studentsModel->getFavoriteCoursesIDsByName($username);

        if(empty($courses_ids)) {
            $cart_list = "The cart list is empty now";
            
        } else {
            //finish $cart_list 
            $cart_list = array();
            foreach($courses_ids as $id){
                $cart_list[]=$courseModel->getCourseInfoByID($id);
            }
        }

        $data = [
            'cart_list' => $cart_list
        ];

            echo view("template/header");
            echo view("shopping_cart", $data);
            echo view("template/footer");
    }

    public function process()
    {
        $studentsModel = new Students_model();
        $courseModel = new Courses_model();
        $session = session();
        $username = $session->get('username');
        $student = $studentsModel->where('username', $username)->first();
        $favorite_courses_string = $student['favorite_courses'];
        $purchased_courses_string = $student['purchased_courses'];
        
        $remove_id = $this->request->getPost('remove');
        $buy_id = $this->request->getPost('buy');

        if($buy_id==null){
            //just delete the course from the cart
            $course_id = $remove_id;
            $favorite_courses_array = explode(',',$favorite_courses_string);
            $newfavorite_courses_array = array_diff($favorite_courses_array, [$course_id]);
            $newfavorite_courses_string = '';
            $count = 1;
            foreach($newfavorite_courses_array as $course_id){
                if($count==1){
                    $newfavorite_courses_string = $newfavorite_courses_string.$course_id;
                } else {
                    $newfavorite_courses_string = $newfavorite_courses_string.','.$course_id;
                }
                $count = $count + 1;
            }

            $dataToUpdate = [
                'favorite_courses' => $newfavorite_courses_string
            ];

            $studentsModel->update_Info($student['id'],$dataToUpdate);


        } else {

            $course_id = $buy_id;
            $favorite_courses_array = explode(',',$favorite_courses_string);
            $newfavorite_courses_array = array_diff($favorite_courses_array, [$course_id]);
            $newfavorite_courses_string = '';
            
            $count = 1;
            foreach($newfavorite_courses_array as $course_id){
                if($count==1){
                    $newfavorite_courses_string = $newfavorite_courses_string.$course_id;
                } else {
                    $newfavorite_courses_string = $newfavorite_courses_string.','.$course_id;
                }
                $count = $count + 1;
            }

            $newpurchased_courses_string = "";
            if($purchased_courses_string == ""){
                $newpurchased_courses_string = $newfavorite_courses_string.$course_id;
            } else {
                $newpurchased_courses_string = $newpurchased_courses_string.','.$course_id;
            }

            $dataToUpdate = [
                'favorite_courses' => $newfavorite_courses_string,
                'purchased_courses' => $newpurchased_courses_string
            ];

            $studentsModel->update_Info($student['id'],$dataToUpdate);

        }

        return redirect()->to('/shoppingcart');
    }
}

   
    
