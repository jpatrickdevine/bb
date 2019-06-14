<?php
/*
 * B!B! console requests script - requests.php
 */
// page title
$pageTitle = 'Requests';
// include header and top nav
include '_includes/header.inc.php';
// include console sidebar
include '_includes/sidebar.inc.php';

/* Get all requests that haven't been denied/confirmed and
the reservation date is for today's date or later */
$q = "SELECT * FROM requests WHERE contacted IS NULL AND UNIX_TIMESTAMP(STR_TO_DATE(JSON_UNQUOTE(JSON_EXTRACT(JSON_request, '$.date')), '%Y%m%d')) >= UNIX_TIMESTAMP(CURRENT_DATE()) ORDER BY time_requested ASC";
$r = queryMysql($q);
// fetch result
$rows = $r->num_rows;

echo <<<_END
                    <div class="row pt-4 pb-2 mb-3">
                        <div class="col">
                            <h1 class="h2 my-4">Requests</h1>
                        </div>
                        <div class="col">
                            <div class="dropleft text-right my-4">
                                <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-toggle="dropdown">
                                    Select Date
                                </button>
                                <div id="datepicker" class="dropdown-menu p-0"></div>
                            </div>
                        </div>
                    </div>

                    <h5 class="text-secondary">New Requests</h5>

_END;

if ($rows == "") {
    echo <<<_END
                    <div class="alert alert-secondary" role="alert">
                        There are no new requests
                    </div>

_END;
    } else {
        echo <<< _END
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Requested</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Party</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Notes</th>
                                    <th scope="col">Deny</th>
                                    <th scope="col">Confirm</th>
                                </tr>
                            </thead>
                            <tbody>

_END;

        for ($j = 0; $j < $rows; ++$j)
        {
            $r->data_seek($j);
            $row = $r->fetch_array(MYSQLI_ASSOC);

            $reqID = $row['request_id'];

            $req = parseJSONrequest($row['JSON_request']);

            $birthday = "";
            $anniversary = "";
            $allergy = "";
            if ($req['birthday']) {
                $birthday = '&#10003; Birthday <br>';
            }
            if ($req['anniversary']) {
                $anniversary = '&#10003; Anniversary <br>';
            }
            if ($req['allergy']) {
                $allergy = '&#10003; Allergy <br>';
            }

            echo '<tr>';
            echo '<th scope="row">' . $row['time_requested'] . '</th>';
            echo '<td>' . $req['dateNice'] . '</td>';
            echo '<td>' . $req['timeNice'] . '</td>';
            echo '<td>' . $req['party'] . '</td>';
            echo '<td>' . $req['l_name'] . ', ' . $req['f_name'] . '</td>';
            echo '<td><em>' . $req['notes'] . '</em> ' . $birthday . $anniversary . $allergy . ' </td>';
            echo '<td><a href="deny_request.php?id=' . $reqID . '" class="text-secondary"><i class="far fa-times-circle"></i></a></td>';
            echo '<td><a href="make_reservation.php?id=' . $reqID . '"><i class="fas fa-calendar-check"></i></a></td>';
            echo '</tr>';
        }

        echo <<< _END
                                </tbody>
                            </table>
_END;

    }

/* Get all requests that haven't been denied/confirmed and
the reservation date is for now or later */
$q = "SELECT * FROM requests WHERE contacted IS NOT NULL ORDER BY time_requested DESC";
$r = queryMysql($q);
// fetch result
$rows = $r->num_rows;

echo <<< _END
                    <br><br>
                    <h5 class="text-secondary">Past Requests</h5>
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Requested</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Party</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Notes</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

_END;
        for ($j = 0; $j < $rows; ++$j)
        {
            $r->data_seek($j);
            $row = $r->fetch_array(MYSQLI_ASSOC);

            $reqID = $row['request_id'];

            $req = parseJSONrequest($row['JSON_request']);

            $birthday = "";
            $anniversary = "";
            $allergy = "";
            if ($req['birthday']) {
                $birthday = '&#10003; Birthday <br>';
            }
            if ($req['anniversary']) {
                $anniversary = '&#10003; Anniversary <br>';
            }
            if ($req['allergy']) {
                $allergy = '&#10003; Allergy <br>';
            }

            echo '<tr>';
            echo '<th scope="row">' . $row['time_requested'] . '</th>';
            echo '<td>' . $req['dateNice'] . '</td>';
            echo '<td>' . $req['timeNice'] . '</td>';
            echo '<td>' . $req['party'] . '</td>';
            echo '<td>' . $req['l_name'] . ', ' . $req['f_name'] . '</td>';
            echo '<td><em>' . $req['notes'] . '</em> ' . $birthday . $anniversary . $allergy . ' </td>';
            echo '<td>' . '</td>';
            echo '<td>' . '</td>';
            echo '</tr>';
        }

        $mysqli->close();
?>
                            </tbody>
                        </table>
                <!-- End content -->
<?php include '_includes/footer.inc.php'; ?>