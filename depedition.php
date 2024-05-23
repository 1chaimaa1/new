<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$iddep = $_GET['id'] ?? "";
$name = "";


$sql_select = "SELECT * FROM departement WHERE iddep = $iddep";
$result = $conn->query($sql_select);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
} else {
    echo "No department found with the provided ID.";
    exit; 
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    
    $sql_update = "UPDATE departement SET name = '$name' WHERE iddep = $iddep";
    if ($conn->query($sql_update) === TRUE) {
        
        header("Location: departs.php");
        exit;
    } else {
        echo "Error updating department: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Department</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Department</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=$iddep"); ?>" class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="departs.php" class="btn btn-secondary ml-2">Cancel</a>
            </div>

        </form>
    </div>
</body>
</html>
