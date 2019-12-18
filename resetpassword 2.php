<?php
session_start();
if(isset($_SESSION['user_data'])){
    if(isset($_POST['oldp'])){
        if(isset($_POST['newp1'])){
            if(isset($_POST['newp2'])){
                $user_id = $_SESSION['user_data']['UserID'];
                // var_dump($_SESSION);
                $oldpwd = $_POST['oldp'];
                $newpwd1 = $_POST['newp1'];
                $newpwd2 = $_POST['newp2'];
                $link = mysqli_connect("localhost", "root", "", "wideworldimporters");
                $sql = "SELECT * FROM users WHERE UserID like ?";
                if($stmt = mysqli_prepare($link, $sql)){
                    mysqli_stmt_bind_param($stmt, "s", $param_term);
                    $param_term = $user_id;
                    if (mysqli_stmt_execute($stmt)) {
                        $login = 1;
                    } else {
                        $login = 0;
                    }
                }
                if($login == 1) {
                    if($newpwd1 == $newpwd2) {
                        $newpwd = password_hash($newpwd1, PASSWORD_DEFAULT);
                        $link2 = mysqli_connect("localhost", "root", "", "wideworldimporters");
                        $sql2 = "UPDATE users SET Password='$newpwd' WHERE UserID=$user_id";
                        // echo $sql2;
                        // echo "lol";
                        if(mysqli_query($link2, $sql2)){
                            header('Location: accountpage.php?pcs=1');
                        } else {
                            echo mysqli_error($link2);
                            // header('Location: accountpage.php?');
                        }
                    }
                }
            }
        }
    }
}

?>