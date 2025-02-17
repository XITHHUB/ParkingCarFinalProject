<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" type="image/x-icon" href="/image/S__4579334-removebg-preview.png">
    <title>Register</title>
</head>
<body>
    <div class="bg">
        <div class="container">
            <div class="box form-box">
                <?php
                    try{
                        $conn = new PDO("mysql:host=localhost;dbname=test", "root", "");
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                    } catch(PDOException $e) {
                        echo "Connection failed : " . $e->getMessage();
                    }
                    if(isset($_POST['submit'])) {
                        $username = $_POST['username'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $stmt = $conn->prepare("SELECT * FROM users WHERE Username = :username");
                        $stmt->bindParam(":username", $username);
                        $stmt->execute();

                        $result = $stmt->fetch();

                        if($result){
                            echo "<div class='message'>
                            <p>This email is used, Try another One Please!</p>
                            </div> <br>";
                            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                        }else{
                            $money = 0;
                            $user = 'User';
                            $saved = $conn->prepare("INSERT INTO `users`(`Username`, `Email`, `Money`, `Password`, `Role`) VALUES (:username,:email,:money,:password,:role)");
                            $saved->bindParam(":username", $username, PDO::PARAM_STR);
                            $saved->bindParam(":email", $email, PDO::PARAM_STR);
                            $saved->bindParam(":money", $money, PDO::PARAM_INT);
                            $saved->bindParam(":password", $password, PDO::PARAM_STR);
                            $saved->bindParam(":role", $user, PDO::PARAM_STR);
                            $saved->execute();
                            echo "<div class='message'>
                            <p>Register Successfully!</p>
                            </div> <br>";
                            echo "<a href='login.html'><button class='btn'>Login</button>";
                        }   
                    }else{
                ?>
                <header>Register</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="">Username : </label>
                        <input type="text" name="username" id="username" autocapitalize="off" required placeholder="Username">
                    </div>
                    <div class="field input">
                        <label for="">Email : </label>
                        <input type="email" name="email" id="email" autocapitalize="off" required placeholder="Email or Username">
                    </div>
                    <div class="field input">
                        <label for="">Password : </label>
                        <input type="password" name="password" id="password" autocapitalize="off" required placeholder="Password">
                    </div>
                    <div class="field input">
                        <label for="">Comfrim Password : </label>
                        <input type="password" name="conpassword" id="conpassword" autocapitalize="off" required placeholder="Password">
                    </div>
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Login" required>
                    </div>
                    <div class="links">
                        Already Have Account. <a href="../Web/login.php">login now.</a>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
</html> 