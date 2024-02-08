<?php

namespace App\Models;

use CodeIgniter\Model;


class Comments_model extends Model
{
    //the comments on the course
    protected $table = 'course_comments';
    protected $allowedFields = ['course_name', 'comment', 'username'];
       
    public function addComment($data)
    {
        $this->insert($data);
    }

    public function getAllCommentsByCourse($course_name)
    {           
        //Notice, it will return the array not stdArry. Do not use "->"  
        return $this->where('course_name', $course_name)->findAll();   
    }

}