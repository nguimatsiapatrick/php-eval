<?php
// Fichier : inscription_traitement.php

// Erreur 1 : Le formulaire est soumis mais on ne vérifie pas la méthode HTTP
if($_POST["submit"]) {

    // Erreur 2 : Utilisation de isset() sur une variable qui n'existe pas encore
    if(isset($prenom) || empty($_POST["email"])) {
        $erreur = "Veuillez remplir tous les champs.";
    } else {
        // Erreur 3 : Mauvaise utilisation de str_replace (ordre des paramètres inversé)
        $prenom = str_replace($_POST["prenom"], "\\", "");
        $email = $_POST["email"];

        // Erreur 4 : La date n'est pas au bon format pour le fichier
        $date = date("d-m-Y H:i:s");

        // Erreur 5 : fopen en mode "w" écrase le fichier au lieu d'ajouter
        $fichier = fopen("inscrits.txt", "w");
        fwrite($fichier, $prenom . " | " . $email . " | " . $date . "\n");
        fclose($fichier);

        // Erreur 6 : header() appelée après un echo
        echo "Redirection...";
        header("Location: confirmation.php");
    }
}
?>

<form method="post" action="inscription_traitement.php">
    Prénom : <input type="text" name="prenom" />
    Email : <input type="text" name="email" />
    <input type="submit" name="submit" value="S'inscrire" />
</form>

<?php
// Erreur 7 : Affichage de l'erreur en dehors du formulaire et après le HTML
if(!empty($erreur)) {
    echo "<p style='color:red'>" . $erreur . "</p>";
}
?>