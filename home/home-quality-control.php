<?php
$users = $db->get("users");
$usersResult = '';

foreach ($users as $user) {
    // Skip if this is the admin user
    if ($user['email'] == 'admin@admin.com') {
        continue;
    }

    // Check if already approved then hide the approve option
    $approveOption = '<a onclick="handleApprove(' . $user['id'] . ')" class="dropdown-item" href="#">Approve</a>';
    $approveText = '';
    if ($user['status'] == 'approved') {
        $approveOption = '';
        $approveText = '<div class="text-success">' . $user['status'] . '</div>';
    } else {
        $approveText = '<div class="text-warning">' . $user['status'] . '</div>';
    }

    $promoteOption = '';
    if ($user['role'] == 'customerService') {
        $promoteOption = '<a onclick="handlePromote(' . $user['id'] . ')" class="dropdown-item" href="#">Promote</a>';
    }

    // Check if disabled
    $disabledText = 'No';
    if ($user['isDisabled']) {
        $disabledText = '<div class="text-danger">Yes</div>';
    }


    $usersResult .= '<tr>' .
        '<td>' . $user['id'] . '</td>' .
        '<td>' . $user['name'] . '</td>' .
        '<td>' . $disabledText . '</td>' .
        '<td>' . $approveText . '</td>' .
        '<td>' . $user['email'] . '</td>' .
        '<td>' . $user['role'] . '</td>' .
        '<td>' .
        '<div class="dropdown show">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Options
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                ' . $approveOption . '
                ' . $disableEnableOption . '
                ' . $promoteOption . '
            </div>
        </div>' . '</td>' .
        '</tr>';
}
?>
<div class="container my-5">
    <h1 class="text-center mb-4">Welcome to your admin panel.</h1>
    <div class="row">
        <div class="col-6">
            <h2>User Accounts</h2>
        </div>
        <div class="col-6">
            <a class="btn btn-primary float-right" href="add-user.php">Add New User</a>
        </div>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Status</th>
                <th>Email</th>
                <th>Role</th>
                <th>-</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $usersResult ?>
        </tbody>
    </table>
</div>
<?php require_once('popups/disable-user-modal.php'); ?>
<script>
    // Approve logic
    function handleApprove(userId) {
        let ajaxData = 'userId=' + userId;
        $.ajax({
            url: 'services/user-service/approve-user.php',
            method: "POST",
            data: ajaxData,
            success: function(response) {
                alert("User has been approved successfully!");
                location.reload();
            },
            error: function(err) {
                alert('Failed to update')
            }
        });
    }

    // Disable Logic
    function handleDisableClick(userId) {
        // Set the defined userId for the disable modal
        $('#disableUserId').val(userId);
    }

    function handleEnableClick(userId) {
        let ajaxData = 'userId=' + userId;
        $.ajax({
            url: 'services/user-service/enable-user.php',
            method: "POST",
            data: ajaxData,
            success: function(response) {
                alert("User enabled successfully!");
                location.reload();
            },
            error: function(err) {
                alert('Failed to update')
            }
        });
    }

    // Promote Logic
    function handlePromote(userId) {
        let ajaxData = 'userId=' + userId;
        $.ajax({
            url: 'services/user-service/promote-user.php',
            method: "POST",
            data: ajaxData,
            success: function(response) {
                alert("Customer serivce user has been promoted successfully!");
                location.reload();
            },
            error: function(err) {
                alert('Failed to update')
            }
        });
    }

    function handleSaveChanges() {
        let userId = $('#disableUserId').val();
        let ajaxData = 'userId=' + userId + '&' + 'disableComment=' + $('#disableUserComment').val();
        $.ajax({
            url: 'services/user-service/disable-user.php',
            method: "POST",
            data: ajaxData,
            success: function(response) {
                alert("User disabled successfully!");
                location.reload();
            },
            error: function(err) {
                alert('Failed to update')
            }
        });
    }
</script>