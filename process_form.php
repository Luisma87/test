<?php
require 'vendor/autoload.php'; // Assuming OpenAI PHP client is installed via Composer

use OpenAI\Client;

// Replace with your OpenAI API key
$openai = new Client([
    'api_key' => 'your-openai-api-key',
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orgName = $_POST['orgName'] ?? '';
    $mailingAddress = $_POST['mailingAddress'] ?? '';
    $ein = $_POST['ein'] ?? '';
    $activities = $_POST['activities'] ?? '';

    $prompt = "Based on the following organization information, provide recommendations for improving the answers:\n\n" .
        "Organization Name: $orgName\n" .
        "Mailing Address: $mailingAddress\n" .
        "EIN: $ein\n" .
        "Activities: $activities\n";

    try {
        $response = $openai->completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => 150,
        ]);

        echo json_encode(['recommendations' => $response['choices'][0]['text']]);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
