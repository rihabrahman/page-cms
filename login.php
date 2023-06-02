<?php
    //start session
    session_start();
    
    include_once('Auth.php');
    
    $user = new Auth();
    
    if(isset($_POST['login'])){
        $email = $user->escape_string($_POST['email']);
        $password = $user->escape_string(md5($_POST['password']));
        
        $auth = $user->check_login($email, $password);
        
        if(!$auth){
            $_SESSION['message'] = 'Invalid username or password';
            header('location:index.php');
        }
        elseif($auth['status'] == 'Inactive')
        {
            $_SESSION['message'] = 'Your account is inactive.';
            header('location:index.php');
        }
        else{
            $_SESSION['user'] = $auth['id'];
            header('location:home.php');
        }
    }
    else{
        $_SESSION['message'] = 'You need to login first';
        header('location:index.php');
    }
?>