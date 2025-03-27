<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNest</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <?php
    session_start();
    if(isset($_POST['ac'])){
        $servername = "localhost";
        $username = "root";
        $password = "";

        $conn = new mysqli($servername, $username, $password);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "USE bookstore";
        $conn->query($sql);

        $sql = "SELECT * FROM book WHERE BookID = '".$_POST['ac']."'";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()){
            $bookID = $row['BookID'];
            $quantity = $_POST['quantity'];
            $price = $row['Price'];
        }

        $sql = "INSERT INTO cart(BookID, Quantity, Price, TotalPrice) VALUES('".$bookID."', ".$quantity.", ".$price.", Price * Quantity)";
        $conn->query($sql);
    }

    if(isset($_POST['delc'])){
        $servername = "localhost";
        $username = "root";
        $password = "";

        $conn = new mysqli($servername, $username, $password);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "USE bookstore";
        $conn->query($sql);

        $sql = "DELETE FROM cart";
        $conn->query($sql);
    }

    $servername = "localhost";
    $username = "root";
    $password = "";

    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "USE bookstore";
    $conn->query($sql);

    $sql = "SELECT * FROM book";
    $result = $conn->query($sql);
    ?>

    <?php
    if(isset($_SESSION['id'])){
        echo '<header class="bg-white shadow-lg py-4">';
        echo '<div class="container mx-auto flex justify-between items-center px-6">';
        echo '<span class="flex-shrink-0  font-extrabold text-xl sm:text-2xl tracking-wide">BookNest</span>';
        echo '<div class="space-x-4">';
        echo '<form class="inline" action="edituser.php"><input class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300" type="submit" name="submitButton" value="Edit Profile"></form>';
        echo '<form class="inline" action="logout.php"><input class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300" type="submit" name="submitButton" value="Logout"></form>';
        echo '</div>';
        echo '</div>';
        echo '</header>';
    }

    if(!isset($_SESSION['id'])){
        echo '<header class="bg-white border py-4">';
        echo '<div class="container mx-auto flex justify-between items-center px-6">';
        echo '<span class="flex-shrink-0  font-extrabold text-xl sm:text-2xl tracking-wide">BookNest</span>';
        echo '<div class="space-x-4">';
        echo '<form class="inline" action="login.php"><input class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-300" type="submit" name="submitButton" value="Login"></form>';
        echo '<form class="inline" action="Register.php"><input class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300" type="submit" name="submitButton" value="Register"></form>';
        echo '</div>';
        echo '</div>';
        echo '</header>';
    }
    ?>

    <div class="container mx-auto py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Books Section -->
            <div class="col-span-2">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php while($row = $result->fetch_assoc()) { ?>
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <img src="<?php echo $row["Image"]; ?>" class="w-full h-56 object-cover" alt="Book Image">
                        <div class="p-4">
                            <h5 class="text-xl font-semibold text-gray-800"><?php echo $row["BookTitle"]; ?></h5>
                            <p class="text-gray-600 mt-2">ISBN: <?php echo $row["ISBN"]; ?></p>
                            <p class="text-gray-600">Author: <?php echo $row["Author"]; ?></p>
                            <p class="text-gray-600">Type: <?php echo $row["Type"]; ?></p>
                            <p class="text-lg font-bold text-gray-800">Rs<?php echo $row["Price"]; ?></p>
                            <form action="" method="post">
                                <div class="mt-4">
                                    <label for="quantity<?php echo $row['BookID']; ?>" class="text-sm text-gray-700">Quantity</label>
                                    <input type="number" class="border-2 border-gray-300 rounded-lg p-2 w-1/2 mt-2" name="quantity" id="quantity<?php echo $row['BookID']; ?>" value="1" min="1">
                                </div>
                                <input type="hidden" value="<?php echo $row['BookID']; ?>" name="ac"/>
                                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300 mt-4">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Cart Section -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    <i class="fa fa-shopping-cart text-2xl"></i> Cart
                    <form style="float:right;" action="" method="post">
                        <input type="hidden" name="delc"/>
                        <button type="submit" class="bg-red-500 text-white hover:bg-red-600 px-4 py-2 rounded-lg transition duration-300 text-sm">Empty Cart</button>
                    </form>
                </h2>
                <div class="space-y-4">
                    <?php
                    $sql = "SELECT book.BookTitle, book.Image, cart.Price, cart.Quantity, cart.TotalPrice FROM book, cart WHERE book.BookID = cart.BookID;";
                    $result = $conn->query($sql);
                    $total = 0;
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='flex items-center space-x-4'>";
                        echo "<img src='".$row["Image"]."' class='w-16 h-16 object-cover rounded-lg' alt='Book Image'>";
                        echo "<div>";
                        echo "<p class='text-gray-700 font-semibold'>".$row['BookTitle']."</p>";
                        echo "<p class='text-gray-600'>Rs ".$row['Price']." x ".$row['Quantity']."</p>";
                        echo "<p class='text-gray-700'>Total: Rs ".$row['TotalPrice']."</p>";
                        echo "</div>";
                        echo "</div>";
                        $total += $row['TotalPrice'];
                    }
                    ?>
                </div>
                <div class="mt-6 border-t-2 pt-4 text-right">
                    <p class="text-lg font-semibold text-gray-800">Total: <b>Rs<?php echo $total; ?></b></p>
                    <form action="checkout.php" method="post">
                        <button class="w-full bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition duration-300 mt-4">Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6 mt-10">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 BookNest. All rights reserved.</p>
            <div class="mt-4">
                <a href="https://www.facebook.com" class="text-gray-400 hover:text-white px-3"><i class="fa fa-facebook"></i></a>
                <a href="https://www.twitter.com" class="text-gray-400 hover:text-white px-3"><i class="fa fa-twitter"></i></a>
                <a href="https://www.instagram.com" class="text-gray-400 hover:text-white px-3"><i class="fa fa-instagram"></i></a>
            </div>
        </div>
    </footer>

</body>
</html>
