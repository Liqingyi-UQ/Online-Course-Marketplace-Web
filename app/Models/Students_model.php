<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Courses_model;

class Students_model extends Model
{


    protected $table = 'students';
    protected $allowedFields = ['username', 'password', 'email', 'purchased_courses', 'favorite_courses' , 
    'security_question', 'security_answer'];

    // Reference:  S. Wang, "Web Information Systems," 
    // INFS7202, School of Information Technology and Electrical Engineering, The University of Queensland, St Lucia, 
    // QLD, Australia, Semester 1, 2023. 
    // Refer to the demo code on the lecture

    public function login($username, $password)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('students');
        $builder->where('username', $username);
        $builder->where('password', $password);
        $query = $builder->get();
        if ($query->getRowArray()) {
            return true;
        }
        return false;
    }

    public function insertStudent($data)
    {
        $this->insert($data);
    }

    public function update_Info($id, $data)
    {
        return $this->update($id, $data);
    }

    public function getFavoriteCoursesIDsByName($username)
    {
        $courseModel = new Courses_model();
        $students=$this->where('username', $username)->find();  
        $student=$students[0];
        $favorite_courses_string=$student['favorite_courses'];
        $favorite_courses_array = explode(',',$favorite_courses_string);
        $favorite_courses_ids_array = array();
        if(empty($favorite_courses_string)){
            return $favorite_courses_ids_array;
        } else {
            foreach($favorite_courses_array as $favorite_courses_id){
                $favorite_courses_ids_array[] = $favorite_courses_id;
            }
            return $favorite_courses_ids_array;
        }
                   
    }

    public function getPurchasedCoursesIDsByName($username)
    {
        $courseModel = new Courses_model();
        $students=$this->where('username', $username)->find();  
        $student=$students[0];
        $purchased_courses_string=$student['purchased_courses'];
        $purchased_courses_array = explode(',',$purchased_courses_string);
        $purchased_courses_ids_array = array();
        if(empty($purchased_courses_string)){
            return $purchased_courses_ids_array;
        } else {
            foreach($purchased_courses_array as $purchased_courses_id){
                $purchased_courses_ids_array[] = $purchased_courses_id;
            }
            return $purchased_courses_ids_array;
        }
                   
    }

    public function getFavoriteCoursesByName($username)
    {
        $courseModel = new Courses_model();
        $students=$this->where('username', $username)->findAll();  
        $student=$students[0];
        $favorite_courses_string=$student['favorite_courses'];
        $favorite_courses_array = explode(',',$favorite_courses_string);
        $favorite_courses_name_array = array();
        if(empty($favorite_courses_array)){
            return $favorite_courses_name_array;
        } else {
            foreach($favorite_courses_array as $favorite_courses_id){
                $favorite_courses_name_array[] = $courseModel->getCourseNameByID($favorite_courses_id);
            }
            return $favorite_courses_name_array;
        }
                   
    }

     //if not find, find null. if find, return the user all information
     public function verifySecurity($username, $security_question,$security_answer){
        $user_info = $this->where('username', $username)
            ->where('security_question', $security_question)
            ->first();
        
        if($user_info==null){
            return null;
        } else {
            //check whether the answer is right
            if(password_verify($security_answer, $user_info['security_answer'])){
                return $user_info;
            } else {
                return null;
            }
        }    
    }

    public function deleteByUsername($username)
    {
        // find the username
        $user = $this->where('username', $username)->first();
    
        // if exist, delete
        if ($user) {
            $this->delete($user['id']);
        }
    }
}
