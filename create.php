<?php 
    session_start(); 
    if ($_SESSION['User'] != 'Admin') {
        header("Location: ../Web/homepage.php");
        exit;
    }
?>
<?php
$username = "";
$password = "";
$email = "";
$money = "";
$role = "";

$errorMessage = "";
$successMessage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST["name"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $money = $_POST["money"];
    $role = $_POST["role"];

    do {
        if ( empty($username) || empty($password) || empty($email) || empty($role) ) {
            $errorMessage = "มีช่องใดช่องหนึ่งยังไม่ครบ!";
            break;
        }

        try{
            $conn = new PDO("mysql:host=localhost;dbname=test", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $e) {
            echo "Connection failed : " . $e->getMessage();
        }
        
        $verify_username = $conn->prepare("SELECT * FROM users WHERE Username = :username");
        $verify_username->bindParam(":username", $username);
        $verify_username->execute();

        $verify_email = $conn->prepare("SELECT * FROM users WHERE Email = :email");
        $verify_email->bindParam(":email", $email);
        $verify_email->execute();

        $result_username = $verify_username->fetch();
        $result_email = $verify_email->fetch();

        if($result_username){
            $errorMessage = "ชื่อของคูณซ้ำโปรดใช้ชื่ออื่น!";
            break;
        }

        if($result_email){
            $errorMessage = "อีเมลของคูณซ้ำโปรดใช้อีเมลอื่น!";
            break;
        }

        $saved = $conn->prepare("INSERT INTO `users`(`Username`, `Email`, `Money`, `Password`, `Role`) VALUES (:username,:email,:money,:password,:role)");
        $saved->bindParam(":username", $username, PDO::PARAM_STR);
        $saved->bindParam(":email", $email, PDO::PARAM_STR);
        $saved->bindParam(":money", $money, PDO::PARAM_INT);
        $saved->bindParam(":password", $password, PDO::PARAM_STR);
        $saved->bindParam(":role", $role, PDO::PARAM_STR);
        $saved->execute();

        $username = "";
        $password = "";
        $email = "";
        $money = "";
        $role = "";

        $successMessage = "สร้างผู้ใช้งานสำเร็จ!";

        header("location: ../Web/backend.php");
        exit;

    } while (false);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"></link>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>สร้างผู้ใช้งานใหม่</h2>

        <?php
            if ( !empty($errorMessage) ) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><?php echo $errorMessage ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        <?php } ?>

        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name : </label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $username ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Password : </label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="password" value="<?php echo $password ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email : </label>
                <div class="col sm-6">
                    <input type="email" class="form-control" name="email" value="<?php echo $email ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Money : </label>
                <div class="col sm-6">
                    <input type="number" class="form-control" name="money" value="<?php echo $money ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Role : </label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="role" value="<?php echo $role ?>">
                </div>
            </div>
            
            <?php
            if ( !empty($successMessage) ) { ?>
                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-6">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><?php echo $successMessage ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="../Web/backend.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>