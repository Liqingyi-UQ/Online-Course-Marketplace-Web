<?php

namespace App\Models;

use CodeIgniter\Model;

class Teachers_model extends Model
{
    // Reference:  S. Wang, "Web Information Systems," 
    // INFS7202, School of Information Technology and Electrical Engineering, The University of Queensland, St Lucia, 
    // QLD, Australia, Semester 1, 2023. 
    // Refer to the demo code on the lecture
    protected $table = 'teachers';
    protected $allowedFields = ['username', 'password', 'email','purchased_courses', 'favorite_courses' 
    , 'security_question', 'security_answer'];

    public function login($username, $password)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('teachers');
        $builder->where('username', $username);
        $builder->where('password', $password);
        $query = $builder->get();
        if ($query->getRowArray()) {
            return true;
        }
        return false;
    }

    public function insertTeacher($data)
    {
        $this->insert($data);
    }

    public function update_Info($id, $data)
    {
        return $this->update($id, $data);
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
