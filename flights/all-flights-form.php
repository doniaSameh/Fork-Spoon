<?php
// Get all the flights for the dropdown
$allFlights = $db->get("flight_list");

$now = new DateTime();
echo '
<form onsubmit="handleAddFlightForm()" action="services/add-flight-to-user.php" method="POST">
<input type="hidden" name="userId" value="' . $result['user_id'] . '" />
<label>Add New Flight</label>
    <div class="d-flex">
    <select name="flightId" class="form-control">';
foreach ($allFlights as $flight) {
    // Check the flight date
    $flightDate = new DateTime($flight['departure_datetime']);
    $flightDateText = date('d-M-Y h:i a', strtotime($flight['departure_datetime']));
    if ($flightDate >= $now) {
        echo '<option value="' . $flight['id'] . '">' . $flight['plane_no'] . ' | ' .  $flightDateText  . '</option>';
    }
}
echo '</select>
<button type="submit" class="btn btn-info">Add</button>
</div>
</form>';
?>

<script>
    function handleAddFlightForm() {
        alert("Flight has been added / updated successfully!");
    }
</script>