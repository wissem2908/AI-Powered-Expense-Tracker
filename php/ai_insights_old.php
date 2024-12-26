<?php

function getAIInsights($spendingData) {
    // Set up the API URL and key
    $apiUrl = "https://api-inference.huggingface.co/models/bigscience/bloom"; // Replace with your desired Hugging Face model
    $apiKey = "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"; // Replace with your Hugging Face API key

    // Prepare the input prompt for the model
    $prompt = "Analyze the following spending data and provide insights and saving tips:\n";
    foreach ($spendingData as $category => $amount) {
        $prompt .= "$category: $amount\n";
    }

    // Set up the request payload
    $payload = json_encode([
        "inputs" => $prompt,
        "parameters" => [
            "max_new_tokens" => 150,
            "temperature" => 0.7
        ]
    ]);

    // Initialize cURL
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    // Execute the request and handle errors
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        return "Error: $error";
    }
    curl_close($ch);

    // Decode and return the response
    $responseData = json_decode($response, true);
    if (isset($responseData['error'])) {
        return "API Error: " . $responseData['error'];
    }

    return $responseData[0]['generated_text'] ?? "No insights generated.";
}

// Example spending data
$categorized_spending = [
    'Food' => 300,
    'Transport' => 150,
    'Utilities' => 100,
    'Entertainment' => 50
];

// Call the AI insights function
$ai_insights = getAIInsights($categorized_spending);
echo json_encode($ai_insights);
?>
