<?php
    require_once('../auth/Auth.php');

    class User extends Auth
    {
        // Insert editor data into user table
        public function store($post)
        {           
            $name = $this->connection->real_escape_string($_POST['name']);
            $email = $this->connection->real_escape_string($_POST['email']);
            $password = $this->connection->real_escape_string(md5($_POST['password']));
            $role = 'Editor';
            $status = $this->connection->real_escape_string($_POST['status']);

            // Duplicate email address check
            $duplicateEmailCheckQuery = "SELECT * FROM users WHERE email='$email'";
            $duplicateEmailCheckResult = $this->connection->query($duplicateEmailCheckQuery);
            if ($duplicateEmailCheckResult->num_rows > 0) {
                $_SESSION['failedMessage'] = 'The email has already been taken.';
                header('location:add.php');
                die();
            }            

            $query="INSERT INTO users(name, email, password, role, status) VALUES('$name', '$email', '$password', '$role', '$status')";
            $editor = $this->connection->query($query);
            if ($editor==true) {
                $_SESSION['successMessage'] = 'New editor added successfully.';
                header('location:index.php');
                die();
            }else{
                $_SESSION['failedMessage'] = 'Failed to add new editor. Please try again!';
                header('location:add.php');
                die();
            }
        }		
        
        // List of editors
        public function index()
        {
            $query = "SELECT * FROM users WHERE role='Editor' ORDER BY id DESC";
            $editors = $this->connection->query($query);
            if ($editors->num_rows > 0) {
                $data = array();
                while ($row = $editors->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            }
        }		
        
        // Fetch single editor data for edit from user table
        public function edit($id)
        {
            $query = "SELECT * FROM users WHERE id = '$id'";
            $editor = $this->connection->query($query);
            if ($editor->num_rows > 0) {
                $row = $editor->fetch_assoc();
                return $row;                
            }
            else{
                echo "Editor not found";
            }
        }		
        
        // Update editor data into user table
        public function update($post)
        {
            $id = $this->connection->real_escape_string($_POST['id']);
            $name = $this->connection->real_escape_string($_POST['name']);
            $email = $this->connection->real_escape_string($_POST['email']);
            $role = 'Editor';
            $status = $this->connection->real_escape_string($_POST['status']);

            // Duplicate email address check
            $duplicateEmailCheckQuery = "SELECT * FROM users WHERE email='$email' and id!=$id";
            $duplicateEmailCheckResult = $this->connection->query($duplicateEmailCheckQuery);
            if ($duplicateEmailCheckResult->num_rows > 0) {
                $_SESSION['failedMessage'] = 'The email has already been taken.';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                die();
            } 

            $query = "UPDATE users SET name = '$name', email = '$email', role = '$role', status = '$status' WHERE id = '$id'";
            $editor = $this->connection->query($query);

            if ($editor==true) {
                $_SESSION['successMessage'] = 'Editor updated successfully.';
                header('location:index.php');
                die();
            }else{
                $_SESSION['failedMessage'] = 'Failed to update editor. Please try again!';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                die();
            }            
        }
        
        // Delete editor data from user table
        public function destroy($id)
        {
            $query = "DELETE FROM users WHERE id = '$id'";
            $editor = $this->connection->query($query);
            if ($editor==true) {
                $_SESSION['successMessage'] = 'Editor deleted successfully.';
                header('location:index.php');
                die();
            }else{
                $_SESSION['failedMessage'] = 'Failed to delete editor. Please try again!';
                header('location:index.php');
                die();
            } 
        }
    }
?>