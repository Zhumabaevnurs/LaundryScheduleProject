<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NEW USER REGISTRATION</title>
    <style type="text/css">
        h1{ color: white;}
        body{ font: 20px sans-serif;
              border: solid;
              border-width: 1em;
              border-color: #20B2AA;
              margin: 15%;
              margin-top: 350px;
              }
        .box{ width: 100%;
              height: 400px;
              text-align: center;
              background-color: #464866;
              opacity: 0.8;
              }
        input[type=submit] {  /* CSS for the Submit button (form) */
              background-color: #20B2AA;
              border: none;
              color: black;
              margin-top: 10em;
              width:120px;
              padding: 12px 18px;
              text-decoration: none;
              margin: 4px 2px;
              cursor: pointer;
              }
          p{color: white;}
    </style>
</head>
<body style="background-color: #25274D;">
<?php
    if (isset($_REQUEST['username']))
		$userId = $_REQUEST['username'];
    else
        $userId = NULL;

    if(isset($_REQUEST['password']))
        $password = $_REQUEST['password'];
    else
        $password = NULL;
?>
    <div class="box">
        <br>
        <h1 style="margin:auto;">NEW USER REGISTRATION</h1>
        </br>
        <form action="register.php" method="post">
            <div class="userid">
                <label for="userid"><span style="padding-left:25px; color:#20B2AA;"> User Id: </label>
                <input type="text" id="userid" name="username" value = "<?php echo $userId ?>">
            </div>
            <br>
            <div class="password">
                <label for="password" style="color:#20B2AA;">Password: </label>
                <input type="password" id="password" name="password" value = "<?php echo $password ?>">
            </div>
            <br>
            <div>
            <p>Password must consist of minimum 8 characters, with upper/lowercase letters,
            numbers and special characters.</p>
            </div>
            <br>
            <div class="submit">
                <input type="submit" value="CONTINUE">
            </div>
            <?php
                if(isset($_REQUEST['password']) && isset($_REQUEST['username']))
                {
                    if ($userId == NULL && $password == NULL)
                        echo "<br> Please enter a valid User ID and Password.";
                    elseif(validatePass($password) && validateID($userId))     // call for password validation && call for userId validation.
                    {
                        $Validated = true;   // Setting $Validated to true allows the link for redirection to appear.
						//sends data to information.php as a session
						session_start();
						$_SESSION['id'] = $userId;
						$_SESSION['pass'] = $password;
                        header('Location: information.php');
                        exit();
                    }
                    elseif (!validatePass($password))
                        echo " <br> Password does not meet the requirments";
                    elseif (!validateID($userId))
                        echo " <br> Duplicate ID detected. Please Change ID.";
                }
            ?>
        </form>
<?php

    // This function makes sure that the password meets the specificaitons.
    // Returns true if the parameter '$pass' meets the requirments, returns false otherwise.
    function validatePass($pass)
    {
        $length = strlen($pass);
        $i = 0;

        $minimumChars = false;          //flags for each requirment.
        $upperCase = false;
        $lowerCase = false;
        $numbers = false;
        $specialChars = false;

        if($length > 7)
            $minimumChars = true;

        while ($i < $length && !$upperCase)
        {
            if (ctype_upper($pass{$i})){
                $upperCase = true;
                $i = 0;
            }
            else
                $i++;
        }

        while ($i < $length && !$lowerCase)
        {
            if (ctype_lower($pass{$i})){
                $lowerCase = true;
                $i = 0;
            }
            else
                $i++;
        }

        while ($i < $length && !$numbers)
        {
            if (ctype_digit($pass{$i})) {
                $numbers = true;
                $i = 0;
            }
            else
                $i++;
        }

        while ($i < $length && !$specialChars)
        {
            if (specialChar($pass{$i}))   // call to a funciton that checks if a Special Char is detected.
            {
                $specialChars = true;
                $i = 0;
            }
            else {
                $i++;
            }
        }

        if ($minimumChars && $upperCase && $lowerCase && $numbers && $specialChars )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // 'ValidateID' makes sure that the User ID is not duplicated..
    // returns true if the parameter '$userId' is not a duplicate, returns false if it detects a duplication.
    function validateID($userId)
    {
		$conn = mysqli_connect("localhost","root", "", "CSC350GroupCTerm");  // connection through mysqli_connect (location, user name, password (if applicable), name of schema)
		if(!$conn) 
		{
			die("Connection failed: " .mysqli_connect_error());
		}
		else 		
			$sql = "select userId from userinfo;"; // writing a query into a variable.
			$result = mysqli_query($conn, $sql); // sending the query to the Data Base and placing the return inside the variable ($result).

        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
                if ($row["userId"] == $userId)
                {
                    return false;
                }
        }
        return true;
    }
    // specialChar returns true if the parameter sent to it is a apecial character, false otherwise.
    function specialChar($temp)
    {
        if (($temp == '!' ||$temp == '@' ||$temp == '#' ||$temp == '$' ||$temp == '%' ||$temp == '^' ||$temp == '&' ||$temp == '*' ||$temp == '(' ||$temp == ')' ||$temp == '-' ||$temp == '_' ||$temp == '+' ||
        $temp == '=' ||$temp == '[' ||$temp == ']' ||$temp == '{' ||$temp == '}' ||$temp == '`' ||$temp == '~' ))
        return true;
        else return false;
    }
?>
</div>
</body>
</html>
