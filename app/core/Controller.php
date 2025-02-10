<?php

class Controller
{
    public function view($view,$data =[])
    {
        extract($data);
        $filename = "../app/views/".$view.".view.php";
        if(file_exists($filename))
        {
            require $filename;
        }else{
            echo "couldn't find view file:" .$filename;
        }
    }
}