<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LOGIN</title>
    <style type="text/css">
    h1{ color: white;}
    body{ font: 20px sans-serif;
          border: solid;
          border-width: 1em;
          border-color: #20B2AA;
          margin: 15%;
          margin-top: 350px;
          background-color: #25274D;
          }
    .box{ width: 100%;
          height: 700px;
          text-align: center;
          background-color: #464866;
          opacity: 0.8;
          }
          a:link, a:visited
          {
          background-color: #20B2AA;
          border: none;
          color: black;
          padding: 12px 18px;
          text-decoration: none;
          margin: 4px 2px;
          cursor: pointer;
          }
          input[type=submit] {  /* CSS for the Submit button (form) */
          background-color: #20B2AA;
          border: none;
          color: black;
          width:120px;
          padding: 12px 18px;
          text-decoration: none;
          margin: 4px 2px;
          cursor: pointer;
          }
    </style>
<?php
  session_start();
  $userApt = $_SESSION['userApt'];
?>
</head>
    <div class="box">
        <br><br><br>
        <h1 style="margin:auto;">Your Laundry Appointment</h1>
        <br>
        <div>
        <?php
        /* Attempt MySQL server connection.*/
        $conn = mysqli_connect("localhost", "root", "", "CSC350GroupCTerm");

        // Check connection
        if($conn === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
        }

       // Attempt select query execution
       $sql = "SELECT * FROM CSC350GroupCTerm.UserInfo LIMIT 1;";
       $result = mysqli_query($conn, $sql);
       $resultCheck = mysqli_num_rows($result);
       if(mysqli_num_rows($result) > 0){
          echo "<h4 style='color:#20B2AA;margin-right:15em;'> First Name: </h4>";
          while($row = mysqli_fetch_array($result)){
          echo "<h4 style='color:#20B2AA;margin-top:-2.5em;'>" .$row['FIRSTNAME']."</h4>";
          }
       }


       // Attempt select query execution
       $sql = "SELECT * FROM CSC350GroupCTerm.UserInfo LIMIT 1";
       $result = mysqli_query($conn, $sql);
       $resultCheck = mysqli_num_rows($result);
       if(mysqli_num_rows($result) > 0){
          echo "<h4 style='color:#20B2AA;margin-right:15em;'> Last Name: </h4>";
          while($row = mysqli_fetch_array($result)){
          echo "<h4 style='color:#20B2AA; margin-top:-2.5em;'>".$row['LASTNAME']."</h4>";
          }
       }

       // Attempt select query execution
       $sql = "SELECT * FROM CSC350GroupCTerm.UserInfo LIMIT 1";
       $result = mysqli_query($conn, $sql);
       $resultCheck = mysqli_num_rows($result);
       if(mysqli_num_rows($result) > 0){
          echo "<h4 style='color:#20B2AA; margin-right:14em;'> User ID: </h4>";
          while($row = mysqli_fetch_array($result)){
          echo "<h4 style='color:#20B2AA; margin-top:-2.5em; '>" .$row['USERID']."</h4>";
          }
       }

       // Attempt select query execution
       $sql = "SELECT * FROM CSC350GroupCTerm.UserInfo LIMIT 1";
       $result = mysqli_query($conn, $sql);
       $resultCheck = mysqli_num_rows($result);
       if(mysqli_num_rows($result) > 0){
          echo "<h4 style='color:#20B2AA; margin-right:13.5em;'>E-mail: </h4>";
          while($row = mysqli_fetch_array($result)){
          echo "<h4 style='color:#20B2AA;margin-top:-2.5em; '>".$row['EMAIL']."</h4>";
          }
       }

       // Attempt select query execution
       $sql = "SELECT * FROM CSC350GroupCTerm.UserInfo LIMIT 1";
       $result = mysqli_query($conn, $sql);
       $resultCheck = mysqli_num_rows($result);
       if(mysqli_num_rows($result) > 0){
          echo "<h4 style='color:#20B2AA; margin-right:13em;'> APT: </h4>";
          while($row = mysqli_fetch_array($result)){
          echo  "<h4 style='color:#20B2AA; margin-top:-2.5em;'>" .$row['APT'] ."</h4>";
          }
       }

  // Close connection
  mysqli_close($conn);
  ?>
      <div >
         <td><a href="timeslotsv5.php">Change Your Appointment</a></td>
      </div>
        </div>
    </div>
  </body>
  </html>
