<?php

namespace App\Models;

use CodeIgniter\Model;


class Courses_model extends Model
{
    //The courses created
    protected $table = 'courses';
    protected $allowedFields = ['teacher_name', 'title', 'description', 'price'];
       
    public function createCourse($data)
    {
        $this->insert($data);
    }

    public function getCourseInfoByID($id)
    {
        $courses=$this->where('id',$id)->find();
        $course=$courses[0];
        return $course;
    }


    public function getCourseNameByID($id)
    {
        $courses=$this->where('id',$id)->find();
        $course=$courses[0];
        return $course['title'];
    }

    public function getCoursesByTeacher($teacher_name)
    {             
        //Notice, it will return the array not stdArry. Do not use "->"  
        return $this->where('teacher_name', $teacher_name)->findAll();   
    }

}