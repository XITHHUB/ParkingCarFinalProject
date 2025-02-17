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

    <!-- Heors -->
    <div class="container col-xxl-8 px-5 py-0" id="Home">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
      <div class="col-10 col-sm-8 col-lg-6">
        <img src="../Web/image/S__4579334-removebg-preview.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
      </div>
      <div class="col-lg-6">
        <h1 class="display-5 fw-bold lh-1 mb-3">สวัสดีผู้ใช่งาน, <?php if (isset($_SESSION['id'])) { echo $username; }; ?></h1>
        <p class="lead">ยินดีต้อนรับเข้าสู่หน้าเว็บไซต์ การจองที่จอดรถที่คุณสามารถจองที่จอดรถ ได้ในทันที่ไม่ว่าจะอยู่ไหนที่ไหนก็จองได้ และ การจองที่จอดรถนี้จะทำให้คุณสะดวกสบายมากขึ้น</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
          <a href="../Web/jong.php"><button type="button" class="btn btn-primary btn-lg px-4 me-md-2">จองตอนนี้เลย</button></a>
          <a href="#Home"><button type="button" class="btn btn-outline-secondary btn-lg px-4">เพิ่มเติม</button></a>
        </div>
      </div>
    </div>
    </div>

    <!-- Futrues -->
    <div class="container px-4 py-5" id="icon-grid">
    <h2 class="pb-2 border-bottom">คุณสมบัติการทำงาน</h2>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 py-5" id="Features">
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#bootstrap"></use></svg>
        <div>
          <h4 class="fw-bold mb-0">Featured </h4>
          <p>Paragraph of text beneath the heading to explain the heading.</p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#cpu-fill"></use></svg>
        <div>
          <h4 class="fw-bold mb-0">Featured title</h4>
          <p>Paragraph of text beneath the heading to explain the heading.</p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#calendar3"></use></svg>
        <div>
          <h4 class="fw-bold mb-0">Featured title</h4>
          <p>Paragraph of text beneath the heading to explain the heading.</p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#home"></use></svg>
        <div>
          <h4 class="fw-bold mb-0">Featured title</h4>
          <p>Paragraph of text beneath the heading to explain the heading.</p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#speedometer2"></use></svg>
        <div>
          <h4 class="fw-bold mb-0">Featured title</h4>
          <p>Paragraph of text beneath the heading to explain the heading.</p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#toggles2"></use></svg>
        <div>
          <h4 class="fw-bold mb-0">Featured title</h4>
          <p>Paragraph of text beneath the heading to explain the heading.</p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#geo-fill"></use></svg>
        <div>
          <h4 class="fw-bold mb-0">Featured title</h4>
          <p>Paragraph of text beneath the heading to explain the heading.</p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#tools"></use></svg>
        <div>
          <h4 class="fw-bold mb-0">Featured title</h4>
          <p>Paragraph of text beneath the heading to explain the heading.</p>
        </div>
      </div>
    </div>
  </div>

    <!-- footer -->
    <div class="container py-1" id="About">
        <p class="pb-2 border-top text-center">Jongdee Powered by <a href="https://x.com/Xvasx3434" class="text-blue">@XvasX</a>.</p>
    </div>
</body>
</html>