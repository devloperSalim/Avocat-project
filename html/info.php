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
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/info.css">
</head>

<?php 
    $pdo = new PDO('mysql:host=localhost;dbname=avocat', 'root', '');
    $clientCIN = $_GET['CIN'] ?? 0; // Get the client ID from the query parameter
    $clientID = $_GET['id'] ?? 0; // Get the client ID from the query parameter
    $sqlS = $pdo->prepare('SELECT * FROM `client` WHERE `cin_client` = :clientID');
    $sqlS->bindParam(':clientID', $clientCIN, PDO::PARAM_STR);
    $sqlS->execute();
    $info = $sqlS->fetchAll(PDO::FETCH_ASSOC);
    $sql = $pdo->prepare('SELECT * FROM `dossier` WHERE `cin` = :clientID AND `num_dossier`=:Num_dossier');
    $sql->bindParam(':clientID', $clientCIN, PDO::PARAM_STR);
    $sql->bindParam(':Num_dossier', $clientID, PDO::PARAM_STR);
    $sql->execute();
    $dossier = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<body> 
<?php
    $pdo = new PDO('mysql:host=localhost;dbname=avocat', 'root', '');
    $sql = $pdo->prepare('SELECT * FROM admin');
    $sql->execute();
    $admin = $sql->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="hero">
        <nav class="navbar navbar-expand-lg navbar-dark  admin"> <!-- Add the "admin" class to the navbar -->
            <div class="container">
                <a class="navbar-brand" href="#"><img src="http://localhost/SiteAvocat/image/logo.png" alt="" class="logo"></a>
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
    <div class="section">
        <div class="box_info">
            <div class="info_client">
                <div class="table_client">
                    <h3>information client :</h3>
                    <table class="table  table-bordered mt-2">
                    <?php foreach($info as $Res): ?>
                        <tr>
                            <th>Nom:</th>
                            <td><input type="text" value="<?php echo $Res['nom_client'] ;?>" name="Nom" id="Nom" disabled></td>
                        </tr>
                        <tr>
                            <th>Prenom :</th>
                            <td><input type="text" value="<?php echo $Res['prenom_client']; ?>" name="prenom" id="prenom" disabled></td>
                        </tr>
                        <tr>
                            <th>Date de naissance:</th>
                            <td><input type="text" value="<?php echo $Res['date_naissance']; ?>" name="DateNai" id="DateNai" disabled></td>
                        </tr>
                        <tr>
                            <th>Adress :</th>
                            <td><input type="text" value="<?php echo $Res['adresse']; ?>" name="adress" id="adress" disabled></td>
                        </tr>
                        <tr>
                            <th>Tel :</th>
                            <td><input type="text" value="<?php echo $Res['telefon'] ;?>" name="Tel" id="Tel" disabled></td>
                        </tr>
                        <tr>
                            <th>Mail :</th>
                            <td><input type="email" value="<?php echo $Res['email'] ;?>" name="Mail" id="Mail" disabled></td>
                        </tr>
                        <tr>
                            <th>CIN :</th>
                            <td><input type="text" value="<?php echo $Res['cin_client']; ?>" name="cin" id="cin" readonly></td>
                        </tr>
                        <?php endforeach ?>
                    </table>

                </div>
                <div class="table_Dossier" id="tab-info-doss">
                    <h3>information dossier client :</h3>
                <?php foreach($dossier as $value): ?>
                    <table class="table tab-infD">
                        <tr>
                            <th>Date de création</th>
                            <td><input type="text" value="<?php echo $value['date_creation'] ;?>" name="" id="" readonly></td>
                        </tr>
                        <tr>
                            <th>Date d’audience </th>
                            <td><input type="text" value="<?php echo $value['date_audience'] ;?>" name="" id="" readonly></td>
                        </tr>
                        <tr>
                            <th>tribunal</th>
                            <td><input type="text" value="<?php echo $value['tribinal'] ;?>" name="" id="" readonly></td>
                        </tr>
                        <tr>
                            
                            <td><a class="btn btn-primary" href="modifierDossier.php?num_dossier=<?php echo $value['num_dossier']?>">modifier</a></td>

                            <td><button type="button" value="<?php echo $value['num_dossier']?>&&<?php echo $value['cin']; ?>" class="btn btn-danger Delete">Supprimer</button></td>
                        </tr>
                        <?php endforeach ?>
                    </table>
                </div>
            </div>
            <h3>downloads dossier pdf or CIN client :</h3>
            <div class="Fichiers">
                <div class="buttons">
                    <div class="btn_dossier"> 
                        <a href="download.php?file=<?php echo $value['dossier_pdf']?>"><button class="btn btn-primary" pdf_src="http://localhost/SiteAvocat/PDFDoss/<?php echo $value['dossier_pdf']?>" class="pdf">dossier.pdf / .word </button></a>
                         
                    </div>
                    <div class="btn_dossier">
                        <a href="download.php?file=<?php echo $Res['cinPdf']?>"><button class="btn btn-primary">CIN.pdf / .png/ .jpeg</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="http://localhost/SiteAvocat/Js/bootstrap.bundle.min.js"></script>
    <script src="http://localhost/SiteAvocat/Js/jquery-3.7.0.min.js"></script>
    <script src="http://localhost/SiteAvocat/Js/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        let subMenu = document.getElementById('subMenu');
        let tab = document.querySelectorAll('.tab-infD input')
         

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }

        window.addEventListener("click", function(e) {

            // var subMenu = document.getElementById("subMenu");
            // console.log(e.target.className)
            if (e.target.className == "containerr" || e.target.className == "buttons") {
                if (subMenu.classList.contains("open-menu")) {
                    subMenu.classList.remove("open-menu");
                }
            }
        });
        $('.Delete').click(function (e) { 
                e.preventDefault();
                var value=$(this).val()

                var id = value.split('&&') 
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "POST",
                            url: "supprimer.php",
                            data: {
                                'id':id[0],
                                'CIN':id[1]
                            }, 
                            success: function (response) {  
                                swal("supremer dossier number : "+id[0], "You clicked the button!", "success");
                                $("#tab-info-doss").load(location.href + " #tab-info-doss")
                            
                            }
                        }); 
                    } else {
                        swal("Your imaginary file is safe!");
                    }
                    });
                        });
            
       
                        

                

</script>


</body>

</html>