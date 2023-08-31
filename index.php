<?php

// Connecting to the database

// Database information
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'rnotes';

// Creating database connection
$dbConn = mysqli_connect($servername, $username, $password, $database);

// Checking error if database not connected successfully
if (!$dbConn) {
    die('Sorry database has been failed to connect successfully') . mysqli_connect_error();
}


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>rNotes - php crud project 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css" />
</head>

<body class="bg-dark text-light py-5">

    <div class="container">
        <!-- note add row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            // Data from the form
                            $title = $_POST['ntitle'];
                            $description = $_POST['ndescription'];

                            // Inserting data to the database 
                            $sql = "INSERT INTO `notes` (`title`, `description`, `datetime`) VALUES ('$title', '$description', CURRENT_TIMESTAMP())";

                            $result = mysqli_query($dbConn, $sql);

                            // Checking query
                            if ($result) {
                                echo '<p class="text-success">User has been created successfully</p>';
                            } else {
                                die(mysqli_error($dbConn));
                            }
                        }
                        ?>
                        <h1 class="h3 mb-3">Add Notes</h1>
                        <form method="POST" action="../crud-app/index.php">
                            <div class="mb-3">
                                <label class="form-label">Note title</label>
                                <input type="text" class="form-control" name="ntitle">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Note Dscription</label>
                                <textarea class="form-control" rows="3" name="ndescription"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Note</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- note add row -->

        <!-- note data row -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="notes_table" class="table table-striped display">
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">Sl.No</th>
                                    <th width="35%" scope="col">Title</th>
                                    <th width="50%" scope="col">Description</th>
                                    <th width="10%" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = 'SELECT * FROM `notes`';
                                $result = mysqli_query($dbConn, $sql);
                                if ($result) {
                                    // Table number of rows
                                    $numOfRow = mysqli_num_rows($result);
                                    if ($numOfRow > 0) {
                                        $slNo = 0;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $slNo = $slNo + 1;
                                            $title = $row['title'];
                                            $description = $row['description'];
                                ?>
                                            <tr>
                                                <th valign="middle" class="p-2"><?php echo $slNo; ?></th>
                                                <td valign="middle" class="p-2"><?php echo $title; ?></td>
                                                <td valign="middle" class="p-2"><?php echo $description; ?></td>
                                                <td valign="middle" class="p-2">
                                                    <a href="#" class="btn btn-danger py-1 px-2">
                                                        <i class="bi bi-archive"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-primary py-1 px-2">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="4" class="text-center">There is no notes available</td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- note data row -->
    </div>


    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(
            function() {
                jQuery('#notes_table').DataTable();
            });
    </script>
    <script>
    </script>
</body>

</html>