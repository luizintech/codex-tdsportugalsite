<?php

namespace App\Dtos;

class Result {
    public $id;
    public $success;
    public $messages;
    public $total;
    
    public $objectResult;
    
	function __construct() {
        $this->id = 0;
        $this->success = false;
        $this->messages = "";
        $this->total = 0;
    }
}