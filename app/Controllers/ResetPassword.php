<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Students_model;
use App\Models\Teachers_model;

class ResetPassword extends Controller
{
    public function index(){
        echo view('template/header');
        echo view('reset_password', ['error' => "", 'success' => "", 'change_state' =>""]);
        echo view('template/footer');
    }

    public function verify()
    {
        $session = session();
        $data['error'] = "";
        $data['success'] = "";
        //get the data from verify
        $username = $this->request->getPost('username');
        $security_question = $this->request->getPost('security_question');
        $security_answer = $this->request->getPost('security_answer');
        $role = $this->request->getPost('role');
        //check
        $model_students = model('App\Models\Students_model');
        $model_teachers = model('App\Models\Teachers_model');
        if ($role == 'student'){
            $check_result = $model_students->verifySecurity($username,$security_question,$security_answer);
        } else {
            $check_result = $model_teachers->verifySecurity($username,$security_question,$security_answer);
        }

        //check the result
        if ($check_result!=null) {
            $verify_security_answer_state = TRUE;
            $session->set('username_want_to_change_password', $check_result['username']);
            $session->set('role_want_to_change_password', $role);
            $data['success'] = "<div class=\"alert alert-success\" role=\"alert\">Security Answer Is Right</div> ";
        } else {
            $verify_security_answer_state = FALSE;
            $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\">The Answer Is Wrong Or Username Does Not Exist</div> ";
        }
        
        $session->set('verify_security_answer_state', $verify_security_answer_state);
        echo view('template/header');
        echo view('reset_password', $data);
        echo view('template/footer');
    }

    public function changepassword()
    {
        $changestate = "";
        //comfirm the password is valid
        $rules = [
            'new_password' => 'required|min_length[8]'
        ];   

        $studentsModel = new Students_model();
        $teachersModel = new Teachers_model();
        $session = session();
        $verify_security_answer_state = $session->get('verify_security_answer_state');
        
        if (!$this->validate($rules)) {
            $changestate = "<div class=\"alert alert-danger\" role=\"alert\">The New Password Not Valid</div> ";
            echo view('template/header');
            echo view('reset_password', ['error' => "", 'success' => "", 'change_state' => $changestate]);
            echo view('template/footer');
        }else{
            //check whether the security answer is right
            if($verify_security_answer_state){

                $username = $session->get('username_want_to_change_password');
                $role = $session->get('role_want_to_change_password');
                if ($role = 'teacher') {
                    $user = $teachersModel->where('username', $username)->first();
                } else {
                    $user = $studentsModel->where('username', $username)->first();
                }

                $dataToUpdate = ['password' => $this->request->getPost('new_password')];
                // If the user is student
                if ($role == 'student') {
                    $studentsModel->update_Info($user['id'],$dataToUpdate);
                } else {
                    $teachersModel->update_Info($user['id'],$dataToUpdate);
                }
                $changestate = "<div class=\"alert alert-success\" role=\"alert\">Change Password Successfully, Go Back To Login</div>";
                echo view('template/header');
                echo view('reset_password', ['error' => "", 'success' => "", 'change_state' => $changestate]);
                echo view('template/footer');
            } else {
                $changestate = "<div class=\"alert alert-danger\" role=\"alert\">Not Passing Security Quesion Test</div> ";
                echo view('template/header');
                echo view('reset_password', ['error' => "", 'success' => "", 'change_state' => $changestate]);
                echo view('template/footer');
            }  
        }
    }
}