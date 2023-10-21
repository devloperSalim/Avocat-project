<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>you forgot a password >>!</title>
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/style.css">
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/bootstrap.min.css">
    <style>
        body
        {
            background: #ccc;
        }
        .content
        {
            width: 50%;
        }
        .content table tr td input {
            width: 100%;
            padding: 7px;
            text-align: center;
            border-radius:6px ;
        }
    </style>
</head>
<body>
<?php 
try{
    if (!empty($_POST["UserName"]) && !empty($_POST["email"])) {
        $pdo = new PDO('mysql:host=localhost;dbname=avocat', 'root', '');
    $sql = $pdo->prepare('SELECT * FROM admin ');
    $sql->execute();
    $admin = $sql->fetch(PDO::FETCH_ASSOC);
    if ($admin["email"]===trim($_POST["email"]) && $admin["nom_admin"]===trim($_POST["UserName"])) { 
        header("location:Edit.php?cin_admin=".$admin["cin_admin"]);
    }
    
    }
    
}
catch(Exception $e){
    echo`error for server !`;
}
    ?>

    <div class="secetion-ifo">
        <div class="content">
        <h1>completed les etape : </h1>
        <br>
        <form action="" method="post">
            <table class="table mt-1">
                <tr>
                    <th>User Name :</th>
                    <td><input type="text" name="UserName" id="UserName" require></td>
                </tr>
                <tr>
                    <th>Your Email :</th>
                    <td><input type="email" name="email" id="email" require></td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="submit" class="btn btn-primary">
                    </td>
                    </form>
                    <td>
                        <button type="button" class="back btn btn-danger" id="RT" >retour</button>
                    </td>
                </tr>
            </table>
        
        </div>
    </div>
    <script> 
        let retour = document.getElementById("RT");
            retour.addEventListener('click',()=>{
                history.back() 
            })
            
    </script>
</body>
</html>