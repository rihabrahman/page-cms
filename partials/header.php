<?php
    $userObj = new Auth();
    //fetch user data
    $sql = "SELECT * FROM users WHERE id = '".$_SESSION['user']."'";
    $user = $userObj->query($sql);     
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Page CMS</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
        <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" rel="stylesheet" />
        <script src="https://cdn.tiny.cloud/1/6d60co0ye77h7jzv1r3d7ku4n6gpkr59pv0y2dhe7aeh6r2i/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    </head>
    <body>
        <div class="container p-3">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="text-left">Page CMS</h4>
                </div>                
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-3 text-right">
                            <p class="h5 mt-1"> <?php echo $user['name']; ?></p>
                        </div>
                        <div class="col-lg-1 text-right p-0">
                            <a href="../auth/home.php" class="btn btn-primary"><i class="fa fa-home" aria-hidden="true"></i></a>
                        </div>
                        <?php 
                            if($user['role'] == 'Admin'){
                        ?>                
                            <div class="col-lg-4 text-right">
                                <a href="../user/index.php" class="btn btn-primary">View Editors</a>
                            </div>
                        <?php 
                            }
                        ?>               
                        <div class="col-lg-3 text-right">
                            <a href="../page/index.php" class="btn btn-primary">View Pages</a>
                        </div>
                        <div class="col-lg-1">
                            <a href="../auth/logout.php" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <hr class="border border-dark">