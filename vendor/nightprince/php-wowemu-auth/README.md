# php-wowemu-auth

## Requirements

* PHP 7.1+
* Web server (ex. Apache or Nginx)
* CMaNGOS instance

## Installation

You can install the libary via composer:

``` bash
composer require nightprince/php-wowemu-auth
```

## Usage

### Register

First you'll want to use Composer's `autoloader`. Place this at the top of your script.

``` php
require_once __DIR__ . '/vendor/autoload.php';
use Laizerox\Wowemu\SRP\UserClient;
```

Next you'll need to create the verifier and salt values using the username and password which your user submitted on your registration form.

``` php
$client = new UserClient($username);
$salt = $client->generateSalt();
$verifier = $client->generateVerifier($password);
```

Once that is generated you'll just insert those values into the database to the `v` and `s` fields.

### Login

First you'll want to use Composer's `autoloader`. Place this at the top of your script.

``` php
require_once __DIR__ . '/vendor/autoload.php';
use Laizerox\Wowemu\SRP\UserClient;
```

Next you'll need to generate your "verifier". Think of this as the hashed version of the password your user put into the password field of you login form.

``` php
$client = new UserClient($username, $saltFromDatabase);
$verifier = strtoupper($client->generateVerifier($password));
```

Next you'll want to compare that value with the value stored in your CMaNGOS `realmd.account` table. You can see below for more of an example.

## Examples

### Register

This example goes over how a user can register via a web form.

``` php
<?php

/* register.php */

require_once __DIR__ . '/vendor/autoload.php';
use Laizerox\Wowemu\SRP\UserClient;

/* Connect to your CMaNGOS database. */
$db = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

/* If the form has been submitted. */
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    /* Grab the users IP address. */
    $ip = $_SERVER['REMOTE_ADDR'];
    
    /* Set the join date. */
    $joinDate = date('Y-m-d H:i:s');
    
    /* Set GM Level. */
    $gmLevel = '0';

    /* Set expansion pack - Wrath of the Lich King. */
    $expansion = '2';
    
    /* Create your v and s values. */
    $client = new UserClient($username);
    $salt = $client->generateSalt();
    $verifier = $client->generateVerifier($password);

    /* Insert the data into the CMaNGOS database. */
    mysqli_query($db, "INSERT INTO account (username, v, s, gmlevel, email, joindate, last_ip, expansion) VALUES ('$username', '$verifier', '$salt',  '$gmLevel', '$email', '$joinDate', '$ip', '$expansion')");
    
    /* Do some stuff to let the user know it was a successful or unsuccessful attempt. */
}    

?>
```

Now you'll obviously want to do some error checking and validation, but we'll leave that up to you.

``` html
<form action="/register" method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="email" name="email" placeholder="Email Address">
    <input type="password" name="password" placeholder="Password">
    <?php $register = sha1(time()); ?>
    <input type="hidden" name="register" value="<?php echo $register; ?>">
    <button type="submit">Register</button>
</form>
```

The above is a very basic HTML form for user registrations.

### Login

``` php
<?php

/* login.php */

require_once __DIR__ . '/vendor/autoload.php';
use Laizerox\Wowemu\SRP\UserClient;

/* Connect to your CMaNGOS database. */
$db = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

/* Function to get values from MySQL. */
function getMySQLResult($query) {
    global $db;
    return $db->query($query)->fetch_object();
}

/* If the form has been submitted. */
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    /* Get the salt and verifier from realmd.account for the user. */
    $query = "SELECT s,v FROM account WHERE username='$username'";
    $result = getMySQLResult($query);
    $saltFromDatabase = $result->s;
    $verifierFromDatabase = strtoupper($result->v);
    
    /* Setup your client and verifier values. */
    $client = new UserClient($username, $saltFromDatabase);
    $verifier = strtoupper($client->generateVerifier($password));

    /* Compare $verifierFromDatabase and $verifier. */
    if ($verifierFromDatabase === $verifier) {
        /* Do your login stuff here, like setting cookies/sessions... */
    }
    else {
        /* Do whatever you wanna do when the login has failed, send a failure message, redirect them to another page, etc... */
    }

?>
```

Again, you'll want to add in your own error checking and validation but this should get you started.

``` html
<form action="/login" method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <?php $login = sha1(time()); ?>
    <input type="hidden" name="login" value="<?php echo $login; ?>">
    <button type="submit">Sign In</button>
</form>
```

The above is a very basic HTML form for user logins.

If you find any defects when using the library please open a new issue in this repository. If you need further assistance we can try assising you in the `#offtopic` channel of [the CMaNGOS Discord server](https://discord.gg/Dgzerzb).
