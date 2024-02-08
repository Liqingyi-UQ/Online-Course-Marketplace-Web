<?php

namespace App\Controllers;

use App\Models\Courses_model;
use App\Models\Students_model;
use App\Models\Teachers_model;
use App\Models\Picture_model;
use CodeIgniter\Files\File;

class Upload extends BaseController
{
    protected $helpers = ['form', 'url'];

    public function index()
    {
        $data['upload_state'] = "";
        $data['success'] = "";
        $data['confirm_state'] = "";
        // check whether the cookie is set or not, if set redirect to welcome page, if not set, check the session
        if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
            echo view("template/header");
            echo view("upload", $data);
            echo view("template/footer");
        }
        else {
            $session = session();
            $username = $session->get('username');
            $password = $session->get('password');
            if ($username && $password) {
                echo view("template/header");
                echo view("upload", $data);
                echo view("template/footer");
            } else {
                echo view('template/header');
                echo view('home');
                echo view('template/footer');
            }
        }
    }
    //teacher can create the course
    public function createCourse()
    {
        $session = session();
        $username = $session->get('username');
        $data['success'] = "";
        $data['upload_state'] = "";
        $data['confirm_state'] = "";
        if (strtolower($this->request->getMethod()) !== 'post') {            
            echo view('template/header');
            echo view('upload', $data);
            echo view('template/footer');
        }
        //Insert the course details to database
        $dataToInsert = [
            'teacher_name' => $username,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price')
        ];
        
        $data['success'] = "<div class=\"alert alert-success\" role=\"alert\"> Create Successfully </div> ";
        $coursesModel = new Courses_model(); 
        $coursesModel->createCourse($dataToInsert);
        echo view('template/header');
        echo view('upload', $data);
        echo view('template/footer');
    }
    // Add the course to the session. Be used before the upload
    public function addSessionCourse() {
        $data['success'] = "";
        $data['upload_state'] = "";
        $data['confirm_state'] = "";
        $session = session();
        $course_name = $this->request->getPost('session_course_name');
        $teacher_name = $session->get('username');
        $courseModel = new Courses_model(); 
        $course = $courseModel->where('teacher_name', $teacher_name)->where('title', $course_name)->first();
        if ($course == null or $course_name == null) {
            $data['confirm_state'] = "<div class=\"alert alert-danger\" role=\"alert\"> Not validate course name </div>";
            echo view('template/header');
            echo view('upload', $data);
            echo view('template/footer');
        } else {
            $data['confirm_state'] = "<div class=\"alert alert-success\" role=\"alert\"> Confirm Successfully </div>";
            $session->set('course_name', $course_name);
            echo view('template/header');
            echo view('upload', $data);
            echo view('template/footer');
        }

    }
    //upload the cover picture
    public function upload_basic_file() {
        $data['success'] = "";
        $data['upload_state'] = "";
        $data['confirm_state'] = "";
        $session = session();
        $teacher_name = $session->get('username');

        $course_name = $this->request->getPost('course_name');
        $file = $this->request->getFile('userfile');
        $fileExtension = $file->guessExtension();
        //Insure the "cover picture" is picture
        $checkFileType = in_array($fileExtension, ['jpg','jpeg','png']);
        $rules = [
            'course_name' => 'required',
        ];    
        //validation
        if ((! $this->validate($rules)) or ($checkFileType == FALSE)) {
            $data['upload_state'] = "<div class=\"alert alert-danger\" role=\"alert\"> Not validate course name or file type </div> ";    
            echo view('template/header');
            echo view('upload', $data);
            echo view('template/footer');
        } else {
            $courseModel = new Courses_model(); 
            $course = $courseModel->where('teacher_name', $teacher_name)->first();
            if($course == null){
                $data['upload_state'] = "<div class=\"alert alert-danger\" role=\"alert\"> The course name dose not exist </div> ";
                echo view('template/header');
                echo view('upload', $data);
                echo view('template/footer');
            } else {
                //upload
                $file->move(WRITEPATH . 'uploads');
                $filename = $file->getName();
                $model = model('App\Models\Upload_model');
                $is_cover = TRUE;
                $check = $model->upload($teacher_name, $course_name, $filename, $is_cover);

                $pictureModel = new Picture_model();

                $path = ROOTPATH.'writable/uploads/';
                // // Crop the image
                // $cropImage = $pictureModel->crop($path,$filename);
    
                // // Rotate the image
                // $rotImage = $pictureModel->rotate($path, $filename); 

                $watermarkerImage = $pictureModel->addTextWatermark($path, $filename, "LearnLion"); 
                
                $data['original'] = '/LearnLion/writable/uploads/'.$filename;
                $data['original_info'] = new File(ROOTPATH.'writable/uploads/'.$filename); 
                // $data['crop'] = '/LearnLion/writable/uploads/'.$cropImage;
                // $data['rot'] = '/LearnLion/writable/uploads/'.$rotImage;   
                $data['watermarker'] = '/LearnLion/writable/uploads/'.$watermarkerImage; 

                if ($check) {
                    $data['upload_state'] = "<div class=\"alert alert-success\" role=\"alert\"> Upload Successfully </div>";
                    echo view('template/header');
                    echo view('upload', $data);
                    echo view('template/footer');
                } else {
                    $data['upload_state'] = "<div class=\"alert alert-danger\" role=\"alert\"> Upload failed </div> ";
                    echo view('template/header');
                    echo view('upload', $data);
                    echo view('template/footer');
                }
            }
        }
    }
}