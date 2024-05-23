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
    $intern_id = $_GET['id'];

    $sql_delete = "DELETE FROM intern WHERE idintern = $intern_id";
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: interns.php");
        exit;
    } else {
        echo "Error deleting intern: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $f_name = $_POST['firstname'];
    $l_name = $_POST['lastname'];
    $birthday = $_POST['birthday'];

    
    $sql_insert = "INSERT INTO intern (firstname, lastname, birthday) VALUES ('$firstname', '$lastname', '$birthday')";
    if ($conn->query($sql_insert) === TRUE) {
        echo "New intern added successfully";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }}



$sql_select = "SELECT * FROM intern";
$result = $conn->query($sql_select);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interns</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container mt-5">
        <h2>𝕷𝖎𝖘𝖙 𝖔𝖋 𝕴𝖓𝖙𝖊𝖗𝖓𝖘✍</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Birthday</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["firstname"] . "</td>
                                <td>" . $row["lastname"] . "</td>
                                <td>" . $row["birthday"] . "</td>
                                <td>
                                    <a class='btn btn-info btn-sm' href='internedition.php?id=" . $row["idintern"] . "'>Update</a>
                                    <a class='btn btn-danger btn-sm' href='?action=delete&id=" . $row["idintern"] . "'>Remove</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="newintern.php" class="btn btn-success">Add New Intern</a>

        
    </div>
</body>
</html>
<?php
$conn->close();
?>
