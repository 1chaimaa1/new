<?php
include 'menu.php';
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $departement_id = $_GET['id'];

    $sql_delete = "DELETE FROM departement WHERE iddep = $departement_id";
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: departs.php");
        exit;
    } else {
        echo "Error deleting department: " . $conn->error;
    }
}


$sql_select = "SELECT admin.username, departement.iddep, departement.name 
               FROM departement 
               JOIN admin ON departement.idadmin = admin.idadmin";
$result = $conn->query($sql_select);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments and Admins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    


</head>
<body>
 
    

 
    <div class="container mt-5">
        <h2>𝕷𝖎𝖘𝖙 𝖔𝖋 𝕯𝖊𝖕𝖆𝖗𝖙𝖒𝖊𝖓𝖙𝖘✍</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Department Name</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["username"] . "</td>
                                <td>" . $row["name"] . "</td>
                                <td>
                                    <a class='btn btn-info btn-sm' href='depedition.php?id=" . $row["iddep"] . "'>Update</a>
                                    <a class='btn btn-danger btn-sm' href='?action=delete&id=" . $row["iddep"] . "'>Remove</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="newdepart.php" class="btn btn-success">Add New Department</a>
    </div>
            </body>  

</html>
<?php
$conn->close();
?>
