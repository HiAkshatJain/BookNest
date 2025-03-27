<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-100">
	<header class="bg-white border py-4 mb-8">
		<div class="container mx-auto flex justify-between items-center px-6">
		<span class="flex-shrink-0  font-extrabold text-xl sm:text-2xl tracking-wide">BookNest</span>
		<div class="space-x-4">
		<form class="inline" action="Register.php"><input class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300" type="submit" name="submitButton" value="Home"></form>
		</div>
		</div>
    </header>

    <?php
    session_start();

    if(isset($_SESSION['id'])){
        $servername = "localhost";
        $username = "root";
        $password = "";

        $conn = new mysqli($servername, $username, $password); 

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "USE bookstore";
        $conn->query($sql);

        $sql = "SELECT CustomerID from customer WHERE UserID = ".$_SESSION['id']."";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            $cID = $row['CustomerID'];
        }

        $sql = "UPDATE cart SET CustomerID = ".$cID." WHERE 1";
        $conn->query($sql);

        $sql = "SELECT * FROM cart";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            $sql = "INSERT INTO `order`(CustomerID, BookID, DatePurchase, Quantity, TotalPrice, Status) 
            VALUES(".$row['CustomerID'].", '".$row['BookID']
            ."', CURRENT_TIME, ".$row['Quantity'].", ".$row['TotalPrice'].", 'N')";
            $conn->query($sql);
        }
        $sql = "DELETE FROM cart";
        $conn->query($sql);

        $sql = "SELECT customer.CustomerName, customer.CustomerIC, customer.CustomerGender, customer.CustomerAddress, customer.CustomerEmail, customer.CustomerPhone, book.BookTitle, book.Price, book.Image, `order`.`DatePurchase`, `order`.`Quantity`, `order`.`TotalPrice`
            FROM customer, book, `order`
            WHERE `order`.`CustomerID` = customer.CustomerID AND `order`.`BookID` = book.BookID AND `order`.`Status` = 'N' AND `order`.`CustomerID` = ".$cID."";
        $result = $conn->query($sql);
        echo '<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg">';
        echo '<blockquote>';
    ?>
    <input class="bg-blue-900 text-white py-2 px-6 rounded-lg cursor-pointer hover:bg-blue-400 float-right" type="button" name="cancel" value="Continue Shopping" onClick="window.location='index.php';">
    <?php
        echo '<h2 class="text-xl text-gray-800 mb-4">Order Successfull</h2>';
        echo "<table class='w-full text-left border-collapse'>";
        echo "<tr><th class='bg-blue-900 text-white p-2'>Order Summary</th>";
        echo "<th class='bg-blue-900 text-white p-2'></th></tr>";
        $row = $result->fetch_assoc();
        echo "<tr><td class='p-2'>Name: </td><td class='p-2'>".$row['CustomerName']."</td></tr>";
        echo "<tr><td class='p-2'>No.Number: </td><td class='p-2'>".$row['CustomerIC']."</td></tr>";
        echo "<tr><td class='p-2'>E-mail: </td><td class='p-2'>".$row['CustomerEmail']."</td></tr>";
        echo "<tr><td class='p-2'>Mobile Number: </td><td class='p-2'>".$row['CustomerPhone']."</td></tr>";
        echo "<tr><td class='p-2'>Gender: </td><td class='p-2'>".$row['CustomerGender']."</td></tr>";
        echo "<tr><td class='p-2'>Address: </td><td class='p-2'>".$row['CustomerAddress']."</td></tr>";
        echo "<tr><td class='p-2'>Date: </td><td class='p-2'>".$row['DatePurchase']."</td></tr>";
        echo "</blockquote>";

        $sql = "SELECT customer.CustomerName, customer.CustomerIC, customer.CustomerGender, customer.CustomerAddress, customer.CustomerEmail, customer.CustomerPhone, book.BookTitle, book.Price, book.Image, `order`.`DatePurchase`, `order`.`Quantity`, `order`.`TotalPrice`
            FROM customer, book, `order`
            WHERE `order`.`CustomerID` = customer.CustomerID AND `order`.`BookID` = book.BookID AND `order`.`Status` = 'N' AND `order`.`CustomerID` = ".$cID."";
        $result = $conn->query($sql);
        $total = 0;
        while($row = $result->fetch_assoc()){
			echo "<tr><td class='border-t-2 border-gray-300 p-2'>";
			echo "<img src='".$row["Image"]."' class='w-1/5'></td><td class='border-t-2 border-gray-300 p-2'>";
			echo $row['BookTitle']."<br>RM".$row['Price']."<br>";
			echo "Quantity: ".$row['Quantity']."<br>";
			echo "</td></tr>";
			$total += $row['TotalPrice'];
		}
		
        echo "<tr><td class='bg-gray-200'></td><td class='text-right bg-gray-200 p-2'>Total Price: <b>Rs".$total."</b></td></tr>";
        echo "</table>";
        echo "</div>";

        $sql = "UPDATE `order` SET Status = 'y' WHERE CustomerID = ".$cID."";
        $conn->query($sql);
    }

    if(!isset($_SESSION['id'])){
        echo "<form method='post' class='max-w-lg mx-auto p-6 bg-white rounded-lg shadow-lg'>";
        echo 'Name:<br><input type="text" name="name" class="border-2 border-gray-300 p-2 rounded-md w-full mt-2" placeholder="Full Name">';
        echo '<span class="error text-red-600 text-sm"><?php echo $nameErr;?></span><br><br>';

        echo 'IC Number:<br><input type="text" name="ic" class="border-2 border-gray-300 p-2 rounded-md w-full mt-2" placeholder="xxxxxx-xx-xxxx">';
        echo '<span class="error text-red-600 text-sm"><?php echo $icErr;?></span><br><br>';

        echo 'E-mail:<br><input type="text" name="email" class="border-2 border-gray-300 p-2 rounded-md w-full mt-2" placeholder="example@email.com">';
        echo '<span class="error text-red-600 text-sm"><?php echo $emailErr;?></span><br><br>';

        echo 'Mobile Number:<br><input type="text" name="contact" class="border-2 border-gray-300 p-2 rounded-md w-full mt-2" placeholder="012-3456789">';
        echo '<span class="error text-red-600 text-sm"><?php echo $contactErr;?></span><br><br>';

        echo '<label>Gender:</label><br>';
        echo '<input type="radio" name="gender" value="Male">Male';
        echo '<input type="radio" name="gender" value="Female">Female';
        echo '<span class="error text-red-600 text-sm"><?php echo $genderErr;?></span><br><br>';

        echo '<label>Address:</label><br>';
        echo '<textarea name="address" cols="30" rows="5" class="border-2 border-gray-300 p-2 rounded-md w-full mt-2" placeholder="Address"></textarea>';
        echo '<span class="error text-red-600 text-sm"><?php echo $addressErr;?></span><br><br>';
        ?>
        <input class="bg-blue-900 text-white py-2 px-6 rounded-lg cursor-pointer hover:bg-blue-400" type="button" name="cancel" value="Cancel" onClick="window.location='index.php';" />
        <?php
        echo '<input class="bg-blue-900 text-white py-2 px-6 rounded-lg cursor-pointer hover:bg-blue-400" type="submit" name="submitButton" value="CHECKOUT">';
        echo '</form><br><br>';
    }
    ?>
</body>
</html>
