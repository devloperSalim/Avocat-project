<?php
    $CIN=$_POST['cin'];
    try {
        
    
    $pdo = new PDO('mysql:host=localhost;dbname=avocat','root','');

    $sql = " DELETE  FROM `client` WHERE cin_client = ?";
     $stmt = $pdo->prepare($sql);
     // Execute the statement with the provided values
     $stmt->execute([$CIN]);

     header('Location: client.php');
    } catch (Exception $E) {
        echo $E->getMessage();
        
    }
?>