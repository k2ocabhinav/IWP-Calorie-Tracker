<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   
    <link rel="stylesheet" href="./signlog.css">
   
    <style>
        .success_msg{
            background-color: green;
        }
        .err_msg{
            background-color: red;
        }
        .notice{
            position: absolute;
            top: 0px;
            right: 0px;
            width: 100%;
            text-align: center;
            color: white;
        }
        .main2{
            position: relative;
        }
    </style>
</head>
<body>
    <div class="main1">
    </div>
    <div class="main2">
            <?php
    $conn = mysqli_connect("localhost", "root", "root", "project");
    echo "";
    if(!$conn) die($mysqli_connect_error());
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
            $usere = $_POST['email'];
            $usern = $_POST['name'];
            $userp = $_POST['password'];
            $userg = $_POST['gender'];
            $query = "SELECT COUNT(id) as cnt FROM Customer where email like '". $usere ."'";
            if (mysqli_num_rows($result = mysqli_query($conn, $query))>0)
            { 
                $res = mysqli_fetch_assoc($result)['cnt'];
                if($res==1)
                    echo "<div class='notice err_msg'>Account already exists.</div>";
                else
                {
                    $query = 'Insert into customer (gender, name, email, password, doj) values ("'.$userg.'","'.$usern.'","'.$usere.'","'.$userp.'", curdate())';
                    if(!mysqli_query($conn, $query)) echo "Fail";
                    else
                    {
                        echo "<div class='notice success_msg'>Successfully registered!!</div>";
                        header("Refresh: 2; Location:./login.php");
                    }
                }
            }
        }
?>
        <h1>CREATE AN ACCOUNT NOW</h1>
        <form action="" method="POST">
            <div class="field">
                <div id="eerror" class="error"></div>
                <h3>Email</h3>
                <input type="email" id="email" name="email">
            </div>
            <div class="field">
                <div id="perror" class="error"></div>
                <h3>Password</h3>
                <input type="password" id="password" name="password">
            </div>
            <div class="field">
                <div id="nerror" class="error"></div>
                <h3>Name</h3>
                <input type="name" id="name" name="name">
            </div>
            <div class="field">
                <h3>Gender</h3>
                <select name="gender" id="gender">
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>
            <div class="field ">
                <input type="submit" name="submit" value="Create my account" >
            </div>
        </form>
        <div class="msg">
            Already have an account? <br><a href="./login.php">Login Instead</a>
        </div>
    </div>
</body>
<script>
    const password = document.getElementById("password");
    const email = document.getElementById("email");
    const name = document.getElementById("name");
    function validate_email()
    {
        x = 1
        const list = email.classList;
        list.remove("correct");
        list.remove("wrong");
        const error = document.getElementById("eerror")
        error.innerHTML = '';
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (email.value.match(mailformat))
           list.add("correct");
        else
        {
            list.add("wrong");
            error.innerText = "Empty field or invalid email format";
            email.parentElement.append(error);
            x = 0
        }
        return x;
    }
    function validate_password()
    {
        x = 1
        const list = password.classList;
        list.remove("correct");
        list.remove("wrong");
        const error = document.getElementById("perror")
        error.innerHTML = '';
        var passformat = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
        if (password.value.match(passformat))
           list.add("correct");
        else
        {
            list.add("wrong");
            error.innerText = "Invalid Password Format. It must be between 6 to 20 characters and be a mix of uppercase and lowercase letters, digits and special charcaters";
            password.parentElement.append(error);
            x = 0
        }
        return x;
    }
    function validate_name()
    {
        x = 1
        const list = name.classList;
        list.remove("correct");
        list.remove("wrong");
        const error = document.getElementById("nerror")
        error.innerHTML = '';
        var nameformat = /^[A-Za-zÀ-ÿ ,.'-]+$/;
        if (name.value.match(nameformat))
           list.add("correct");
        else
        {
            list.add("wrong");
            error.innerText = "Name cannot have numbers. A single name is mandatory.";
            name.parentElement.append(error);
            x = 0
        }
        return x;
    }
    document.forms[0][0].addEventListener('keyup', validate_email)
    document.forms[0][1].addEventListener('keyup', validate_password)
    document.forms[0][2].addEventListener('keyup', validate_name)
    function validate()
    {
        if(validate_email() & validate_name() & validate_password())
            return false;
        else
            return true;
    }
</script>
</html>


