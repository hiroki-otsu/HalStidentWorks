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
    public function checkBlankSpace($value,$msg){
        if(empty($value)){
            $this->setErrors($msg);
        }
        return $value;
    }
}