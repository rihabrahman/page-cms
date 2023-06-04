<?php
    include_once('DbConnection.php');

    class Auth extends DbConnection{
    
        public function __construct(){
            parent::__construct();
        }
    
        public function check_login($email, $password)
        {
            $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
            $query = $this->connection->query($sql);
            if($query->num_rows > 0){
                $row = $query->fetch_array();
                
                return $row;
            }
            else{
                return false;
            }
        }
    
        public function query($sql)
        {
            $query = $this->connection->query($sql);    
            $row = $query->fetch_array();
    
            return $row;       
        }
    
        public function escape_string($value)
        {
            return $this->connection->real_escape_string($value);
        }

        public function unauthorized_user()
        {
            $_SESSION['failedMessage'] = 'The action is not permitted.';
            header('location:../home.php');
            die();
        }
    }
?>