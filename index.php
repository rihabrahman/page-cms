<?php

    // Include database file
    include 'users.php';  $editorObj = new Users();  // Delete record from table
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $editorObj->destroy($id);
    }

?> 
<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Editor Information</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>

    </head>
    <body>
        <div class="card text-center" style="padding:15px;">
        <h4>Editor Information</h4>
        </div><br><br> 
        <div class="container">
            <?php
                if (isset($_GET['msg1']) == "insert") {
                echo "<div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        New editor added successfully.
                        </div>";
                } 
                if (isset($_GET['msg2']) == "update") {
                echo "<div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        Editor information updated successfully.
                        </div>";
                }
                if (isset($_GET['msg3']) == "delete") {
                echo "<div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        Editor deleted successfully.
                        </div>";
                }
            ?>
            <h2>
                All Editor Information
                <a href="add.php" class="btn btn-primary" style="float:right;">Add New Editor</a>
            </h2>
            <table class="table table-hover" id="example">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $editors = $editorObj->index(); 
                        if($editors != null){
                        foreach ($editors as $editor) {
                    ?>
                    <tr>
                        <td><?php echo $editor['id'] ?></td>
                        <td><?php echo $editor['name'] ?></td>
                        <td><?php echo $editor['email'] ?></td>
                        <td><?php echo $editor['status'] ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $editor['id'] ?>">
                                <button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Edit</button>
                            </a>
                            <!-- <a href="index.php?id=<?php echo $editor['id'] ?>" onclick="confirm('Are you sure want to delete this editor?')">
                                <button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> &nbsp; Delete</button>
                            </a> -->
                        </td>
                    </tr>
                    <?php 
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script>
            $(document).ready(function () {
                $('#example').DataTable();
            });
        </script>
    </body>
</html>