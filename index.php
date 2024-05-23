<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome Admin</h1>
    </header>
    <div class="dashboard">
        <div class="box" onclick="location.href='departs.php';">
            <h2>Departments Management</h2>
        </div>
        <div class="box" onclick="location.href='interns.php';">
            <h2>Interns Management</h2>
        </div>
        <div class="box" onclick="location.href='internship.php';">
            <h2>Internship Management</h2>
        </div>
    </div>
</body>
</html>


<style> 

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color:   #3bc0e1;
}

header {
    background-color: #3b4484 ;
    
    color: white;
    padding: 22px 0;
    text-align: center;
}

.dashboard {
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: 80vh;
}

.box {
    width: 200px;
    height: 150px;
    background-color: whitesmoke;
    border: 4px solid #3b4484;
    border-radius: 5px;
    box-shadow: 0 0 33px  rgba(  62, 94, 150 , 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.box:hover {
    transform: scale(1.17);
}

.box h2 {
    font-size: 1.5em;
    color:  #234377  ;
}
</style>
