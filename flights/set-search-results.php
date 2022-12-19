<?php require_once($_SERVER['DOCUMENT_ROOT']."/fork&spoon/database-manager/database-object.php");?>
<?php

$search_criteria = $_SESSION['search_criteria'];
$search_critera_lower = strtolower($search_criteria);

$cart = $_SESSION["cart"];
$search_result = array();
if(isset($cart)) {
    foreach (array_keys($cart) as $userId) {
        // Flags used to define if search is found
        $found_in_name = false;
        $found_in_flights = false;
    
        $user_flights = array();
    
        $db->where("id", $userId);
        $user = $db->getOne("users");
        // Search for the user by his name entered in the search box
        $user_name_lower = strtolower($user['name']);
        if (str_contains($user_name_lower, $search_critera_lower)) {
            $found_in_name = true;
        }
        foreach ($cart[$userId] as $flightId) {
            $db->where("id", $flightId);
            $flight = $db->getOne("flight_list");
    
            $db->where("id", $flight['departure_airport_id']);
            $dept_airport = $db->getOne("airport_list");
    
            $db->where("id", $flight['arrival_airport_id']);
            $arrival_airport = $db->getOne("airport_list");
    
            array_push($user_flights, array(
                'id' => $flight['id'],
                'flight_number' => $flight['plane_no'],
                'dept_date' => date('d-M-Y h:i a', strtotime($flight['departure_datetime'])),
                'arrival_date' => date('d-M-Y h:i a', strtotime($flight['arrival_datetime'])),
                'dept_airport' => $dept_airport['airport'],
                'arrival_airport' => $arrival_airport['airport'],
                'price' => $flight['price']
            ));
    
            // Check if has search critera
            $plan_name_lower = strtolower($flight['plane_no']);
            if (str_contains($plan_name_lower, $search_critera_lower)) {
                $found_in_flights = true;
            }
        }
        // Before pushing the result make sure it contains the search criteria
        if ($found_in_flights or $found_in_name) {
            $search_result[$user['id']] = array(
                'user_id' => $user['id'],
                'user_name' => $user['name'],
                'user_picture' => $user['pictureUrl'],
                'flights' => $user_flights
            );
        }
    }
    $_SESSION['search_result'] = $search_result;
    header('Location: /egyway/');
} else {
    header('Location: /egyway?noResults=true');
}
