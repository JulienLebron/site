<?php
require_once 'inc/init.inc.php';

//---------------------------------- TRAITEMENT PHP --------------------------------//
if(!internauteEstConnecte())
{
    header('location:connexion.php');
}
//---------------------------------- AFFICHAGE HTML--------------------------------//
require_once 'inc/haut.inc.php';
// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';
// $_SESSION['membre']['civilite'] = 'm';
?>

<div class="jumbotron text-center">
    <h2>Profil de <?= $_SESSION['membre']['prenom'] ?></h2>
</div>

<div class="container mt-5 text-center">
    <?php 
        if($_SESSION['membre']['civilite'] == 'm')
        {
            echo '<img src="https://picsum.photos/id/1005/200/200" alt="photo de profil" style="clip-path: ellipse(50% 50%);">';
        }
        else
        {
            echo '<img src="https://picsum.photos/id/1011/200/200" alt="photo de profil" style="clip-path: ellipse(50% 50%);">';
        }
    ?>
</div>
<div class="container text-center mt-5">
    <h3><?= $_SESSION['membre']['pseudo']; ?></h3>
    <div class="alert alert-info text-center">Vous trouverez ci-dessous vos informations personnel</div>
    <table class="table table-bordered mt-4 text-center">
        <thead class="table-dark">
            <tr>
                <th scope="col">Pseudo</th>
                <th scope="col">Prénom</th>
                <th scope="col">Nom</th>
                <th scope="col">Email</th>
                <th scope="col">Adresse</th>
                <th scope="col">Ville</th>
                <th scope="col">Code Postal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $_SESSION['membre']['pseudo']; ?></td>
                <td><?= $_SESSION['membre']['prenom']; ?></td>
                <td><?= $_SESSION['membre']['nom']; ?></td>
                <td><?= $_SESSION['membre']['email']; ?></td>
                <td><?= $_SESSION['membre']['adresse']; ?></td>
                <td><?= $_SESSION['membre']['ville']; ?></td>
                <td><?= $_SESSION['membre']['code_postal']; ?></td>
            </tr>
        </tbody>
    </table>
</div>




<?php
require_once 'inc/bas.inc.php';