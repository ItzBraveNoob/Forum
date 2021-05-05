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

    <!-- PHp to handle comment -->

    <?php
     $id=$_GET['threadid'];
     $method=$_SERVER['REQUEST_METHOD'];
$showAlert=false;
if($method=='POST'){
  $th_comment=$_POST['comment'];
  $sno=$_POST['sno'];
  $sql="INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_date`) VALUES ('$th_comment', '$id', '$sno', current_timestamp())";
  if ($th_comment=="") {
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
      <strong>Successfull!</strong> You successfully posted your solution.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>';
    }
  }
  
  
}
?>



    <!-- PHp to show Threads -->
    <?php
$id=$_GET['threadid'];
$sql="SELECT * FROM `threads` WHERE Thread_id='$id'";
$result=mysqli_query($connect,$sql);
while ($row=mysqli_fetch_assoc($result)) {
  $title=$row['Thread_title'];
  $desc=$row['Thread_desc'];

  $thread_userid=$row['Thread_user_id'];
  $sql2 = "SELECT * FROM `users` WHERE `sno`='$thread_userid'";
  $result2=mysqli_query($connect,$sql2);
  $row2=mysqli_fetch_assoc($result2);
  $posted_by=$row2['user_email'];
 
}
?>

    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo$title; ?></h1>
            <p class="lead"><?php echo$desc; ?></p>

            <hr class="my-4">
            <p><b> <?php echo "Posted by : $posted_by "; ?> </b></p>

        </div>
    </div>


    <!-- To input comment -->
    <?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
  echo'<div class="container">
          <h1 class="py-2">Post Comment</h1>
          <form action=" '.$_SERVER["REQUEST_URI"].'" method="post">
            <div class="form-group">
             <label for="exampleFormControlTextarea1" class="font-weight-bold">Give Resolution</label>
              <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
              <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
          </form>
        </div>';
}
else{
  echo'<div class="container">
  <h1 class="py-2">Post Comment</h1>
        <div class="alert alert-warning" role="alert">
        Please login to post a comment!
        </div>
        </div>';

}
?>


<div class="container">
<h1 class="py-2 my-2">Discussions</h1>

<?php
$id=$_GET['threadid'];
$sql="SELECT * FROM `comments` WHERE thread_id='$id'";
$result=mysqli_query($connect,$sql);
$noResult=true;
while ($row=mysqli_fetch_assoc($result)) {
    $noResult=false;
    $desc=$row['comment_content'];

    // Saving From xss attack
    $desc=str_replace("<","&lt",$desc);
    $desc=str_replace(">","&gt",$desc);

    $cat_time=$row['comment_date'];

    $comment_userid=$row['comment_by'];
    $sql2 = "SELECT * FROM `users` WHERE `sno`='$comment_userid'";
    $result2=mysqli_query($connect,$sql2);
    $row2=mysqli_fetch_assoc($result2);
    

    echo'
    <div class="media my-2">
  <img src="Images/default_image.jpeg" width="84px" class="mr-3" alt="...">
  <div class="media-body">
  <p class="font-weight-bold my-0"> Resolution By : '.$row2['user_email'].' at '.$cat_time.'</p>
    <p>'.$desc.'</p>
  </div>
</div>';
}
if ($noResult) {
    echo '<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-4">No Search Found !</h1>
      <p class="lead">Be the first person to answer the question.</p>
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