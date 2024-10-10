<?php
require_once('../paymentmethod/vendor/autoload.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve selected payment method
    $payment_method = $_POST['payment_method'];

    // PayMongo API Key (replace with your actual test key if needed)
    $apiKey = 'sk_test_8FHikGJxuzFP3ix4itFTcQCv';

    // Create a payment link using Guzzle HTTP client
    try {
        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic ' . base64_encode($apiKey . ':'),
                'content-type' => 'application/json',
            ],
            'json' => [
                'data' => [
                    'attributes' => [
                        'amount' => 10000, // Example amount in centavos (100 PHP)
                        'description' => 'Test Payment',
                        'payment_method_types' => [$payment_method] // Dynamic payment method (Gcash or Paymaya)
                    ]
                ]
            ]
        ]);

        $body = json_decode($response->getBody(), true);
        $paymentLink = $body['data']['attributes']['checkout_url'];

        // Redirect user to the payment link
        header('Location: ' . $paymentLink);
        exit;

    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
