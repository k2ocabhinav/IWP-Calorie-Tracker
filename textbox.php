<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
            position: sticky;
            width: 100%;
            z-index: 100;
        }
        li{
            list-style: none;
            margin-bottom: 10px;
        }
        li:hover{
            background-color: #dee2e6;
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
        .error{
            background-color: red;
            color: white;
            width: 100%;
            font-size: 20px;
        }
        table, #autocomplete{
            width: 50vw;
            margin: auto;
        }
        .table{
            width: 50vw; !important;
        }
        #autocomplete input{
            width: 90%;
            margin-bottom: 20px;
            height: 50px;
        }
        tr{
            width:100%;
        }
        th{
            text-align: left;
        }
        .header{
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }
        h1{
            text-align: center;
            font-size: 40px;
            margin: 10px;
        }
        .grouping{
            display: flex;
            justify-content: space-between;
        }
        #submit{
            height: 50px;
        }
        .x:hover{
            cursor: pointer;
        }
        #food_list{
            text-align: left;
            width: 50vw;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><?php echo "USER". $_SESSION['user_id']?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Book an appointment</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="datewise.php">View Report</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<h1><?php echo $_POST["daterec"] ?></h1>
<?php
if (session_status() != PHP_SESSION_NONE) 
{   
    $drec =  $_POST["daterec"];
    if(!isset($_SESSION['user_id'])) die('<div class="erorr">Aww Snap! Something seems to have gone wrong at our end. Please try again later</div>');
    $conn = mysqli_connect("localhost", "root", "root", "project");
    if(!$conn) die(mysqli_connect_error());
    else
    {
        $id = (int)$_SESSION['user_id'];
        $query = "Select name from customer where id = $id";
        if(!$result=mysqli_query($conn, $query)) die("Please try again later");
    }
}
?>
<div id="autocomplete">
        <div class="grouping">
            <input type="text" class="form-control" name="item" id="item" placeholder="Enter the food item">
            <button type="button" class="btn btn-light" id="submit">Add</button>
        </div>
        <div id="food_list"></div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Food Item</th>
                <th>Carbhydrates</th>
                <th>Fats</th>
                <th>Proteins</th>
                <th>Calories</th>
                <th>Remove Field</th>
            </tr>
        </thead>
        <tbody id="here">
        </tbody>
    </table>
</body>
<script>
    var drc = <?php echo "'".$drec."'"?>;
    var uid = <?php echo $_SESSION['user_id'] ?>;
    $(document).ready(function(){

        $(window).on('load', function(){
            $.ajax({
                    url: "load_items.php",
                    method: "POST",
                    data: {'b': 1, 'uid': uid,  'dateOfRecord':drc},
                    success: function(data)
                    {
                        console.log(data);
                        $("#here").append(data);
                    }
                });
            });
        $("#item").keyup(function()
        {
            var item = $(this).val();
            if(item!='')
            {
                $.ajax({
                    url: "load_items.php",
                    method: "POST",
                    data: {'fooditem': item},
                    success: function(data)
                    {
                        $("#food_list").fadeIn("fast").html(data);
                    }
                });
            }
            else
            {
                $("#food_list").fadeOut();
            }
        });
        $(document).on('click', '#food_list li', function(){
            $("#item").val($(this).text());
            $("#food_list").fadeOut();
        });
        $("#submit").on('click', function(e)
        {
            var fditem = $("#item").val();
            if(fditem!='')
            {
                $.ajax({
                    url: "load_items.php",
                    method: "POST",
                    data: {'fditem': fditem, 'uid': uid,  'dateOfRecord':drc},
                    success: function(data)
                    {
                        data = JSON.parse(data);
                        fname = data['name'];
                        cal = 4*data['carb']+9*data['fats']+4*data['protein']
                        ht = `<tr><td>${data['name']}</td><td>${data['carb']}</td><td>${data['fats']}</td><td>${data['protein']}</td><td>${cal}</td><td class='x'>Remove</td></tr>`;
                        $("#here").append(ht);
                    }
                });
            }
        });
        $(document).on('click', 'td.x', function(){
            var dltitem = $(this).closest('tr').find('td:first').text();
            $.ajax({
                    url: "load_items.php",
                    method: "POST",
                    data: {'dltitem': dltitem, 'uid': uid,  'dateOfRecord':drc},
                    success: function(data)
                    {
                        console.log(data)
                    }
                });
                $(this).parent().remove();

        });
    });
</script>
</html>