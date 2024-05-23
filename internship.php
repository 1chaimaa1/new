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
    $internship_id = $_GET['id'];

    $sql_delete = "DELETE FROM internship WHERE idship = $internship_id";
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: internship.php");
        exit;
    } else {
        echo "Error deleting internship: " . $conn->error;
    }
}


$sql_select = "SELECT 
    admin.username, 
    departement.name AS department_name, 
    intern.firstname, 
    intern.lastname, 
    internship.startdate, 
    internship.enddate,
    internship.idship
FROM 
    internship
JOIN 
    admin ON internship.idadmin = admin.idadmin
JOIN 
    departement ON internship.iddep = departement.iddep
JOIN 
    intern ON internship.idintern = intern.idintern";
$result = $conn->query($sql_select);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internships</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>𝕷𝖎𝖘𝖙 𝖔𝖋 𝕴𝖓𝖙𝖊𝖗𝖓𝖘𝖍𝖎𝖕𝖘✍</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Department Name</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["username"]) . "</td>
                                <td>" . htmlspecialchars($row["department_name"]) . "</td>
                                <td>" . htmlspecialchars($row["firstname"]) . "</td>
                                <td>" . htmlspecialchars($row["lastname"]) . "</td>
                                <td>" . htmlspecialchars($row["startdate"]) . "</td>
                                <td>" . htmlspecialchars($row["enddate"]) . "</td>
                                <td>
                                    <a class='btn btn-info btn-sm' href='editionship.php?id=" . $row["idship"] . "'>Update</a>
                                    <a class='btn btn-danger btn-sm' href='?action=delete&id=" . $row["idship"] . "'>Remove</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="newship.php" class="btn btn-success">Add New Internship</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>
