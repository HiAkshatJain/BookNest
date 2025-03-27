<?php
if (isset($_GET['errcode'])) {
    $errorMessages = [
        1 => 'Invalid username or password. Please try again.',
        2 => 'Please login.'
    ];

    $errcode = intval($_GET['errcode']);
    if (array_key_exists($errcode, $errorMessages)) {
        $errorMessage = $errorMessages[$errcode];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

    <div class="max-w-sm mx-auto mt-12 p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-center mb-4">Login</h1>
        
        <form action="checklogin.php" method="post">
            <div class="mb-4">
                <label for="username" class="block text-lg">Username</label>
                <input type="text" name="username" id="username" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-6">
                <label for="pwd" class="block text-lg">Password</label>
                <input type="password" name="pwd" id="pwd" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <?php if (isset($errorMessage)) : ?>
                <div class="mb-4 text-red-500 text-sm text-center">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>

            <div class="flex justify-between">
                <input type="submit" value="Login" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none">
                <input type="button" value="Cancel" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none" onclick="window.location='index.php';">
            </div>
        </form>
    </div>
</body>
</html>
