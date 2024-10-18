<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
  $state = $_POST['state'];
  $account_length = $_POST['account_length'];
  $area_code = $_POST['area_code'];
  $intl_plan = $_POST['intl_plan'];
  $vmail_plan = $_POST['vmail_plan'];
  $vmail_messages = $_POST['vmail_messages'];
  $day_minutes = $_POST['day_minutes'];
  $day_calls = $_POST['day_calls'];
  $day_charge = $_POST['day_charge'];
  $eve_minutes = $_POST['eve_minutes'];
  $eve_calls = $_POST['eve_calls'];
  $eve_charge = $_POST['eve_charge'];
  $night_minutes = $_POST['night_minutes'];
  $night_calls = $_POST['night_calls'];
  $night_charge = $_POST['night_charge'];
  $intl_minutes = $_POST['intl_minutes'];
  $intl_calls = $_POST['intl_calls'];
  $intl_charge = $_POST['intl_charge'];
  $service_calls = $_POST['service_calls'];

  // Prepare the data to send to the Flask API
  $data = [
    'account_length' => $account_length,
    'area_code' => $area_code,
    'intl_plan' => ($intl_plan == 'yes' ? 1 : 0),
    'vmail_plan' => ($vmail_plan == 'yes' ? 1 : 0),
    'vmail_messages' => $vmail_messages,
    'day_minutes' => $day_minutes,
    'day_calls' => $day_calls,
    'day_charge' => $day_charge,
    'eve_minutes' => $eve_minutes,
    'eve_calls' => $eve_calls,
    'eve_charge' => $eve_charge,
    'night_minutes' => $night_minutes,
    'night_calls' => $night_calls,
    'night_charge' => $night_charge,
    'intl_minutes' => $intl_minutes,
    'intl_calls' => $intl_calls,
    'intl_charge' => $intl_charge,
    'service_calls' => $service_calls,
  ];

  // Send the data to the Flask API using cURL
  $ch = curl_init('http://127.0.0.1:5000/predict');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

  $response = curl_exec($ch);
  curl_close($ch);

  // Decode the response
  $result = json_decode($response, true);
  $_SESSION['prediction'] = $result['prediction'];
  header('location: result.php');
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Forecast Customer Attrition in a Telecommunication firm through the Implementation of Deep Neural Networks</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- Material Kit CSS -->
  <link href="assets/css/material-kit.css?v=3.0.0" rel="stylesheet" />
</head>

<body>
  <!-- Navbar Transparent -->
  <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3 navbar-transparent">
    <div class="container">
      <a class="navbar-brand text-white text-center mx-auto w-full font-weight-bolder" href="predict.php" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom" target="_blank">
        Forecast Customer Attrition in a Telecommunication firm through the Implementation of Deep Neural Networks.
      </a>
    </div>
  </nav>
  <!-- End Navbar -->


  <div class="page-header min-vh-100 px-0" style="background-image: url('https://images.unsplash.com/photo-1630752708689-02c8636b9141?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2490&q=80')">
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container mx-auto">
      <div class="row">
        <div class="col-md-12 mx-auto">
          <div class="card card-body shadow-xl mx-3 mx-md-4">
            <div class="container">
              <h2>Forecast Customer Attrition in a Telecommunication Firm</h2>
              <form action="predict.php" method="POST">
                <div class="row">
                  <div class="col-6">

                    <div class="row">
                      <div class="col-6">
                        <label for="state">State</label>
                        <input type="text" id="state" name="state" placeholder='eg. HT' required>
                      </div>
                      <div class="col-6">
                        <label for="account_length">Account Length</label>
                        <input type="number" id="account_length" name="account_length" placeholder='eg. 80' required>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-6">
                        <label for="area_code">Area Code</label>
                        <input type="number" id="area_code" name="area_code" placeholder='eg. 415' required>
                      </div>
                      <div class="col-6">
                        <label for="intl_plan">International Plan</label>
                        <input type="number" id="intl_plan" name="intl_plan" placeholder='1 for yes, 0 for no' required>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-6">
                        <label for="vmail_plan">Voice Mail Plan</label>
                        <input type="number" id="vmail_plan" name="vmail_plan" placeholder='1 for yes, 0 for no' required>
                      </div>
                      <div class="col-6">
                        <label for="vmail_messages">Number of Voicemail Messages</label>
                        <input type="number" id="vmail_messages" name="vmail_messages" placeholder='eg. 0' required>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-6">
                        <label for="day_minutes">Total Day Minutes</label>
                        <input type="number" step="0.01" id="day_minutes" name="day_minutes" placeholder='eg. 120.5' required>
                      </div>
                      <div class="col-6">
                        <label for="day_calls">Total Day Calls</label>
                        <input type="number" id="day_calls" name="day_calls" placeholder='eg. 100' required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <label for="day_charge">Total Day Charge</label>
                        <input type="number" step="0.01" id="day_charge" name="day_charge" placeholder='eg. 30.24' required>
                      </div>
                      <div class="col-6">
                        <label for="eve_minutes">Total Evening Minutes</label>
                        <input type="number" step="0.01" id="eve_minutes" name="eve_minutes" placeholder='eg. 90.3' required>
                      </div>
                    </div>
                  </div>

                  <div class="col-6">

                    <div class="row">
                      <div class="col-6">
                        <label for="eve_calls">Total Evening Calls</label>
                        <input type="number" id="eve_calls" name="eve_calls" placeholder='eg. 90' required>
                      </div>
                      <div class="col-6">
                        <label for="eve_charge">Total Evening Charge</label>
                        <input type="number" step="0.01" id="eve_charge" name="eve_charge" placeholder='eg. 10.3' required>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-6">
                        <label for="night_minutes">Total Night Minutes</label>
                        <input type="number" step="0.01" id="night_minutes" name="night_minutes" placeholder='eg. 150.0' required>
                      </div>
                      <div class="col-6">
                        <label for="night_calls">Total Night Calls</label>
                        <input type="number" id="night_calls" name="night_calls" placeholder='eg. 95' required>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-6">
                        <label for="night_charge">Total Night Charge</label>
                        <input type="number" step="0.01" id="night_charge" name="night_charge" placeholder='eg. 7.0' required>
                      </div>
                      <div class="col-6">
                        <label for="intl_minutes">Total International Minutes</label>
                        <input type="number" step="0.01" id="intl_minutes" name="intl_minutes" placeholder='eg. 12.0' required>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-6">
                        <label for="intl_calls">Total International Calls</label>
                        <input type="number" id="intl_calls" name="intl_calls" placeholder='eg. 15' required>
                      </div>
                      <div class="col-6">
                        <label for="intl_charge">Total International Charge</label>
                        <input type="number" step="0.01" id="intl_charge" name="intl_charge" placeholder='eg. 3.24' required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <label for="service_calls">Customer Service Calls</label>
                        <input type="number" id="service_calls" name="service_calls" placeholder='eg. 5' required>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class='btn bg-info text-white mt-5'>Predict</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>