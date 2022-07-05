<?php

    session_start();
    
    $error = "";

    if (array_key_exists('Logout', $_GET)) {
        setcookie('id', '', time() - 60*60*24*365);
        unset($_SESSION['id']);
        header("Location: index.php");
    } else if (array_key_exists("id", $_SESSION) || array_key_exists("id", $_COOKIE)) {
        header("Location: loggedin.php");
    }

    if(array_key_exists('submit', $_POST)) {

        include("connection.php");

        if(!$_POST['email']) {
            $error .= "An email address is required<br>";
        }
        if(!$_POST['password']) {
            $error .= "A password is required<br>";
        }
    }

    if ($error != "") {
        $error = "<p>There were error(s) in your form:</p>".$error;
    } else {

        if($_POST['signUp'] == '1') {
            $query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";

            $result = mysqli_query($link, $query);
            if (mysqli_num_rows($result) > 0) {
                $error = "That email address is taken.";
            } else {
                $password = $_POST['password'];
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $hashed_password)."')";
                if (!mysqli_query($link, $query)) {
                    $error = "Your sign up failed. Please try again.";
                } else {
                    $_SESSION['id'] = mysqli_insert_id($link);
                    if ($_POST['stayLoggedIn'] == '1') {
                        setcookie("id", mysqli_insert_id($link), time() + 60*60*24);
                    }
                    header("Location: loggedin.php");
                }
            } 
        } else {
            $password = $_POST['password'];
            $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_array($result);
            if (isset($row)) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['id'] = $row['id'];
                    if (isset($_POST['stayLoggedIn']) AND $_POST['stayLoggedIn'] == '1') {
                        setcookie("id", $row['id'], time() + 60*60*24);
                    }
                    header("Location: loggedin.php");
                } else {
                    $error = "That email/password combination is incorrect.";
                }
            } else {
                $error = "That email/password combination is incorrect.";
            }
        }
    }

?>


<?php include("header.php"); ?>
    <div class="container" id="homePageContainer">
    <h1>Secret Diary</h1>
    <p class="form-text"><strong>Store your thoughts permanently and access them whenever you want.</strong></p>
    <div id="error">
            <?php if($error != "") {
                echo '<div class="alert alert-danger" role="alert">
                    <p>'.$error.'</p>
              </div>';
            } ?>
    </div>
        <form method="post" id="signUpForm">
            <p>Interested? Sign Up now?</p>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Email Address">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="stayLoggedIn" value="1">
            <label class="form-check-label" for="stayLoggedIn">Stay logged in</label>
        </div>
            <input type="hidden" name="signUp" value=1>
            <button type="submit" class="btn btn-success" value="Sign Up" name="submit"> Sign Up </button>
            <p class="toggle"><a class="toggleForms">Log in</a></p>
        </form>
        <form method="post" id="logInForm">
            <p>Log In using your username and password.</p>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Email Address">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="stayLoggedIn" value="1">
            <label class="form-check-label" for="stayLoggedIn">Stay logged in</label>
        </div>
            <input type="hidden" name="signUp" value=0>
            <button type="submit" class="btn btn-success" value="Log In" name="submit"> Log In </button>
            <p class="toggle"><a class="toggleForms">Sign Up</a></p>
        </form>
    </div>
<?php include("footer.php"); ?>