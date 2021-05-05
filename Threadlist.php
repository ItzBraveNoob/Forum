<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Coding-Forum</title>
</head>

<body>
    <?php include 'utils/_header.php';?>
    <?php include 'utils/_dbConnect.php';?>
<?php
$id=$_GET['catid'];
$sql="SELECT * FROM `categories` WHERE category_id='$id'";
$result=mysqli_query($connect,$sql);

while ($row=mysqli_fetch_assoc($result)) {
  
  $cat=$row['category_name'];
  $desc=$row['category_description'];
  
}

?>

<?php
$method=$_SERVER['REQUEST_METHOD'];
$showAlert=false;
if($method=='POST'){
  $th_title=$_POST['title'];
  $th_desc=$_POST['desc'];
  
  // Saving from php xss attack
  $th_title=str_replace("<","&lt",$th_title);
  $th_title=str_replace(">","&gt",$th_title);
  
  $th_desc=str_replace("<","&lt",$th_desc);
  $th_desc=str_replace(">","&gt",$th_desc);




  $sno=$_POST['sno'];
  $sql="INSERT INTO `threads` ( `Thread_title`, `Thread_desc`, `Thread_cat_id`, `Thread_user_id`, `Date`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
  if ($th_title==""|| $th_desc=="") {
    $blank=true;
  }
  else{
    $blank=false;
  }
  if ($blank) {
    echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Error Found!</strong> You have not filled the credentials.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
    
    
  }
  else{
    $result=mysqli_query($connect,$sql);
    $showAlert=true;
    if ($showAlert) {
      echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Successfull!</strong> You successfully entered your problem.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>';
    }
  }

  
}
?>


<div class="container my-3">
<div class="jumbotron">
  <h1 class="display-4">Welcome to Our <?php echo$cat; ?> Forum</h1>
  <p class="lead"><?php echo$desc; ?></p>
  <hr class="my-4">
  <p class="font-weight-bold">Answer Below</p>
  <!-- <a class="btn btn-success btn-lg" href="" role="button">Learn more</a> -->
</div>
</div>

<!-- Taking problem from the user using the form -->

<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
  echo'
  <div class="container">
  <h1 class="py-2">Start a Discussions</h1>
  <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Problem Title</label>
    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
    <small id="emailHelp" class="form-text text-muted">Keep the title small and point to point.</small>
    <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Define your issue</label>
    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
  </div>
  <button type="submit" class="btn btn-success">Submit</button>
</form>
</div>';
}
else {
  echo'<div class="container">
  <h1 class="py-2">Start a Discussions</h1>
        <div class="alert alert-warning" role="alert">
        Please login to post a question!
        </div>
        </div>';

}
?>

<div class="container">
<h1 class="py-2 my-2">Browse Questions</h1>

<?php
$id=$_GET['catid'];
$sql="SELECT * FROM `threads` WHERE Thread_cat_id='$id'";
$result=mysqli_query($connect,$sql);
$noResult=true;
while ($row=mysqli_fetch_assoc($result)) {
    $noResult=false;
  $id=$row['Thread_id'];
    $title=$row['Thread_title'];
    $desc=$row['Thread_desc'];
    $cat_time=$row['Date'];
    $thread_userid=$row['Thread_user_id'];
    $sql2 = "SELECT * FROM `users` WHERE `sno`='$thread_userid'";
    $result2=mysqli_query($connect,$sql2);
    $row2=mysqli_fetch_assoc($result2);


    echo'
    <div class="media my-2">
  <img src="Images/default_image.jpeg" width="84px" class="mr-3" alt="...">
  <div class="media-body">
  <p class="font-weight-bold my-0">Asked By : '.$row2['user_email'].' at '.$cat_time.'</p>
  <h5 class="mt-0"> <a class="text-dark" href="Thread.php?threadid='.$id.'">'.$title.'</a></h5>
  <p>'.$desc.'</p>
  </div>
</div>';

}
// echo var_dump($noResult);
if ($noResult) {
    echo '<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-4">No Result Found !</h1>
      <p class="lead">Be the first person to ask question .</p>
    </div>
  </div>';
}
?>

</div>

    <?php include 'utils/_footer.php';?>

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
</body>

</html>