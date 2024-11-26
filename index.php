<?php
session_start();

// Initialisation des variables de session
if (!isset($_SESSION['position'])) {
    $_SESSION['position'] = 0;  // Position initiale de la voiture (0px)
}
if (!isset($_SESSION['vitesse'])) {
    $_SESSION['vitesse'] = 0;  // Vitesse initiale de la voiture
}
if (!isset($_SESSION['autonomie'])) {
    $_SESSION['autonomie'] = 10;  // Autonomie initiale
}
if (!isset($_SESSION['contact'])) {
    $_SESSION['contact'] = false;  // Contact initial
}

// Messages de retour
$message = "";

// Gérer les actions de l'utilisateur
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'demarrer':
        if (!$_SESSION['contact']) {
            $_SESSION['contact'] = true;
            $message = "Le contact est allumé.";
        } else {
            $message = "Le contact est déjà allumé.";
        }
        break;

    case 'accelerer':
        if ($_SESSION['contact'] && $_SESSION['autonomie'] > 0) {
            $_SESSION['position'] += 10; // Déplacer la voiture de 10px à chaque accélération
            $_SESSION['vitesse'] += 10;  // Augmenter la vitesse
            $_SESSION['autonomie']--;    // Réduire l'autonomie à chaque accélération
            $message = "Vitesse actuelle : {$_SESSION['vitesse']} km/h. Autonomie restante : {$_SESSION['autonomie']}/10.";
        } else if ($_SESSION['autonomie'] <= 0) {
            $message = "Autonomie épuisée, vous ne pouvez plus accélérer.";
        } else {
            $message = "Il faut démarrer la voiture avant d'accélérer.";
        }
        break;

    case 'freiner':
        if ($_SESSION['vitesse'] > 0) {
            $_SESSION['position'] = max(0, $_SESSION['position'] - 10); // Réduire la position de la voiture
            $_SESSION['vitesse'] = max(0, $_SESSION['vitesse'] - 10);   // Réduire la vitesse
            $message = "Vitesse actuelle : {$_SESSION['vitesse']} km/h.";
        } else {
            $message = "La voiture est déjà à l'arrêt.";
        }
        break;

    case 'fairePlein':
        $_SESSION['autonomie'] = 10;
        $message = "Le plein est fait ! Autonomie réinitialisée à 10/10.";
        break;

    case 'couperContact':
        if ($_SESSION['contact']) {
            $_SESSION['contact'] = false;
            $_SESSION['vitesse'] = 0;  // Arrêter la voiture
            $message = "Le contact est maintenant coupé. La voiture est arrêtée.";
        } else {
            $message = "Le contact est déjà coupé.";
        }
        break;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gran Turismo 9</title>
    <!-- Lien vers le fichier CSS externe -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Interface principale -->
    <div class="interface">
        <!-- Barre en haut avec les informations de la voiture -->
        <div class="status-bar">
            <div class="infoVoiture">
                <p><strong>Marque:</strong> Mercedes</p>
                <p><strong>Modèle:</strong> AMG</p>
                <p><strong>Couleur:</strong> Noire</p>
                <p><strong>Puissance réelle:</strong> 300 ch</p>
                <p><strong>Puissance fiscale:</strong> 15 cv</p>
            </div>

            <!-- Vitesse et Autonomie (droite) -->
            <div class="speed-autonomy">
                <p><strong>Vitesse : </strong><?php echo $_SESSION['vitesse']; ?> km/h</p>
                <div class="vitesse-bar">
                    <div class="vitesse-bar-inner" style="width: <?php echo ($_SESSION['vitesse'] / 200) * 100; ?>%;"></div>
                </div>

                <p><strong>Autonomie : </strong><?php echo $_SESSION['autonomie']; ?>/10</p>
                <div class="autonomie-bar">
                    <div class="autonomie-bar-inner" style="width: <?php echo ($_SESSION['autonomie'] / 10) * 100; ?>%;"></div>
                </div>
            </div>
        </div>

        <!-- Route et voiture -->
        <!-- Route et voiture -->
        <div class="route">
            <div class="voiture" style="left: <?php echo $_SESSION['position']; ?>px;">
                <img src="images.png" alt="voiture" class="voiture-img">
            </div>
        </div>

        <!-- Boutons de commande pour contrôler la voiture -->
        <div class="commande">
            <a href="index.php?action=demarrer">DEMARRER</a>
            <a href="index.php?action=accelerer">ACCELERER</a>
            <a href="index.php?action=freiner">FREINER</a>
            <a href="index.php?action=fairePlein">FAIRE LE PLEIN</a>
            <a href="index.php?action=couperContact">COUPER LE CONTACT</a>
        </div>

        <!-- Section pour les messages du jeu -->
        <div class="message-box">
            <p><?php echo $message; ?></p> <!-- Affichage du message -->
        </div>
    </div>

</body>

</html>