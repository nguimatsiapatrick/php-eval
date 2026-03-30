**Total : 100 points — Seuil de réussite : 50/100**  
**Durée estimée : ~30 minutes**  
**Documents autorisés : Aucun**

> Répondez directement dans ce fichier en remplaçant les lignes `_Votre réponse ici_`.  
> Écrivez votre nom et prénom ci-dessous.

**Nom et prénom :** _NGUIMATSIA PATRICK______________________

---

## Question 1 — `isset()` vs `empty()` (40 points)

### a) La fonction `isset()` *(8 pts)*

Donnez la syntaxe complète de `isset()`, expliquez quand elle retourne `TRUE` et quand elle retourne `FALSE`.

_Votre réponse ici_
isset(mixed $var, mixed ...$vars): bool
---

### b) La fonction `empty()` *(8 pts)*

Donnez la syntaxe complète de `empty()`, expliquez quand elle retourne `TRUE` et quand elle retourne `FALSE`.

_Votre réponse ici_
empty(mixed $var): bool
---

### c) Différence fondamentale *(8 pts)*

Quelle est la différence entre `isset()` et `empty()` lorsqu'une variable vaut `0` ? Justifiez votre réponse.

_Votre réponse ici_
0
---

### d) Tableau comparatif *(16 pts)*

Complétez ce tableau (TRUE ou FALSE) :

| Valeur de `$var` | `isset($var)` | `empty($var)` |
|---|---|---|
| `$var = 0;` | TRUE | TRUE |
| `$var = "";` | TRUE | TRUE |
| `$var = "bonjour";` | TRUE | FALSE |
| Variable non déclarée | FALSE | TRUE |
| `$var = "0";` | TRUE | TRUE |
| `$var = null;` | FALSE | TRUE |
| `$var = false;` | TRUE | TRUE |
| `$var = [];` | TRUE | TRUE |

---

## Question 2 — GET / POST et manipulation de fichiers (60 points)

### a) GET vs POST *(15 pts)*

Expliquez la différence entre la méthode `GET` et la méthode `POST` pour le passage de variables en PHP. Dans quel cas préfère-t-on utiliser `GET` ? Quelle est la limite de caractères de `GET` ?

_Votre réponse ici_

---

### b) Passage de paramètres dans l'URL *(15 pts)*

Donnez la syntaxe permettant de passer les variables `categorie` (valeur : "php") et `page` (valeur : 2) dans une URL pointant vers `catalogue.php`.

Montrez ensuite comment récupérer ces deux variables en PHP côté serveur.

_Votre réponse ici_
catalogue.php?categorie=php&page=2
<?php
// Récupération avec $_GET
$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Sécurisation des données
$categorie = htmlspecialchars($categorie);

echo "Catégorie : " . $categorie . "<br>";
echo "Page : " . $page;
?>
---
---

### c) Les modes d'ouverture de `fopen()` *(20 pts)*

Citez et expliquez les **6 modes d'ouverture** possibles de la fonction `fopen()`. Pour chacun, précisez : lecture, écriture, ou les deux ; et où est placé le pointeur.

_Votre réponse ici_
Mode	Description	Lecture	Écriture	Position pointeur
r	Lecture seule	Oui	Non	Début du fichier
r+	Lecture et écriture	Oui	Oui	Début du fichier
w	Écriture seule (crée ou écrase)	Non	Oui	Début (efface le contenu)
w+	Lecture et écriture (crée ou écrase)	Oui	Oui	Début (efface le contenu)
a	Écriture seule (ajout à la fin)	Non	Oui	Fin du fichier
a+	Lecture et écriture (ajout à la fin)	Oui	Oui	Fin du fichier
---
---

### d) La fonction `header()` *(10 pts)*

À quoi sert la fonction `header()` ? Donnez un exemple concret. Quelle contrainte très importante doit-on respecter lors de son utilisation, et pourquoi ?

_Votre réponse ici_
<?php
// Redirection vers une autre page
header("Location: confirmation.php");
exit; // Toujours appeler exit après une redirection

// Définir le type de contenu
header("Content-Type: application/json");
echo json_encode($data);

// Définir un code de statut HTTP
header("HTTP/1.0 404 Not Found");
?>
---
---

## 📊 Barème

| Question | Sous-question | Points |
|---|---|---|
| Q1 — isset() vs empty() | a) isset() | 8 |
| | b) empty() | 8 |
| | c) Différence avec 0 | 8 |
| | d) Tableau | 16 |
| Q2 — GET/POST/fichiers | a) GET vs POST | 15 |
| | b) Passage de paramètres | 15 |
| | c) Modes fopen() | 20 |
| | d) header() | 10 |
| **TOTAL** | | **100** |

---

> ⚠️ Seuil de réussite : **50/100 minimum**
