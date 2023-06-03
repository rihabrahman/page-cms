<?php
    require_once('../Auth.php');

    class User extends Auth
    {
        // Insert data into user table
        public function store($post)
        {           
            $name = $this->connection->real_escape_string($_POST['name']);
            $email = $this->connection->real_escape_string($_POST['email']);
            $password = $this->connection->real_escape_string(md5($_POST['password']));
            $role = 'Editor';
            $status = $this->connection->real_escape_string($_POST['status']);

            $duplicateEmailCheckQuery = "SELECT * FROM users WHERE email='$email'";
            $duplicateEmailCheckResult = $this->connection->query($duplicateEmailCheckQuery);
            if ($duplicateEmailCheckResult->num_rows > 0) {
                $_SESSION['message'] = 'The email has already been taken.';
                header('location:add.php');
                die();
            }            

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
            $id = $this->connection->real_escape_string($_POST['id']);
            $name = $this->connection->real_escape_string($_POST['name']);
            $email = $this->connection->real_escape_string($_POST['email']);
            $role = 'Editor';
            $status = $this->connection->real_escape_string($_POST['status']);

            $duplicateEmailCheckQuery = "SELECT * FROM users WHERE email='$email' and id!=$id";
            $duplicateEmailCheckResult = $this->connection->query($duplicateEmailCheckQuery);

            if ($duplicateEmailCheckResult->num_rows > 0) {
                $_SESSION['message'] = 'The email has already been taken.';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                die();
            } 

            if (!empty($id) && !empty($postData)) {
                $query = "UPDATE users SET name = '$name', email = '$email', role = '$role', status = '$status' WHERE id = '$id'";
                $sql = $this->connection->query($query);
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