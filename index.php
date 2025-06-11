<?php

/*--------------------------------------------------------------------------
 * Project : Easy-Weather App    				           |
 * -------------------------------------------------------------------------
 
 * Developer   : Tayyab Sabir
 * Email       : tayyabsabir72@gmail.com
 * GitHub      : https://github.com/tayyab1251/
 * Year        : 2K24
 * -------------------------------------------------------------------------*/

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);

require 'client/header.php';
// require 'loadEnv.php';

$decoded = null;
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search-weather'])) {

    $userInput = htmlspecialchars(trim($_GET['userInput']));

    if (empty($userInput)) {
        exit("Please enter a valid city name.");
    }

    $key = 'f5951fb2359845c6be04473825160510712l';

    $BASE_URL = 'https://api.weatherapi.com';
    $API_PATH = '/v1/current.json?';
    $API_KEY = 'key=' . $key;
    $SEPARATOR = '&';
    $CITY = $userInput;  // User input 
    $LOCATION = 'q=' . $CITY;
    $AQI = 'aqi=yes';
    $URL = $BASE_URL . $API_PATH . $API_KEY . $SEPARATOR . $LOCATION . $SEPARATOR . $AQI;

    $data = file_get_contents($URL);
    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";
    $decoded = json_decode($data, true);
    //echo "<pre>";
    //print_r($decoded);
    //echo "</pre>";
    if ($decoded === null || !isset($decoded['current'])) {
        exit("Error fetching data for the city. Please try again.");
    }
}

?>

<!-- Outer div -->
<div class="container">
    <div class="title">
        <h1 class="appName">Easy Weather</h1>
    </div>

    <!-- Search -->
    <div class="search-field">
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET">
            <div class="userInput-div">
                <input type="text" class="userInput" name="userInput" placeholder="Search your place here..." value="<?php echo isset($_GET['userInput']) ? $_GET['userInput'] : ''; ?>">
                <input class="submit-btn" value="Search" name="search-weather" type="submit">
            </div>
        </form>
    </div>
    <!-- Search ends -->

    <!-- Main -->
    <div class="main">
        <!-- Left Side -->
        <div class="left-side">
            <?php if ($decoded): ?>
                <h2><?php echo htmlspecialchars($decoded['location']['name']); ?></h2>
                <p class="temp"><?php echo $decoded['current']['temp_c'] ?> &#176; C</p>
            <?php else: ?>
                <p>Please search for a city to get weather data.</p>
            <?php endif; ?>
        </div>
        <!-- Left Side ends -->

        <!-- Right Side -->
        <div class="right-side">
            <div class="img">
                <?php if (isset($decoded) && isset($decoded['current']['condition']['icon'])): ?>
                    <img src="https:<?php echo $decoded['current']['condition']['icon']; ?>" class="weather-img" alt="Weather Icon">
                    <small><?php echo htmlspecialchars($decoded['current']['condition']['text']); ?></small>
                <?php endif; ?>
            </div>
        </div>
        <!-- Right Side ends -->
    </div>
    <!-- Main ends -->

    <!-- conditions -->
    <div class="conditions">
        <div class="feelsLike">
            <div class="left">
                <h2><i class="ri-temp-hot-fill"></i> Feels like</h2>
                <?php if ($decoded): ?>
                    <p class="temp2"><?php echo $decoded['current']['feelslike_c'] . '<small style="font-size:0.9rem;  padding:0.5rem; font-weight:100;">&#176; C</small>'; ?> </p>
                <?php endif; ?>
            </div>
            <div class="right">

                <h2><i class="ri-windy-fill"></i> Wind</h2>
                <?php if ($decoded): ?>
                    <p class="temp2"><?php echo $decoded['current']['wind_kph'] . '<small style="font-size:0.9rem;  padding:0.5rem; font-weight:100;">kph</small>'; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="feelsLike">
            <div class="left">
                <h2><i class="ri-water-percent-fill"></i> Humidity</h2>
                <?php if ($decoded): ?>
                    <p class="chances"><?php echo $decoded['current']['humidity'] . '<small style="font-size:0.9rem;  padding:0.5rem; font-weight:100;">%</small>'; ?> </p>
                <?php endif; ?>
            </div>
            <div class="right">
                <h2> <i class="ri-sun-line"></i> UV Index</h2>
                <?php if ($decoded): ?>
                    <p class="index">
                        <?php
                        $UV_Index = $decoded['current']['uv'];
                        if ($UV_Index >= 0 && $UV_Index <= 2) {
                            echo $UV_Index . '<small style="font-size:0.9rem;  padding:0.5rem; font-weight:100;">low</small>';
                        } elseif ($UV_Index > 2 && $UV_Index <= 5) {
                            echo $UV_Index . '<small style="font-size:0.9rem;  padding:0.5rem; font-weight:100;">moderate</small> ';
                        } elseif ($UV_Index > 5 && $UV_Index <= 7) {
                            echo $UV_Index . '<small style="font-size:0.9rem;  padding:0.5rem; font-weight:100;">high</small>';
                        } elseif ($UV_Index > 7  && $UV_Index <= 10) {
                            echo $UV_Index . '<small style="font-size:0.9rem;  padding:0.5rem; font-weight:100;">very high</small> ';
                        } else {
                            echo $UV_Index . '<small style="font-size:0.9rem;  padding:0.5rem; font-weight:100;">extreme</small> ';
                        }
                        ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
<!-- Outer ends -->

<?php require './client/footer.php'; ?>