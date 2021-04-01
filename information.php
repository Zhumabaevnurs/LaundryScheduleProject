<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Information</title>
    <style type="text/css">
        h1{ color: #20B2AA;}
        body{ font: 20px sans-serif;
              border: solid;
              border-width: 1em;
              border-color: #20B2AA;
              margin: 15%;
              margin-top: 350px;
              background-color: #25274D;
              }
        .box{
              width: 100%;
              height: 510px;
              text-align: center;
              background-color: #464866;
              opacity: 0.8;
        }

        input[type=submit] {
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
    </style>
</head>
<?php
	//Receives username and password from register.php as a session
	session_start();
	$userId = $_SESSION['id'];
    $password = $_SESSION['pass'];

    $Validated = false;

    if (isset($_REQUEST['firstName']))
            $firstName = $_REQUEST['firstName'];
    else
        $firstName = NULL;

    if(isset($_REQUEST['lastName']))
        $lastName = $_REQUEST['lastName'];
    else
        $lastName = NULL;

    if(isset($_REQUEST['email']))
        $email = $_REQUEST['email'];
    else
        $email = NULL;

    if(isset($_REQUEST['phone']))
        $phone = $_REQUEST['phone'];
    else
        $phone = NULL;
	
    if (isset($_POST['apt']))
        $apt = $_POST['apt'];
    else
        $apt = NULL;


?>
    <div class="box">
    <?php
        if (empty($_POST))  // Confirmation for the user for a succsesful submission of the previous page.
            echo '<span style="color: white"> Success! User ID and Password Created. </span>';

        if(isset($_REQUEST['firstName']) && isset($_REQUEST['lastName']) && isset($_REQUEST['email']) && isset($_REQUEST['phone']))
        {
			if (strlen($phone) != 10 || !ctype_digit($phone))    // input validation- validating that the phone number contains non-digits or not 10 digits.
				echo '<br><span style="color: red"> Please enter a valid phone number.  </span>';
				
			elseif(!validatePhone($phone))
				echo '<br><span style="color: red"> This phone number has been taken. </span>';
				
			elseif(!validateEmail($email))
				echo '<br><span style="color: red"> Please enter a valid email. </span>';
			
			elseif(!emailDuplicateCheck($email))
				echo '<br><span style="color: red"> This email has been taken. </span>';
				
			elseif($firstName != NULL && $lastName != NULL && $email != NULL && $apt != NULL && $phone != NULL) // input validation- if all mandatory fields have been sumitted- send the data to the Data Base.
				{
					$Validated = true;      // Allow link to Login page to appear.
					sendData($userId,$password,$firstName,$lastName,$email,$apt,$phone);      // call for function to send data to the Data Base.
				}
				
			else
				echo '<br><span style="color: red"> Please fill all mandatory fields. </span>';

        }
    ?>
        <h1 style="margin:auto;"> <br>NEW USER INFROMATION</h1>
        </br>
        <form action="information.php" method="post">
            <div class="firstName">
                <label for="firstName"><span style="color:#20B2AA;"> First Name: </label>
                <input type="text" id="firstName" name="firstName" value= <?php echo $firstName ?> >
            </div>
            <br>
            <div class="lastName">
                <label for="lastName"  style="color:#20B2AA;">Last Name: </label>
                <input type="text" id="lastName" name="lastName" value= <?php echo $lastName ?>>
            </div>
          <br>
            <div class="info">
                <label for="email" style="color:#20B2AA; padding-left:70px;">Email: </label>
                <input type="text" id="email" name="email" value= <?php echo $email?>>
                <br>
                <label for="phone" style="color:#20B2AA; padding-left:22px;">Phone Number: </label>
                <input type="text" id="phone" name="phone" value= <?php echo $phone ?>>
                <br>
                <label for="apt" style="color:#20B2AA;">Apartment Number: </label>
                <select name="apt">                   <!--- Inserted php code to keep the values selected after submission --->
				<?php
				$conn = mysqli_connect("localhost","root", "", "CSC350GroupCTerm");
					if(!$conn)
					{
						die("Connection failed: " .mysqli_connect_error());
					}
					else
						$sql = "select APT from userinfo order by APT;";
						$result = mysqli_query($conn, $sql);
						$taken = mysqli_fetch_array($result);
					for($i = 0; $i < 25; $i++)
					{
						if ($i+1 == $taken[0])
							$taken = mysqli_fetch_array($result);
						else
							$rooms[] = ($i + 1);	
					}
					
					for($j = 0; $rooms[$j]; $j++)
					{
						echo '<option value="'.$rooms[$j].'">'.$rooms[$j].'</option>';
					}
				?>
                </select>
            </div>
            <br>
            <div class="submit">
                <input type="submit" value="SAVE">
            </div>
            <?php
            if ($Validated)
            {
                echo '<br><span style="color: white">Information Saved, Click on the link below to Authenticate User. </span>';
                echo ' <br> <a href="login.php">Login To Authenticate User</a>';
            }
             ?>
        </form>
    </div>
<?php
// SendData() Sends the values it recives as parameters to the database.
function sendData($userId,$password,$firstName,$lastName,$email,$apt,$phone)
    {
		// connection through mysqli_connect (location, user name, password (if applicable), name of schema)
		$conn = mysqli_connect("localhost","root", "", "CSC350GroupCTerm");
		if(!$conn)
		{
			die("Connection failed: " .mysqli_connect_error());
		}
		else
			$sql = "insert into CSC350GroupCTerm.userinfo(USERID,PASSWORD,FIRSTNAME,LASTNAME,EMAIL,PHONE,APT)values('".$userId."','".$password."','".$firstName."','".$lastName."','".$email."','".$phone."','".$apt."')";
			$result = mysqli_query($conn, $sql);
    }
	
//checks whether email has an @ symbol
function validateEmail($email)
	{
		$symbol = false;
		$length = strlen($email);
		
		for ($i = 0; $i < $length; $i++)
		{
			if($email[$i] == '@') 
			{
				$symbol = true;
			}
		}
		
		if ($symbol) return true;
		else return false;
	}
function emailDuplicateCheck($email)
{		
		$conn = mysqli_connect("localhost","root", "", "CSC350GroupCTerm");  // connection through mysqli_connect (location, user name, password (if applicable), name of schema)
		if(!$conn) 
		{
			die("Connection failed: " .mysqli_connect_error());
		}
		else 		
			$sql = "select email from userinfo;"; // writing a query into a variable.
			$result = mysqli_query($conn, $sql); // sending the query to the Data Base and placing the return inside the variable ($result).

        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
                if ($row["email"] == $email)
                {
                    return false;
                }
        }
        return true;
}

function validatePhone($phone)
{
		$conn = mysqli_connect("localhost","root", "", "CSC350GroupCTerm");  // connection through mysqli_connect (location, user name, password (if applicable), name of schema)
		if(!$conn) 
		{
			die("Connection failed: " .mysqli_connect_error());
		}
		else 		
			$sql = "select phone from userinfo;"; // writing a query into a variable.
			$result = mysqli_query($conn, $sql); // sending the query to the Data Base and placing the return inside the variable ($result).

        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
                if ($row["phone"] == $phone)
                {
                    return false;
                }
        }
        return true;
}


?>
</body>
</html>
