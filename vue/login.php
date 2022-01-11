<?php
session_start();

include("../model/utilisateurs-fonction.php");

// Si l'utilisateur est déjà connecté, il est renvoyé sur la page d'accueil
if (isset($_SESSION["role"])) {
    header("Location: index.php");
}

// Récupération des données de connexion
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$mdp = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$mdp = hash('sha256', $mdp);

$erreur = false;

// Essayes la connexion
if (isset($email) != null && isset($mdp) != null) {
    $user = GetUserByEmailAndPassword($email, $mdp);
    if ($user != null) {
        try {
            if($user[0]["actif"]==1){
                if($user[0]["admin"]==0){
                    $_SESSION["role"] = "user";
                }
                else{
                    $_SESSION["role"] = "admin";
                }
                $_SESSION["idUser"] = $user[0]["id_user"];
                header("Location: index.php");
            }
            else{
                $erreur = true;
                $txtErreur = "Email ou mot de passe incorrecte.";
            }
        } catch (Exception $e) {
            $erreur = true;
            $txtErreur = "Merci de contacter un administrateur : " . $e;
        }
    } else {
        $erreur = true;
        $txtErreur = "Email ou mot de passe incorrecte.";
    }
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Animated-Pretty-Product-List-v12.css">
    <link rel="stylesheet" href="assets/css/Article-List.css">
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Pretty-Login-Form.css">
</head>

<body>
    <section class="showcase">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col">
                    <section class="article-list">
                        <div class="container" style="text-align: center;margin-top: 17px;">
                            <div class="intro">
                                <h2 class="text-center" style="margin-top: 15%;">Connexion</h2>
                            </div>
                        </div>
                    </section>
                    <section class="login-clean">
                        <form method="post">
                            <h2 class="visually-hidden">Login Form</h2>
                            <div class="illustration"></div>
                            <div class="mb-3"><input class="form-control" type="email" name="email" placeholder="Email"></div>
                            <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Mot de passe"></div>
                            <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit" style="background: var(--bs-blue);">Se connecter</button></div>
                        </form>
                        <form action="#" method="POST">
                        <?php if ($erreur == true) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Erreur!</strong> ' . $txtErreur . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                        }
                        ?>
                    </section>
                    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
                        <div class="container"><a class="navbar-brand logo" href="#">T-Shirt shop</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                            <div class="collapse navbar-collapse" id="navcol-1">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item"><a class="nav-link" href="index.php">Acceuil</a></li>
                                    <li class="nav-item"><a class="nav-link" href="shop.php">Produit</a></li>
                                    <li class="nav-item"><a class="nav-link active" href="login.php">Connexion</a></li>
                                    <li class="nav-item"><a class="nav-link" href="register.php">Inscription</a></li>
                                    <li class="nav-item"><a class="nav-link" href="shop.php">Panier</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <footer class="bg-light footer">
        <footer class="footer-dark">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-3 item">
                        <h3>Services</h3>
                        <ul>
                            <li><a href="#">Web design</a></li>
                            <li><a href="#">Development</a></li>
                            <li><a href="#">Hosting</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-3 item">
                        <h3>About</h3>
                        <ul>
                            <li><a href="#">Company</a></li>
                            <li><a href="#">Team</a></li>
                            <li><a href="#">Careers</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 item text">
                        <h3>Company Name</h3>
                        <p>Praesent sed lobortis mi. Suspendisse vel placerat ligula. Vivamus ac sem lacus. Ut vehicula rhoncus elementum. Etiam quis tristique lectus. Aliquam in arcu eget velit pulvinar dictum vel in justo.</p>
                    </div>
                </div>
                <p class="copyright">Company Name © 2021</p>
            </div>
        </footer>
    </footer>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Animated-Pretty-Product-List-v12.js"></script>
</body>

</html>