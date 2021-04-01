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
<?php


?>

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
    $dateArray = getDate();
    $date=date_create();

    switch ($dateArray['wday']){ // setting up different arrays for each different case.
        case 0:
            $index = array('Mo' => "-5 days", 'Tu' => "-4 days", 'We'=> "-3 days" ,'Th' => "-2 days", 'Fr' => "-1 days", 'Sa' => "0 days", 'Su' => "1 days");
        break;
        case 1:
            $index = array('Mo' => "-6 days", 'Tu' => "-5 days", 'We'=> "-4 days" ,'Th' => "-3 days", 'Fr' => "-2 days", 'Sa' => "-1 days", 'Su' => "0 days");
        break;
        case 2:
            $index = array('Mo' => "0 days", 'Tu' => "1 days", 'We'=> "2 days" ,'Th' => "3 days", 'Fr' => "4 days", 'Sa' => "5 days", 'Su' => "6 days");
        break;
        case 3:
            $index = array('Mo' => "-1 days", 'Tu' => "0 days", 'We'=> "1 days" ,'Th' => "2 days", 'Fr' => "3 days", 'Sa' => "4 days", 'Su' => "5 days");
        break;
        case 4:
            $index = array('Mo' => "-2 days", 'Tu' => "-1 days", 'We'=> "0 days" ,'Th' => "1 days", 'Fr' => "2 days", 'Sa' => "3 days", 'Su' => "4 days");
        break;
        case 5:
            $index = array('Mo' => "-3 days", 'Tu' => "-2 days", 'We'=> "-1 days" ,'Th' => "0 days", 'Fr' => "1 days", 'Sa' => "2 days", 'Su' => "3 days");
        break;
        case 6:
            $index = array('Mo' => "-4 days", 'Tu' => "-3 days", 'We'=> "-2 days" ,'Th' => "-1 days", 'Fr' => "0 days", 'Sa' => "1 days", 'Su' => "2 days");
        break;

    }

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

<table id="table" border="1"></table>

<script>
//here I used nested array to fill up cells with array's elements
var array = [
                         ["12-03AM","12-03AM","12-03AM","12-03AM","12-03AM","12-03AM","12-03AM","12-03AM"],
                         ["03-06AM","03-06AM","03-06AM","03-06AM","03-06AM","03-06AM","03-06AM","03-06AM"],
                         ["06-09AM","06-09AM","06-09AM","06-09AM","06-09AM","06-09AM","06-09AM","06-09AM"],
                         ["09-12PM","09-12PM","09-12PM","09-12PM","09-12PM","09-12PM","09-12PM","09-12PM"],
                         ["12-03PM","12-03PM","12-03PM","12-03PM","12-03PM","12-03PM","12-03PM","12-03PM"],
                         ["03-06PM","03-06PM","03-06PM","03-06PM","03-06PM","03-06PM","03-06PM","03-06PM"],
                         ["06-09PM","06-09PM","06-09PM","06-09PM","06-09PM","06-09PM","06-09PM","06-09PM"],
                         ["09-12AM","09-12AM","09-12AM","09-12AM","09-12AM","09-12AM","09-12AM","09-12AM"],
                       ],
                table = document.getElementById("table");

  // Method 1
  for(var i = 1; i < table.rows.length; i++)
  {
    // cells
    for(var j = 0; j < table.rows[i].cells.length; j++)
    {
      table.rows[i].cells[j].innerHTML = array[i - 1][j];
    }
  }

  // Method 2

  for(var i = 0; i < array.length; i++)
  {
    // create a new row
    var newRow = table.insertRow(table.length);
    for(var j = 0; j < array[i].length; j++)
    {
      // create a new cell
      var cell = newRow.insertCell(j);

      // add value to the cell
      cell.innerHTML = array[i][j];
     }
   }

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
