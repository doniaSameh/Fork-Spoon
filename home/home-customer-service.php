<?php
$search_result = null;
$search_criteria = null;
if (isset($_SESSION['search_result'])) {
    $search_result = $_SESSION['search_result'];
}
if(isset($_SESSION['search_criteria'])) {
    $search_criteria = $_SESSION['search_criteria'];
}
?>

<div class="container mt-5">
    <h2>Search User Carts</h2>
    <form action="services/search-cart.php" method="post">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Enter search criteria" aria-label="Recipient's username" value="<?php echo $search_criteria; ?>" />
            <div class="input-group-append">
                <button class="btn btn-info" type="submit" id="button-addon2">Search</button>
            </div>
        </div>
    </form>
</div>
<div class="container my-2">
    <?php
    if (isset($search_result)) {
        foreach ($search_result as $result) {
            if (empty($result['flights'])) {
                continue;
            }
            echo '
                <div class="card mb-5">
                <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <img width="100" src="/egyway' . $result['user_picture'] . '" />
                    </div>
                    <div class="col-8">
                        <h4>' . $result['user_name'] . '</h4>
                    </div>
                    <div class="col-2">
                        <button onclick="handleCancelOrderClick(' . $result['user_id'] . ')" class="btn btn-danger" data-toggle="modal" data-target="#cancelOrderModal">Cancel Order</button>
                    </div>
                </div>';
            foreach ($result['flights'] as $flight) {
                echo '<div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="ms-3">
                                        <h5>' . $flight['flight_number'] . '</h5>
                                        <p class="small mb-0"><b>Departure:</b> ' . $flight['dept_airport'] . '</p>
                                        <p class="small mb-2">' . $flight['dept_date'] . '</p>
                                            <p class="small mb-0"><b>Arrival:</b> ' . $flight['arrival_airport'] . '</p>
                                        <p class="small mb-1">' . $flight['arrival_date'] . '</p>

                                    </div>
                                </div>
                                <div class="d-flex flex-row align-items-center">
                                    <div style="width: 120px;">
                                        <h5 class="mb-0"><p class="price">' . $flight['price'] . '</p> EGP</h5>
                                    </div>
                                    <a onclick="handleRemoveFromCartClick(' . $flight['id'] . ', ' . $result['user_id'] . ')" href="#!" class="text-danger"><i class="fas fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            echo '<div class="pb-5">';
            require('flights/all-flights-form.php');
            echo '</div>
            </div>
            </div>';
        }
    } ?>
</div>
<?php require_once('popups/cancel-order-modal.php'); ?>
<script>
    function handleRemoveFromCartClick(flightId, userId) {
        let ajaxData = 'flightId=' + flightId + '&userId=' + userId;
        $.ajax({
            type: "POST",
            url: "services/cart/remove-from-cart-customer-service.php",
            dataType: "json",
            data: ajaxData,
            success: function(data) {}
        });
        location.reload();
        alert("Removed flight from user cart successfully !")
    }

    // Disable Logic
    function handleCancelOrderClick(userId) {
        // Set the defined userId for the disable modal
        $('#userId').val(userId);
    }

    function handleConfirmClick() {
        let userId = $('#userId').val();
        let ajaxData = 'userId=' + userId;
        $.ajax({
            url: 'services/cancel-order.php',
            method: "POST",
            data: ajaxData,
            success: function(response) {
                alert("Order has been canceled successfully!");
                location.reload();
            },
            error: function(err) {
                alert('Failed to update')
            }
        });
    }
</script>