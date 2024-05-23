<?php
session_start();


$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["start_date"]) && !empty($_POST["end_date"]) && !empty($_POST["intern_id"]) && !empty($_POST["depart_id"]) && !empty($_POST["admin_id"])) {
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];
        $intern_id = intval($_POST["intern_id"]);
        $department_id = intval($_POST["depart_id"]);
        $admin_id = intval($_POST["admin_id"]);

        
        $stmt = $conn->prepare("INSERT INTO internship (idadmin, iddep, idintern, startdate, enddate) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("iiiss", $admin_id, $department_id, $intern_id, $start_date, $end_date);
        if ($stmt->execute()) {
            header("Location: internship.php"); 
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}


$sql_interns = "SELECT idintern, firstname, lastname FROM intern";
$result_interns = $conn->query($sql_interns);
$interns = [];
if ($result_interns->num_rows > 0) {
    while ($row = $result_interns->fetch_assoc()) {
        $interns[] = $row;
    }
}


$sql_admins = "SELECT idadmin, username FROM admin";
$result_admins = $conn->query($sql_admins);
$admins = [];
if ($result_admins->num_rows > 0) {
    while ($row = $result_admins->fetch_assoc()) {
        $admins[] = $row;
    }
}


$sql_departments = "SELECT iddep, name FROM departement";
$result_departments = $conn->query($sql_departments);
$departments = [];
if ($result_departments->num_rows > 0) {
    while ($row = $result_departments->fetch_assoc()) {
        $departments[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Internship</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Internship</h2>
        <form action="" method="post"> 
            <div class="mb-3">
                <label for="intern_id" class="form-label">Intern Name</label>
                <select name="intern_id" id="intern_id" class="form-select">
                    <?php foreach ($interns as $intern) {
                        echo "<option value='" . htmlspecialchars($intern['idintern']) . "'>" . htmlspecialchars($intern['firstname'] . " " . $intern['lastname']) . "</option>";
                    } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="depart_id" class="form-label">Department</label>
                <select name="depart_id" id="depart_id" class="form-select">
                    <?php foreach ($departments as $department) {
                        echo "<option value='" . htmlspecialchars($department['iddep']) . "'>" . htmlspecialchars($department['name']) . "</option>";
                    } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="admin_id" class="form-label">Admin</label>
                <select name="admin_id" id="admin_id" class="form-select">
                    <?php foreach ($admins as $admin) {
                        echo "<option value='" . htmlspecialchars($admin['idadmin']) . "'>" . htmlspecialchars($admin['username']) . "</option>";
                    } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control">
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Add Internship</button>
            <a href="internship.php" class="btn btn-secondary ml-2">Cancel</a>
            <?php if (!empty($error)) { echo "<p class='text-danger mt-3'>$error</p>"; } ?>
        </form>
    </div>
</body>
</html>
