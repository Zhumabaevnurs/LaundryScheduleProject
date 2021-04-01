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
          height: 400px;
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
</head>
<?php
    if (isset($_REQUEST['username']))
        $userId = $_REQUEST['username'];
    else
        $userId = NULL;

    if(isset($_REQUEST['pwd']))
        $password = $_REQUEST['pwd'];
    else
        $password = NULL;
?>
    <div class="box">
        <br><br><br>
        <h1 style="margin:auto;">LOGIN</h1>
        </br>
        <form action="login.php" method="post">
            <div class="userid">
                <label for="userid"><span style="padding-left:25px; color:#20B2AA;"> User Id: </label>
                <input type="text" id="userid" name="username">
            </div>
            <br>
            <div class="password">
                <label for="password" style="color:#20B2AA;">Password: </label>
                <input type="password" id="password" name="pwd">
            </div>
            <br>
            <div class="submit">
                <input type="submit" value="LOGIN" style="font-size:20px;">
                <a href="register.php">REGISTER</a> 
            </div>
        </form>
        <?php
        if(isset($_REQUEST['username']) && isset($_REQUEST['pwd']))
        {
            if($userId != NULL && $password != NULL)  // input validation, checking to make sure a blank field was not submitted.
            {
                if (authenticateUser($userId, $password))  // Calling the function to authenticate the user.
                    echo "<br>User Successfuly Authenticated!";
                else
                    echo "<br>INVALID USERID OR PASSWORD – TRY AGAIN OR REGISTER.";
            }
            else
                echo "Please enter a valid User ID and Password.";
        }
        ?>
    </div>
<?php
    // authenticateUser checks to see if the database has a row with the userID and password that are sent as parameters.
    // if found, returns true, returns false otherwise.
    function authenticateUser($userId, $password)
    {
		$conn = mysqli_connect("localhost","root", "", "CSC350GroupCTerm");  // connection through mysqli_connect (location, user name, password (if applicable), name of schema)
		if(!$conn) 
		{
			die("Connection failed: " .mysqli_connect_error());
		}
		else 		
			$sql = "select * from userinfo where userId = '". $userId ."' and password = '". $password ."';"; // writing a query into a variable.
			$result = mysqli_query($conn, $sql);
			
		$rows = mysqli_num_rows($result);
		
		if( $rows == 1) $match = true;
		else $match = false;
		
		return $match;
    }


?>
</body>
</html>
