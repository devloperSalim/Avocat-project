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
        $pdo = new PDO('mysql:host=localhost;dbname=avocat','root','');
        $sql = $pdo->prepare('SELECT * FROM client');
        $sql->execute();

        $client = $sql->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="tab-client" id="tab-client">
        <br>
        <h1 style="text-align: center;">Page client:</h1>
        <br><br>
        <div class="boxContainer">
            <table class="table text-center table-striped">
                <tr> 
                    <th>Client </th>
                    <th>Ville</th> 
                    <th>More Detail</th>
                    <th colspan="2">ACTION</th>
                </tr>
                <?php
                    foreach($client as $value){
                ?>
                <tr>
                    <td><?php echo $value['nom_client']?></td>
                    <td><?php echo $value['cin_client']?></td>
                    <td><?php echo $value['adresse']?></td> 
                    <td><a href="infoclient.php?id=<?php echo $value['cin_client'];?>"><button type="button" class="btn btn-danger">Show Details</button></a></td>
                    <td><a href="confirmation.php?cin=<?php echo $value['cin_client'];?> " ><button type="button" value="<?php echo $value['cin_client'];?>" class="btn btn-primary Delete">Supremer</button></a></td>
                </tr>  
                <?php
                }
                ?>
            </table>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="http://localhost/SiteAvocat/Js/bootstrap.bundle.min.js"></script>
    <script src="http://localhost/SiteAvocat/Js/jquery-3.7.0.min.js"></script>
    <script src="http://localhost/SiteAvocat/Js/sweetalert.min.js"></script>
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


        $(document).ready(function () {
            

            $('.Delete').click(function (e) { 
                e.preventDefault();
                var cin=$(this).val()
 
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
                            url: "SUPclient.php",
                            data: {
                                'cin':cin
                            }, 
                            success: function (response) {  
                                swal("supremer client!", "You clicked the button supremer!", "success");
                                $("#tab-client").load(location.href + " #tab-client")
                            
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