<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/font-awesome-pro-v6-6/css/all.min.css"> 
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/style.css">
</head>
<body>

<?php
    $pdo = new PDO('mysql:host=localhost;dbname=avocat', 'root', '');
    $sql = $pdo->prepare('SELECT * FROM admin');
    $sql->execute();
    $admin = $sql->fetch(PDO::FETCH_ASSOC);
    ?>


    <?php

use function PHPSTORM_META\type;


if(isset($_POST['ajouter'])){
    $num_dossier = $_POST['num'];
    $titre_dossier = $_POST['titre'];
    $date_create = $_POST['date_Create'];
    $date_Daudience = $_POST['date_Daudience'];
    $tribunal = $_POST['tribinal'];
    $dossier_pdf = $_FILES['dossier_Pdf']['name'];
    $cin = $_POST['cin'];
    $Eta_dossier = $_POST['etat_dossier']; 
    if(!empty($titre_dossier) && !empty($date_create) && !empty($date_Daudience) && !empty($tribunal) && !empty($dossier_pdf) && !empty($cin) && !empty($Eta_dossier)){
        // Connect to the database
        $pdo = new PDO('mysql:host=localhost;dbname=avocat','root','');

        // Prepare the SQL statement
        $sql = "INSERT INTO dossier (num_dossier, titre_dossier, date_creation, date_audience, tribinal, dossier_pdf, cin, etat_dossier) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        
        $allowdfileEXt=array('jpg','txt','xls','doc','png','zip','rar');
        $fileNameArr=explode('.',$_FILES['dossier_Pdf']['name']);
        $fileEXt=strtolower(end($fileNameArr));
        
        //Upload PDF dossier
        if(in_array($fileEXt,$allowdfileEXt)){
            if(move_uploaded_file($_FILES['dossier_Pdf']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."/SiteAvocat/PDFDoss/".$_FILES['dossier_Pdf']['name'])){
            
                // Execute the statement with the provided values
                $stmt->execute([$num_dossier, $titre_dossier, $date_create, $date_Daudience, $tribunal, $dossier_pdf, $cin, $Eta_dossier]);
            
                header('Location: ajouter.php'); // Redirect to the same page after the data is added
                exit();
            }
            else
            {
                echo "<div class='alert alert-info'>dossier  not Upload!!!.</div>";
            }
        }
        else{
            echo "<div class='alert alert-info'>extention   not exact!!!.</div>";
        }
    } else {
        echo "<div class='alert alert-info'>Please Fill All Data.</div>";
    }
}
?>

    <div class="hero">
        <nav class="navbar navbar-expand-lg navbar-dark  admin"> <!-- Add the "admin" class to the navbar -->
            <div class="container">
                <a class="navbar-brand" href="#"><img src="http://localhost/SiteAvocat/image/logo.png"  alt="" class="logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="link" href="dossiers.php">Dossiers</a>
                        </li>
                        <li class="nav-item">
                            <a class="link" href="client.php">Clients</a>
                        </li>
                        <li class="nav-item">
                            <a class="link" href="ajouter.php">Ajouter</a>
                        </li>
                    </ul>
                    <img src="http://localhost/SiteAvocat/image/user.jpg" class="user-pic" onclick="toggleMenu()">
                </div>
            </div>

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="http://localhost/SiteAvocat/image/user.jpg">
                        <h3>Zohra Boulkhir</h3>
                    </div>
                    <hr>
                    <?php
                    $cin_admin = $admin['cin_admin']; // Assuming 'cin_admin' is the correct field name
                    $encoded_cin = urlencode($cin_admin);
                    ?>
                    <a href="Edit.php?cin_admin=<?php echo $encoded_cin; ?>" class="menu-link">
                        <!-- <img src="imges/proicon"> -->
                        <i class="fa fa-edit fa-regular"></i>
                        <p>Edit Profile</p>
                        <span>></span>
                    </a>
                    <a href="decconection.php" class="menu-link">
                        <!-- <img src="imges/icondeconx"> -->
                        <i class="fa fa-sign-out fa-solid"></i>
                        <p>Deconnexion</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </nav>
    </div>
    <div class="tab-client">
        <h2 style="text-align: center;">Ajouter dossiers</h2>
        <div class="form-dossier">
            <form action="" method="post" enctype="multipart/form-data">
                <table class="table tab-dossier">
                    <tr>
                        <th><label for="num">nemero Dossier :</label></th>
                        <td><input type="text"  value="" name="num" id="num" ></td>
                    </tr>
                    <tr>
                        <th><label for="titre">Titre Dossiers</label></th>
                        <td><input type="text" value="" name="titre" id="titre"></td>
                    </tr>
                    <tr>
                        <th><label for="dateCreat">Date creation :</label></th>
                        <td><input type="date" name="date_Create" id="dateCreat"></td>
                    </tr>
                    <tr>
                        <th><label for="dateDaudience">Date D'audience</label></th>
                        <td><input type="date" name="date_Daudience" id="dateDaudience"></td>
                    </tr>
                    <tr>
                        <th><label for="tribinal">Tribinal :</label></th>
                        <td><input type="text" name="tribinal" id="tribinal"></td>
                    </tr>
                    
                    <tr>
                        <th><label for="dossierPdf">dossier PDF :</label></th>
                        <td><input type="file" name="dossier_Pdf" id="dossierPdf"></td>
                    </tr>
                    <tr>
                        <th><label for="cinPdf">CIN client :</label></th>
                        <td>
                            <select name="cin" id="cinPdf">
                                <?php
                                // Create a PDO connection to the database
                                $pdo = new PDO('mysql:host=localhost;dbname=avocat','root','');

                                // Fetch data from the "client" table
                                $clients = $pdo->query('SELECT * FROM client')->fetchAll(PDO::FETCH_ASSOC);

                                // Generate <option> elements based on the fetched data
                                foreach($clients as $client){
                                    echo "<option value='".$client['cin_client']."'>".$client['nom_client']."</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="eta_dossier">Eta dossier :</label></th>
                        <td>
                            <select name="etat_dossier" id="">
                                <option value="En traitement" selected>En traitement</option>
                                <option value="A rejete">A rejete</option>
                                <option value="Admis">Admis</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="reset" value="Reset"></td>
                        <td><input type="submit" name="ajouter" value="Envoyer"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div> 

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        let subMenu = document.getElementById('subMenu');   
        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }

        window.addEventListener("click", function(e) {
            if(e.target.className == "secetion-ifo") {
                if (subMenu.classList.contains("open-menu")) {
                    subMenu.classList.remove("open-menu");
                }
            }
        });
    </script>
</body>
</html>


give code php ajouter for this code