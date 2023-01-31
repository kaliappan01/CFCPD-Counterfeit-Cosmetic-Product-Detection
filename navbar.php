<nav class="navbar navbar-expand-lg navbar-dark" style="position: fixed; width: 100%;z-index: 20; background-color: #006466">
<a class="navbar-brand" href="checkproduct.php">
<img src="images/fibble.jpg" style="width: 70px;"> &nbsp
</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
    aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon" style="color: #4287f5;"></span>
  </button>

  <div class="collapse navbar-collapse" id="basicExampleNav">
    <ul class="navbar-nav mr-auto">

    <?php
    if ( isset( $_SESSION['role'] ) ){
    ?>
      <li class="nav-item">
        <a class="nav-link" href="checkproduct.php" style="color: white">Check Products</a>
      </li>
      <?php
      if ( $_SESSION['role']==1 ){
    ?>
      <li class="nav-item">
        <a class="nav-link" href="sell_product.php" style="color: white">Sell Product</a>
      </li>
    <?php
    }
    if ( $_SESSION['role']==0 ){
    ?>
      <li class="nav-item">
        <a class="nav-link" href="addproduct.php" style="color: white">Add Products</a>
      </li>
    <?php
        }if ( $_SESSION['role']==1 || $_SESSION['role']==0 ){
    ?>
      <li class="nav-item">
        <a class="nav-link" href="scanshipment.php" style="color: white">Scan Shipment</a>
      </li>
    <?php
    }
    }
    ?>
    <li class="nav-item">
    <a class="nav-link" id="aboutbtn" style="color: white"> About </a>
    </li>
    </ul>

    <form class="form-inline">
      <div class="md-form my-0">
        <a class="nav-link" href="logout.php" style="padding-left:5px;padding-right:5px;margin-left:0px;color: white"> Logout </a>
      </div>
    </form>

  </div>
</nav>

