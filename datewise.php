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
            font-size: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body{
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }
        form{
            width: 8em;
            height: 10em;
            text-align: center;
            padding: 20px;
            border: 2px solid black;
            margin: 10px;
            position: relative;
        }
        .date{
            font-size: 2em;
        }
        .rem{
            font-size: 0.7em;
        }
        .cal{
            margin-top: 10px;
        }
        input[type='submit']
        {
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
            border: none;
            background-color: grey;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <?php
        session_start();
        $user_id = $_SESSION['user_id'];
        $conn = mysqli_connect("localhost", "root", "root", "project") or die(mysqli_connect_error());
        $query = "Select doj from customer where id = $user_id";
        $doj = mysqli_fetch_assoc($result = mysqli_query($conn, $query))['doj'];
        while(1==1)
        {
            $day=date("j",strtotime($doj));
            $month=date("F",strtotime($doj));
            $year=date("Y",strtotime($doj));
            $output = "";
            $query = "select sum((food.carb*4+food.fats*9+food.protein*4)*records.qnty) as total from records, food where records.dfid=food.id and records.id=$user_id and records.dor = '$doj'";
            if (mysqli_num_rows($result=mysqli_query($conn,$query))>0)
            {
                while($row = mysqli_fetch_assoc($result))
                {
                    if(is_null($row['total']))
                        $output = "No records!!";
                    else
                        $output = $row['total'];
                }
            }
            $_SESSION['date'] = $doj;
            $html_text = "<form method='POST' action='textbox.php'>
            <div class='card'>
            <div class='date'>$day</div>
            <div class='rem'>$month, $year</div>
            <div class='cal'>$output</div>
            <input type='hidden' name='daterec' value=$doj />
            </div>
            <input type='submit' value='View' name='view$doj'>
            </form>";
            echo $html_text;
            $doj = date('Y-m-d', strtotime($doj . ' +1 day'));
            if(date('Ymd') == date('Ymd', strtotime($doj)-86400))
                break;
        }
?>
</body>
</html>