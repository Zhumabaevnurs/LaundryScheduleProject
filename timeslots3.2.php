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


td input{
  width:100%;
  border: 1px solid #ddd;
  margin-top: -1px; /* Prevent double borders */
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  color: black;
  display: block

}

 td input:hover:not(.header) {
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

    switch ($dateArray['wday']){ // setting up different arrays for each different case.
        case 0:
          $index = array('Mo' => "-6 days", 'Tu' => "-5 days", 'We'=> "-4 days" ,'Th' => "-3 days", 'Fr' => "-2 days", 'Sa' => "-1 days", 'Su' => "0 days");
        break;
        case 1:
          $index = array('Mo' => "0 days", 'Tu' => "1 days", 'We'=> "2 days" ,'Th' => "3 days", 'Fr' => "4 days", 'Sa' => "5 days", 'Su' => "6 days");
        break;
        case 2:
          $index = array('Mo' => "-1 days", 'Tu' => "0 days", 'We'=> "1 days" ,'Th' => "2 days", 'Fr' => "3 days", 'Sa' => "4 days", 'Su' => "5 days");
        break;
        case 3:
          $index = array('Mo' => "-2 days", 'Tu' => "-1 days", 'We'=> "0 days" ,'Th' => "1 days", 'Fr' => "2 days", 'Sa' => "3 days", 'Su' => "4 days");
        break;
        case 4:
          $index = array('Mo' => "-3 days", 'Tu' => "-2 days", 'We'=> "-1 days" ,'Th' => "0 days", 'Fr' => "1 days", 'Sa' => "2 days", 'Su' => "3 days");
        break;
        case 5:
          $index = array('Mo' => "-4 days", 'Tu' => "-3 days", 'We'=> "-2 days" ,'Th' => "-1 days", 'Fr' => "0 days", 'Sa' => "1 days", 'Su' => "2 days");
        break;
        case 6:
          $index = array('Mo' => "-5 days", 'Tu' => "-4 days", 'We'=> "-3 days" ,'Th' => "-2 days", 'Fr' => "-1 days", 'Sa' => "0 days", 'Su' => "1 days");
        break;

    }
    $array = array();

    $boolDate = array(1,1,1,1,1,1,1);  // demo date array

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


      $dateData = array('USEDATE' => date_create('2020-12-11 09:00')); // demo date for testing. this will be on friday at 9 AM
      $weekDay=$dateData['USEDATE']->format('w');
      $hour = $dateData['USEDATE']->format('H');


      // THIS IS A DUMMY FUNCTION TO SIMULATE A RETURNED QUERY FROM THE DATABASE. (ONE ROW SENT BACK - FRIDAY AT 9 AM):
      //********************************************************************************
        //if (mysqli_num_rows($dateData) > 0)
        //while (($row = mysqli_fetch_assoc($dateData))){
          $WEEKDAY = ($dateData["USEDATE"]->format('w') + 6) % 7;     // converting the taken slot's timestamp ('USEDATE' column) to the day of the week as index for the array, (modulus operation is just to make 0 = Monday and 6 = Sunday).
          $HOUR = $dateData['USEDATE']->format('H') / 3;            // converting the timestamp to the timesolt specified and dividing by 3 to fit as index for the array.
          $array[$WEEKDAY][$HOUR] = 0;
        //}*****************************************************************************

       // This is testing for the array- you can see the values in each day.
      for($w = 0; $w<= 6; $w++)
      {
        echo "<br> Day number $w :   ";
          for ($t = 0 ; $t <=7; $t++)
          {
            $result = $array[$w][$t];
            echo "$result \t";
          }
      }

      //multidimentional array to fill up a table
      /*$timeSlots=getDate();
      if(timeSlots['hours']>=0 && timeSlots['hours']>=3)*/

      /*
      $timeSlotArray = array(
        array('Mo'=>"12-03AM",'Mo'=>"03-06AM",'Mo'=>"06-09AM",'Mo'=>"09-12AM",'Mo'=>"12-03PM",'Mo'=>"03-06PM",'Mo'=>"06-09PM", 'Mo'=>"09-12PM"),
        array('Tu'=>"12-03AM",'Tu'=>"03-06AM",'Tu'=>"06-09AM",'Tu'=>"09-12AM",'Tu'=>"12-03PM",'Tu'=>"03-06PM",'Tu'=>"06-09PM", 'Tu'=>"09-12PM"),
        array('We'=>"12-03AM",'We'=>"03-06AM",'We'=>"06-09AM",'We'=>"09-12AM",'We'=>"12-03PM",'We'=>"03-06PM",'We'=>"06-09PM", 'We'=>"09-12PM"),
        array('Th'=>"12-03AM",'Th'=>"03-06AM",'Th'=>"06-09AM",'Th'=>"09-12AM",'Th'=>"12-03PM",'Th'=>"03-06PM",'Th'=>"06-09PM", 'Th'=>"09-12PM"),
        array('Fr'=>"12-03AM",'Fr'=>"03-06AM",'Fr'=>"06-09AM",'Fr'=>"09-12AM",'Fr'=>"12-03PM",'Fr'=>"03-06PM",'Fr'=>"06-09PM", 'Fr'=>"09-12PM"),
        array('Sa'=>"12-03AM",'Sa'=>"03-06AM",'Sa'=>"06-09AM",'Sa'=>"09-12AM",'Sa'=>"12-03PM",'Sa'=>"03-06PM",'Sa'=>"06-09PM", 'Sa'=>"09-12PM"),
        array('Su'=>"12-03AM",'Su'=>"03-06AM",'Su'=>"06-09AM",'Su'=>"09-12AM",'Su'=>"12-03PM",'Su'=>"03-06PM",'Su'=>"06-09PM", 'Su'=>"09-12PM"),
      );*/

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
  <li><?php date_add($date, date_interval_create_from_date_string($index['Mo'])); echo date_format($date, "m-d"); $date=date_create(); ?><br>Mo</li>
  <li><?php date_add($date, date_interval_create_from_date_string($index['Tu'])); echo date_format($date, "m-d"); $date=date_create(); ?><br>Tu</li>
  <li><?php date_add($date, date_interval_create_from_date_string($index['We'])); echo date_format($date, "m-d"); $date=date_create(); ?><br>We</li>
  <li><?php date_add($date, date_interval_create_from_date_string($index['Th'])); echo date_format($date, "m-d"); $date=date_create(); ?><br>Th</li>
  <li><?php date_add($date, date_interval_create_from_date_string($index['Fr'])); echo date_format($date, "m-d"); $date=date_create(); ?><br>Fr</li>
  <li><?php date_add($date, date_interval_create_from_date_string($index['Sa'])); echo date_format($date, "m-d"); $date=date_create(); ?><br>Sa</li>
  <li><?php date_add($date, date_interval_create_from_date_string($index['Su'])); echo date_format($date, "m-d"); $date=date_create(); ?><br>Su</li>
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
