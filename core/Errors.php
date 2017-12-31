<?php

class errors
{
    protected $errors = array();

    public function errors($errorName,$errorMsg){
        $this ->errors = array(
            $errorName => $errorMsg
        );
    }
}