<?php 
    session_start(); 
    if ($_SESSION['User'] != 'Admin') {
        header("Location: ../Web/homepage.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"></link>
    <title>BackEnd</title>
</head>
<body>
    <div class="container my-5">
        <h2>ข้อมูลผู้ใช้งาน</h2>
        <a class="btn btn-primary" href="../Web/create.php" role="button">สร้างผู้ใช้งานใหม่</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Money</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    try{
                        $conn = new PDO("mysql:host=localhost;dbname=test", "root", "");
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                    } catch(PDOException $e) {
                        echo "Connection failed : " . $e->getMessage();
                    }
                    $stmt = $conn->prepare("SELECT * FROM `users`");
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                    foreach($result as $k) { ?>
                        <tr>
                            <td><?= $k['Id'];?></td>
                            <td><?= $k['Username'];?></td>
                            <td><?= $k['Password'];?></td>
                            <td><?= $k['Email'];?></td>
                            <td><?= $k['Money'];?></td>
                            <td><?= $k['Role'];?></td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="../Web/edit.php?Id=<?= $k['Id'];?>">Edit</a>
                                <a class="btn btn-danger btn-sm" href="../Web/delete.php?Id=<?= $k['Id'];?>">Delete</a>
                            </td>
                        </tr>
                   <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>