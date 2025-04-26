<!DOCTYPE html>
<html>
<style >
	body {font-family: Arial, Helvetica, sans-serif;background-repeat: no repeat; text-transform: uppercase;
  background-size: 100%;
}
	table{
		border: 1px solid white; height:50px; width:800px;
	}
	tr{
		border: 1px solid white; height:50px; width:800px;
	}
	th{
		border: 1px solid white; height:50px; width:800px;
	}
</style>
<style>
	body{
		background-image: url('img/crc.jpg');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-size: 100%;
	}
</style>
<head>
	<title>STADIUMS</title>
</head>
<body>
<div ><table align="center" width="100%"><tr><th><p><h1 style="color: black;">stadiums</h1></p></th></tr></div>
	 <div style="margin-top:100px;" >
	<table align="center" style="color: black;">
		<tr>
			<th>Stadium Name</th>
			<th>Capacity</th>
			<th>Board Name</th>
			<th>Team's Stadium</th>
		</tr>
		<?php
		$con=mysqli_connect("localhost","root","","cricket");
		$query="select * from stadiums";
		$result=mysqli_query($con,$query);
		if(mysqli_num_rows($result)>0)
		{
			while ($row=mysqli_fetch_assoc($result)) {
			echo "<tr><th>".$row["stadium_name"]."</th>"."<th>".
			$row["capacity"]."</th><th>".
			$row["board_name"]."</th><th>".
			$row["team"]."</th></tr>";
			}
		}
		mysqli_close($con);
		?>
	</table>
</body>
</html>