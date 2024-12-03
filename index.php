<?php
  session_start();
  $message = "";
  
  // sign in
  if (isset($_POST['username_signin']) && isset($_POST['password_signin'])) {
    $username = $_POST['username_signin'];
    $password = $_POST['password_signin'];
    $f = fopen("users.csv", "r");
    while ($line = fgetcsv($f)) {
      if ($line[0] == $username && $line[1] == $password) {
        $_SESSION['username'] = $username;
        header("Location: ./post/index.php");
        exit();
      }
      elseif ($line[0] == $username && $line[1] != $password) {
        $message = "Incorrect password.";
        break;
      }
      else {
        $message = "User not found.";
      }
    }
    fclose($f);
  }

  // sign up
  if (isset($_POST['username_signup']) && isset($_POST['password_signup'])) {
    $username = $_POST['username_signup'];
    $password = $_POST['password_signup'];
    $f = fopen("users.csv", "a+");
    $user_exists = false;
    while ($line = fgetcsv($f)) {
      if ($line[0] == $username) {
        $user_exists = true;
        $message = "User already exists.";
        break;
      }
    }
    if (!$user_exists) {
      fputcsv($f, [$username, $password]);
      fclose($f);
      $message = "User created, please sign in.";
    }
  }

  // form validation
  if (isset($_POST['username_signin']) && !isset($_POST['password_signin'])) {
    $message = "Please enter a password.";
  }
  if (isset($_POST['username_signup']) && !isset($_POST['password_signup'])) {
    $message = "Please enter a password.";
  }
  if (isset($_POST['password_signin']) && !isset($_POST['username_signin'])) {
    $message = "Please enter a username.";
  }
  if (isset($_POST['password_signup']) && !isset($_POST['username_signup'])) {
    $message = "Please enter a username.";
  }

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
      <form action="" method="post">
        <input type="text" name="username_signin" placeholder="Username">
        <input type="password" name="password_signin" placeholder="Password">
        <input type="submit" value="Sign In" class="btn btn-success">
      </form>
      <h2>SIGN UP</h2>
      <form action="" method="post">
        <input type="text" name="username_signup" placeholder="Username">
        <input type="password" name="password_signup" placeholder="Password">
        <input type="submit" value="Sign Up" class="btn btn-success">
      </form>
      <form action="" method="post">
        <input type="submit" value="Continue as Guest" name="guest" class="btn btn-danger">
      </form>
    </div>
  </body>

  <script>
    var message = "<?php echo $message; ?>";
    if (message) {
      alert(message);
    }
  </script>
</html>
