<?php

session_start();


function redirectToLogin() {
    header("Location: login.php"); 
    exit(); 
}


if (!isset($_SESSION['username'])) {
    redirectToLogin(); 
}


if (isset($_GET['logout'])) {
    
    session_unset();

    
    session_destroy();

    
    redirectToLogin();
}
$connect = mysqli_connect(
    'db',        
    'php_docker',
    'password',  
    'php_docker' 
);


if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$table_name = "students";


if (isset($_POST['search'])) {
    $search_id = mysqli_real_escape_string($connect, $_POST['search_id']);
    $query = "SELECT * FROM $table_name WHERE id = '$search_id'";
} else {
    $query = "SELECT * FROM $table_name";
}

$response = mysqli_query($connect, $query);


if (!$response) {
    die("Query failed: " . mysqli_error($connect));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <style>
       
        body, h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        dl, dd, ol, ul, figure, hr { margin: 0; padding: 0; }

        
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            margin: 20px;
        }

        
        .college-header {
            text-align: center;
            margin-bottom: 20px;
        }

        
        .college-logo {
            max-width: 300px;
            height: auto;
        }

        
        form {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        label {
            margin-right: 10px;
        }

        input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        
        th {
            background-color: #007bff;
            color: #fff;
            padding: 12px;
            text-align: left;
        }

       
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
    </style>
</head>
<body>
    <!-- College Header -->
    <div class="college-header">
        <img src="logo project.png" alt="College Logo" class="college-logo">
        <h1>Alexu Computer Science (AI)</h1>
    </div>

    <!-- Search Form -->
    <form method="post">
        <label for="search_id">Search by ID:</label>
        <input type="text" id="search_id" name="search_id">
        <button type="submit" name="search">Search</button>
        <button type="submit" name="show_all">Show All</button>
    </form>

    <!-- Student Information Table -->
    <table>
        <!-- Table Header -->
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>CGPA</th>
                <th>ID</th>
            </tr>
        </thead>
        <!-- Table Body -->
        <tbody>
            <?php
            // Display all rows by default
            while ($row = mysqli_fetch_assoc($response)) {
                echo "<tr>";
                echo "<td>" . $row['Name'] . "</td>";
                echo "<td>" . $row['age'] . "</td>";
                echo "<td>" . $row['cgpa'] . "</td>";
                echo "<td>" . $row['id'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <!-- Logout button -->
    <form action="table.php" method="GET">
        <button type="submit" name="logout" value="true">Logout</button>
    </form>
</body>
</html>

<?php

mysqli_close($connect);
?>
