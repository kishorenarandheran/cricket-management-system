<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cricket Rankings</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('img/crc2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            margin: 0;
            color: #333;
        }
        .section-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
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
            max-width: 500px;
            margin: 2rem auto;
        }
        input, button {
            transition: all 0.3s ease;
        }
        input:focus, button:hover {
            transform: scale(1.02);
        }
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-weight: 500;
        }
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
        @media (max-width: 640px) {
            th, td {
                font-size: 0.9rem;
                padding: 0.75rem;
            }
            .section-container, .form-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="flex flex-col items-center">
    <!-- Header -->
    <header class="w-full bg-indigo-900 text-white py-6 text-center">
        <h1 class="text-4xl font-bold tracking-tight">Cricket Rankings</h1>
        <p class="mt-2 text-lg">Explore team and player rankings</p>
    </header>

    <!-- Admin Dashboard Button -->
    <div class="w-full max-w-5xl mx-auto mt-4 mb-4 flex justify-center">
        <a href="admin1st.html" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300 shadow-md">
            Back to Admin Dashboard
        </a>
    </div>

    <!-- Status Messages -->
    <?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
        <div class="w-full max-w-5xl mx-auto">
            <div class="alert <?php echo $_GET['status'] === 'success' ? 'alert-success' : 'alert-error'; ?>">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Team Rankings -->
    <div class="section-container w-full max-w-5xl mx-auto mt-8">
        <h2 class="text-2xl font-semibold text-center mb-6">Team Rankings</h2>
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $con = mysqli_connect("localhost", "root", "", "cricket");
                $query = "SELECT * FROM team ORDER BY rating DESC";
                $result = mysqli_query($con, $query);
                $i = 0;
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $i++;
                        $nm = $row["name"];
                        $q = "UPDATE team SET rank='$i' WHERE name='$nm'";
                        mysqli_query($con, $q);
                        echo "<tr>";
                        echo "<td>$i</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["rating"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center text-gray-500'>No teams available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Team Update Form -->
    <div class="form-container">
        <h2 class="text-2xl font-semibold text-center mb-6">Update Team Rating</h2>
        <form action="update.php" method="POST" class="flex flex-col gap-4">
            <input type="text" name="name" placeholder="Enter Team Name (e.g., RCB)" class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            <input type="number" name="rating" placeholder="Enter Rating (e.g., 129)" class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            <button type="submit" class="bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700">Update</button>
        </form>
    </div>

    <!-- Batsman Rankings -->
    <div class="section-container w-full max-w-5xl mx-auto">
        <h2 class="text-2xl font-semibold text-center mb-6">Batsman Rankings</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>Team Name</th>
                    <th>Runs</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM player WHERE type='batsman' ORDER BY runs DESC";
                $result = mysqli_query($con, $query);
                $i = 0;
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $i++;
                        $nm = $row["cap_no"];
                        $q = "UPDATE player SET rank='$i' WHERE cap_no='$nm'";
                        mysqli_query($con, $q);
                        echo "<tr>";
                        echo "<td>" . $row["playername"] . "</td>";
                        echo "<td>$i</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["runs"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center text-gray-500'>No batsmen available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bowler Rankings -->
    <div class="section-container w-full max-w-5xl mx-auto">
        <h2 class="text-2xl font-semibold text-center mb-6">Bowler Rankings</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>Team Name</th>
                    <th>Wickets</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM player WHERE type='bowler' ORDER BY wickets DESC";
                $result = mysqli_query($con, $query);
                $i = 0;
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $i++;
                        $nm = $row["cap_no"];
                        $q = "UPDATE player SET rank='$i' WHERE cap_no='$nm'";
                        mysqli_query($con, $q);
                        echo "<tr>";
                        echo "<td>" . $row["playername"] . "</td>";
                        echo "<td>$i</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["wickets"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center text-gray-500'>No bowlers available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- All-Rounder Rankings -->
    <div class="section-container w-full max-w-5xl mx-auto">
        <h2 class="text-2xl font-semibold text-center mb-6">All-Rounder Rankings</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>Team Name</th>
                    <th>Runs</th>
                    <th>Wickets</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM player WHERE type='allrounder' ORDER BY (runs + wickets*2) DESC";
                $result = mysqli_query($con, $query);
                $i = 0;
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $i++;
                        $nm = $row["cap_no"];
                        $q = "UPDATE player SET rank='$i' WHERE cap_no='$nm'";
                        mysqli_query($con, $q);
                        echo "<tr>";
                        echo "<td>" . $row["playername"] . "</td>";
                        echo "<td>$i</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["runs"] . "</td>";
                        echo "<td>" . $row["wickets"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center text-gray-500'>No all-rounders available</td></tr>";
                }
                mysqli_close($con);
                ?>
            </tbody>
        </table>
    </div>

    <!-- Player Update Form -->
    <div class="form-container">
        <h2 class="text-2xl font-semibold text-center mb-6">Update Player Stats</h2>
        <form action="pupdate.php" method="POST" class="flex flex-col gap-4">
            <input type="text" name="name" placeholder="Enter Player Name" class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            <input type="number" name="runs" placeholder="Enter Runs" class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            <input type="number" name="wickets" placeholder="Enter Wickets" class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            <input type="number" name="no_of_matches" placeholder="Enter Number of Matches" class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            <button type="submit" class="bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700">Update</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="w-full bg-gray-800 text-white text-center py-4 mt-8">
        <p>© 2025 Cricket Rankings. All rights reserved.</p>
    </footer>
</body>
</html>
//2