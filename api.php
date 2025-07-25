<?php

$prompt = $_POST[ 'prompt' ];

$dataPath = 'Ahmad.txt';

$myData = file_get_contents( $dataPath );

$finalPrompt = "You are not an AI. You are a smart assistant who only answers based on the information below.\n\n" .
               "ONLY use this data to answer the user's question:\n\n" .
               "$myData\n\n" .
               "User's Question: $prompt\n\n" .
               "If the answer is not found in the data, reply with: 'I don't know based on the provided information.'";


$apiKey = 'AIzaSyATNzBz00m9EOsNyo8m9p1clpOyFKveBa8';
$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key='.$apiKey;

$payload = [
    'contents' => [
        [ 'parts' => [ [ 'text' => $finalPrompt ] ] ]
    ]
];
$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($payload) );
curl_setopt( $ch, CURLOPT_HTTPHEADER, [ 'Content-Type: application/json' ] );
$response = curl_exec($ch);
curl_close($ch);

echo $response;


?>