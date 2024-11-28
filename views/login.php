<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../public/assets/css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<body>


    <form action="" method="">

        <h2>Login Page</h2>
        <label for="email">Email&nbsp;</label>
        <input type="email" id="email" name="email" placeholder="Email" value="" required>

        <label for="password">password&nbsp;:</label>
        <input type="password" id="password" name="password" placeholder="Password" required><br>

        <input type="hidden" name="csrf_token" value="">
        <input type="submit" value="Log In">
    </form>
</body>

</html>