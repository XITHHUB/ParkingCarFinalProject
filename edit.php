<?php 
    session_start(); 
    if ($_SESSION['User'] != 'Admin') {
        header("Location: ../Web/homepage.php");
        exit;
    }
?>
<?php
try{
    $conn = new PDO("mysql:host=localhost;dbname=test", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
    echo "Connection failed : " . $e->getMessage();
}
$id = "";
$username = "";
$password = "";
$email = "";
$money = "";
$role = "";

$errorMessage = "";
$successMessage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'GET') {

    if ( !isset($_GET["Id"]) ) {
        header("location: ../Web/backend.php");
        exit;
    }

    $id = $_GET["Id"];

    $stmt = $conn->prepare("SELECT * FROM `users` WHERE Id = :id");
    $stmt->bindParam(":id",$id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if(!$result){
        header("location: ../Web/backend.php");
        exit;
    }

    $id = $result["Id"];
    $username = $result["Username"];
    $password = $result["Password"];
    $email = $result["Email"];
    $money = $result["Money"];
    $role = $result["Role"];

} else {

    $id = $_POST["id"];
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

        $update = $conn->prepare("UPDATE `users` SET `Username`=:name,`Email`=:email,`Money`=:money,`Password`=:password,`Role`=:role WHERE Id = :id");
        $update->bindParam(":id",$id);
        $update->bindParam(":name",$username);
        $update->bindParam(":email",$email);
        $update->bindParam(":money",$money);
        $update->bindParam(":password",$password);
        $update->bindParam(":role",$role);
        $update->execute();

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
            <input type="hidden" name="id" value="<?php echo $id; ?>">
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