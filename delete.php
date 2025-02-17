<?php 
    session_start(); 
    if ($_SESSION['User'] != 'Admin') {
        header("Location: ../Web/homepage.php");
        exit;
    }
?>
<?php
if ( isset($_GET["Id"]) ) {
    $id = $_GET["Id"];
    try{
        $conn = new PDO("mysql:host=localhost;dbname=test", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch(PDOException $e) {
        echo "Connection failed : " . $e->getMessage();
    }
    $stmt = $conn->prepare("DELETE FROM `users` WHERE Id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
}
header("location: ../Web/backend.php");
exit;
?>