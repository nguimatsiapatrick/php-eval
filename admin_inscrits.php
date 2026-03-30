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
