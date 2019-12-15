<?php
    
    class Config{
        
        private $host = "localhost";
        private $dbname = "book";
        private $user = "root";
        private $password = "";
        
        private $cnx = null;
        
        public function Connect()
        {
            $this->cnx = new mysqli($this->host, $this->user, $this->password, $this->dbname);
            if(mysqli_connect_errno($this->cnx))
            {
                die("DB faible");
            }
            $sSQL= "SET NAMES 'utf8'";
            
            mysqli_query($this->cnx,$sSQL);
            return $this->cnx;
        }
        
        public function Disconnect($cnx)
        {
            mysqli_close($cnx);
        }
        
    }

?>