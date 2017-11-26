<?php
    class RecordNotFoundException extends Exception{
        //attributes
        protected $message;
        //getter
        public function get_message(){
            return $this->message;
        }
        //constructor
        public function __construct(){
            if(func_num_args()==0){
                $this->message = 'Record not found';
            }
            if(func_num_args()==1){
                $this->message = 'Record not found for id'.func_get_arg(0);
            }

        }
    }
?>