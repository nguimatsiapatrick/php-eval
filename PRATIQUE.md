**Total : 100 points — Seuil de réussite : 50/100**  
**Durée estimée : ~1h00**  
**Documents autorisés : Aucun**

> Pour les trous de code (Q1) : répondez dans ce fichier en numérotant vos réponses.  
> Pour le code from scratch (Q2) : créez les fichiers PHP directement dans votre dossier.  
> Écrivez votre nom et prénom ci-dessous.

**Nom et prénom :** ___Nguimatsia tsagueu____________________

---

## Question 1 — Compléter du code PHP (40 points)

> **Contexte :** Un visiteur s'inscrit à un atelier en ligne. Le formulaire doit **conserver les données saisies** si le formulaire est renvoyé incomplet, et sauvegarder l'inscription dans un fichier texte.

Complétez les parties `/* 1 */` à `/* 12 */` dans le code ci-dessous.  
**Écrivez vos réponses numérotées dans la section "Vos réponses" plus bas.**

```php
<?php
$erreur = "";

// Traitement si le formulaire a été soumis
if(/* 1 */($_POST["envoyer"])) {

    // Vérification des champs obligatoires
    if(/* 2 */($_POST["prenom"]) || empty($_POST["email"])) {
        $erreur = "Veuillez remplir tous les champs obligatoires.";
    } else {
        // Nettoyage des données
        $prenom = /* 3 */("\\", "", $_POST["prenom"]);
        $email  = str_replace("\\", "", $_POST["email"]);
        $niveau = str_replace("\\", "", $_POST["niveau"]);

        // Récupération de la date du jour (format jj/mm/aaaa)
        $date = /* 4 */("d/n/Y");

        // Sauvegarde dans le fichier (ajout à la fin)
        $fichier = /* 5 */("inscrits.txt", /* 6 */);
        /* 7 */($fichier, $prenom . " | " . $email . " | " . $niveau . " | " . $date . "\n");
        /* 8 */($fichier);

        // Redirection vers la page de confirmation
        /* 9 */("Location: confirmation.php");
    }
}
?>

<form method="post" action="inscription.php">
  <fieldset>
    <legend>Inscription à l'atelier</legend>

    <?php if(!empty($erreur)) echo "<p style='color:red'>" . $erreur . "</p>"; ?>

    Prénom :
    <input type="text" name="prenom" size="40" value="
      <?php
        if(!/* 10 */($_POST["prenom"]))
          echo /* 11 */($_POST["prenom"]);
      ?>" />
    <br />

    Email :
    <input type="text" name="email" size="40" value="
      <?php
        if(!empty($_POST["email"]))
          echo htmlentities($_POST["email"]);
      ?>" />
    <br />

    Débutant :
    <input type="radio" name="niveau" value="débutant"
      <?php
        if(isset($_POST["niveau"]) && $_POST["niveau"] == "débutant")
          echo "checked=\"checked\"";
      ?> />

    Avancé :
    <input type="radio" name="niveau" value="avancé"
      <?php
        if(isset($_POST["niveau"]) && $_POST["niveau"] == "avancé")
          echo /* 12 */;
      ?> />
    <br />

    <input type="submit" name="envoyer" value="S'inscrire" />
    <input type="reset" value="Effacer" />
  </fieldset>
</form>
```

### ✏️ Vos réponses — Q1

Remplacez chaque `?` par votre réponse :

| N° | Votre réponse |
|---|---|
| 1 | isset |
| 2 | empty |
| 3 | str_replace |
| 4 | date |
| 5 | fopen |
| 6 |  'a'|
| 7 | fwrite |
| 8 | fclose |
| 9 | hearder |
| 10 | empty |
| 11 | htmlentities |
| 12 | "checked=\"checked\"" |

*(~3,5 pts par réponse correcte)*

---

## Question 2 — Écrire du code from scratch (60 points)

> **Contexte :** Vous développez une page d'administration pour consulter et rechercher parmi les inscrits sauvegardés dans `inscrits.txt`.  
> Chaque ligne du fichier a la structure : `prenom | email | niveau | date`

Écrivez **un seul fichier** `admin_inscrits.php` qui remplit les deux fonctions ci-dessous.

---

### Partie A — Affichage de la liste des inscrits *(30 pts)*

Le fichier doit :

1. Lire `inscrits.txt` avec `fread()` + `filesize()` pour compter le nombre total d'inscrits (nombre de `\n`) et l'afficher en haut de page *(5 pts)*
2. Si le fichier est vide ou inexistant, afficher : *"Aucun inscrit pour l'instant."* *(5 pts)*
3. Lire le fichier **ligne par ligne** avec `fgets()` *(5 pts)*
4. Pour chaque ligne, découper les champs avec `explode()` sur le séparateur `|` *(5 pts)*
5. Afficher les inscrits dans un **tableau HTML** avec les colonnes :
   **Prénom** | **Email** | **Niveau** | **Date d'inscription** *(10 pts)*

---

### Partie B — Recherche par mot-clé *(30 pts)*

Au-dessus du tableau, le fichier doit afficher un formulaire avec :
- Un champ texte *"Rechercher un inscrit (prénom ou email)"*
- Un bouton *"Rechercher"*

Comportement attendu :

1. Vérifier que le champ de recherche n'est pas vide *(5 pts)*
2. Si une recherche est soumise, relire `inscrits.txt` ligne par ligne et afficher **uniquement les lignes** contenant le mot recherché — insensible à la casse avec `stristr()` *(15 pts)*
3. Si aucun résultat : afficher *"Aucun inscrit ne correspond à votre recherche."* *(5 pts)*
4. Si aucune recherche n'est soumise : afficher la liste complète *(5 pts)*

Ajoutez un lien retour vers `inscription.php` en bas de page.
---
<?php
$searchTerm = '';
$searchSubmitted = false;

// Check if the search form was submitted
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchSubmitted = true;
    $searchTerm = trim($_GET['search']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration - Liste des inscrits</title>
    <style>
        body { font-family: sans-serif; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .search-form { margin-bottom: 20px; background: #f9f9f9; padding: 10px; border-radius: 5px; }
        .result-count { font-weight: bold; margin: 10px 0; }
        .no-results { color: red; font-style: italic; }
    </style>
    </head>
<body>

<h1>Administration des inscriptions</h1>

<div class="search-form">
    <form method="get" action="admin_inscrits.php">
        <label for="search">Rechercher un inscrit (prénom ou email) :</label>
        <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" size="40" />
        <button type="submit">Rechercher</button>
        <?php if ($searchSubmitted): ?>
            <a href="admin_inscrits.php">Afficher tous les inscrits</a>
        <?php endif; ?>
    </form>
</div>

<?php
$filename = "inscrits.txt";
$inscrits = [];
$totalCount = 0;
// --- Check if file exists and is readable ---
if (file_exists($filename) && is_readable($filename)) {
    // --- Part A (1): Count total lines using fread() and filesize() ---
    $handle = fopen($filename, "r");
    if ($handle) {
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        // Count newline characters
        $totalCount = substr_count($contents, "\n");
        // Adjust if the last line doesn't end with a newline
        if (strlen($contents) > 0 && substr($contents, -1) != "\n") {
            $totalCount++;
        }
    }
    // --- Part A (2): If file is empty or no data, show message ---
    if ($totalCount == 0) {
        echo "<p>Aucun inscrit pour l'instant.</p>";
    } else {
        // Display total count
        echo "<div class='result-count'>Nombre total d'inscrits : " . $totalCount . "</div>";

        // --- Read the file line by line to process data ---
        $handle = fopen($filename, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $line = trim($line);
                if (empty($line)) continue;

                // --- Part A (4): Split the line using explode() ---
                $parts = explode("|", $line);
                // Clean up each part
                $prenom = trim($parts[0]);
                $email = trim($parts[1]);
                $niveau = trim($parts[2]);
                $date = trim($parts[3]);
                $inscrits[] = [
                    'prenom' => $prenom,
                    'email' => $email,
                    'niveau' => $niveau,
                    'date' => $date
                ];
            }
            fclose($handle);
        }

        // --- Part B: Filter results if search is submitted ---
        $filteredInscrits = [];
        if ($searchSubmitted && !empty($searchTerm)) {
            foreach ($inscrits as $inscrit) {
                // --- Part B (2): Case-insensitive search using stristr() ---
                if (stristr($inscrit['prenom'], $searchTerm) !== false || stristr($inscrit['email'], $searchTerm) !== false) {
                    $filteredInscrits[] = $inscrit;
                }
            }

            // --- Part B (3): Check if no results found ---
            if (count($filteredInscrits) == 0) {
                echo "<p class='no-results'>Aucun inscrit ne correspond à votre recherche.</p>";
            }
        } else {
            // No search or empty search, show all
            $filteredInscrits = $inscrits;
        }
         // --- Part A (5): Display results in HTML table ---
        if (count($filteredInscrits) > 0) {
            echo "<table>";
            echo "<thead><tr><th>Prénom</th><th>Email</th><th>Niveau</th><th>Date d'inscription</th></tr></thead>";
            echo "<tbody>";
            foreach ($filteredInscrits as $inscrit) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($inscrit['prenom']) . "</td>";
                echo "<td>" . htmlspecialchars($inscrit['email']) . "</td>";
                echo "<td>" . htmlspecialchars($inscrit['niveau']) . "</td>";
                echo "<td>" . htmlspecialchars($inscrit['date']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        }
    }
} else {
    // --- Part A (2): If file does not exist or is not readable ---
    echo "<p>Aucun inscrit pour l'instant.</p>";
}
?>

<p><a href="inscription.php">← Retour au formulaire d'inscription</a></p>

</body>
</html>



---

## 📊 Barème

| Question | Détail | Points |
|---|---|---|
| Q1 — Compléter du code | 12 trous (~3,5 pts chacun) | 40 |
| Q2 — From scratch | Partie A — Affichage liste | 30 |
| | Partie B — Recherche | 30 |
| **TOTAL** | | **100** |

---

> ⚠️ Seuil de réussite : **50/100 minimum**
