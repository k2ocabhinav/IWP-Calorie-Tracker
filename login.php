<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./signlog.css">
    <script src="./validate.js"></script>
    <style>
        .main1{
            background-image: url('./loginc.jpg');
        }
        .main2{
          position:relative;  
        }
        .notice{
            position: absolute;
            top: 0px;
            right: 0px;
            width: 100%;
            text-align: center;
            color: white;
        }
        .success_msg{
            background-color: green;
        }
        .err_msg{
            background-color: red;
        }
    </style>
</head>
<body>
    <div class="main1"></div>
    <div class="main2">
        <h1>LOGIN</h1>
        <form action="" method="POST">
            <div class="field">
                <h3>Email</h3>
                <input type="email" name="email" id="email">
            </div>
            <div class="field">
                <h3>Password</h3>
                <input type="password" name="password" id="password">
            </div>
            <div class="field">
                <input type="submit" value="Login">
            </div>
        </form>
        <div class="msg">
            Don't have an account? Make one for free now!
            <br>
            <a href="./signup.php">Signup</a>
            <?php
        $conn = mysqli_connect("localhost", "root", "root", "project");
        echo "";
        if(!$conn) die($mysqli_connect_error());
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $query = "SELECT id FROM Customer where email like '". $_POST['email'] ."'";
            if (mysqli_num_rows($result = mysqli_query($conn, $query))>0)
            {
                $queryf = "SELECT id FROM Customer where email like '". $_POST['email'] ."' and password like '". $_POST['password']."'";
                if (!mysqli_num_rows($result = mysqli_query($conn, $queryf))>0)
                echo '<div class="err_msg notice" onclick="this.remove()">Wrong Password!</div>';
                else
                {
                    $row = mysqli_fetch_assoc($result);
                    var_dump($row);
                    session_start();
                    $_SESSION['user_id'] = $row['id'];
                    header('Location:datewise.php');
                }
            }
            else
            echo '<div class="err_msg notice" onclick="this.remove()">This username does not exists</div>';
        }
        ?>
        </div>
    </div>
</body>
</html>