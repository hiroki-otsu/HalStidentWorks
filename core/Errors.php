<?php

class errors
{
    protected $errors = array();

    public function setErrors($errorMsg){
        $this->errors[] ='<li>'.$errorMsg.'</li>';
    }

    public function  getErrors(){
        foreach ($this->errors as $msg){
            print $msg;
        }
    }
}