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


td a {
  border: 1px solid #ddd;
  margin-top: -1px; /* Prevent double borders */
  background-color: #1abc9c;
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  color: black;
  display: block
}

 td a:hover:not(.header) {
  background-color: #eee;
}

<?php
  session_start();
  $dateData = $_SESSION['datedata'];
  $boolDate = $_SESSION['booldate'];
?>


}
</style>
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
    for($t = 0; $t<=8; $t++)
    {
        for ($w = 0 ; $w <7; $w++)
        {
			if($t == 0) echo $dateDataMD[$w];
			else
			{
				$result = $array[$w][$t-1];
        if($result==1)
        {
          echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Not Available&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        else {
          echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }

			}
        }
		echo "<br>";
    }


    // this is multidimentional array for time slots
    $timeSlotArray = array(
      array("12-03AM","03-06AM","06-09AM","09-12AM","12-03PM","03-06PM","06-09PM","09-12PM"),
      array("12-03AM","03-06AM","06-09AM","09-12AM","12-03PM","03-06PM","06-09PM","09-12PM"),
      array("12-03AM","03-06AM","06-09AM","09-12AM","12-03PM","03-06PM","06-09PM","09-12PM"),
      array("12-03AM","03-06AM","06-09AM","09-12AM","12-03PM","03-06PM","06-09PM","09-12PM"),
      array("12-03AM","03-06AM","06-09AM","09-12AM","12-03PM","03-06PM","06-09PM","09-12PM"),
      array("12-03AM","03-06AM","06-09AM","09-12AM","12-03PM","03-06PM","06-09PM","09-12PM"),
      array("12-03AM","03-06AM","06-09AM","09-12AM","12-03PM","03-06PM","06-09PM","09-12PM")
    );





?>

<ul class="weekdays"> <!-- Here I inserted php to show date of all weekdays- it is set according to the given day". -->
<?php
	echo "<li>".$dateDataMD[0]."<br>Mo</li>";
	echo "<li>".$dateDataMD[1]."<br>Tu</li>";
	echo "<li>".$dateDataMD[2]."<br>We</li>";
	echo "<li>".$dateDataMD[3]."<br>Th</li>";
	echo "<li>".$dateDataMD[4]."<br>Fr</li>";
	echo "<li>".$dateDataMD[5]."<br>Sa</li>";
	echo "<li>".$dateDataMD[6]."<br>Su</li>";
?>
</ul>


<table id="table" border="1">
  <tr>
  <td><input type="submit" value="<?php echo $timeSlotArray[0][0] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[1][0] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[2][0] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[3][0] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[4][0] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[5][0] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[6][0] ?>"></td>
</tr>
<tr>
  <tr>
    <td><input type="submit" value="<?php echo $timeSlotArray[0][1] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[1][1] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[2][1] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[1][1] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[1][1] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[1][1] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[1][1] ?>"></td>
</tr>
<tr>
  <tr>
    <td><input type="submit" value="<?php echo $timeSlotArray[0][2] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[1][2] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[2][2] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[3][2] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[4][2] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[5][2] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[6][2] ?>"></td>
</tr>
<tr>
  <td><input type="submit" value="<?php echo $timeSlotArray[0][3] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[1][3] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[2][3] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[3][3] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[4][3] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[5][3] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[6][3] ?>"></td>
</tr>
<tr>
  <tr>
    <td><input type="submit" value="<?php echo $timeSlotArray[0][4] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[1][4] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[2][4] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[3][4] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[4][4] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[5][4] ?>"></td>
    <td><input type="submit" value="<?php echo $timeSlotArray[6][4] ?>"></td>
</tr>
<tr>
  <td><input type="submit" value="<?php echo $timeSlotArray[0][5] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[1][5] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[2][5] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[3][5] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[4][5] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[5][5] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[6][5] ?>"></td>
</tr>
<tr>
  <td><input type="submit" value="<?php echo $timeSlotArray[0][6] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[1][6] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[2][6] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[3][6] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[4][6] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[5][6] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[6][6] ?>"></td>
</tr>
<tr>
  <td><input type="submit" value="<?php echo $timeSlotArray[0][7] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[1][7] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[2][7] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[3][7] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[4][7] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[5][7] ?>"></td>
  <td><input type="submit" value="<?php echo $timeSlotArray[6][7] ?>"></td>
</tr>


</table>

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
