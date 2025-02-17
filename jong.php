<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"></link>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>homepage</title>
</head>
<body>
    <!-- Header -->
    <div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">

        <a href="../Web/homepage.php" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <img src="../Web/image/S__4579334-removebg-preview.png" class="img-fluid" alt="Responsive image" width="75" height="75">
        </a>
        
        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="#Home" class="nav-link px-2 link-secondary">Home</a></li>
            <li><a href="#Features" class="nav-link px-2 link-dark">Features</a></li>
            <li><a href="#About" class="nav-link px-2 link-dark">About</a></li>
        </ul>

        <?php
        
          try{
            $conn = new PDO("mysql:host=localhost;dbname=test", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
          } catch(PDOException $e) {
            echo "Connection failed : " . $e->getMessage();
          }
          
          if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
          }
        
          $stmt = $conn->prepare("SELECT * FROM `users` WHERE Id = :id");
          $stmt->bindParam(":id",$id);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
          if (isset($_SESSION['id'])) {
            $username = $result['Username'];
          }

        ?>

        <?php
          if (isset($_SESSION['id'])) { ?>
            <div class="col-md-auto text-end">
          <?php } else { ?>
            <div class="col-md-3 text-end">
          <?php }; ?>
            <?php 
                if ( !isset($_SESSION['valid']) ) { ?>
                <a role="button" class="btn btn-outline-primary me-2" href="../Web/login.php">Login</a>
                <a class="btn btn-primary" href="../Web/register.php" role="button">Sign-up</a>
            <?php } else { ?> 
                <a class="btn btn-light">Moeney : <?php echo $result['Money']; ?></a>
                <a class="btn btn-primary">เติมเงิน</a>
                <a class="btn btn-danger" href="../Web/logout.php" role="button">Logout</a>
            <?php } ;?>
        </div>
        </header>
    </div>

    <?php
        if(isset($_POST['submit'])) {
            $starttime = $_POST['starttime'];
            $enstime = $_POST['endtime'];
            $starth = explode(":",(string)$starttime)[0];
            $startmin = explode(":",(string)$starttime)[1];
            $endh = explode(":",(string)$enstime)[0];
            $endmin = explode(":",(string)$enstime)[1];
            $resulth = ((int)$endh - (int)$starth);
            $resultmin = ((int)$endmin - (int)$startmin);
            if ((int)$resulth < 0){
              (int)$resulth = 24 + abs((int)$resulth);
            } elseif ((int)$resultmin < 0) {
              (int)$resulth = $resulth - 1;
              (int)$resultmin = abs((int)$resultmin);
            }
            echo sprintf("Hours : %.2f , Money : %.2f", ((int)$resulth+(int)$resultmin/60), ((int)$resulth+(int)$resultmin/60)*10);
        } else {
    ?>
    <form class="row align-items-center justify-content-center" action="" method="post">
    <div class="col-lg-auto ml-auto">
    <h1 class="h3 mb-3 fw-normal text-center">กรุณากรอกข้อมูลเพื่อจองที่จอดรถ</h1>
    
    <div class="form-floating mb-3">
      <input type="date" class="form-control" id="floatingInput" name="starttime">
      <label for="floatingInput">วันที่จอง</label>
    </div>
    <div class="form-floating mb-3">
      <input type="time" class="form-control" id="floatingInput" name="starttime">
      <label for="floatingInput">เวลาที่เริ่มมาจอด</label>
    </div>
    <div class="form-floating mb-3">
      <input type="time" class="form-control" id="floatingPassword" name="endtime">
      <label for="floatingPassword">เวลาที่จอดสิ้นสุด</label>
    </div>
      <input type="submit" class="w-100 btn btn-lg btn-primary mb-5" name="submit" value="จองเลย" required>
    </div>
    </form>
    <?php } ?>

    <!-- footer -->
    <div class="container py-1" id="About">
        <p class="pb-2 border-top text-center">Jongdee Powered by <a href="https://x.com/Xvasx3434" class="text-blue">@XvasX</a>.</p>
    </div>
</body>
</html>