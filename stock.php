<?php

class Stock {   
    public $book_id;   
    public $book_quantity;   
  
    public function __construct($book_id, $book_quantity)   
    {   
        $this->book_id = $book_id;   
        $this->book_quantity = $book_quantity;   
    }   
}
