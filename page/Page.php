<?php
    require_once('../Auth.php');

    class Page extends Auth
    {
        // Insert data into user table
        public function store($post)
        {           
            $user_id = $this->connection->real_escape_string($_POST['user_id']);
            $name = $this->connection->real_escape_string($_POST['name']);
            $meta_title = $this->connection->real_escape_string($_POST['meta_title']);
            $meta_description = $this->connection->real_escape_string($_POST['meta_description']);
            $content = $this->connection->real_escape_string($_POST['content']);
            $thumbnail_image = $this->connection->real_escape_string($_POST['thumbnail_image']);
            $status = $this->connection->real_escape_string($_POST['status']);

            $duplicateEmailCheckQuery = "SELECT * FROM pages WHERE name='$name'";
            $duplicateEmailCheckResult = $this->connection->query($duplicateEmailCheckQuery);
            if ($duplicateEmailCheckResult->num_rows > 0) {
                $_SESSION['message'] = 'The email has already been taken.';
                header('location:add.php');
                die();
            }            

            $query="INSERT INTO pages(user_id, name, meta_title, meta_description, content, thumbnail_image, status) VALUES('$user_id', '$name', '$meta_title', '$meta_description', '$content', '$thumbnail_image', '$status')";

            $sql = $this->connection->query($query);
            if ($sql==true) {
                header("Location:index.php?msg1=insert");
            }else{
                echo "Failed to add new page. Please try again!";
            }
        }		
        
        // List of all pages
        public function index()
        {
            $query = "SELECT * FROM pages";
            $result = $this->connection->query($query);
            if ($result->num_rows > 0) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            }
            else{
                echo "No page found";
            }
        }
        
        
        // List of pages as per editor
        public function editorIndex($user_id)
        {
            $query = "SELECT * FROM pages WHERE user_id=$user_id";
            $result = $this->connection->query($query);
            if ($result->num_rows > 0) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            }
            else{
                echo "No page found";
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
            $role = 'Editor';
            $status = $this->connection->real_escape_string($_POST['status']);
            $id = $this->connection->real_escape_string($_POST['id']);

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