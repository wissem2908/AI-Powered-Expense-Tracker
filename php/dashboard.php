<?php
require 'config.php'; // Include database connection

session_start();

    //connexion a la base de données
    $bdd = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . "; charset=utf8", DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure the user is logged in by checking the session
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Get total expenses
        $stmt = $bdd->prepare("SELECT SUM(amount) AS total_expenses FROM expenses WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $total_expenses = $stmt->fetch()['total_expenses'];

        // Get categorized spending
        $stmt = $bdd->prepare("SELECT category, SUM(amount) AS category_total FROM expenses WHERE user_id = :user_id GROUP BY category");
        $stmt->execute([':user_id' => $user_id]);
        $categorized_spending = $stmt->fetchAll();

        // Get monthly spending trends (last 6 months)
        $stmt = $bdd->prepare("SELECT DATE_FORMAT(date, '%Y-%m') AS month, SUM(amount) AS monthly_total FROM expenses WHERE user_id = :user_id GROUP BY month ORDER BY month DESC LIMIT 6");
        $stmt->execute([':user_id' => $user_id]);
        $monthly_trends = $stmt->fetchAll();

        // Output the data as a JSON response (or echo as needed)
        echo json_encode([
            'total_expenses' => $total_expenses,
            'categorized_spending' => $categorized_spending,
            'monthly_trends' => $monthly_trends
        ]);
    } else {
        echo "User not logged in.";
    }
}
?>
