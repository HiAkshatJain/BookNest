<?php
session_start();

$nameErr = $emailErr = $genderErr = $addressErr = $icErr = $contactErr = $usernameErr = $passwordErr = "";
$name = $email = $gender = $address = $ic = $contact = $uname = $upassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Please enter your name";
    } else {
        if (!preg_match("/^[a-zA-Z ]*$/", $_POST["name"])) {
            $nameErr = "Only letters and white space allowed";
        } else {
            $name = test_input($_POST["name"]);
        }
    }

    // Validate username
    if (empty($_POST["uname"])) {
        $usernameErr = "Please enter your Username";
    } else {
        $uname = test_input($_POST["uname"]);
    }

    // Validate password
    if (empty($_POST["upassword"])) {
        $passwordErr = "Please enter your Password";
    } else {
        $upassword = test_input($_POST["upassword"]);
    }

    // Validate IC
    if (empty($_POST["ic"])) {
        $icErr = "Please enter your IC number";
    } else {
        if (!preg_match("/^[0-9 -]*$/", $_POST["ic"])) {
            $icErr = "Please enter a valid IC number";
        } else {
            $ic = test_input($_POST["ic"]);
        }
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Please enter your email address";
    } else {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        } else {
            $email = test_input($_POST["email"]);
        }
    }

    // Validate contact number
    if (empty($_POST["contact"])) {
        $contactErr = "Please enter your phone number";
    } else {
        if (!preg_match("/^[0-9 -]*$/", $_POST["contact"])) {
            $contactErr = "Please enter a valid phone number";
        } else {
            $contact = test_input($_POST["contact"]);
        }
    }

    // Validate gender
    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required!";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    // Validate address
    if (empty($_POST["address"])) {
        $addressErr = "Please enter your address";
    } else {
        $address = test_input($_POST["address"]);
    }

    // If no errors, proceed to insert into database
    if (empty($nameErr) && empty($usernameErr) && empty($passwordErr) && empty($icErr) && empty($emailErr) && empty($contactErr) && empty($genderErr) && empty($addressErr)) {
        $servername = "localhost";
        $username_db = "root";
        $password_db = "";

        $conn = new mysqli($servername, $username_db, $password_db, "bookstore");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO users(UserName, Password) VALUES('$uname', '$upassword')";
        $conn->query($sql);

        $userID = $conn->insert_id;

        $sql = "INSERT INTO customer(CustomerName, CustomerPhone, CustomerIC, CustomerEmail, CustomerAddress, CustomerGender, UserID) 
                VALUES('$name', '$contact', '$ic', '$email', '$address', '$gender', $userID)";
        $conn->query($sql);

        header("Location: index.php");
        exit();
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
	<header class="bg-white border py-4">
		<div class="container mx-auto flex justify-between items-center px-6">
		<span class="flex-shrink-0  font-extrabold text-xl sm:text-2xl tracking-wide">BookNest</span>
		<div class="space-x-4">
		<form class="inline" action="login.php"><input class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-300" type="submit" name="submitButton" value="Login"></form>
		<form class="inline" action="Register.php"><input class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300" type="submit" name="submitButton" value="Register"></form>
		</div>
		</div>
    </header>

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-6">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h1 class="text-2xl font-bold text-center mb-4">Register</h1>

            <div class="mb-4">
                <label for="name" class="block text-lg">Full Name:</label>
                <input type="text" id="name" name="name" placeholder="Full Name" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo $name; ?>">
                <span class="text-red-500 text-sm"><?php echo $nameErr; ?></span>
            </div>

            <div class="mb-4">
                <label for="uname" class="block text-lg">Username:</label>
                <input type="text" id="uname" name="uname" placeholder="Username" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo $uname; ?>">
                <span class="text-red-500 text-sm"><?php echo $usernameErr; ?></span>
            </div>

            <div class="mb-4">
                <label for="upassword" class="block text-lg">Password:</label>
                <input type="password" id="upassword" name="upassword" placeholder="Password" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <span class="text-red-500 text-sm"><?php echo $passwordErr; ?></span>
            </div>

            <div class="mb-4">
                <label for="ic" class="block text-lg">IC Number:</label>
                <input type="text" id="ic" name="ic" placeholder="xxxxxx-xx-xxxx" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo $ic; ?>">
                <span class="text-red-500 text-sm"><?php echo $icErr; ?></span>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-lg">E-mail:</label>
                <input type="text" id="email" name="email" placeholder="example@email.com" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo $email; ?>">
                <span class="text-red-500 text-sm"><?php echo $emailErr; ?></span>
            </div>

            <div class="mb-4">
                <label for="contact" class="block text-lg">Mobile Number:</label>
                <input type="text" id="contact" name="contact" placeholder="012-3456789" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo $contact; ?>">
                <span class="text-red-500 text-sm"><?php echo $contactErr; ?></span>
            </div>

            <div class="mb-4">
                <label for="gender" class="block text-lg">Gender:</label><br>
                <input type="radio" id="male" name="gender" value="Male" <?php if ($gender == "Male") echo "checked"; ?>> Male
                <input type="radio" id="female" name="gender" value="Female" <?php if ($gender == "Female") echo "checked"; ?>> Female
                <span class="text-red-500 text-sm"><?php echo $genderErr; ?></span>
            </div>

            <div class="mb-4">
                <label for="address" class="block text-lg">Address:</label>
                <textarea id="address" name="address" rows="4" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo $address; ?></textarea>
                <span class="text-red-500 text-sm"><?php echo $addressErr; ?></span>
            </div>

            <div class="flex justify-between items-center">
                <input type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none" value="Submit">
                <input type="button" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600" value="Cancel" onclick="window.location='index.php';">
            </div>
        </form>
    </div>
</body>
</html>
