<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Log in | Rate my Professor</title>
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
    <?php
    include_once('db_connect.php');
    include_once('links.html');
    include('nav.php');


    if (array_key_exists('redirect', $_SESSION)) {
        $lastPage = $_SESSION['redirect'];
    } else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
        $lastPage = $_SERVER['HTTP_REFERER'];
    } else {

        $lastPage = "http://cs.gettysburg.edu/~dhakam01/cs360/project/Bootstrap/index.php"; //TODO: dynamically figure out the home url
    }
    if (array_key_exists('login_failed', $_SESSION)) {
        $loginFailed = true;
        unset($_SESSION['login_failed']);
    } else {
        $loginFailed = false;
    }
    ?>
</head>

<body>

<div class="container">

    <form class="form-signin" method="POST" action="login-auth.php">
        <?php
        if ($loginFailed) {
            printf("<div class='alert alert-danger'> <strong>Login Failed !</strong> Username and Password you provided do not match.<br> Please try again.</div>");
        }
        if (array_key_exists('signup_success', $_SESSION)) {
            unset($_SESSION['signup_success']);
            printf("<div class='alert alert-success'> <strong>Sign up Successful !</strong> You have successfully signed up." .
                " Please use your username and password to log in.</div>");
        }

        // Test redirect from $_GET
        echo '<input type="hidden" name="location" value="';
        if(isset($_GET['location'])) {
            echo htmlspecialchars($_GET['location']);
        }
        if(isset($_GET['id'])) {
            echo "?id=" . htmlspecialchars($_GET['id']);
        }
        echo '" />';
        //  Will show something like this:
        //  <input type="hidden" name="location" value="course-review.php?id=1" />
        /************************************************/
        ?>
        
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="hidden" name="referer" value="<?php echo $lastPage; ?>">
        <input type="username" name='username' class="form-control" placeholder="Username" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p align="center"><a href="signup.php">Register</a> - <a href="#">Forgot Password</a></p>
    </form>

</div> <!-- /container -->

</body>
</html>
