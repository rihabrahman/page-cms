<?php
    require_once('../Auth.php');
    require_once('dynamic_template.php');

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
            $created_at = $this->timeStamp();

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
            
            // Validation for allowed extensions. in_array() function searches extension in allowed_extension array.
            if(!in_array($extension,$allowed_extensions))
            {
                $_SESSION['failedMessage'] = 'Invalid format. Only jpg / jpeg / png format allowed.';
                header('location:add.php');
                die();
            }
            else
            {
                //rename the image file
                $newImageName=$name."_".date("Ymdhis").".".$extension;
                // Code for move image into directory
                move_uploaded_file($_FILES["thumbnail_image"]["tmp_name"],"include/images/".$newImageName);
            }

            if($status == 'Active')
            {
                $dynamicTemplate = dynamic_template($meta_title, $meta_description, $content, $newImageName);
                $staticHtmlTemplate = file_put_contents("static_template.php", $dynamicTemplate);
                $newHtmlFile = file_get_contents("static_template.php");
                if (!file_exists($name . '.html')) { 
                    $handle = fopen('include/' . $name .'.html','w+'); 
                    fwrite($handle,$newHtmlFile); 
                    fclose($handle); 
                }
            }

            $query="INSERT INTO pages(user_id, name, meta_title, meta_description, content, thumbnail_image, status, created_at) VALUES('$user_id', '$name', '$meta_title', '$meta_description', '$content', '$newImageName', '$status', '$created_at')";
            $page = $this->connection->query($query);
                
            if ($page==true) {
                $_SESSION['successMessage'] = 'Page added successfully.';
                header('location:index.php');
                die();
            }else {
                $_SESSION['failedMessage'] = 'Failed to add new page. Please try again!';
                header('location:index.php');
                die();
            }
        }		
        
        // List of all pages for admin
        public function index()
        {
            $query = "SELECT pages.id, pages.name AS pageName, pages.meta_title, pages.meta_description, pages.thumbnail_image, pages.status, pages.created_at, pages.updated_at, users.name AS editorName FROM `pages` LEFT JOIN `users` on pages.user_id=users.id ORDER BY pages.id DESC";
            $pages = $this->connection->query($query);
            if ($pages->num_rows > 0) {
                $data = array();
                while ($row = $pages->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            }
            
        }
        
        
        // List of pages as per editor
        public function editorIndex($user_id)
        {
            $query = "SELECT pages.id, pages.name AS pageName, pages.meta_title, pages.meta_description, pages.thumbnail_image, pages.status, pages.created_at, pages.updated_at FROM pages WHERE user_id=$user_id ORDER BY id DESC";
            $pages = $this->connection->query($query);
            if ($pages->num_rows > 0) {
                $data = array();
                while ($row = $pages->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            }
        }		
        
        // Fetch single data for edit from page table
        public function edit($id)
        {
            $query = "SELECT * FROM pages WHERE id = $id";
            $page = $this->connection->query($query);
            if ($page->num_rows > 0) {
                $row = $page->fetch_assoc();
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
            $name = $this->connection->real_escape_string($_POST['name']);
            $meta_title = $this->connection->real_escape_string($_POST['meta_title']);
            $meta_description = $this->connection->real_escape_string($_POST['meta_description']);
            $content = $_POST['content'];
            $thumbnail_image=$_FILES["thumbnail_image"]["name"];
            $status = $this->connection->real_escape_string($_POST['status']);
            $updated_at = $this->timeStamp();

            $duplicateNameCheckQuery = "SELECT * FROM pages WHERE name='$name' and id != $id";
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
                
                // Validation for allowed extensions. in_array() function searches extension in allowed_extension array.
                if(!in_array($extension,$allowed_extensions))
                {
                    $_SESSION['failedMessage'] = 'Invalid format. Only jpg / jpeg / png format allowed.';
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    die();
                }
                else
                {   
                    $imageFilePath = "include/images/";
                    unlink($imageFilePath.$page['thumbnail_image']);

                    //rename the image file
                    $newImageName=$name."_".date("Ymdhis").".".$extension;

                    // Code for move image into directory
                    move_uploaded_file($_FILES["thumbnail_image"]["tmp_name"], $imageFilePath.$newImageName);

                    $query="UPDATE pages SET thumbnail_image = '$newImageName' WHERE id = '$id'";
                    $thumbnailImage = $this->connection->query($query);
                }    
            } else{
                $newImageName=$page['thumbnail_image'];
            }

            if($status == 'Active')
            {
                $dynamicTemplate = dynamic_template($meta_title, $meta_description, $content, $newImageName);
                $newTemplate = file_put_contents("static_template.php", $dynamicTemplate);
                $newHtmlFile = file_get_contents("static_template.php");
                if (!file_exists($name . '.html')) { 
                    $handle = fopen('include/' . $name .'.html','w+');
                    fwrite($handle,$newHtmlFile);
                    fclose($handle); 
                }
            } else{
                $htmlFile = 'include/'. $page['name'] . '.html';
                unlink($htmlFile);
            }

            if (!empty($id) && !empty($post)) {
                $query="UPDATE pages SET name = '$name', meta_title = '$meta_title', meta_description = '$meta_description', content = '$content', status = '$status', updated_at='$updated_at' WHERE id = $id";
                $page = $this->connection->query($query);
                if ($page==true) {
                    $_SESSION['successMessage'] = 'Page updated successfully.';
                    header('location:index.php');
                    die();
                }else{
                    $_SESSION['failedMessage'] = 'Failed to update page. Please try again!';
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    die();
                }
            }
            
        }
        
        // Delete page data from table
        public function destroy($id)
        {
            $pageSelectionQuery = "SELECT * FROM pages WHERE id = '$id'";
            $pageInfo = $this->connection->query($pageSelectionQuery)->fetch_assoc();

            $imageFilePath = "include/images/";
            unlink($imageFilePath.$pageInfo['thumbnail_image']);

            $htmlFile = 'include/'. $pageInfo['name'] . '.html';
            unlink($htmlFile);

            $pageDeletionQuery = "DELETE FROM pages WHERE id = '$id'";
            $pageDelete = $this->connection->query($pageDeletionQuery);

            if ($pageDelete==true) {
                $_SESSION['successMessage'] = 'Page deleted successfully.';
                header('location:index.php');
                die();
            }else{
                $_SESSION['failedMessage'] = 'Failed to delete page. Please try again!';
                header('location:index.php');
                die();
            }
        }

        // Date and time as per current time of Dhaka
        private function timeStamp()
        {
            date_default_timezone_set("Asia/Dhaka");

            return $timeStamp = date("Y-m-d H:i:s");
        }
    }
?>