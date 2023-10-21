<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/style.css">
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/font-awesome-pro-v6-6/css/all.min.css">
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/bootstrap.min.css">
    <style>
        body {
            
            background: url('http://localhost/SiteAvocat/image/juger-marteau-avocats-justice-documents-objet-travaillant-table_28283-731.jpg') no-repeat;
            background-position: center;
            background-size: cover;
        }
        .container
        {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center; 
        }
    </style>
</head>
<body>
    <?php 
        if(isset($_POST['login'])){
            $userName = $_POST['UserName'];
            $password = $_POST['password'];

            if(!empty($userName) && !empty($password)){
                $pdo = new PDO('mysql:host=localhost;dbname=avocat','root','');
                $sql = $pdo->prepare('SELECT * FROM admin WHERE nom_admin=? AND password=?');
                $sql->execute([$userName, $password]);

                if($sql->rowCount() >= 1){
                    // Connection successful
                    session_start();
                    $_SESSION['admin'] = $sql->fetch(PDO::FETCH_ASSOC);
                    header('Location: home.php');
                    exit();
                } else {
                    echo "<div class='alert alert-info'>Login or password incorrect.</div>";
                }
            } else {
                echo "<div class='alert alert-info'>All fields are required.</div>";
            }
        }
    ?>
    <div class="container">
    <div class="container1">
        <form action="" method="post">
            <h1>Login</h1>
            <div class="box">
                <span class="icon"><i class="fa fa-user fa-regular"></i></span>
                <input type="text" name="UserName" id="userName">
            </div>
            <div class="box">
                <span class="icon"><i class="fa fa-regular fa-lock"></i></span>
                <input type="password" name="password" id="pass">
            </div>
            <div class="box"> 
                <input type="submit" name="login" value="Login">
            </div>
            <div class="box_b">
                <span>
                    <input type="checkbox" name="Remember" id="Btn_check">
                    <label for="Btn_check">Remember Me</label>
                </span>
                <span>
                    <a href="Forgot_P.php">Forgot Password?</a>
                </span>
            </div>
        </form>
    </div>
    </div>
</body>
</html>
