<?php 
    session_start([
        'cookie_lifetime' => 300,    // 5min
    ]);

    $error = false; 

  // Login setup with username & password
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $fp = fopen("./data/users.txt", "r");
    if($username && $password){
        $_SESSION['loggedin'] = false;
        $_SESSION['user']     = false;
        $_SESSION['role']     = false;
        while($data = fgetcsv($fp)){
            if($data[0] == $username && $data[1] == sha1($password)){
                $_SESSION['loggedin'] = true;
                $_SESSION['user']     = $username;
                $_SESSION['role']     = $data[2];
                header('location:index.php');
            }
        }
        if(!$_SESSION['loggedin']){
            $error = true;
        }
    }
    

    // Logout destroy code
    if(isset($_GET['logout'])){
        $_SESSION['loggedin'] = false;
        $_SESSION['user']     = false;
        $_SESSION['role']     = false;
        session_destroy();
        header('location:index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/milligram.css" type="text/css" />
    <link rel="stylesheet" href="css/normalize.css" type="text/css" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
    <!-- Header Area Start -->
    <header class="header_area"> 
        <div class="contianer"> 
         <marquee>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum accusantium adipisci tempore qui mollitia dolorum impedit consequatur, architecto libero ullam! Ea cupiditate aut ipsum dicta, magnam dolor provident quidem corporis.</marquee>
        </div>
    </header>
    <!-- Header Area Stop -->

    <!-- Login Area Start -->
    <section class="crud_project"> 
        <div class="container"> 
            <div class="row"> 
                <div class="column column-60 column-offset-20"> 
                    <h2>Simple Auth Form</h2>
                    <p>
                        <?php 
                            if(true == $_SESSION['loggedin']){
                                echo "Hello Admin, Welcome!";
                            }else{
                                echo "Hellow Stranger, Login Below";
                            }
                        ?>
                    </p>
                </div>
            </div>

            <div class="row"> 
                <div class="column column-60 column-offset-20"> 
                  <?php 
                    if($error){
                        echo "<blockquote>User Name & Password didn't match</blockquote>";
                    }
                     if(false == $_SESSION['loggedin']): 
                   ?>
                    <form method="POST">
                        <label for="username">User Name</label>
                        <input type="text" name="username" id="username" />
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" /> <br> <br>
                        <button type="submit" class="button-primary" name="submit">Log IN</button>
                    </form>
                    <?php else: ?> 
                        <form action="auth.php" method="POST"> 
                            <input type="hidden" name="logout" value="1" />
                            <button type="submit" class="button-primary" name="submit">Log Out</button>
                        </form>
                  <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Area Stop -->

    <!-- Footer Area Stop -->
    <footer class="copyright_area"> 
        <div class="container"> 
            <p>Copyright &copy; <a href="https://www.facebook.com/w3sarwar">Golam Sarwar</a> | Reserved All Content 2023</p>
        </div>
    </footer>
    <!-- Footer Area Stop -->
</body>
</html>