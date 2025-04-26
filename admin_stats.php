<?php
// Start session
session_start();

// Connect to the database
$con = mysqli_connect("localhost", "root", "", "cricket") or die(mysqli_error($con));

// Function to execute query and return results
function execute_query($con, $query) {
    $result = mysqli_query($con, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    return $data;
}

// Get team rankings data
function get_team_rankings($con) {
    $query = "SELECT name, rank, rating FROM team ORDER BY rank";
    return execute_query($con, $query);
}

// Get top run scorers
function get_top_run_scorers($con, $limit = 10) {
    $query = "SELECT playername, runs, name FROM player ORDER BY runs DESC LIMIT $limit";
    return execute_query($con, $query);
}

// Get top wicket takers
function get_top_wicket_takers($con, $limit = 10) {
    $query = "SELECT playername, wickets, name FROM player ORDER BY wickets DESC LIMIT $limit";
    return execute_query($con, $query);
}

// Get player types distribution
function get_player_types($con) {
    $query = "SELECT type, COUNT(*) as count FROM player GROUP BY type";
    return execute_query($con, $query);
}

// Get match distribution by venue
function get_match_distribution($con) {
    $query = "SELECT s.stadium_name, COUNT(p.team1) as match_count 
              FROM stadiums s 
              LEFT JOIN played_in p ON s.stadium_name = p.stadium_name 
              GROUP BY s.stadium_name";
    return execute_query($con, $query);
}

// Fetch all data
$team_rankings = get_team_rankings($con);
$top_run_scorers = get_top_run_scorers($con);
$top_wicket_takers = get_top_wicket_takers($con);
$player_types = get_player_types($con);
$match_distribution = get_match_distribution($con);

// Close database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cricket Statistics Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .dashboard {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .chart-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 800px;
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        .header {
            background-color: #33afd9;
            color: white;
            padding: 10px 0;
            margin-bottom: 20px;
            text-align: center;
            border-radius: 8px;
        }
        .back-button {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #33afd9;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .back-button:hover {
            background-color: #2b93b6;
        }
        .button-container {
            text-align: center;
        }
        canvas {
            max-width: 100%;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Cricket Statistics Dashboard</h1>
    </div>
    
    <div class="dashboard">
        <!-- Team Rankings Chart -->
        <div class="chart-container">
            <h2>Team Rankings</h2>
            <canvas id="teamRankingsChart"></canvas>
        </div>
        
        <!-- Team Ratings Chart -->
        <div class="chart-container">
            <h2>Team Ratings</h2>
            <canvas id="teamRatingsChart"></canvas>
        </div>
        
        <!-- Top Run Scorers Chart -->
        <div class="chart-container">
            <h2>Top Run Scorers</h2>
            <canvas id="runScorersChart"></canvas>
        </div>
        
        <!-- Top Wicket Takers Chart -->
        <div class="chart-container">
            <h2>Top Wicket Takers</h2>
            <canvas id="wicketTakersChart"></canvas>
        </div>
        
        <!-- Player Types Distribution Chart -->
        <div class="chart-container">
            <h2>Player Types Distribution</h2>
            <canvas id="playerTypesChart"></canvas>
        </div>
        
        <!-- Match Distribution Chart -->
        <div class="chart-container">
            <h2>Match Distribution by Venue</h2>
            <canvas id="matchDistributionChart"></canvas>
        </div>
    </div>
    
    <div class="button-container">
        <a href="admin1st.html" class="back-button">Back to Admin Panel</a>
    </div>
    
    <script>
        // Chart.js configuration
        
        // Team Rankings Chart (Pie Chart)
        const teamRankingsCtx = document.getElementById('teamRankingsChart').getContext('2d');
        new Chart(teamRankingsCtx, {
            type: 'pie',
            data: {
                labels: [<?php echo "'" . implode("', '", array_column($team_rankings, 'name')) . "'"; ?>],
                datasets: [{
                    label: 'Team Rankings',
                    data: [<?php 
                        // Invert ranks for visualization (lower rank = bigger slice)
                        $ranks = array_column($team_rankings, 'rank');
                        $max_rank = max($ranks);
                        $inverted_ranks = array_map(function($rank) use ($max_rank) {
                            return $max_rank + 1 - $rank;
                        }, $ranks);
                        echo implode(", ", $inverted_ranks);
                    ?>],
                    backgroundColor: [
                        '#ff9999', '#66b3ff', '#99ff99', '#ffcc99'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Team Ranking Distribution'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const rank = <?php echo max($ranks); ?> + 1 - context.raw;
                                return `${context.label}: Rank ${rank}`;
                            }
                        }
                    }
                }
            }
        });
        
        // Team Ratings Chart (Bar Chart)
        const teamRatingsCtx = document.getElementById('teamRatingsChart').getContext('2d');
        new Chart(teamRatingsCtx, {
            type: 'bar',
            data: {
                labels: [<?php echo "'" . implode("', '", array_column($team_rankings, 'name')) . "'"; ?>],
                datasets: [{
                    label: 'Rating Points',
                    data: [<?php echo implode(", ", array_column($team_rankings, 'rating')); ?>],
                    backgroundColor: [
                        '#ff9999', '#66b3ff', '#99ff99', '#ffcc99'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Team Ratings'
                    }
                }
            }
        });
        
        // Top Run Scorers Chart (Horizontal Bar Chart)
        const runScorersCtx = document.getElementById('runScorersChart').getContext('2d');
        new Chart(runScorersCtx, {
            type: 'bar',
            data: {
                labels: [<?php echo "'" . implode("', '", array_column($top_run_scorers, 'playername')) . "'"; ?>],
                datasets: [{
                    label: 'Runs',
                    data: [<?php echo implode(", ", array_column($top_run_scorers, 'runs')); ?>],
                    backgroundColor: [
                        <?php
                        $team_colors = [
                            'rcb' => '#ff0000',
                            'csk' => '#ffff00',
                            'mi' => '#0000ff',
                            'srh' => '#ffa500'
                        ];
                        
                        $colors = [];
                        foreach ($top_run_scorers as $player) {
                            $team = $player['name'];
                            $colors[] = isset($team_colors[$team]) ? "'" . $team_colors[$team] . "'" : "'#999999'";
                        }
                        echo implode(", ", $colors);
                        ?>
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Top Run Scorers'
                    }
                }
            }
        });
        
        // Top Wicket Takers Chart (Horizontal Bar Chart)
        const wicketTakersCtx = document.getElementById('wicketTakersChart').getContext('2d');
        new Chart(wicketTakersCtx, {
            type: 'bar',
            data: {
                labels: [<?php echo "'" . implode("', '", array_column($top_wicket_takers, 'playername')) . "'"; ?>],
                datasets: [{
                    label: 'Wickets',
                    data: [<?php echo implode(", ", array_column($top_wicket_takers, 'wickets')); ?>],
                    backgroundColor: [
                        <?php
                        $colors = [];
                        foreach ($top_wicket_takers as $player) {
                            $team = $player['name'];
                            $colors[] = isset($team_colors[$team]) ? "'" . $team_colors[$team] . "'" : "'#999999'";
                        }
                        echo implode(", ", $colors);
                        ?>
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Top Wicket Takers'
                    }
                }
            }
        });
        
        // Player Types Distribution Chart (Pie Chart)
        const playerTypesCtx = document.getElementById('playerTypesChart').getContext('2d');
        new Chart(playerTypesCtx, {
            type: 'pie',
            data: {
                labels: [<?php 
                    $types = array_map(function($type) {
                        return ucfirst(strtolower($type['type']));
                    }, $player_types);
                    echo "'" . implode("', '", $types) . "'";
                ?>],
                datasets: [{
                    label: 'Player Types',
                    data: [<?php echo implode(", ", array_column($player_types, 'count')); ?>],
                    backgroundColor: [
                        '#ff9999', '#66b3ff', '#99ff99'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Player Types Distribution'
                    }
                }
            }
        });
        
        // Match Distribution Chart (Bar Chart)
        const matchDistributionCtx = document.getElementById('matchDistributionChart').getContext('2d');
        new Chart(matchDistributionCtx, {
            type: 'bar',
            data: {
                labels: [<?php echo "'" . implode("', '", array_column($match_distribution, 'stadium_name')) . "'"; ?>],
                datasets: [{
                    label: 'Number of Matches',
                    data: [<?php echo implode(", ", array_column($match_distribution, 'match_count')); ?>],
                    backgroundColor: [
                        '#ff9999', '#66b3ff', '#99ff99', '#ffcc99'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Match Distribution by Venue'
                    }
                }
            }
        });
    </script>
</body>
</html>
