<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Courses_model;

class Home extends Controller {
    // Reference: S. Kumar, "CodeIgniter 4 Tutorial: Load More using AJAX," 
    // Geek Culture, Medium, Sep. 8, 2021. [Online]. Available: 
    // https://medium.com/geekculture/codeigniter-4-tutorial-load-more-using-ajax-2d7926042ff9. 
    // Accessed: Apr. 27, 2023.
    public function index() {
        helper(['form', 'url']);
        $this->courseModel = new Courses_Model();
        $data = [
            'courses' => $this->courseModel->paginate(4),
            'pager' => $this->courseModel->pager
        ];
        echo view('template/header');
        echo view('home', $data);
        echo view('template/footer');
    }
   //load more data if scoll. And "4 courses" is "one page"
   public function onScrollLoadMore(){
        $limit = 4; 
        $page = $this->request->getVar('page');
        $offset = $limit * ($page - 1);
        $data['courses'] = $this->loadMoreData($limit, $offset);
        echo view('load_courses', $data);
   }
   //load more data when scoll
   function loadMoreData($limit,$offset){
        $db = new Courses_model();
        $builder = $db->get($limit, $offset);
        $result = $builder->getResult();
        if (!$result) {
            //log error message 
            $error = $db->error();
            log_message('error', $error['message']); 
        }

    return $result;
   }    

} ?>