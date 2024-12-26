<?php
require 'config.php'; // Include database connection

session_start();
// Connection to the database
$bdd = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . "; charset=utf8", DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
// Ensure the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Check if POST data is received
    if (isset($_POST['amount'], $_POST['category'], $_POST['date'])) {
        $amount = $_POST['amount'];
        $category = $_POST['category'];
        $date = $_POST['date'];
        $description = isset($_POST['description']) ? $_POST['description'] : ''; // Optional field

        // Insert expense into the database
        try {
            $bdd = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . "; charset=utf8", DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $stmt = $bdd->prepare("INSERT INTO expenses (user_id, amount, category, date, description) VALUES (:user_id, :amount, :category, :date, :description)");
            $stmt->execute([
                ':user_id' => $user_id,
                ':amount' => $amount,
                ':category' => $category,
                ':date' => $date,
                ':description' => $description
            ]);

            // Send a success response with string
            echo json_encode(['status' => 'success']);
        } catch (PDOException $e) {
            // Send error response with string
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
}
?>
