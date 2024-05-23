<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$name = $admin_id = "";
$name_err = $admin_id_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a department name.";
    } else {
        $name = trim($_POST["name"]);
    }

    
    if (empty(trim($_POST["admin_id"]))) {
        $admin_id_err = "Please select an admin.";
    } else {
        $admin_id = trim($_POST["admin_id"]);
    }

    
    if (empty($name_err) && empty($admin_id_err)) {
        
        $sql_insert = "INSERT INTO departement (name, idadmin) VALUES (?, ?)";

        if ($stmt = $conn->prepare($sql_insert)) {
            
            $stmt->bind_param("si", $param_name, $param_admin_id);

            
            $param_name = $name;
            $param_admin_id = $admin_id;

            
            if ($stmt->execute()) {
                
                header("Location: departs.php");
                exit;
            } else {
                echo "Something went wrong. Please try again later.";
            }

            
            $stmt->close();
        }
    }

    
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Department</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Department</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group mb-3">
                <label>Department Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group mb-3">
                <label>Admin</label>
                <select name="admin_id" class="form-control <?php echo (!empty($admin_id_err)) ? 'is-invalid' : ''; ?>">
                    <option value="">Select an admin</option>
                    <?php
                    
                    $sql_admins = "SELECT idadmin, username FROM admin";
                    $result_admins = $conn->query($sql_admins);

                    if ($result_admins->num_rows > 0) {
                        while ($admin = $result_admins->fetch_assoc()) {
                            echo "<option value='" . $admin['idadmin'] . "'>" . $admin['username'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <span class="invalid-feedback"><?php echo $admin_id_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="departs.php" class="btn btn-secondary ml-2">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>

