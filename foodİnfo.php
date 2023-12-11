<!DOCTYPE html>
<html>
<head>
    <title>Food Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
        }
        label {
            display: block;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .result {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Food Information</h1>
        <form action="foodİnfo.php" method="get">
            <label for="name">Enter Food Name:</label>
            <input type="text" name="name" id="name" required>
            <button type="submit">Get Food Information</button>
        </form>
        <div class="result">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                // Database connection credentials
                $host = "5.193.46.135";
                $port = "3323";
                $username = "root";
                $password = "admin";
                $database = "cookpal";

                $con = mysqli_connect($host, $username, $password, $database, $port);

                if (!$con) {
                    die("Failed to connect: " . mysqli_connect_error());
                }

                // Check if the name parameter is set and not empty
                if (isset($_GET['name']) && !empty($_GET['name'])) {
                    $foodName = $_GET['name'];

                    // Query the database to retrieve the food information for similar names
                    $sql = "SELECT * FROM caloriesinfo WHERE name LIKE ?";
                    $stmt = mysqli_prepare($con, $sql);
                    $searchName = "%" . $foodName . "%"; // Adding wildcards to search for similar names
                    mysqli_stmt_bind_param($stmt, "s", $searchName);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if (mysqli_num_rows($result) > 0) {
                        while ($food = mysqli_fetch_assoc($result)) {
                            // Output the food information for each matching result
                            echo "Name: " . $food['name'] . "<br>";
                            echo "Protein: " . $food['protein'] . " grams<br>";
                            echo "Energy: " . $food['energy'] . " kal<br>";
                            echo "Fat: " . $food['fat'] . " grams<br>";
                            echo "Carbohydrate: " . $food['carbohydrate'] . " grams<br>";
                            echo "Sugar: " . $food['sugar'] . " grams<br>";
                            echo "Fiber: " . $food['fiber'] . " grams<br>";
                            echo "Portionwgt: " . $food['portionwgt'] . "<br>";
                            echo "portionFactor: " . $food['portionFactor'] . "<br>";
                            echo "Unit: " . $food['unit'] . "<br>";
                            echo "<hr>"; // Add a horizontal line to separate results
                        }
                    } else {
                        echo "No matching foods found.";
                    }
                } else {
                    echo "Please enter a food name.";
                }

                // Close the database connection
                mysqli_close($con);
            }
        ?>
        </div>
    </div>
</body>
</html>
