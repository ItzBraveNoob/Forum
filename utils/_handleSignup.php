<?php 
 $showError="false";
//  $blank="false";
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    include '_dbConnect.php';
    $user_email=$_POST['signupEmail'];
    $pass=$_POST['signupPassword'];
    $cpass=$_POST['CPassword'];
    // CHeck email exists

    $existSql="SELECT * FROM `users` WHERE user_email='$user_email'";
    $result=mysqli_query($connect,$existSql);
    $numRows=mysqli_num_rows($result);
    if ($numRows>0) {
        $showError="Email already in use";
       
    }
    else if ($user_email==""||$pass==""||$cpass=="") {
         $blank="true";
    }
    else
    {
        if ($pass==$cpass) {
            $hash=password_hash($pass,PASSWORD_DEFAULT);
            $sql="INSERT INTO `users` ( `user_email`, `user_pass`, `timestamp`) VALUES ( '$user_email', '$hash', current_timestamp())";
            $result=mysqli_query($connect,$sql);
            if ($result) {
                $showAlert=true;
                header("Location: /Php/Forum/index.php?signupsuccess=true");
                exit();
            }
            
        }
        else{
            $showError="Passwords do not match";
        }
    }
    header("Location: /Php/Forum/index.php?signupsuccess=false&error=$showError&blankfill=$blank");
}

?>