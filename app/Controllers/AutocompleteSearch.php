<?php namespace App\Controllers;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;

class AutocompleteSearch extends Controller
{
    public function index() {
        return view('home');
    }
    
    public function ajaxSearch()
    {
        helper(['form', 'url']);
        $data = [];
        $db      = \Config\Database::connect();
        $builder = $db->table('courses');   
        $query = $builder->like('title', $this->request->getVar('q'))
                    ->select('id, title as text')
                    ->limit(10)->get();
        $data = $query->getResult();
        
		echo json_encode($data);
    }
}