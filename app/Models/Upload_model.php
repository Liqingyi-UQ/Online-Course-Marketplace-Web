<?php

namespace App\Models;

use CodeIgniter\Model;

class Upload_model extends Model
{
    // Reference:  S. Wang, "Web Information Systems," 
    // INFS7202, School of Information Technology and Electrical Engineering, The University of Queensland, St Lucia, 
    // QLD, Australia, Semester 1, 2023. 
    // Refer to the demo code on the lecture
    protected $table = 'uploaded_file';
    protected $allowedFields = ['course_name', 'teacher_name', 'file_name', 'is_cover'];

    public function upload($teacher_name, $course_name, $filename, $is_cover)
    {
        $file = [
            'teacher_name' => $teacher_name,
            'course_name' => $course_name,
            'file_name' => $filename,
            'is_cover' => $is_cover
        ];
        $db = \Config\Database::connect();
        $builder = $db->table('uploaded_file');
        if ($builder->insert($file)) {
            return true;
        } else {
            return false;
        }
    }
        
}