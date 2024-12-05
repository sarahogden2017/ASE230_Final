<?php
  session_start();

  // continue as guest
  if (isset($_POST['guest'])) {
    $_SESSION['username'] = 'guest';
    header("Location: ./post/index.php");
  }
?>

<html>
  <!--This will be where the user will be welcomed and asked to sign in, if they do not sign in they should only have access to /index.php and /detail.php-->
  <head>
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/journal/bootstrap.min.css">
  </head>

  <body>
    <div class="d-flex justify-content-center align-items-center">
      <h1 class="bg-primary text-white p-3 w-100">Creative Writing Forum</h1>
    </div>
    <div class="container justify-content-center align-items-center">
      <!-- Sign in, sign up, or continue as guest -->
      <h2>SIGN IN</h2>
      <form action="login_scripts/sign_in.php" method="post">
        <input type="text" name="username_signin" placeholder="Username" required>
        <input type="password" name="password_signin" placeholder="Password" required>
        <input type="submit" value="Sign In" class="btn btn-success">
      </form>
      <h2>SIGN UP</h2>
      <form action="login_scripts/sign_up.php" method="post">
        <input type="text" name="username_signup" placeholder="Username" required>
        <input type="password" name="password_signup" placeholder="Password" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="submit" value="Sign Up" class="btn btn-success">
      </form>
      <form action="" method="post">
        <input type="submit" value="Continue as Guest" name="guest" class="btn btn-danger">
      </form>
    </div>
  </body>
</html>
