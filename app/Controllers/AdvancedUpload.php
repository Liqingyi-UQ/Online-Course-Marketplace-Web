<?php 
namespace App\Controllers;
use App\Controllers\BaseController;

class AdvancedUpload extends BaseController{

   public function index(){
      return view('upload_serveral_files');
   }

   public function fileUpload(){
      $session = session();
      $teacher_name = $session->get('username');
      $course_name = $session->get('course_name');

      $data = array();

      // Read new token and assign to $data['token']
      $data['token'] = csrf_hash();

      ## Validation
      $validation = \Config\Services::validation();

      $input = $validation->setRules([
         'file' => 'uploaded[file]|max_size[file,2048]|ext_in[file,jpeg,jpg,png,pdf],'
      ]);

      if ($validation->withRequest($this->request)->run() == FALSE){

          $data['success'] = 0;
          $data['error'] = $validation->getError('file');// Error response

      }else{

          if($file = $this->request->getFile('file')) {
             if ($file->isValid() && ! $file->hasMoved()) {
                // Get file name and extension
                $name = $file->getName();
                $ext = $file->getClientExtension();

                // // Get random file name
                // $newName = $file->getRandomName();

                // Store file in writeable/uploads/ folder
                $file->move('../writable/uploads', $name);

                $model = model('App\Models\Upload_model');
                $is_cover = FALSE;
                $check = $model->upload($teacher_name, $course_name, $name, $is_cover);

                // Response
                $data['success'] = 1;
                $data['message'] = 'Uploaded Successfully!';

             }else{
                // Response
                $data['success'] = 2;
                $data['message'] = 'File not uploaded.'; 
             }
          }else{
             // Response
             $data['success'] = 2;
             $data['message'] = 'File not uploaded.';
          }
      }
      return $this->response->setJSON($data);

   }

}