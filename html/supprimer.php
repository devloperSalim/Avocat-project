<?php
    $id=$_POST['id'];
    $CIN=$_POST['CIN'];
     // Connect to the database
     $pdo = new PDO('mysql:host=localhost;dbname=avocat','root','');

     $sql = " DELETE  FROM `dossier` WHERE cin = ? AND num_dossier= ?";
     $stmt = $pdo->prepare($sql);
     // Execute the statement with the provided values
     $stmt->execute([$CIN,$id]);
        if($stmt){
            echo 200;
        }
        else{
            echo 500;
        }
    //  header('Location: infoclient.php?id='.$CIN);
     exit();
     
?>