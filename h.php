<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        table{
            border: 2px solid black;
        }
        #autocomplete input{
            width: 70%;
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
    </style>
</head>
<body>
<nav>
        <ul>
            <li><a href="./logout.php">Logout</a></li>
            <li><a href="./home.html">Home</a></li>
            <li><a href="#contact">Book an appointment</a></li>
            <li><a href="#about">Store</a></li>
        </ul>
</nav>
<?php
session_start();
if (session_status() != PHP_SESSION_NONE) 
{   
    // echo $_POST["daterec"];
    $drec =  $_POST["daterec"];
    // echo $drec;
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
        <input type="text" name="item" id="item" placeholder="Enter the food item">
        <button type="button" id="submit">Add</button>
        <div id="food_list"></div>
    </div>
    <table>
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
                        // $("#here").append(data);
                        console.log(data)
                        data = JSON.parse(data);
                        fname = data['name'];
                        cal = 4*data['carb']+9*data['fats']+4*data['protein']
                        console.log(data)
                        ht = `<tr><td>${data['name']}</td><td>${data['carb']}</td><td>${data['fats']}</td><td>${data['protein']}</td><td>${cal}</td><td class='x'>Remove</td></tr>`
                        $("#here").append(ht);
                    }
                });
            }
        });
        $(document).on('click', 'td.x', function(){

            var dltitem = $(this).closest('tr').find('td:first').text();
            console.log(dltitem);
            $.ajax({
                    url: "load_items.php",
                    method: "POST",
                    data: {'dltitem': dltitem, 'uid': uid,  'dateOfRecord':drc},
                    success: function(data)
                    {
                    }
                });
                $(this).parent().remove();

        });
    });
</script>
</html>