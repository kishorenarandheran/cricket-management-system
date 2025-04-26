<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cricket Schedules</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts for modern typography -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('img/bg1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            margin: 0;
            color: #333;
        }
        .table-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            background: #1e40af;
            color: white;
            text-transform: uppercase;
            font-weight: 600;
        }
        tr:hover {
            background: #f1f5f9;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 2rem auto;
        }
        input[type="number"], input[type="submit"] {
            transition: all 0.3s ease;
        }
        input[type="number"]:focus, input[type="submit"]:hover {
            transform: scale(1.02);
        }
        @media (max-width: 640px) {
            th, td {
                font-size: 0.9rem;
                padding: 0.75rem;
            }
            .table-container, .form-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center">
    <!-- Header Section -->
    <header class="w-full bg-indigo-900 text-white py-6 text-center">
        <h1 class="text-4xl font-bold tracking-tight">Cricket Match Schedules</h1>
        <p class="mt-2 text-lg">Stay updated with the latest match schedules</p>
    </header>

    <!-- Schedule Table -->
    <div class="table-container w-full max-w-5xl mx-auto mt-8">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Team 1</th>
                    <th>Team 2</th>
                    <th>Match Number</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $con = mysqli_connect("localhost", "root", "", "cricket");
                $query = "SELECT * FROM schedules ORDER BY date";
                $result = mysqli_query($con, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["date"] . "</td>";
                        echo "<td>" . $row["team1"] . "</td>";
                        echo "<td>" . $row["team2"] . "</td>";
                        echo "<td>" . $row["match_no"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center text-gray-500'>No schedules available</td></tr>";
                }
                mysqli_close($con);
                ?>
            </tbody>
        </table>
    </div>

    <!-- Form to Retrieve Players -->
    <div class="form-container">
        <h2 class="text-2xl font-semibold text-center mb-6">Retrieve Players by Match Number</h2>
        <form action="tt.php" method="post" class="flex flex-col gap-4">
            <input 
                type="number" 
                name="match_no" 
                placeholder="Enter Match Number" 
                class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                required
            >
            <input 
                type="submit" 
                value="Submit" 
                class="w-full bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700 cursor-pointer"
            >
        </form>
    </div>

    <!-- Footer -->
    <footer class="w-full bg-gray-800 text-white text-center py-4 mt-8">
        <p>&copy; 2025 Cricket Schedules. All rights reserved.</p>
    </footer>
</body>
</html>