<?php  include "query.php"; ?>

<html>
<body>
<form action="login.php" method="post">
    <fieldset>
        <legend style="color:gray"><b>Login</b></legend>

        <label><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="user_name" required>
        <br>

        <label><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>
        <br><br>

        <input type="button" name="Back" value="Back to home page" onclick= "location.href='index.php'">
        <input type="submit" name="Login" value="Login">
        <br><br><a href="register.php">Are you still not registered?</a>
    </fieldset>
</form>
</body>
</html>

<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $user = getUser($_POST['user_name']);

        if($user[0] == 0)
            echo "<script type='text/javascript'>alert('Wrong username!'); </script>";
        else
        {
            $user_type = getUserType($user[0]);
            print_r(md5($_POST['password']));
            if (md5($_POST['password']) == $user[4])
            {
                
                if($user_type == 'member' )
                {
                    $status = getMemberStatus($user[0]);

                    if($status[0] == "Blocked")
                    {
                        echo "<script type='text/javascript'>alert('This user\'s account has been blocked. Can not log in!');location.href='login.php'; </script>";
                    }
                    else
                    {
                        $_SESSION["user_id"] = $user[0];
                        $_SESSION["user_name"] = $_POST["user_name"];
                        $_SESSION["name"] = $user[1];
                        $_SESSION["surname"] = $user[2];
                        $_SESSION["user_type"] = getUserType($user[0]);

                        $action = $_POST["user_name"] . " has logged in.";
                       
                        addProcessingHistory($action);

                        echo '<script type="text/javascript">location.href="index.php";</script>';
                    }
                }
                else {
                    $_SESSION["user_id"] = $user[0];
                    $_SESSION["user_name"] = $_POST["user_name"];
                    $_SESSION["name"] = $user[1];
                    $_SESSION["surname"] = $user[2];
                    $_SESSION["user_type"] = getUserType($user[0]);
                    echo '<script type="text/javascript">location.href="index.php";</script>';
                }
            }
            else
                echo "<script type='text/javascript'>alert('Wrong password!'); </script>";
        }
    }
?>

