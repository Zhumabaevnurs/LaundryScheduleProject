<!DOCTYPE html>
<html>
<head>
<style>
* {box-sizing: border-box;}
ul {list-style-type: none;}
body {font-family: Verdana, sans-serif;
  background-color: #25274D;

}
h2{
  margin-top: -1em;
}

.month {
  padding: 20px 25px;
  width: 100%;
  height: 10em;
  background: #1abc9c;
  text-align: center;
}

.month ul {
  margin: 0;
  padding: 0;
}

.month ul li {
  color: white;
  font-size: 20px;
  text-transform: uppercase;
  letter-spacing: 3px;
}

.month .prev {
  float: left;
  padding-top: 10px;
}

.month .next {
  float: right;
  padding-top: 10px;
}

.weekdays {
  margin: 0;
  padding: 10px 0;
  background-color: #ddd;
}

.weekdays li {
  display: inline-block;
  width: 13.6%;
  color: black;
  text-align: center;
}

table {
  padding: 10px 0;
  background-color: white;
  opacity: 0.8;
  margin: 0;
  width: 100%;

}

</style>
<?php
  session_start();
  $dateData = $_SESSION['datedata'];
  $boolDate = $_SESSION['booldate'];
  $userApt = $_SESSION['userApt'];
?>
</head>
<body>

<h1 style="text-align: center; color: white;">Weekly Laundry Schedule</h1>

<div class="month">
  <ul>
    <li class="prev">&#10094;</li>
    <li class="next">&#10095;</li>
    <li>
      <h1 id="month"></h1>
      <h2 id="year"></h2>
    </li>
  </ul>
</div>

<?php
    date_default_timezone_set('America/New_York');
    $dateArray = getDate();
    $date=date_create();

	$dateDataMD[] = date_format($dateData[0], "m-d");
	$dateDataMD[] = date_format($dateData[1], "m-d");
	$dateDataMD[] = date_format($dateData[2], "m-d");
	$dateDataMD[] = date_format($dateData[3], "m-d");
	$dateDataMD[] = date_format($dateData[4], "m-d");
	$dateDataMD[] = date_format($dateData[5], "m-d");
	$dateDataMD[] = date_format($dateData[6], "m-d");

	$startDate = clone $dateData[0];
	date_modify($startDate, '-1 day');
	date_time_set($startDate, 23,59,59);
	$startDateSTR = date_format($startDate,"YmdHis");

	$endDate = clone $dateData[6];
	date_time_set($endDate, 23, 59, 59);
	$endDateSTR = date_format($endDate,"YmdHis");

	$conn = mysqli_connect("localhost","root", "", "CSC350GroupCTerm");  // connection through mysqli_connect (location, user name, password (if applicable), name of schema)
	if(!$conn)
	{
		die("Connection failed: " .mysqli_connect_error());
	}
	else
		$sql = "select usedate from schedule where usedate > ".$startDateSTR." AND usedate < ".$endDateSTR." ORDER BY usedate;"; // writing a query into a variable.
		$result = mysqli_query($conn, $sql);

    $array = array();

    for($i = 0; $i<= 6; $i++)
      if ($boolDate[$i] == 1)
      {
        $array[$i] = array(1,1,1,1,1,1,1,1);
      }
      else
        $array[$i] = array(0,0,0,0,0,0,0,0);


      $currentSlot = $dateArray['hours'] / 3 ; // changing the time to fit index for timeslots


      for($j = 0; $j <=7; $j++)
        if ($j <= $currentSlot)
          $array[($dateArray['wday']+6)%7][$j] = 0;    // if the time is smaller than our time- set it to zero! (modulus operation is just to make 0 = Monday and 6 = Sunday).


		if(mysqli_num_rows($result))
		{
			$scheduleData = mysqli_fetch_array($result);
			for ($i = 0; $i < mysqli_num_rows($result); $i++)
			{
				$scheduleDateTime = new DateTime($scheduleData[0]);
				$WEEKDAY = (date_format($scheduleDateTime,'w') + 6) % 7;   // converting the taken slot's timestamp ('USEDATE' column) to the day of the week as index for the array, (modulus operation is just to make 0 = Monday and 6 = Sunday).
				$HOUR = (date_format($scheduleDateTime,'H')) / 3;            // converting the timestamp to the timesolt specified and dividing by 3 to fit as index for the array.
				$array[$WEEKDAY][$HOUR] = 0;
				$scheduleData = mysqli_fetch_array($result);
			}
		}
    // This is testing for the array- you can see the values in each day.
/*    for($t = 0; $t< 9; $t++)
    {
        for ($w = 0 ; $w <7; $w++)
        {
			if($t == 0) echo "&nbsp;$dateDataMD[$w]&nbsp;";
			else
			{
				$result = $array[$w][$t-1];
				echo "&nbsp;&nbsp;&nbsp;&nbsp;$result&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
        }
		echo "<br>";
    }

*/

echo '<ul class="weekdays">';

	echo "<li>".$dateDataMD[0]."<br>Mo</li>";
	echo "<li>".$dateDataMD[1]."<br>Tu</li>";
	echo "<li>".$dateDataMD[2]."<br>We</li>";
	echo "<li>".$dateDataMD[3]."<br>Th</li>";
	echo "<li>".$dateDataMD[4]."<br>Fr</li>";
	echo "<li>".$dateDataMD[5]."<br>Sa</li>";
	echo "<li>".$dateDataMD[6]."<br>Su</li>";

echo '</ul>';
?>
<table id="table" border="1">
<form action="appointmentDisplay2.php" method="post">
<?php
 echo'<tr>';
	$y = 0;
	for ($x = 0; $x < 7; $x++)
	{
		if($array[$x][$y] != 0)
		{
			echo'<td>
			<input type="radio" name="timeslot" value="'.$y.','.$x.'" />
			<label>00AM-03AM</label
			</td>';
		}
		else
		{
			echo '<td>Not Available</td>';
		}
	}
echo'</tr>
<tr>';
	$y++; //y=1
	for ($x = 0; $x < 7; $x++)
	{
		if($array[$x][$y] != 0)
		{
			echo'<td>
			<input type="radio" name="timeslot" value="'.$y.','.$x.'" />
			<label>03AM-06AM</label
			</td>';
		}
		else
		{
			echo '<td>Not Available</td>';
		}
	}
echo'</tr>
<tr>';
	$y++; //y=2
	for ($x = 0; $x < 7; $x++)
	{
		if($array[$x][$y] != 0)
		{
			echo'<td>
			<input type="radio" name="timeslot" value="'.$y.','.$x.'" />
			<label>06AM-09AM</label
			</td>';
		}
		else
		{
			echo '<td>Not Available</td>';
		}
	}
echo'</tr>
<tr>';
	$y++; //y=3
	for ($x = 0; $x < 7; $x++)
	{
		if($array[$x][$y] != 0)
		{
			echo'<td>
			<input type="radio" name="timeslot" value="'.$y.','.$x.'" />
			<label>09AM-12PM</label
			</td>';
		}
		else
		{
			echo '<td>Not Available</td>';
		}
	}
echo'</tr>
<tr>';
	$y++; //y=4
	for ($x = 0; $x < 7; $x++)
	{
		if($array[$x][$y] != 0)
		{
			echo'<td>
			<input type="radio" name="timeslot" value="'.$y.','.$x.'" />
			<label>   12PM-03PM</label
			</td>';
		}
		else
		{
			echo '<td>Not Available</td>';
		}
	}
echo'</tr>
<tr>';
	$y++; //y=5
	for ($x = 0; $x < 7; $x++)
	{
		if($array[$x][$y] != 0)
		{
			echo'<td>
			<input type="radio" name="timeslot" value="'.$y.','.$x.'" />
			<label>   03PM-06PM</label
			</td>';
		}
		else
		{
			echo '<td>Not Available</td>';
		}
	}
echo'</tr>
<tr>';
	$y++; //y=6
	for ($x = 0; $x < 7; $x++)
	{
		if($array[$x][$y] != 0)
		{
			echo'<td>
			<input type="radio" name="timeslot" value="'.$y.','.$x.'" />
			<label>   06PM-09PM</label
			</td>';
		}
		else
		{
			echo '<td>Not Available</td>';
		}
	}
echo'</tr>
<tr>';
	$y++; //y=7
	for ($x = 0; $x < 7; $x++)
	{
		if($array[$x][$y] != 0)
		{
			echo'<td>
			<input type="radio" name="timeslot" value="'.$y.','.$x.'" />
			<label>09PM-00AM</label
			</td>';
		}
		else
		{
			echo '<td>Not Available</td>';
		}
	}

?>
</tr>
</table>
    <br>
    <input style="margin-left:40%;width:13.5%; height:5%;background:#1abc9c; font-size:1.5em;" type="submit" value="SELECT">
</form>

<script>


  //getMonth() method for display the name of the month
  var m = new Date();
  var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
  document.getElementById("month").innerHTML = months[m.getMonth()];

  //getFullYear method to returns the full year of a date
  var y = new Date();
  document.getElementById("year").innerHTML = y.getFullYear();

</script>

</body>
</html>
