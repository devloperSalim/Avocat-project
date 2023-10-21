<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Dossier</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/font-awesome-pro-v6-6/css/all.min.css"> 
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/style.css">
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/modifier.css">
</head>
<body>
    <?php
    $num_dossier = $_GET['num_dossier'];
    $pdo = new PDO('mysql:host=localhost;dbname=avocat', 'root', '');

    // Check if the dossier with the given number exists
    $sql = $pdo->prepare('SELECT * FROM dossier WHERE num_dossier=?');
    $sql->execute([$num_dossier]);
    $dossier = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$dossier) {
        echo "<div class='alert alert-danger'>Dossier not found.</div>";
        exit();
    }

    if (isset($_POST['modifier'])) {
        $num_dossier = $_POST['num'];
        $titre_dossier = $_POST['titre'];
        $date_create = $_POST['date_Create'];
        $date_Daudience = $_POST['date_Daudience'];
        $tribunal = $_POST['tribinal'];
        $dossier_pdf = $_FILES['dossier_Pdf']['name'];
        $cin = $_POST['cin'];
        $Eta_dossier = $_POST['etat_dossier'];


        if (!empty($titre_dossier) && !empty($date_create) && !empty($date_Daudience) && !empty($tribunal) && !empty($dossier_pdf) && !empty($cin) && !empty($Eta_dossier)) {
            // Prepare the SQL statement for updating the dossier
            $sql = "UPDATE dossier SET num_dossier=?, titre_dossier=?, date_creation=?, date_audience=?, tribinal=?, dossier_pdf=?, cin=?, etat_dossier=? WHERE num_dossier=?";

            


            //Upload PDF dossier

            $allowdfileEXt=array('jpg','txt','xls','doc','png','zip','rar');
            $fileNameArr=explode('.',$_FILES['dossier_Pdf']['name']);
            $fileEXt=strtolower(end($fileNameArr));
            if(in_array($fileEXt,$allowdfileEXt)){
                    if(move_uploaded_file($_FILES['dossier_Pdf']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."/SiteAvocat/PDFDoss/".$_FILES['dossier_Pdf']['name'])){
                        
                        // Prepare the statement and execute with the provided values
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$num_dossier, $titre_dossier, $date_create, $date_Daudience, $tribunal, $dossier_pdf, $cin, $Eta_dossier, $num_dossier]);

                        header('location:info.php?id='.$num_dossier.'&&CIN='.$cin); // Redirect to the same page after the data is added
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
        } else {
            // Display an error message if any field is empty
            echo "<div class='alert alert-danger'>Please Fill All Data.</div>";
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
    <br><br>
    <div class="tab-client">
        <h2 style="text-align: center;">Modifier dossier</h2>
        <div class="form-dossier">
            <form action="" method="post" enctype="multipart/form-data">
                <table class="table tab-modifier">
                    <tr>
                        <th><label for="num">Numéro Dossier:</label></th>
                        <td><input type="text" value="<?php echo $dossier['num_dossier']?>" name="num" id="num" readonly></td>
                    </tr>
                    <tr>
                        <th><label for="titre">Titre Dossiers</label></th>
                        <td><input type="text" value="<?php echo $dossier['titre_dossier']?>" name="titre" id="titre"></td>
                    </tr>
                    <tr>
                        <th><label for="dateCreat">Date creation :</label></th>
                        <td><input type="date" value="<?php echo $dossier['date_creation']?>" name="date_Create"  id="dateCreat" readonly></td>
                    </tr>
                    <tr>
                        <th><label for="dateDaudience">Date D'audience</label></th>
                        <td><input type="date" value="<?php echo $dossier['date_audience']?>" name="date_Daudience" id="dateDaudience"></td>
                    </tr>
                    <tr>
                        <th><label for="tribinal">Tribinal :</label></th>
                        <td><input type="text" value="<?php echo $dossier['tribinal']?>" name="tribinal" id="tribinal"></td>
                    </tr>
                    
                    <tr>
                        <th><label for="dossierPdf">dossier PDF :</label></th>
                        <td><input type="file" value="<?php echo $dossier['dossier_pdf']?>" name="dossier_Pdf" id="dossierPdf"></td>
                    </tr>
                    <tr>
                        <th><label for="cinPdf">CIN client :</label></th>
                        <td>
                            <select name="cin" id="cinPdf">
                                <?php
                                // Fetch data from the "client" table
                                $clients = $pdo->query('SELECT * FROM client')->fetchAll(PDO::FETCH_ASSOC);
                                // Generate <option> elements based on the fetched data
                                foreach($clients as $client){
                                    $selected = ($client['cin_client'] == $dossier['cin']) ? 'selected' : '';
                                    echo "<option value='".$client['cin_client']."' $selected>".$client['nom_client']."</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="eta_dossier">Eta dossier :</label></th>
                        <td>
                            <select name="etat_dossier" id="">
                                <option value="En traitement" <?php echo ($dossier['etat_dossier'] == 'En traitement') ? 'selected' : ''; ?>>En traitement</option>
                                <option value="A rejete" <?php echo ($dossier['etat_dossier'] == 'A rejete') ? 'selected' : ''; ?>>A rejete</option>
                                <option value="Admis" <?php echo ($dossier['etat_dossier'] == 'Admis') ? 'selected' : ''; ?>>Admis</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="reset" value="Reset"></td>
                        <td><input type="submit" name="modifier" value="Modifier"></td>
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
    </script>/ Your JavaScript code here
  
</body>
</html>

    <!-- Bootstrap JS -->
