<?php
// Connection à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "blog";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexionmet 
if ($conn->connect_error) {
    die("Connexion à la base de données échouée: " . $conn->connect_error);
}


// Gestion des requêtes en fonction de la méthode HTTP utilisée
switch ($method) {
    case 'GET':
        if(isset($_GET['id'])){
            getById();
        }elseif(isset($_GET['category_id'])){
            getByCategory();
        }else{
        handleGetRequest();
        }
        break;
    case 'POST':
        handlePostRequest();
        break;
    case 'DELETE':
        handleDeleteRequest();
        break;
    default:
        echo "Méthode HTTP non prise en charge";
        break;
}

// Fonction pour gérer les requêtes GET
function handleGetRequest()
{
    global $conn;
    $sql = "SELECT * FROM articles";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($data);
    

}

// get articles by cetegory
function getByCategory()
{
    global $conn;

    // Récupération de l'id de la catégorie
    $id = $_GET['id'];
    $sql = "SELECT * FROM articles WHERE category_id = $id";

    $result = $conn->query($sql);

    // Vérification de la requête
    if ($result->num_rows > 0) {
        // Conversion des résultats en tableau JSON
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        // Envoi de la réponse en format JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        echo "Aucun article trouvé";
    }
}

function getById()
{
    global $conn;

    // Récupération de l'id de l'article
    $id = $_GET['id'];
    $sql = "SELECT * FROM articles WHERE id = $id";
    $result = $conn->query($sql);

    // Vérification de la requête
    if ($result->num_rows > 0) {
        // Conversion des résultats en tableau JSON
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        // Envoi de la réponse en format JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        echo "Aucun article trouvé";
    }
}

// fonction pour gérer les requêtes POST
function handlePostRequest()
{
    global $conn;

    // Récupération des données envoyées en POST
    $data = json_decode(file_get_contents('php://input'), true);

    // Vérification des données envoyées
    if (isset($data['title']) && isset($data['content']) && isset($data['category_id'])) {
        // Insertion des données dans la base de données
        $title = $data['title'];
        $content = $data['content'];
        $category_id = $data['category_id'];
        $sql = "INSERT INTO articles (title, content, category_id) VALUES ('$title', '$content', '$category_id')";
        if ($conn->query($sql) === TRUE) {
            echo "Article créé avec succès";
        } else {
            echo "Erreur lors de la création de l'article: " . $conn->error;
        }
    } else {
        echo "Données manquantes";
    }
}

// Fonction pour gérer les requêtes DELETE
function handleDeleteRequest(){

    $id = $_GET['id'];
    global $conn;
    $sql = "DELETE FROM articles WHERE id='$id'";
    if($conn->query($sql)){
        http_response_code(200);
        echo "Article supprimé avec succès";}
    else{
        http_response_code(404);
        echo "Erreur lors de la suppression de l'article";
    }
}