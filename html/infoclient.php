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
    $clientCIN = $_GET['id'] ?? 0; // Get the client ID from the query parameter
    $sql = $pdo->prepare('SELECT * FROM `client` WHERE `cin_client` = :clientID');
    $sql->bindParam(':clientID', $clientCIN, PDO::PARAM_STR);
    $sql->execute();
    $info = $sql->fetchAll(PDO::FETCH_ASSOC);
    $sql = $pdo->prepare('SELECT * FROM `dossier` WHERE `cin` = :clientID');
    $sql->bindParam(':clientID', $clientCIN, PDO::PARAM_STR);
    $sql->execute();
    $dossier = $sql->fetchAll(PDO::FETCH_ASSOC);
    ?>

<?php
    $pdo = new PDO('mysql:host=localhost;dbname=avocat', 'root', '');
    $sql = $pdo->prepare('SELECT * FROM admin');
    $sql->execute();
    $admin = $sql->fetch(PDO::FETCH_ASSOC);
    ?>

    <div class="hero">
        <nav class="navbar navbar-expand-lg navbar-dark admin"> <!-- Add the "admin" class to the navbar -->
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
    <div class="secetion-ifo">
        <div class="cont-center">
            <div class="tab-info">
                <table class="table tab table-bordered mt-2">
                    <?php foreach($info as $value): ?>
                    <tr>
                        <th>Nom</th>
                        <td><input type="text" value="<?php echo $value['nom_client'];?>" name="" id="" readonly></td>
                    </tr>
                    <tr>
                        <th>Prenom</th>
                        <td><input type="text" value="<?php echo $value['prenom_client'];?>" name="" id="" readonly></td>
                    </tr>
                    <tr>
                        <th>Date de Naissance</th>
                        <td><input type="text" value="<?php echo $value['date_naissance'];?>" name="" id="" readonly></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><input type="text" value="<?php echo $value['adresse'];?>" name="" id="" readonly></td>
                    </tr>
                    <tr>
                        <th>Tel</th>
                        <td><input type="text" value="<?php echo $value['telefon'];?>" name="" id="" readonly></td>
                    </tr>
                    <tr>
                        <th>Mail</th>
                        <td><input type="text" value="<?php echo $value['email'];?>" name="" id="" readonly></td>
                    </tr>
                    <tr>
                        <th>CIN</th>
                        <td><input type="text" value="<?php echo $value['cin_client'];?>" name="" id="" readonly></td>
                    </tr> 
                    <?php endforeach; ?>
                </table>
                <span id="btns">
                <a href="modifierClient.php?cin_client=<?php echo $value['cin_client'];?>" class="btn editer btn-primary">Editer</a>

                </span>
            </div>
            <div class="tab-info-doss" id="tab-info-doss">
                <table class="table text-uppercase tab table-bordered mt-2">
                    <tr>
                        <th>Num Dossiers</th>
                        <th>Titre</th> 
                        <th>Supprimer</th>
                        <th>More Details</th>
                    </tr>
                    <?php foreach($dossier as $value): ?>
                    <tr>
                        <td><?php echo $value['num_dossier'];?></td>
                        <td><?php echo $value['titre_dossier'];?></td>
                        <td><a href="supprimer.php?id=<?php echo $value['num_dossier'];?>&&CIN=<?php echo $value['cin'];?>"><button class="btn btn-danger Delete" id="btnS" value="<?php echo $value['num_dossier'];?>&&<?php echo $value['cin'];?>">Supprimer</button></a></td>
                        <td><a href="info.php?id=<?php echo $value['num_dossier']?>&&CIN=<?php echo $value['cin'];?>"><button class="btn btn-primary">Show More</button></a></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <span id="btns">
                    <button class="btn annuler btn-primary">Annuler</button>
                    <button class="btn btn-danger">Valider</button>
                </span>
            </div>
        </div>
        <div class="btnretour">
            <button type="button" id="retour" class="btn btn-warning">Retour   <i class="fa fa-solid fa-arrow-right"></i></button>
        </div>
    </div> 

    <!-- Bootstrap JS -->
    <script src="http://localhost/SiteAvocat/Js/bootstrap.bundle.min.js"></script>
    <script src="http://localhost/SiteAvocat/Js/jquery-3.7.0.min.js"></script>
    <script src="http://localhost/SiteAvocat/Js/sweetalert.min.js"></script>
    <script>
        let subMenu = document.getElementById('subMenu');
        let tab = document.querySelectorAll('.tab-infD input')
        let editer = document.querySelector('.editer');
        let retour = document.getElementById('retour');
         

        editer.addEventListener('click', () => {
            tab.forEach(input => {
                input.removeAttribute("readonly");
            })
        })
        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    
        window.addEventListener("click", function (e) {
            if (e.target.className == "containerr" || e.target.className == "buttons") {
                if (subMenu.classList.contains("open-menu")) {
                    subMenu.classList.remove("open-menu");
                }
            }
        });

        retour.addEventListener('click',()=>{history.back()})



        $(document).ready(function () {
            

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
            });
    </script>
</body>
</html>
