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


$idintern = $firstname = $lastname = $birthday = "";


if (isset($_GET['id'])) {
    $idintern = $_GET['id'];
    $sql_select = "SELECT * FROM intern WHERE idintern = $idintern";
    $result = $conn->query($sql_select);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $birthday = $row['birthday'];
    } else {
        echo "No intern found with the provided ID.";
        exit;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthday = $_POST['birthday'];

    
    $sql_update = "UPDATE intern SET firstname = '$firstname', lastname = '$lastname', birthday = '$birthday' WHERE idintern = $idintern";
    if ($conn->query($sql_update) === TRUE) {
        
        header("Location: interns.php");
        exit;
    } else {
        echo "Error updating intern: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Intern</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Intern</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=$idintern"); ?>" class="row g-3">
            <div class="col-md-6">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstname; ?>" required>
            </div>
            <div class="col-md-6">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname; ?>" required>
            </div>
            <div class="col-md-6">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo $birthday; ?>" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="interns.php" class="btn btn-secondary ml-2">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>