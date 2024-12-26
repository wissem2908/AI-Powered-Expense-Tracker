<?php
require 'config.php'; // Include database connection



try {

    //connexion a la base de données
    $bdd = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . "; charset=utf8", DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = sha1(trim($_POST['password']));
    
        $stmt = $bdd->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        try {
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $password,
            ]);
            echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
        
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                echo "Error: Username or Email already exists.";
            } else {
                echo "Error: " . $e->getMessage();
            }
        }
    }
    
    } catch (Exception $e) {
    $msg = $e->getMessage();
    echo json_encode(array("reponse" => "false", "place" => "tc", "message" => $msg, "type" => "danger", "icon" => "nc-icon nc-bell-55", "autoDismiss" => 0));
    }
    
?>

