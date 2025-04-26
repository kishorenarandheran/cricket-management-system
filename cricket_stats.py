import matplotlib.pyplot as plt
import mysql.connector
import numpy as np
from matplotlib.backends.backend_agg import FigureCanvasAgg as FigureCanvas
from matplotlib.figure import Figure
import os
import io
import base64

# Function to connect to the database
def connect_to_db():
    try:
        connection = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="cricket"
        )
        return connection
    except mysql.connector.Error as error:
        print(f"Error connecting to MySQL database: {error}")
        return None

# Function to execute a query and return results
def execute_query(connection, query):
    cursor = connection.cursor(dictionary=True)
    cursor.execute(query)
    result = cursor.fetchall()
    cursor.close()
    return result

# Function to save plot as base64 string (for web embedding)
def get_plot_as_base64(fig):
    buf = io.BytesIO()
    fig.savefig(buf, format='png', bbox_inches='tight')
    buf.seek(0)
    img_str = base64.b64encode(buf.read()).decode('utf-8')
    return img_str

# Function to create team rankings visualization
def visualize_team_rankings(connection):
    query = "SELECT name, rank, rating FROM team ORDER BY rank"
    teams_data = execute_query(connection, query)
    
    if not teams_data:
        return None
    
    team_names = [team['name'] for team in teams_data]
    team_ratings = [team['rating'] for team in teams_data]
    team_ranks = [int(team['rank']) for team in teams_data]
    
    # Create figure with two subplots
    fig, (ax1, ax2) = plt.subplots(1, 2, figsize=(12, 6))
    fig.suptitle('Team Performance Analysis', fontsize=16)
    
    # Bar chart for team ratings
    bars = ax1.bar(team_names, team_ratings, color=['#ff9999', '#66b3ff', '#99ff99', '#ffcc99'])
    ax1.set_title('Team Ratings')
    ax1.set_xlabel('Teams')
    ax1.set_ylabel('Rating Points')
    ax1.set_ylim(0, max(team_ratings) * 1.2)
    
    # Add rating values on top of bars
    for bar, rating in zip(bars, team_ratings):
        height = bar.get_height()
        ax1.text(bar.get_x() + bar.get_width()/2., height + 2,
                f'{rating}', ha='center', va='bottom')
    
    # Pie chart for team rankings
    colors = ['#ff9999', '#66b3ff', '#99ff99', '#ffcc99']
    # Invert ranks for visualization (lower rank = bigger slice)
    inverted_ranks = [max(team_ranks) + 1 - rank for rank in team_ranks]
    
    ax2.pie(inverted_ranks, labels=team_names, colors=colors, autopct='%1.1f%%',
            startangle=90, shadow=True)
    ax2.set_title('Team Ranking Distribution')
    ax2.axis('equal')  # Equal aspect ratio ensures that pie is drawn as a circle
    
    plt.tight_layout()
    return fig

# Function to visualize player statistics
def visualize_player_stats(connection):
    # Top run scorers
    run_query = "SELECT playername, runs, name FROM player ORDER BY runs DESC LIMIT 10"
    run_data = execute_query(connection, run_query)
    
    # Top wicket takers
    wicket_query = "SELECT playername, wickets, name FROM player ORDER BY wickets DESC LIMIT 10"
    wicket_data = execute_query(connection, wicket_query)
    
    if not run_data or not wicket_data:
        return None
    
    fig, (ax1, ax2) = plt.subplots(2, 1, figsize=(12, 10))
    fig.suptitle('Player Performance Analysis', fontsize=16)
    
    # Top run scorers
    player_names = [player['playername'] for player in run_data]
    runs = [int(player['runs']) for player in run_data]
    teams = [player['name'] for player in run_data]
    
    # Create color map based on teams
    team_colors = {'rcb': '#ff0000', 'csk': '#ffff00', 'mi': '#0000ff', 'srh': '#ffa500'}
    bar_colors = [team_colors.get(team, '#999999') for team in teams]
    
    bars1 = ax1.barh(player_names, runs, color=bar_colors)
    ax1.set_title('Top 10 Run Scorers')
    ax1.set_xlabel('Runs')
    ax1.set_ylabel('Players')
    ax1.invert_yaxis()  # Invert y-axis to show highest runs at the top
    
    # Add run values at the end of bars
    for bar, run in zip(bars1, runs):
        width = bar.get_width()
        ax1.text(width + 50, bar.get_y() + bar.get_height()/2,
                f'{run}', ha='left', va='center')
    
    # Top wicket takers
    player_names = [player['playername'] for player in wicket_data]
    wickets = [int(player['wickets']) for player in wicket_data]
    teams = [player['name'] for player in wicket_data]
    
    bar_colors = [team_colors.get(team, '#999999') for team in teams]
    
    bars2 = ax2.barh(player_names, wickets, color=bar_colors)
    ax2.set_title('Top 10 Wicket Takers')
    ax2.set_xlabel('Wickets')
    ax2.set_ylabel('Players')
    ax2.invert_yaxis()  # Invert y-axis to show highest wickets at the top
    
    # Add wicket values at the end of bars
    for bar, wicket in zip(bars2, wickets):
        width = bar.get_width()
        ax2.text(width + 2, bar.get_y() + bar.get_height()/2,
                f'{wicket}', ha='left', va='center')
    
    # Add legend for teams
    from matplotlib.patches import Patch
    legend_elements = [Patch(facecolor=color, label=team) 
                      for team, color in team_colors.items()]
    fig.legend(handles=legend_elements, loc='upper right', bbox_to_anchor=(0.95, 0.98))
    
    plt.tight_layout(rect=[0, 0, 0.95, 0.95])  # Adjust layout to make room for the legend
    return fig

# Function to visualize player types distribution
def visualize_player_types(connection):
    query = "SELECT type, COUNT(*) as count FROM player GROUP BY type"
    type_data = execute_query(connection, query)
    
    if not type_data:
        return None
    
    types = [data['type'].capitalize() for data in type_data]
    counts = [int(data['count']) for data in type_data]
    
    fig, ax = plt.subplots(figsize=(8, 8))
    
    # Create pie chart
    colors = ['#ff9999', '#66b3ff', '#99ff99']
    explode = [0.1 if t == max(counts) else 0 for t in counts]  # Explode the largest slice
    
    ax.pie(counts, explode=explode, labels=types, colors=colors, autopct='%1.1f%%',
           startangle=90, shadow=True)
    ax.set_title('Player Type Distribution')
    ax.axis('equal')  # Equal aspect ratio ensures that pie is drawn as a circle
    
    return fig

# Function to visualize match distribution by venue
def visualize_match_distribution(connection):
    query = """
    SELECT s.stadium_name, COUNT(p.team1) as match_count 
    FROM stadiums s 
    LEFT JOIN played_in p ON s.stadium_name = p.stadium_name 
    GROUP BY s.stadium_name
    """
    venue_data = execute_query(connection, query)
    
    if not venue_data:
        return None
    
    venues = [data['stadium_name'] for data in venue_data]
    match_counts = [int(data['match_count']) for data in venue_data]
    
    fig, ax = plt.subplots(figsize=(10, 6))
    
    # Create bar chart
    bars = ax.bar(venues, match_counts, color=['#ff9999', '#66b3ff', '#99ff99', '#ffcc99'])
    ax.set_title('Match Distribution by Venue')
    ax.set_xlabel('Stadiums')
    ax.set_ylabel('Number of Matches')
    
    # Add count values on top of bars
    for bar, count in zip(bars, match_counts):
        height = bar.get_height()
        ax.text(bar.get_x() + bar.get_width()/2., height + 0.1,
                f'{count}', ha='center', va='bottom')
    
    plt.xticks(rotation=45, ha='right')
    plt.tight_layout()
    return fig

# Function to visualize team performance over time
def visualize_team_performance(connection):
    # This would require historical data which might not be available
    # For demonstration, we'll create a simulated performance chart
    
    teams = ['rcb', 'csk', 'mi', 'srh']
    matches = range(1, 6)  # 5 matches
    
    # Simulated performance data (could be replaced with actual data if available)
    performance = {
        'rcb': [120, 115, 125, 130, 120],
        'csk': [115, 120, 110, 125, 119],
        'mi': [110, 105, 115, 120, 116],
        'srh': [125, 130, 120, 115, 122]
    }
    
    fig, ax = plt.subplots(figsize=(10, 6))
    
    for team in teams:
        ax.plot(matches, performance[team], marker='o', linewidth=2, label=team)
    
    ax.set_title('Team Performance Trend')
    ax.set_xlabel('Match Number')
    ax.set_ylabel('Performance Rating')
    ax.legend()
    ax.grid(True, linestyle='--', alpha=0.7)
    
    return fig

# Main function to generate all visualizations
def generate_all_visualizations():
    connection = connect_to_db()
    if not connection:
        print("Failed to connect to database")
        return
    
    # Create output directory if it doesn't exist
    output_dir = "cricket_stats_output"
    if not os.path.exists(output_dir):
        os.makedirs(output_dir)
    
    # Generate and save all visualizations
    visualizations = {
        'team_rankings': visualize_team_rankings,
        'player_stats': visualize_player_stats,
        'player_types': visualize_player_types,
        'match_distribution': visualize_match_distribution,
        'team_performance': visualize_team_performance
    }
    
    results = {}
    
    for name, viz_function in visualizations.items():
        fig = viz_function(connection)
        if fig:
            # Save as PNG file
            output_path = f"{output_dir}/{name}.png"
            fig.savefig(output_path, bbox_inches='tight')
            print(f"Saved {output_path}")
            
            # Get base64 string for web embedding
            img_str = get_plot_as_base64(fig)
            results[name] = img_str
            
            plt.close(fig)
    
    connection.close()
    return results

# Generate HTML page with all visualizations
def generate_html_page():
    connection = connect_to_db()
    if not connection:
        print("Failed to connect to database")
        return
    
    visualizations = {
        'team_rankings': visualize_team_rankings,
        'player_stats': visualize_player_stats,
        'player_types': visualize_player_types,
        'match_distribution': visualize_match_distribution,
        'team_performance': visualize_team_performance
    }
    
    html_content = """
    <!DOCTYPE html>
    <html>
    <head>
        <title>Cricket Statistics Dashboard</title>
        <style>
            body {
                font-family: Arial, sans-serif;
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
            }
            h1, h2 {
                text-align: center;
                color: #333;
            }
            img {
                max-width: 100%;
                height: auto;
                display: block;
                margin: 0 auto;
            }
            .header {
                background-color: #333;
                color: white;
                padding: 10px 0;
                margin-bottom: 20px;
                text-align: center;
            }
            .back-button {
                display: inline-block;
                margin: 20px auto;
                padding: 10px 20px;
                background-color: #333;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                text-align: center;
            }
            .back-button:hover {
                background-color: #555;
            }
            .button-container {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>Cricket Statistics Dashboard</h1>
        </div>
        <div class="dashboard">
    """
    
    for name, viz_function in visualizations.items():
        fig = viz_function(connection)
        if fig:
            img_str = get_plot_as_base64(fig)
            title = ' '.join(word.capitalize() for word in name.split('_'))
            
            html_content += f"""
            <div class="chart-container">
                <h2>{title}</h2>
                <img src="data:image/png;base64,{img_str}" alt="{title}">
            </div>
            """
            
            plt.close(fig)
    
    html_content += """
        </div>
        <div class="button-container">
            <a href="admin1st.html" class="back-button">Back to Admin Panel</a>
        </div>
    </body>
    </html>
    """
    
    connection.close()
    
    # Save HTML file
    with open("cricket_stats_dashboard.html", "w") as f:
        f.write(html_content)
    
    print("Generated HTML dashboard: cricket_stats_dashboard.html")

# Run the main functions
if __name__ == "__main__":
    print("Generating visualizations...")
    generate_all_visualizations()
    print("Generating HTML dashboard...")
    generate_html_page()
    print("Done!")