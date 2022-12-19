<?php
$goingFrom = '';
$goingTo = '';
$dateFrom = '';
$dateTo = '';
// Multiple destination variables
$goingFromMultiple = array();
$goingToMultiple = array();
$dateFromMultiple = array();
$dateToMultiple = array();
if (isset($_POST['dateFrom'])) {
    $goingFrom = $_POST['goingFrom'];
    $goingTo = $_POST['goingTo'];
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];
}

// Multiple destinations variables
if (isset($_POST['dateFromMultiple'])) {
    $goingFromMultiple = $_POST['goingFromMultiple'];
    $goingToMultiple = $_POST['goingToMultiple'];
    $dateFromMultiple = $_POST['dateFromMultiple'];
    $dateToMultiple = $_POST['dateToMultiple'];
}

$airports = $db->get("airport_list");
$airportsFromDropdown = '';
$airportsToDropdown = '';

$selectedFrom = '';
foreach ($airports as $value) {
    if ($value['id'] == $goingFrom) {
        $selectedFrom = 'selected';
    } else {
        $selectedFrom = '';
    }
    $airportsFromDropdown .= '<option ' . $selectedFrom . ' value="' . $value['id'] . '">' . $value['airport'] . '</option>';
}

$selectedTo = '';
foreach ($airports as $value) {
    if ($value['id'] == $goingTo) {
        $selectedTo = 'selected';
    } else {
        $selectedTo = '';
    }
    $airportsToDropdown .= '<option ' . $selectedTo . ' value="' . $value['id'] . '">' . $value['airport'] . '</option>';
}
?>

<form action="flights.php" method="POST">
    <div class="row">
        <div class="col-12 mb-2">
            <label for="travelType">Select Travel Type</label>
            <select id="travelType" name="travelType" class="form-control" required onchange="onTravelTypeChange()">
                <option disabled selected value>Select...</option>
                <option value="1">Return in less than 7 days</option>
                <option value="2">Return after 7 days</option>
                <option value="3">Transit flight</option>
                <option value="4">Direct flight</option>
                <option value="5">Multiple destinations</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <label>Leaving From</label>
            <select name="goingFrom" class="form-control" required>
                <option disabled selected value>Select...</option>
                <?php echo $airportsFromDropdown ?>
            </select>
        </div>
        <div class="col-3">
            <label>Going To</label>
            <select name="goingTo" class="form-control" required>
                <option disabled selected value>Select...</option>
                <?php echo $airportsToDropdown ?>
            </select>
        </div>
        <div class="col-3">
            <label>Departing</label>
            <input id="dateFrom" name="dateFrom" class="form-control" type="date" value="<?php echo $dateFrom; ?>" required />
        </div>
        <div class="col-3">
            <label>Returning</label>
            <input id="dateTo" name="dateTo" class="form-control" type="date" value="<?php echo $dateTo; ?>" required />
        </div>
    </div>
    <div id="multipleDestinationFlight" class="row my-2">
        <div class="col-3">
            <label>Leaving From</label>
            <select name="goingFromMultiple[]" class="form-control">
                <option disabled selected value>Select...</option>
                <?php echo $airportsFromDropdown ?>
            </select>
        </div>
        <div class="col-3">
            <label>Going To</label>
            <select name="goingToMultiple[]" class="form-control">
                <option disabled selected value>Select...</option>
                <?php echo $airportsToDropdown ?>
            </select>
        </div>
        <div class="col-3">
            <label>Departing</label>
            <input id="dateFrom" name="dateFromMultiple[]" class="form-control" type="date" />
        </div>
        <div class="col-3">
            <label>Returning</label>
            <input id="dateTo" name="dateToMultiple[]" class="form-control" type="date" />
        </div>
    </div>
    <!-- The add more than one flights -->
    <div id="multipleFlights" class="row">
        <?php
        for ($rowCounter = 0; $rowCounter < count($goingFromMultiple); $rowCounter++) {
            echo '<div id="' . $rowCounter + 1 . '" class="col-12 my-2">
                <div class="row">
                    <div class="col-3">
                        <label>Leaving From</label>
                        <select name="goingFromMultiple[]" class="form-control" required>
                            <option disabled selected value>Select...</option>
                            ' . $airportsFromDropdown  . '
                        </select>
                    </div>
                    <div class="col-3">
                        <label>Going To</label>
                        <select name="goingToMultiple[]" class="form-control" required>
                            <option disabled selected value>Select...</option>
                            ' .  $airportsToDropdown . '
                        </select>
                    </div>
                    <div class="col-3">
                        <label>Departing</label>
                        <input id="dateFrom" name="dateFromMultiple[]" class="form-control" type="date" value=" ' . $dateFromMultiple[$rowCounter] . '" required />
                    </div>
                    <div class="col-3">
                        <label>Returning</label>
                        <input id="dateTo" name="dateToMultiple[]" class="form-control" type="date" required />
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
    <div>
        <button type="button" id="addFlightBtn" class="btn btn-link" onclick="handleAddFlightClick()">+ Add another flight</button>
        <button type="button" id="removeFlightBtn" class="btn btn-link text-danger" onclick="handleRemoveFlightClick()">- Remove flight</button>
    </div>
    <div class="col-12 mt-2">
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
</form>

<script>
    let rowsCount = Number('<?php echo count($dateFromMultiple) ?>') ?? 1;

    $('#addFlightBtn').hide();
    $('#removeFlightBtn').hide();
    $('#multipleDestinationFlight').hide();

    let row = function(rowId) {
        return `
            <div id="${rowId}" class="col-12 my-2">
                <div class="row">
                    <div class="col-3">
                        <label>Leaving From</label>
                        <select name="goingFromMultiple[]" class="form-control" required>
                            <option disabled selected value>Select...</option>
                            <?php echo $airportsFromDropdown ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <label>Going To</label>
                        <select name="goingToMultiple[]" class="form-control" required>
                            <option disabled selected value>Select...</option>
                            <?php echo $airportsToDropdown ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <label>Departing</label>
                        <input id="dateFrom" name="dateFromMultiple[]" class="form-control" type="date" required />
                    </div>
                    <div class="col-3">
                        <label>Returning</label>
                        <input id="dateTo" name="dateToMultiple[]" class="form-control" type="date" required />
                    </div>
                </div>
            </div>`;
    }

    function handleAddFlightClick() {
        rowsCount += 1;
        $('#multipleFlights').append(row(rowsCount));
        $('#removeFlightBtn').show();
    }

    function handleRemoveFlightClick() {
        $('#multipleFlights').find('#' + rowsCount).remove();
        rowsCount -= 1;
        if (rowsCount == 1) {
            $('#removeFlightBtn').hide();

        }
    }

    function GetFormattedDate(days) {
        let today = new Date();
        today.setDate(today.getDate() + days);
        let year = today.getFullYear();
        let month = (today.getMonth() <= 9 ? '0' : '') + (today.getMonth() + 1);
        let day = (today.getDate() <= 9 ? '0' : '') + today.getDate();
        return year + '-' + month + '-' + day;
    }

    // Set the min date for dateFrom to be today
    $('#dateFrom').attr('min', GetFormattedDate(0))


    function onTravelTypeChange() {
        const travelType = $('#travelType').val();
        switch (travelType) {
            case "1":
                let maxDate = GetFormattedDate(7)
                $('#dateTo').attr('max', maxDate);
                $('#dateTo').attr('min', null);
                $('#multipleDestinationFlight').hide();
                $('#removeFlightBtn').hide();
                $('#addFlightBtn').hide();
                break;
            case "2":
                let minDate = GetFormattedDate(7)
                $('#dateTo').attr('min', minDate);
                $('#dateTo').attr('max', null);
                $('#multipleDestinationFlight').hide();
                $('#removeFlightBtn').hide();
                $('#addFlightBtn').hide();
                break;
            case "5":
                $('#multipleDestinationFlight').show();
                $('#addFlightBtn').show();
                $('#removeFlightBtn').hide();
                break;
            default:
                $('#multipleDestinationFlight').hide();

        }

    }
</script>