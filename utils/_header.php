<?php
 session_start();
include 'utils/_dbConnect.php';
echo '<nav class="navbar navbar-expand-lg navbar-light bg-dark ">
<a class="navbar-brand text-light" href="index.php">Gaming-Forum</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button> 

<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav mr-auto">
    <li class="nav-item active">
      <a class="nav-link text-light" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="about.php">About</a>
    </li>
    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Categories
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
    $sql="SELECT * FROM `categories` LIMIT 3";
    $result=mysqli_query($connect,$sql);
    while($row=mysqli_fetch_assoc($result)){
      echo '<a class="dropdown-item" href="Threadlist.php?catid='.$row['category_id'].'">'.$row['category_name'].'</a>';
    }
    
    echo'</div>
    </li>
    <li class="nav-item">
    <a class="nav-link text-light" href="contact.php" tabindex="-1" >Contact</a>
    </li>
    </ul>
    <div class="mx-2 row">';
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
     echo'<form class="form-inline my-2 my-lg-0" action="/Php/Forum/search.php" method ="get">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
            <p class="text-light my-0 mx-2"> Welcome '.$_SESSION['useremail'].'</p>
            <a href="/Php/Forum/utils/_logout.php" class="btn btn-outline-success ml-2 ">Logout</a>
            </form> ';
            
  }
  else
  {
    echo'<form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <button class="btn btn-outline-success ml-2 " data-toggle="modal" data-target="#loginModal" >Login</button>
            <button class="btn btn-outline-success mx-2 " data-toggle="modal" data-target="#signupModal" >Signup</button>';
  }
echo'</div>
</div>
</nav>';
include 'utils/_signupModal.php';
include 'utils/_loginModal.php';
if (isset($_GET['signupsuccess'])&&$_GET['signupsuccess']=="true") {
  echo'<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Successfull signup!</strong> You can now login.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
if (isset($_GET['error'])=="Email already in use") {
  echo'<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
  <strong>Warning!</strong> Already an email exist with same name try new email or you had not filled the entries.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>';
}

?>