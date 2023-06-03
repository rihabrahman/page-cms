<?php
    require_once('../Auth.php');
    require_once('test.php');

    class Page extends Auth
    {
        // Insert data into user table
        public function store($post)
        {           
            $user_id = $this->connection->real_escape_string($_POST['user_id']);
            $name = $this->connection->real_escape_string($_POST['name']);
            $meta_title = $this->connection->real_escape_string($_POST['meta_title']);
            $meta_description = $this->connection->real_escape_string($_POST['meta_description']);
            $content = $_POST['content'];
            $thumbnail_image=$_FILES["thumbnail_image"]["name"];
            $status = $this->connection->real_escape_string($_POST['status']);

            $duplicateNameCheckQuery = "SELECT * FROM pages WHERE name='$name'";
            $duplicateNameCheckQuery = $this->connection->query($duplicateNameCheckQuery);
            if ($duplicateNameCheckQuery->num_rows > 0) {
                $_SESSION['failedMessage'] = 'The name has already been taken.';
                header('location:add.php');
                die();
            }
            // get the image extension
            $extension = pathinfo($thumbnail_image, PATHINFO_EXTENSION);

            // allowed extensions
            $allowed_extensions = array("jpg","jpeg","png");
            
            // Validation for allowed extensions .in_array() function searches an array for a specific value.
            if(!in_array($extension,$allowed_extensions))
            {
                $_SESSION['failedMessage'] = 'Invalid format. Only jpg / jpeg/ png /gif format allowed.';
                header('location:add.php');
                die();
            }
            else
            {
                 //rename the image file
                $imgnewfile=$name.uniqid().time().".".$extension;
                // Code for move image into directory
                move_uploaded_file($_FILES["thumbnail_image"]["tmp_name"],"include/images/".$imgnewfile);
            }
            $check = test($meta_title, $meta_description, $content, $imgnewfile);
            $newTemplate = file_put_contents("template.php", $check);
            $newContent = file_get_contents("template.php");
            if (!file_exists($name . '.html')) { $handle = fopen('include/' . $name .'.html','w+'); fwrite($handle,$newContent); fclose($handle); }

            $query="INSERT INTO pages(user_id, name, meta_title, meta_description, content, thumbnail_image, status) VALUES('$user_id', '$name', '$meta_title', '$meta_description', '$content', '$imgnewfile', '$status')";
            $sql = $this->connection->query($query);
                
            if ($sql==true) {
                $_SESSION['successMessage'] = 'Page added successfully.';
                header('location:index.php');
                die();
            }else{
                $_SESSION['failedMessage'] = 'Failed to add new page. Please try again!';
                header('location:index.php');
                die();
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
        }		
        
        // Fetch single data for edit from user table
        public function edit($id)
        {
            $query = "SELECT * FROM pages WHERE id = '$id'";
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
        public function update($post)
        {
            $id = $this->connection->real_escape_string($_POST['id']);
            $user_id = $this->connection->real_escape_string($_POST['user_id']);
            $name = $this->connection->real_escape_string($_POST['name']);
            $meta_title = $this->connection->real_escape_string($_POST['meta_title']);
            $meta_description = $this->connection->real_escape_string($_POST['meta_description']);
            $content = $_POST['content'];
            $thumbnail_image=$_FILES["thumbnail_image"]["name"];
            $status = $this->connection->real_escape_string($_POST['status']);

            $duplicateNameCheckQuery = "SELECT * FROM pages WHERE name='$name' and id!=$id";
            $duplicateNameCheckQuery = $this->connection->query($duplicateNameCheckQuery);
            
            if ($duplicateNameCheckQuery->num_rows > 0) {
                $_SESSION['failedMessage'] = 'The page name has already been taken.';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                die();
            }
            
            $query = "SELECT * FROM pages WHERE id = '$id'";
            $page = $this->connection->query($query)->fetch_assoc();

            if($page['name'] != $name)
            {
                $htmlFile = 'include/'. $page['name'] . '.html';
                unlink($htmlFile);
            }
            
            if(!empty($thumbnail_image))
            {
                // get the image extension
                $extension = pathinfo($thumbnail_image, PATHINFO_EXTENSION);

                // allowed extensions
                $allowed_extensions = array("jpg","jpeg","png");
                
                // Validation for allowed extensions .in_array() function searches an array for a specific value.
                if(!in_array($extension,$allowed_extensions))
                {
                    $_SESSION['failedMessage'] = 'Invalid format. Only jpg / jpeg/ png /gif format allowed.';
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    die();
                }
                else
                {   
                    $imageFilePath = "include/images/";
                    unlink($imageFilePath.$page['thumbnail_image']);

                    //rename the image file
                    $imgnewfile=$name.uniqid().time().".".$extension;

                    // Code for move image into directory
                    move_uploaded_file($_FILES["thumbnail_image"]["tmp_name"], $imageFilePath.$imgnewfile);

                    $query="UPDATE pages SET thumbnail_image = '$imgnewfile' WHERE id = '$id'";
                    $sql = $this->connection->query($query);
                }    
            } else{
                $imgnewfile=$page['thumbnail_image'];
            }

            $check = test($meta_title, $meta_description, $content, $imgnewfile);
            $newTemplate = file_put_contents("template.php", $check);
            $newContent = file_get_contents("template.php");
            if (!file_exists($name . '.html')) { $handle = fopen('include/' . $name .'.html','w+'); fwrite($handle,$newContent); fclose($handle); }

            if (!empty($id) && !empty($post)) {
                $query="UPDATE pages SET user_id = '$user_id', name = '$name', meta_title = '$meta_title', meta_description = '$meta_description', content = '$content', status = '$status' WHERE id = $id";
                $sql = $this->connection->query($query);
                if ($sql==true) {
                    $_SESSION['successMessage'] = 'Page updated successfully.';
                    header('location:index.php');
                    die();
                }else{
                    $_SESSION['failedMessage'] = 'Failed to update page. Please try again!';
                    header('location:index.php');
                    die();
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