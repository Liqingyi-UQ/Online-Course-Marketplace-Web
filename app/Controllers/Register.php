<?php

namespace App\Controllers;

use App\Models\Students_model;
use App\Models\Teachers_model;
use App\ThirdParty\Recaptcha;

class Register extends BaseController
{
    protected $helpers = ['form', 'url'];

    // Reference:  S. Wang, "Web Information Systems," 
    // INFS7202, School of Information Technology and Electrical Engineering, The University of Queensland, St Lucia, 
    // QLD, Australia, Semester 1, 2023. 
    // Refer to the demo code on the practice
    public function index()
    {
        $data['error'] = "";
        $data['success'] = "";
        // check whether the cookie is set or not, if set redirect to welcome page, if not set, check the session
        if (isset($_COOKIE['username']) && isset($_COOKIE['password'])&& isset($_COOKIE['role'])) {
            return redirect()->to('/');
        }
        else {
            $session = session();
            $username = $session->get('username');
            $password = $session->get('password');
            $role = $session->get('role');
            if ($username && $password && $role) {
                return redirect()->to('/');
            } else {
                echo view('template/header');
                echo view('register', $data);
                echo view('template/footer');
            }
        }
    }
    public function check_register()
    {
        // $session = session();
        $data['success'] = "";
        $data['error'] = "";
        if (strtolower($this->request->getMethod()) !== 'post') {      
            echo view('template/header');
            echo view('register', $data);
            echo view('template/footer');
        }

        $recaptcharesponse = $this->request->getPost('g-recaptcha-response');
        $Recaptcha = new Recaptcha();
        //using recaptcha to check robot
        if (!($Recaptcha->check_Response($recaptcharesponse))) {    
            $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Should check robot or not </div> ";               
            echo view('template/header');
            echo view('register', $data);
            echo view('template/footer');
        } else {
            //set the rule. Insure the password strength and unique username and unique email
            $rules = [
                'username' => 'required|min_length[4]|alpha_numeric|is_unique[students.username,teachers.username]',
                'password' => 'required|min_length[8]',
                'role' => 'required|in_list[student,teacher]',
                'email' => 'required|valid_email|is_unique[students.email,teachers.email]',
            ];             
    
            if (! $this->validate($rules)) {
                $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Not validate username or password or email </div> ";    
                echo view('template/header');
                echo view('register', $data);
                echo view('template/footer');
            }else{
                $data['success'] = "<div class=\"alert alert-success\" role=\"alert\"> Register Successfully</div> ";
                //using hash code to ensure security
                $hashed_answer = password_hash($this->request->getPost('security_answer'), PASSWORD_DEFAULT);
                $dataToInsert = [
                    'username' => $this->request->getPost('username'),
                    'password' => $this->request->getPost('password'),
                    'email' => $this->request->getPost('email'),
                    'security_question' => $this->request->getPost('security_question'),
                    'security_answer' =>  $hashed_answer
                ];
                
                $dataToVerify = [
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'role' => $this->request->getPost('role'),
                    'success' => '',
                    'error' => ''
                ];
                // $session->set('register_username',$dataToInsert['username']);
                // $session->set('register_email',$dataToInsert['email']);

                $studentsModel = new Students_model(); 
                $teachersModel = new Teachers_model(); 
                // Insert the user data to database
                // If the email verification dose not work, it will be deleted
                if ($this->request->getPost('role') == 'student') {
                    $studentsModel->insertStudent($dataToInsert);
                } else {
                    $teachersModel->insertTeacher($dataToInsert);
                }

                echo view('template/header');
                // echo view('register', $data);
                echo view('email_verification',$dataToVerify);
                echo view('template/footer');
            }
        }

        
    }
}