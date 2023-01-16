<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 20px;
        }
        .front{
            background-image: url('./front.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            width: 100vw;
            height: 100vh;
            position: relative;
        }
        nav{
            background-color: white;
            display: flex;
            justify-content: flex-end;
            /* position: fixed; */
            width: 100%;
            z-index: 100;
        }
        ul{
            margin: 0 10px;
            padding: 10px;
            display: flex;
            justify-content: end;
            list-style: none;
        }
        li{
            margin-left: 20px;
        }
        a{
            color: black;
            text-decoration: none;
        }
        .ontop{
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0px;
            background-color: rgba(165, 218, 200, 0.247);
            color: white;
            font-size: 150px;
            font-weight: 1000;
        }
        h1{

        }
    </style>
</head>
<body>
<?php
session_start();
session_unset();
session_destroy();
    echo"<nav><ul><li><a href='./login.php'>Login</a></li><li><a href='./signup.php'>Signup</a></li><li><a href='#contact'>Contact Us</a></li><li><a href='#about'>About Me</a></li></ul></nav><h1>You have been logged out.</h1>";
?>  
</body>
</html>