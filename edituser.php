<?php
session_start();
$nameErr = $emailErr = $genderErr = $addressErr = $icErr = $contactErr = $usernameErr = $passwordErr = "";
$name = $email = $gender = $address = $ic = $contact = $uname = $upassword = "";
$cID;

$oUserName;
$oPassword;
$oName;
$oIC;
$oEmail;
$oPhone;
$oAddress;

$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "USE bookstore";
$conn->query($sql);

$sql = "SELECT users.UserName, users.Password, customer.CustomerName, customer.CustomerIC, customer.CustomerEmail, customer.CustomerPhone, customer.CustomerGender, customer.CustomerAddress
    FROM users, customer
    WHERE users.UserID = customer.UserID AND users.UserID = ".$_SESSION['id']."";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
    $oUserName = $row['UserName'];
    $oPassword = $row['Password'];
    $oName = $row['CustomerName'];
    $oIC = $row['CustomerIC'];
    $oEmail = $row['CustomerEmail'];
    $oPhone = $row['CustomerPhone'];
    $oAddress = $row['CustomerAddress'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Please enter your name";
    } else {
        $name = $_POST['name'];

        if (empty($_POST["uname"])) {
            $usernameErr = "Please enter your Username";
        } else {
            $uname = $_POST['uname'];

            if (empty($_POST["upassword"])) {
                $passwordErr = "Please enter your Password";
            } else {
                $upassword = $_POST['upassword'];

                if (empty($_POST["ic"])) {
                    $icErr = "Please enter your IC number";
                } else {
                    $ic = $_POST['ic'];

                    if (empty($_POST["email"])) {
                        $emailErr = "Please enter your email address";
                    } else {
                        $email = $_POST['email'];

                        if (empty($_POST["contact"])) {
                            $contactErr = "Please enter your phone number";
                        } else {
                            $contact = $_POST['contact'];

                            if (empty($_POST["gender"])) {
                                $genderErr = "Gender is required!";
                            } else {
                                $gender = $_POST['gender'];

                                if (empty($_POST["address"])) {
                                    $addressErr = "Please enter your address";
                                } else {
                                    $address = $_POST['address'];

                                    $servername = "localhost";
                                    $username = "root";
                                    $password = "";

                                    $conn = new mysqli($servername, $username, $password); 

                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    } 

                                    $sql = "USE bookstore";
                                    $conn->query($sql);

                                    $sql = "UPDATE users SET UserName = '".$uname."', Password = '".$upassword."' WHERE UserID = ".$_SESSION['id']."";
                                    $conn->query($sql);

                                    $sql = "UPDATE customer SET CustomerName = '".$name."', CustomerPhone = '".$contact."', 
                                    CustomerIC = '".$ic."', CustomerEmail = '".$email."', CustomerAddress = '".$address."', 
                                    CustomerGender = '".$gender."' WHERE UserID = ".$_SESSION['id']."";
                                    $conn->query($sql);

                                    header("Location:index.php");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

function test_input($data){
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
	<header class="bg-white border py-4">
		<div class="container mx-auto flex justify-between items-center px-6">
		<span class="flex-shrink-0  font-extrabold text-xl sm:text-2xl tracking-wide">BookNest</span>
		<div class="space-x-4">
    	<form class="inline" action="logout.php"><input class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300" type="submit" name="submitButton" value="Logout"></form>	
		</div>
		</div>
    </header>

    <div class="max-w-3xl mx-auto mt-12 p-8 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-bold text-center mb-6">Edit Profile</h1>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="mb-4">
                <label for="name" class="block text-lg">Full Name</label>
                <input type="text" name="name" id="name" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="<?php echo $oName; ?>">
                <span class="text-red-500 text-sm"><?php echo $nameErr;?></span>
            </div>

            <div class="mb-4">
                <label for="uname" class="block text-lg">Username</label>
                <input type="text" name="uname" id="uname" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="<?php echo $oUserName; ?>">
                <span class="text-red-500 text-sm"><?php echo $usernameErr;?></span>
            </div>

            <div class="mb-4">
                <label for="upassword" class="block text-lg">New Password</label>
                <input type="password" name="upassword" id="upassword" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="<?php echo $oPassword; ?>">
                <span class="text-red-500 text-sm"><?php echo $passwordErr;?></span>
            </div>

            <div class="mb-4">
                <label for="ic" class="block text-lg">IC Number</label>
                <input type="text" name="ic" id="ic" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="<?php echo $oIC; ?>">
                <span class="text-red-500 text-sm"><?php echo $icErr;?></span>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-lg">E-mail</label>
                <input type="text" name="email" id="email" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="<?php echo $oEmail; ?>">
                <span class="text-red-500 text-sm"><?php echo $emailErr;?></span>
            </div>

            <div class="mb-4">
                <label for="contact" class="block text-lg">Mobile Number</label>
                <input type="text" name="contact" id="contact" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="<?php echo $oPhone; ?>">
                <span class="text-red-500 text-sm"><?php echo $contactErr;?></span>
            </div>

            <div class="mb-4">
                <label for="gender" class="block text-lg">Gender</label><br>
                <input type="radio" name="gender" value="Male" <?php if (isset($gender) && $gender == "Male") echo "checked";?>> Male
                <input type="radio" name="gender" value="Female" <?php if (isset($gender) && $gender == "Female") echo "checked";?>> Female
                <span class="text-red-500 text-sm"><?php echo $genderErr;?></span>
            </div>

            <div class="mb-4">
                <label for="address" class="block text-lg">Address</label><br>
                <textarea name="address" id="address" cols="50" rows="5" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="<?php echo $oAddress; ?>"></textarea>
                <span class="text-red-500 text-sm"><?php echo $addressErr;?></span>
            </div>

            <div class="flex justify-between">
                <input type="submit" name="submitButton" value="Save Changes" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none">
                <input type="button" value="Cancel" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none" onclick="window.location='index.php';">
            </div>
        </form>
    </div>
</body>
</html>
