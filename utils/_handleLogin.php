<?php
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    include '_dbConnect.php';
    $email=$_POST['loginEmail'];
    $pass=$_POST['loginPass'];
    
    // CHeck email exists

    $sql="SELECT * FROM `users` WHERE user_email='$email'";
    $result=mysqli_query($connect,$sql);
    $numRows=mysqli_num_rows($result);
    if ($numRows==1) {
        $row=mysqli_fetch_assoc($result);
            if (password_verify($pass,$row['user_pass'])) {
                session_start();
                $_SESSION['loggedin']=true;
                $_SESSION['useremail']=$email;
                $_SESSION['sno']=$row['sno'];
                echo "logged in ".$email;
            }
            header("Location: /Php/Forum/index.php");   
    }
    header("Location: /Php/Forum/index.php");
}
   
?>