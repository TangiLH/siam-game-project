<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<nav class="navbar navbar-expand-xl navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="../pages/">Siam</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <?php if(verifieAuth()): ?>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../pages/portail.php">Portail</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><?php echo $_SESSION["user"]["pseudo"]?></a>
        </li>
        <?php endif; ?>
      </ul>
      
          <?php if(verifieAuth()): ?>
          <?php if($_SESSION["user"]["estadmin"]) :?>
          <a class="btn btn-outline-dark" href="../pages/admin.php">Admin</a>&nbsp;&nbsp;&nbsp;&nbsp;
          <?php endif; ?>
          <?php endif; ?>
        <?php if(verifieAuth()): ?>
      <div class="dropdown-center">
  <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
  Dropdown Menu 
  </button>
  <ul class=" dropdown-menu">
    <li><form class="d-flex" method="post">
        <!-- <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"> -->
        <input class="dropdown-item" type="submit" name="logout" value="Log Out"></input>&nbsp;&nbsp;
      
      </form></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="../pages/profile.php">Change MDP</a></li>
  </ul>
</div><?php else: ?>
  <a class="btn btn-outline-light" href="../pages/login.php">Login</a>&nbsp;&nbsp;&nbsp;&nbsp;
<?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;

      
      <?php if(isset($_POST["logout"])){
        logout();
    }?>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
