<?php
    session_start();
    //return to login if not logged in
    if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
        header('location:index.php');
    }

    include_once('Auth.php');
    $user = new Auth();
    
    //fetch user data
    $sql = "SELECT * FROM users WHERE id = '".$_SESSION['user']."'";
    $row = $user->query($sql);     
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Page CMS</title>
    </head>
    <body>
        <div class="card text-center p-3">
            <div class="row">
                <div class="col-lg-3">
                    <h4>Page CMS</h4>
                </div>
                <div class="col-lg-9">
                    <?php require 'header.php'; ?>
                </div>
            </div>            
        </div> 
        <?php
                if(isset($_SESSION['failedMessage'])){
                    ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $_SESSION['failedMessage']; ?>
                        </div>
                    <?php     
                    unset($_SESSION['failedMessage']);
                }
            ?>
    </body>
</html>