<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit profile</title>
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/EditPro.css">
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/font-awesome-pro-v6-6/css/all.min.css">
    <link rel="stylesheet" href="http://localhost/SiteAvocat/Css/style.css">
</head>
<body>
<?php
    $cin_admin = $_GET['cin_admin']; 
    $pdo = new PDO('mysql:host=localhost;dbname=avocat', 'root', '');
    $sql = $pdo->prepare('SELECT * FROM admin WHERE cin_admin=?');
    $sql->execute([$cin_admin]);
    $admin = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        echo "<div class='alert alert-danger'>Admin not found.</div>";
        exit();
    }

    if (isset($_POST['modifier'])) {
        $new_cin = $_POST['cin_admin'];
        $nom  = $_POST['nom_admin'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Update admin information
        $updateSql = "UPDATE admin SET cin_admin = ?, nom_admin = ?, email = ?, password = ? WHERE cin_admin = ?";
        $stmt = $pdo->prepare($updateSql);
        $stmt->execute([$new_cin, $nom, $email, $password, $cin_admin]);

        header('Location: home.php');
        exit();
    }
    ?>
    <div class="hero">
        <!-- ... -->
    </div>
    <div class="secetion-ifo">
    <div class="Edi_cont">
        <div class="containerEdit">
            <h2>Editing Profile :</h2>
            <br><br>
            <form action="" method="post">
                <table class="table mt-1">
                    <tr>
                        <th>
                            your Cin :
                        </th>
                        <td>
                            <input type="text" name="cin_admin" value="<?php echo $admin['cin_admin']; ?>" readonly>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            your name :
                        </th>
                        <td>
                            <input type="text" name="nom_admin" value="<?php echo $admin['nom_admin']; ?>" placeholder="Enter your Name">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Email:
                        </th> 
                        <td>
                            <input type="email" name="email" value="<?php echo $admin['email']; ?>" placeholder="Enter your Email">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            password :
                        </th> 
                        <td>
                            <input type="password" name="password" id="password" placeholder="New password">
                        </td>
                    </tr>
                </table>
                <div class="button">
                    <input type="submit" value="Submit" name="modifier">
                    <a href="home.php"  class="btn btn-primary">Annuler</a>
                </div>
            </form>
            </div>
        </div>
        </div>
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