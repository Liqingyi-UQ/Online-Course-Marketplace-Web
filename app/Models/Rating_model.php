<?php

namespace App\Models;

use CodeIgniter\Model;


class Rating_model extends Model
{
    //the rating for courses
    protected $table = 'ratings';
    protected $allowedFields = ['course_name', 'username', 'score'];
       
    public function addRating($ratingToAdd)
    {
        $this->insert($ratingToAdd);
    }

    public function getAverageScoreByCourse($course_name)
    {   
        $allScore = 0;  
        $count = 0;    
        $ratings = $this->where('course_name', $course_name)->findAll();
        foreach($ratings as $r){
            $allScore += $r['score'];
            $count ++;
        }
        if ($count == 0){
            return 0;
        } else {
            return $allScore / $count;
        }
    }

    public function getTotallPeopleByCourse($course_name)
    {   
        $count = 0;    
        $ratings = $this->where('course_name', $course_name)->findAll();
        foreach($ratings as $r){
            $count ++;
        }
        return $count;
    }

}