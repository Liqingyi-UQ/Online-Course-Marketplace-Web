<?php

namespace App\Models;

use DateTime;
use CodeIgniter\Model;

/*
Quiz 2 Model, INFS3202/7202, Sem 1, 2023
*/


// Task 4 - Write your code below to implement insertData() and getTop() functions
class Quiz2Model extends Model
{
    protected $table = 'Games';
    protected $allowedFields = ['GID','Title','ReleasedDate','Rating', 'ReviewNumbers', 'Genres'];

    public function insertData($csv_file)
    {
        $file = fopen($csv_file->getPathname(), 'r');
        $i = 0;
        $numberOfFields = 6;
        $csvArr = array();
        
        while (($filedata = fgetcsv($file)) !== FALSE) {
            $num = count($filedata);
            if($i > 0 && $num == $numberOfFields){ 
                $csvArr[$i]['GID'] = $filedata[0];
                $csvArr[$i]['Title'] = $filedata[1];

                // Convert the date format
                $date = DateTime::createFromFormat('M d, Y', $filedata[2]);
                $formattedDate = $date->format('Y-m-d');
            
                $csvArr[$i]['ReleasedDate'] = $formattedDate;
                $csvArr[$i]['Rating'] = $filedata[3];
                $csvArr[$i]['ReviewNumbers'] = $filedata[4];
                $csvArr[$i]['Genres'] = $filedata[5];
            }
            $i++;
        }
        fclose($file);
        
        foreach($csvArr as $userdata){
            $quiz2s = new Quiz2Model();
            $quiz2s->insert($userdata);
        }


    }

    public function getTop()
    {
        // construct your query according to the given SQL statement in the document. 
        $result = $this->select('GID, Title, Rating, ReviewNumbers, Genres')
        ->like('Genres', 'RPG')
        ->orderBy('Rating', 'DESC')
        ->limit(50)
        ->find();
        // return your result
        return $result;
    }
}
// Task 4 - END

