<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function __construct()
	{
		helper(['url']);
	}

    public function index()
    {
        $data['error'] = "";
        // check whether the cookie is set or not, if set redirect to welcome page, if not set, check the session
        if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
            return redirect()->to('/');
        }
        else {
            $session = session();
            $username = $session->get('username');
            $password = $session->get('password');
            if ($username && $password) {
                return redirect()->to('/');
            } else {
                echo view('template/header');
                echo view('login', $data);
                echo view('template/footer');
            }
        }
    }
    
    // Reference:  S. Wang, "Web Information Systems," 
    // INFS7202, School of Information Technology and Electrical Engineering, The University of Queensland, St Lucia, 
    // QLD, Australia, Semester 1, 2023. 
    // Refer to the demo code on the practice
    public function check_login()
    {
        $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect username or password!! </div> ";
        $username = $this->request->getPost('username');
        // echo $username;
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role');
        $if_remember = $this->request->getPost('remember');
        // echo 'this is remember me : '. $if_remember;
        $model_students = model('App\Models\Students_model');
        $model_teachers = model('App\Models\Teachers_model');

        if ($role == 'student'){
            $check_result = $check_students = $model_students->login($username, $password);
        } else {
            $check_result = $model_teachers->login($username, $password);
        }


        if ($check_result) {
            # Create a session 
            $session = session();
            $session->set('username', $username);
            $session->set('password', $password);
            $session->set('role', $role);
            if ($if_remember) {
                // echo'remember me true  !!';
                # Create a cookie
                setcookie('username', $username, time() + (86400 * 30), "/");
                setcookie('password', $password, time() + (86400 * 30), "/");
                setcookie('role', $role, time() + (86400 * 30), "/");
            }
            // echo view('template/header');
            // echo view('login', $data);
            // echo view('template/footer');
            return redirect()->to('/');
        } else {
            echo view('template/header');
            echo view('login', $data);
            echo view('template/footer');
        }
    }

    public function logout()
    {
        helper('cookie');
        $session = session();
        $session->destroy();
        //destroy the cookie
        setcookie('username', '', time() - 3600, "/");
        setcookie('password', '', time() - 3600, "/");
        setcookie('role', '', time() - 3600, "/");
        return redirect()->to(base_url());
    }
}