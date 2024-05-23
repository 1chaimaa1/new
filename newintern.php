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



$firstname = $lastname = $birthday = $iddep = "";
$firstname_err = $lastname_err = $birthday_err = $iddep_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = "Please enter a first name.";
    } else {
        $firstname = trim($_POST["firstname"]);
    }

    
    if (empty(trim($_POST["lastname"]))) {
        $lastname_err = "Please enter a last name.";
    } else {
        $lastname = trim($_POST["lastname"]);
    }


    if (empty(trim($_POST["birthday"]))) {
        $birthday_err = "Please enter a birthday.";
    } else {
        $birthday = trim($_POST["birthday"]);
    }

    
    if (empty(trim($_POST["iddep"]))) {
        $iddep_err = "Please select a department.";
    } else {
        $iddep = trim($_POST["iddep"]);
    }

    
    if (empty($firstname_err) && empty($lastname_err) && empty($birthday_err) && empty($iddep_err)) {
        
        $sql_intern = "INSERT INTO intern (firstname, lastname, birthday) VALUES (?, ?, ?)";
        
        if ($stmt_intern = $conn->prepare($sql_intern)) {
            
            $stmt_intern->bind_param("sss", $param_firstname, $param_lastname, $param_birthday);

            
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_birthday = $birthday;

            
            if ($stmt_intern->execute()) {
                
                $idintern = $conn->insert_id;

                
                $sql_internship = "INSERT INTO internship (iddep, idintern, idadmin, startdate, enddate) VALUES (?, ?, ?, NOW(), NULL)";
                
                if ($stmt_internship = $conn->prepare($sql_internship)) {
                    
                    $stmt_internship->bind_param("iii", $param_iddep, $param_idintern, $param_idadmin);

                    
                    $param_iddep = $iddep;
                    $param_idintern = $idintern;
                    $param_idadmin = $_SESSION['admin_id'];

                    
                    if ($stmt_internship->execute()) {
                        
                        header("Location: interns.php");
                        exit();
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }

                    
                    $stmt_internship->close();
                }
            } else {
                echo "Something went wrong. Please try again later.";
            }

            
            $stmt_intern->close();
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
    <title>Add New Intern</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Intern</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group mb-3">
                <label>First Name</label>
                <input type="text" name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
                <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
            </div>
            <div class="form-group mb-3">
                <label>Last Name</label>
                <input type="text" name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
                <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
            </div>
            <div class="form-group mb-3">
                <label>Birthday</label>
                <input type="date" name="birthday" class="form-control <?php echo (!empty($birthday_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $birthday; ?>">
                <span class="invalid-feedback"><?php echo $birthday_err; ?></span>
            </div>
            <div class="form-group mb-3">
                <label>Department</label>
                <select name="iddep" class="form-control <?php echo (!empty($iddep_err)) ? 'is-invalid' : ''; ?>">
                    <option value="">Select a department</option>
                    <?php
                    
                    $sql_dept = "SELECT iddep, name FROM departement";
                    $result_dept = $conn->query($sql_dept);

                    if ($result_dept->num_rows > 0) {
                        while ($department = $result_dept->fetch_assoc()) {
                            echo "<option value='" . $department['iddep'] . "'>" . $department['name'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <span class="invalid-feedback"><?php echo $iddep_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="interns.php" class="btn btn-secondary ml-2">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
