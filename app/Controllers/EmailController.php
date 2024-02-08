<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Email\Email;
use App\Models\Students_model;
use App\Models\Teachers_model;

class EmailController extends Controller
{
    public function send()
    {
        $session = session();
        helper(['form']);
        // add code here!
        $data['success'] = "";
        $data['error'] = "";
        $receiver = $this->request->getVar('email');
        $username = $this->request->getVar('username');
        $role = $this->request->getVar('role');

        $session->set('verify_username',$username);
        $session->set('verify_email',$receiver);
        $session->set('verify_role',$role);
        

        $sender = "qingyi.li1@uq.edu.au";
        $subject = "The Verification Code From LearnLion";
        $number = rand(1000, 9999); // give a 4 digits random number
        $session->set('verify_code', $number);
        $message = $role . " " . $username . ": Your verification code is " . $number;
            // echo $receiver, $sender, $subject, $message;
            $email = new Email();

            $emailConf = [
                'protocol' => 'smtp',
                'wordWrap' => true,
                'SMTPHost' => 'mailhub.eait.uq.edu.au',
                'SMTPPort' => 25
            ];
            $email->initialize($emailConf);
            
            $email->setTo($receiver);
            $email->setFrom($sender);
            $email->setSubject($subject);
            $email->setMessage($message);


            $data = [
                'username' => $username,
                'email' => $receiver,
                'role' => $role,
                'success' => '',
                'error' => ''
            ];

            

        if ($email->send()) {
            $data['success'] = "<div class=\"alert alert-success\" role=\"alert\">Send Verfication Code Successfully</div> ";
        } else {
            $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\">Error sending email. Please try again later.</div> ";
        }

        echo view('template/header');
        echo view('email_verification',$data);
        echo view('template/footer');
    }

    public function verify()
    {
        $session = session();
        $dataToShow = [
            'username' => $session->get('verify_username'),
            'email' => $session->get('verify_email'),
            'role' => $session->get('verify_role'),
            'success' => '',
            'error' => '',
            'verify_state' => ''
        ];
        $verification_code = $this->request->getVar('verification_code');
        $right_code = $session->get('verify_code');

        $username = $session->get('verify_username');

        if($right_code==$verification_code){
            $dataToShow['verify_state'] = "<div class=\"alert alert-success\" role=\"alert\">Code is right, please go to log in</div> ";
            echo view('template/header');
            echo view('email_verification',$dataToShow);
            echo view('template/footer');
        } else {
            $dataToShow['verify_state'] = "<div class=\"alert alert-danger\" role=\"alert\">Code is wrong, please register again</div> ";

            $studentsModel = new Students_model(); 
            $teachersModel = new Teachers_model(); 
            // If the email verification dose not work, it will be deleted
            if (($session->get('verify_role'))== 'student') {
                $studentsModel->deleteByUsername($username);
            } else {
                $teachersModel->deleteByUsername($username);
            }

            echo view('template/header');
            echo view('email_verification',$dataToShow);
            echo view('template/footer');
        }

    }
}