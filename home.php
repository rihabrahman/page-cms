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
        <?php require 'header.php'; ?>

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
        <?php require 'footer.php'; ?>
