<?php
require 'config.php'; // Include database connection

session_start();

// Connection to the database
$bdd = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . "; charset=utf8", DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure the user is logged in by checking the session
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Get the expenses list for the user
        $stmt = $bdd->prepare("SELECT * FROM expenses WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        
        // Fetch the results
        $expenses_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output the data as a JSON response
        echo json_encode([
            'expenses_list' => $expenses_list
        ]);
    } else {
        echo json_encode(['error' => 'User not logged in.']);
    }
}
?>
