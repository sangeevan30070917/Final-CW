<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Data in Table</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<?php
// Connect to the database
$connection = mysqli_connect("localhost", "username", "password", "database_name");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Execute query to retrieve data
$result = mysqli_query($connection, "SELECT * FROM table_name");

// Close connection
mysqli_close($connection);
?>

<!-- Display data in a table -->
<table>
    <tr>
        <th>Column 1</th>
        <th>Column 2</th>
        <!-- Add more column headings as needed -->
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['column1']; ?></td>
            <td><?php echo $row['column2']; ?></td>
            <!-- Add more columns as needed -->
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>