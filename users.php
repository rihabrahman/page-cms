<?php
    class Users
    {
        private $serverName = "localhost";
        private $userName   = "root";
        private $password   = "";
        private $database   = "page_cms";
        public  $connection;

        // Establish Database Connection 
        public function __construct()
        {
            $this->connection = new mysqli($this->serverName, $this->userName,$this->password,$this->database);
            if(mysqli_connect_error()) {
                trigger_error("Failed to connect to MySQL: " . mysqli_connect_error());
            }
            else{
                return $this->connection;
            }
        }	

        // Insert data into user table
        public function store($post)
        {
            $name = $this->connection->real_escape_string($_POST['name']);
            $email = $this->connection->real_escape_string($_POST['email']);
            $password = $this->connection->real_escape_string(md5($_POST['password']));
            $role = $this->connection->real_escape_string($_POST['role']);
            $status = $this->connection->real_escape_string($_POST['status']);
            $query="INSERT INTO users(name, email, password, role, status) VALUES('$name', '$email', '$password', '$role', '$status')";
            $sql = $this->connection->query($query);
            if ($sql==true) {
                header("Location:index.php?msg1=insert");
            }else{
                echo "Failed to add new editor. Please try again!";
            }
        }		
        
        // List of editors
        public function index()
        {
            $query = "SELECT * FROM users WHERE role='Editor'";
            $result = $this->connection->query($query);
            if ($result->num_rows > 0) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            }
            else{
                echo "No editor found";
            }
        }		
        
        // Fetch single data for edit from user table
        public function edit($id)
        {
            $query = "SELECT * FROM users WHERE id = '$id'";
            $result = $this->connection->query($query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row;                
            }
            else{
                echo "Editor not found";
            }
        }		
        
        // Update Editor data into user table
        public function update($postData)
        {
            $name = $this->connection->real_escape_string($_POST['name']);
            $email = $this->connection->real_escape_string($_POST['email']);
            $password = $this->connection->real_escape_string(md5($_POST['password']));
            $role = $this->connection->real_escape_string($_POST['role']);
            $status = $this->connection->real_escape_string($_POST['status']);
            $id = $this->connection->real_escape_string($_POST['id']);
            if (!empty($id) && !empty($postData)) {
                $query = "UPDATE users SET name = '$name', email = '$email', password = '$password' , role = '$role', status = '$status' WHERE id = '$id'";
                $sql = $this->connection->query($query);
                echo $sql;
                if ($sql==true) {
                    header("Location:index.php?msg2=update");
                }else{
                    echo "Editor update failed. Please try again!";
                }
            }
            
        }
        
        // Delete Editor data from user table
        public function destroy($id)
        {
            $query = "DELETE FROM users WHERE id = '$id'";
            $sql = $this->connection->query($query);
            if ($sql==true) {
                header("Location:index.php?msg3=delete");
            }else{
                echo "Editor does not deleted. Please try again!";
            }
        }
    }
?>