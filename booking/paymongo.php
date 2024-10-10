<?php
// require_once('../paymentmethod/vendor/autoload.php');

// Replace with your PayMongo API keys
$api_key = 'pk_test_WLnVGBjNdZeqPjoSUpyDk7qu';
$api_secret = 'sk_test_8FHikGJxuzFP3ix4itFTcQCv';

// Get the payment method from the form data
$payment_method = $_POST['payment_method'];


// Get the payment amount from the session
$amount = $_SESSION['pay'];

// Set the payment description (replace with your desired description)
$description = 'Test payment';

// Create a new PayMongo client
$client = new \GuzzleHttp\Client();

// Set the API endpoint and authentication headers
$endpoint = 'https://api.paymongo.com/v1/links';
$headers = [
    'accept' => 'application/json',
    'content-type' => 'application/json',
    'authorization' => 'Basic ' . base64_encode($api_key . ':' . $api_secret),
];

// Set the payment data
$data = [
    'data' => [
        'attributes' => [
            'amount' => $amount,
            'description' => $description,
            'currency' => 'PHP',
            'payment_method_types' => [$payment_method],
        ],
    ],
];

// Convert the data to JSON
$json_data = json_encode($data);

// Send the request to PayMongo
$response = $client->request('POST', $endpoint, [
    'headers' => $headers,
    'body' => $json_data,
]);

// Get the response data
$response_data = json_decode($response->getBody(), true);

// Get the payment link
$payment_link = $response_data['data']['attributes']['url'];

// Redirect the user to the payment link
header('Location: ' . $payment_link);
exit;