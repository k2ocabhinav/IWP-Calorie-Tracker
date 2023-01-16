<?php
$conn = mysqli_connect("localhost", "root", "root", "project") or die(mysqli_connect_error);
if(isset($_POST['fooditem']))
{
    $search_term = $_POST['fooditem'];
    $query = "Select name from food where name like '%{$search_term}%'";
    $output = '<ul>';
    if(mysqli_num_rows($result=mysqli_query($conn, $query))>0)
    {
        while($row = mysqli_fetch_assoc($result))
            $output.='<li>'.$row['name'].'</li>';
    }
    else $output.='<li>Food item not found</li>';
    $output.='</ul>';
    echo $output;
}
if(isset($_POST['fditem']))
{
    $search_term = $_POST['fditem'];
    $query = "Select * from food where name like '$search_term'";
    $output = '';
    if(mysqli_num_rows($result=mysqli_query($conn, $query))>0) 
    {
        $output = mysqli_fetch_assoc($result);
        $u = $_POST['uid'];
        $d = $_POST['dateOfRecord'];
        $fd = $output['id'];
        $inn_query = "Select qnty from records where id=$u and dor='$d' and dfid = $fd";
        if(mysqli_num_rows($result2 = mysqli_query($conn, $inn_query))>0)
        {
            $output2 = mysqli_fetch_assoc($result2);
            $req = $output2['qnty'];
            $last = "update records set qnty=qnty+1 where  id=$u and dor='$d' and dfid = $fd";
            mysqli_query($conn, $last);
        }
        else
        {
            $last = "Insert into records values ($u, '$d', $fd, 1)";
            mysqli_query($conn, $last);
        }   
    }
    else $output.='<li>Food item not found</li>';
    echo json_encode($output);
}

if(isset($_POST['dltitem']))
{
    $search_term = $_POST['dltitem'];
    $u = $_POST['uid'];
    $d = $_POST['dateOfRecord'];
    $query = "Select id from food where name like $search_term";
    if(mysqli_num_rows($result=mysqli_query($conn, $query))>0) 
    {
        $output = mysqli_fetch_assoc($result);
        $fd = $output['id'];
        $last = "update records set qnty=qnty-1 where  id=$u and dor='$d' and dfid = $fd";
        if(mysqli_query($conn, $last)) echo "Sucess";
        else echo "Error3";
    }   
}
if(isset($_POST['b']))
{
    $u = $_POST['uid'];
    $d = $_POST['dateOfRecord'];
    $query = "select food.carb, food.fats, food.protein, food.name, records.qnty from records, food where records.dfid = food.id and records.id = $u and records.dor = '$d'";
    // echo $query;
    $output = '';
    if(mysqli_num_rows($result=mysqli_query($conn, $query))>0) 
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $carb = $row['carb'];
            $fats = $row['fats'];
            $pro = $row['protein'];
            $cal = 4*($carb+$pro)+9*($fats);
            $n = $row['name'];
            for($i=0; $i<$row['qnty']; $i++)
                $output.= "<tr><td>'$n'</td><td>$carb</td><td>$fats</td><td>$pro</td><td>$cal</td><td class='x'>Remove</td></tr>";
        }  
        echo $output;
    }
    // else echo "Error1"; 
}

