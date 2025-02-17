<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" type="image/x-icon" href="/image/S__4579334-removebg-preview.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Login</title>
</head>
<body>
    <div class="bg">
        <div class="container">
            <div class="box form-box">
                <?php 

                $errorMessage = "";

                if(isset($_SESSION['valid'])){
                    header("Location: ../Web/homepage.php");
                    exit;
                }    

                try{
                    $conn = new PDO("mysql:host=localhost;dbname=test", "root", "");
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                } catch(PDOException $e) {
                    echo "Connection failed : " . $e->getMessage();
                }

                if( isset($_POST['submit']) ) {
                    $username = $_POST["email"];
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $stmt = $conn->prepare("SELECT * FROM `users` WHERE Email = :email || Username = :username");
                    $stmt->bindParam(":email",$email);
                    $stmt->bindParam(":username",$username);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if( is_array($result) && !empty($result) ) {
                        $_SESSION['valid'] = $result['Email'];
                        $_SESSION['username'] = $result['Username'];
                        $_SESSION['id'] = $result['Id'];
                        $_SESSION['User'] = $result['Role'];
                        header("Location: ../Web/homepage.php");
                        exit;
                    } else { ?>
                        <div class='message'>
                        <p>Wrong Username or Password</p>
                        </div> 
                        <br>
                        <a href='../Web/login.php'><button class='btn'>Go Back</button>
                    <?php }; 
                    
                } else { ?>
                <header>Login</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="">Email or Username : </label>
                        <input type="text" name="email" id="email" autocapitalize="off" required placeholder="Email or Username">
                    </div>
                    <div class="field input">
                        <label for="">Password : </label>
                        <input type="password" name="password" id="password" autocapitalize="off" required placeholder="Password">
                    </div>
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Login" required>
                    </div>
                    <div class="links">
                        Don't Have Account. <a href="../Web/register.php">Sign Up Now.</a>
                    </div>
                </form>
            </div>
        </div>
        <?php }; ?>
    </div>
</body>
</html>