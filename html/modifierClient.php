<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/font-awesome-pro-v6-6/css/all.min.css"> 
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/style.css">   
</head>
<body>
<?php

$cin_client = $_GET['cin_client'];
$pdo = new PDO('mysql:host=localhost;dbname=avocat','root','');
$sql = $pdo->prepare('SELECT * FROM client WHERE cin_client=?');
$sql->execute([$cin_client]);
$client = $sql->fetch(PDO::FETCH_ASSOC);

if (!$client) {
    echo "<div class='alert alert-danger'>Client not found.</div>";
    exit();
}




if(isset($_POST['ajouter'])){
    $nom_client = $_POST['nom'];
    $prenom_client = $_POST['prenom'];
    $cin_client = $_POST['cin'];
    $dateNis = $_POST['dateNai'];
    $adresse = $_POST['address'];
    $telefon = $_POST['tel'];
    $email = $_POST['email'];
    $cin_pdf = $_FILES['CINPdf']['name'];

    if(!empty($nom_client) && !empty($prenom_client) && !empty($cin_client) && !empty($dateNis) && !empty($adresse) && !empty($telefon) && !empty($email) && !empty($cin_pdf)){
        // Connect to the database
        $pdo = new PDO('mysql:host=localhost;dbname=avocat','root','');


        //Upload PDF dossier

        $allowdfileEXt=array('jpg','txt','xls','doc','png','zip','rar');
        $fileNameArr=explode('.',$_FILES['CINPdf']['name']);
        $fileEXt=strtolower(end($fileNameArr));
        if(in_array($fileEXt,$allowdfileEXt)){
                if(move_uploaded_file($_FILES['CINPdf']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."/SiteAvocat/PDFCin/".$_FILES['CINPdf']['name'])){
                    
                    // Prepare the SQL statement
                        $sql = "UPDATE  client SET nom_client=?,prenom_client=?, cin_client=?, date_naissance=?, adresse=?, telefon=?, email=? ,cinPdf=? WHERE cin_client=?";
                        $stmt = $pdo->prepare($sql);

                        // Execute the statement with the provided values
                        $stmt->execute([$nom_client, $prenom_client, $cin_client, $dateNis,$adresse, $telefon, $email ,$cin_pdf,$cin_client,]);
                        
                        header('Location:client.php');
                        exit();
                }
                else
                {
                    echo "<div class='alert alert-info'>dossier  not Upload!!!.</div>";
                }
        }
        else
        {
            echo "<div class='alert alert-info'>extention   not exact!!!.</div>";
        }
        ;
    } else {
        echo "<div class='alert alert-info'>Please Fill All Data.</div>";
    }
}
?>

<?php
    $pdo = new PDO('mysql:host=localhost;dbname=avocat', 'root', '');
    $sql = $pdo->prepare('SELECT * FROM admin');
    $sql->execute();
    $admin = $sql->fetch(PDO::FETCH_ASSOC);
    ?>

    <div class="hero">
        <nav class="navbar navbar-expand-lg navbar-dark admin">
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
                        <i class="fa fa-edit fa-regular"></i>
                        <p>Edit Profile</p>
                        <span>></span>
                    </a>
                    <a href="decconection.php" class="menu-link">
                        <i class="fa fa-sign-out fa-solid"></i>
                        <p>Deconnexion</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </nav>
    </div>
    <div class="tab-client">
        <h2 style="text-align: center;">Modifier client</h2>
        <div class="form-client">
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="table tab-form table-responsive-lg">
                    <tr>
                        <th><label for="nom">Nom client:</label></th>
                        <td><input type="text" value="<?php echo $client['nom_client'] ?>" name="nom" id="nom"></td>
                    </tr>
                    <tr>
                        <th><label for="prenom">Prénom client:</label></th>
                        <td><input type="text" value="<?php echo $client['prenom_client'] ?>" name="prenom" id="prenom"></td>
                    </tr>
                    <tr>
                        <th><label for="cin">CIN client:</label></th>
                        <td><input type="text" value="<?php echo $client['cin_client'] ?>" name="cin" id="cin" readonly></td>
                    </tr>
                    <tr>
                        <th><label for="dossierPdf">CIN PDF  or image :</label></th>
                        <td><input type="file"  name="CINPdf" id="CINPdf"></td>
                    </tr>
                    <tr>
                        <th><label for="dateNai">Date Naissance:</label></th>
                        <td><input type="date" value="<?php echo $client['date_naissance'] ?>" name="dateNai" id="dateNai"></td>
                    </tr>
                    <tr>
                        <th><label for="address">Address client:</label></th>
                        <td><input type="text" value="<?php echo $client['adresse'] ?>" name="address" id="address"></td>
                    </tr>
                    <tr>
                        <th><label for="tel">Numéro de téléphone:</label></th>
                        <td><input type="text" value="<?php echo $client['telefon'] ?>" name="tel" id="tel"></td>
                    </tr>
                    <tr>
                        <th><label for="email">Email client:</label></th>
                        <td><input type="email" value="<?php echo $client['email'] ?>"  name="email" id="email"></td>
                    </tr>
                    <tr>
                        <td><input type="reset" value="Reset"></td>
                        <td><input type="submit" value="Envoyer" name="ajouter"></td>
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
            if (e.target.className !== "user-pic" && subMenu.classList.contains("open-menu")) {
                subMenu.classList.remove("open-menu");
            }
        });
    </script>
</body>
</html>