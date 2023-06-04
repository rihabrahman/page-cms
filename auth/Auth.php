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

        //all editors count
        public function all_editor()
        {
            $allEditorSql = "SELECT COUNT(DISTINCT id) as total FROM users";
            $allEditorCount = $this->query($allEditorSql);

            return $allEditorCount;
        }

        //all active editors count
        public function all_active_editor()
        {
            $allActiveEditorSql = "SELECT COUNT(DISTINCT id) as total FROM users WHERE status = 'Active'";
            $allActiveEditorCount = $this->query($allActiveEditorSql);

            return $allActiveEditorCount;
        }
        
        //all inactive editors count
        public function all_inactive_editor()
        {
            $allInactiveEditorSql = "SELECT COUNT(DISTINCT id) as total FROM users WHERE status = 'Inactive'";
            $allInactiveEditorCount = $this->query($allInactiveEditorSql);

            return $allInactiveEditorCount;
        }
        
        //all pages count
        public function all_page()
        {
            $allPageSql = "SELECT COUNT(DISTINCT id) as total FROM pages";
            $allPageCount = $this->query($allPageSql);

            return $allPageCount;
        }

        //all active pages count
        public function all_active_page()
        {
            $allActivePageSql = "SELECT COUNT(DISTINCT id) as total FROM pages WHERE status = 'Active'";
            $allActivePageCount = $this->query($allActivePageSql);

            return $allActivePageCount;
        }
        
        //all inactive pages count
        public function all_inactive_page()
        {
            $allInactivePageSql = "SELECT COUNT(DISTINCT id) as total FROM pages WHERE status = 'Inactive'";
            $allInactivePageCount = $this->query($allInactivePageSql);

            return $allInactivePageCount;
        }

        //editor's all pages count
        public function editor_all_page($id)
        {
            $editorsPageSql = "SELECT COUNT(DISTINCT id) as total FROM pages WHERE user_id=$id";
            $editorsPageCount = $this->query($editorsPageSql);

            return $editorsPageCount;
        }

        //editor's active pages count
        public function editor_active_page($id)
        {
            $editorsActivePageSql = "SELECT COUNT(DISTINCT id) as total FROM pages WHERE status = 'Active' AND user_id=$id";
            $editorsActivePageCount = $this->query($editorsActivePageSql);

            return $editorsActivePageCount;
        }
        
        //editor's inactive pages count
        public function editor_inactive_page($id)
        {
            $editorsInactivePageSql = "SELECT COUNT(DISTINCT id) as total FROM pages WHERE status = 'Inactive'  AND user_id=$id";
            $editorsInactivePageCount = $this->query($editorsInactivePageSql);

            return $editorsInactivePageCount;
        }
    }
?>