<?php


// Connexion à la base de données MySQL
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "blog";

// Création de la connexion
$conn = new mysqli($servername, $username, $password);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error . "\n");
}

// Création de la base de données
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Base de données créée avec succès\n";
} else {
    echo "Erreur lors de la création de la base de données: " . $conn->error . "\n";
}

// Sélection de la base de données
$conn->select_db($dbname);

// Création de la table des catégories
$sql = "CREATE TABLE IF NOT EXISTS categories (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Table des catégories créée avec succès\n";
} else {
    echo "Erreur lors de la création de la table des catégories: " . $conn->error . "\n";
}

// création de la table des utilisateurs
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table des utilisateurs créée avec succès\n";
} else {
    echo "Erreur lors de la création de la table des utilisateurs: " . $conn->error . "\n";
}



// Insertion de données factices dans la table des catégories
// Insertion de données factices dans la table des utilisateurs

$categories = ['Technologie', 'Business', 'Lifestyle', 'Sport', 'Politique'];
foreach ($categories as $category) {
    $sql = "INSERT INTO categories (name)
    VALUES ('$category')";

    if ($conn->query($sql) === TRUE) {
        echo "Données factices insérées dans la table des catégories avec succès\n";
    } else {
        echo "Erreur lors de l'insertion de données factices dans la table des catégories: " . $conn->error . "\n";
    }
}
$users = [
    ['username' => 'maha', 'password' => password_hash('maha123', PASSWORD_DEFAULT)],
    ['username' => 'valentine', 'password' => password_hash('valentine123', PASSWORD_DEFAULT)]
];

foreach($users as $user){
    $sql = "INSERT INTO users (username, password) VALUES ('{$user['username']}', '{$user['password']}')";

    if($conn->query($sql) === TRUE){
        echo "Données factices insérées dans la table des utilisateurs avec succès\n";
    } else {
        echo "Erreur lors de l'insertion de données factices dans la table des utilisateurs: " . $conn->error . "\n";
    }
}

// Création de la table des articles
$sql = "CREATE TABLE IF NOT EXISTS articles (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category_id INT(6) UNSIGNED,
    FOREIGN KEY (category_id) REFERENCES categories(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table des articles créée avec succès\n";
} else {
    echo "Erreur lors de la création de la table des articles: " . $conn->error . "\n";
}

// Insertion de données factices dans la table des articles
require_once 'vendor/autoload.php';
use Faker\Factory;

$faker = Factory::create('fr_FR');

    for ($i = 0; $i < 10; $i++) {
        $title = $faker->sentence($nbWords = 6, $variableNbWords = true);
        $content = $faker->paragraph($nbSentences = 3, $variableNbSentences = true);
        $category_id = rand(1, count($categories));
        $sql = "INSERT INTO articles (title, content, category_id) VALUES ('$title', '$content', '$category_id')";
        if ($conn->query($sql) === TRUE) {
            echo "Données factices insérées dans la table des articles avec succès\n";
        } else {
            echo "Erreur lors de l'insertion de données factices dans la table des articles: " . $conn->error . "\n";
        }
    }

$conn->close();
