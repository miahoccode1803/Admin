<?php
    class connectDB{
        public $con;
        protected $server='localhost';
        protected $username= 'root';

        protected $passwords= '';
        protected $db ='quanlydt';

        function __construct(){
            $this->con = mysqli_connect($this->server, $this->username, $this->passwords,$this->db);
            mysqli_query($this->con,'SET NAMES "utf8"');
        }
    }

    

?>