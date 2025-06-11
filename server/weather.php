<?php

// require './client/header.php';
// require 'loadEnv.php';

// $decoded = null; 

// if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search-weather'])) {

//     $userInput = htmlspecialchars(trim($_GET['userInput']));

//     if (empty($userInput)) {
//         exit("Please enter a valid city name.");
//     }

//     $BASE_URL = 'https://api.weatherapi.com';
//     $API_PATH = '/v1/current.json?';
//     $API_KEY = 'key=' . $_ENV['WEATHER_KEY'];
//     $SEPARATOR = '&';
//     $CITY = $userInput;  // User input 
//     $LOCATION = 'q=' . $CITY;
//     $AQI = 'aqi=yes';
//     $URL = $BASE_URL . $API_PATH . $API_KEY . $SEPARATOR . $LOCATION . $SEPARATOR . $AQI;

//     $data = file_get_contents($URL);
//     $decoded = json_decode($data, true); 

//     if ($decoded === null || !isset($decoded['current'])) {
//         exit("Error fetching data for the city. Please try again.");
//     }

// }
