<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function testpage()
    {
        echo 'test page';
    }

    public function processcsv()
    {

        $file_path = getenv('PROCESSCSV_PATH');
        $file_name = getenv('PROCESSCSV_FILE');

        $masterData = array();
        $c = 0;

        for ( $i = 1; $i <= 7; $i++ ) {

            $csvfile = $file_path.$file_name.$i.".csv";
            // echo $csvfile;

            $file = fopen($csvfile,"r");

            
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                // print_r($filedata);

                if (!array_key_exists($filedata[0],$masterData)) {
                    $masterData[$filedata[0]] = (int)$filedata[1];
                    // echo "B";
                } else {
                    $masterData[$filedata[0]] = $masterData[$filedata[0]] + $filedata[1];
                    // echo "A";
                }

                $c++;
                
            }

            fclose($file);

        }

        // echo $c;

        // asort($masterData);
        arsort($masterData);

        // print_r($masterData);

        $jsonData = json_encode($masterData);

        echo $jsonData;
        
    }
}
