<?php
/*
 * B!B! management console script - index.php
 */
// page title
$pageTitle = 'Management Console';
// include header and top nav
include '_includes/header.inc.php';
// include console sidebar
include '_includes/sidebar.inc.php';

$coverCount = $covers1730 = $covers1930 =  $covers2130 = 0;
$birthdayCount = 0;
$anniversaryCount = 0;
$allergyCount = 0;

$resDate = date("Y-m-d", $d);

// 5:30 reservations
$q = "SELECT SUM(party) FROM reservations WHERE date='$resDate' AND time='1730'";
$r = queryMysql($q);
$row = $r->fetch_array(MYSQLI_NUM);
if ($row[0]) $covers1730 = $row[0];
// 7:30 reservations
$q = "SELECT SUM(party) FROM reservations WHERE date='$resDate' AND time='1930'";
$r = queryMysql($q);
$row = $r->fetch_array(MYSQLI_NUM);
if ($row[0]) $covers1930 = $row[0];
// 9:30 reservations
$q = "SELECT SUM(party) FROM reservations WHERE date='$resDate' AND time='2130'";
$r = queryMysql($q);
$row = $r->fetch_array(MYSQLI_NUM);
if ($row[0]) $covers2130 = $row[0];

$coverCount = $covers1730 + $covers1930 + $covers2130;

// birthdays
$q = "SELECT COUNT(occasion) FROM reservations WHERE date='$resDate' AND occasion='birthday'";
$r = queryMysql($q);
$row = $r->fetch_array(MYSQLI_NUM);
if ($row[0]) $birthdayCount = $row[0];

// anniversaries
$q = "SELECT COUNT(occasion) FROM reservations WHERE date='$resDate' AND occasion='anniversary'";
$r = queryMysql($q);
$row = $r->fetch_array(MYSQLI_NUM);
if ($row[0]) $anniversaryCount = $row[0];

// allergies
$q = "SELECT COUNT(allergy) FROM reservations WHERE date='$resDate' AND allergy IS NOT NULL";
$r = queryMysql($q);
$row = $r->fetch_array(MYSQLI_NUM);
if ($row[0]) $allergyCount = $row[0];

/* *** start content below on col 17 *** */
?>
                <!-- Start content -->
                    <!-- Date row with datepicker -->
                    <div class="row pt-4 pb-2 mb-3 border-bottom">
                        <div class="col-lg-5">
                            <!-- Date heading -->
                            <h1 class="h2">
                                <?php echo date("l, F j, Y", $d) . "\n"; ?>
                            </h1>
                        </div>
                        <div class="col-lg-3">
                            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                                <!-- <<< -->
                                <a class="btn btn-link" href="index.php?d=<?php echo $prevDay ?>">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <!-- Today -->
                                <a class=" <?php if ($d == $todaysDate) { echo 'btn btn-primary'; } else { echo 'btn btn-outline-primary'; } ?>" href="index.php">
                                    Today
                                </a>
                                <!-- >>> -->
                                <a class="btn btn-link" href="index.php?d=<?php echo $nextDay ?>">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="dropleft text-right">
                                <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-toggle="dropdown">
                                    Select Date
                                </button>
                                <div id="datepicker" class="dropdown-menu p-0"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Cover count and graph row -->
                    <div class="row">
                        <!-- Cover count column -->
                        <div class="col-5 pr-4">
                            <!-- reservation info rows -->
                            <div class="row my-4">
                                <div class="col-10">
                                    <strong>Total cover count</strong>
                                </div>
                                <div class="col-2 text-right">
                                    <strong><?php echo $coverCount ?></strong>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-10">
                                    <strong>Birthdays</strong>
                                </div>
                                <div class="col-2 text-right">
                                    <strong><?php echo $birthdayCount ?></strong>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-10">
                                    <strong>Anniversaries</strong>
                                </div>
                                <div class="col-2 text-right">
                                    <strong><?php echo $anniversaryCount ?></strong>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-10">
                                    <strong>Allergies</strong>
                                </div>
                                <div class="col-2 text-right">
                                    <strong><?php echo $allergyCount ?></strong>
                                </div>
                            </div>
                        </div>
                        <!-- Spacer column -->
                        <div class="col-2 px-4"></div>
                        <!-- Graph column -->
                        <div class="col-5 pl-4  d-none d-md-block">
                            <canvas class="my-4 w-100" id="myChart"></canvas>
                        </div>
                    </div>
                    <!-- Begin reservations/requests content row -->
<?php
if ($coverCount != 0) {
echo <<<_END

                    <div class="pt-1">
                        <h2 class="h3 mb-4">Reservations</h2>

_END;
}

// 5:30 reservations
$q = "SELECT * FROM reservations WHERE date='$resDate' AND time='1730'";
$r = queryMysql($q);
$row = $r->fetch_array(MYSQLI_ASSOC);
$numRows = $r->num_rows;

if ($numRows != "") {

    echo <<<_END
                        <!-- 5:30 reservations table -->
                        <h4 class="text-secondary">5:30pm ($covers1730)</h4>
                        <div class="table-responsive mb-4">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Party</th>
                                        <th>Phone</th>
                                        <th>Notes</th>
                                        <th>Occasion</th>
                                        <th>Allergy</th>
                                    </tr>
                                </thead>
                                <tbody>
_END;

    for ($j = 0; $j < $numRows; ++$j)
    {
        $r->data_seek($j);
        $row = $r->fetch_array(MYSQLI_ASSOC);
        $covers1730 += $row['party'];
        $reqId = $row['request_id'];

        $occasion = "";
        $allergy = "";

        if ($row['occasion'] == "birthday") $occasion = '<i class="fas fa-birthday-cake"></i> Birthday';
        if ($row['occasion'] == "anniversary") $occasion = '<i class="far fa-kiss-wink-heart"></i> Anniversary';
        if ($row['allergy'] == "unknown") $allergy = '<i class="fas fa-allergies"></i> Allergy';

        $query = "SELECT * FROM requests WHERE request_id=$reqId";
        $result = queryMysql($query);
        $rowNew = $result->fetch_array(MYSQLI_ASSOC);
        $req = parseJSONrequest($rowNew['JSON_request']);

        $notes = "";

        if ($row['notes']) $notes = $row['notes'];
        if ($req['notes']) $notes = $req['notes'];

        echo '<tr>';
        echo '<td>' . $req['l_name'] . ', ' . $req['f_name'] . '</td>';
        echo '<td>' . $row['party'] . '</td>';
        echo '<td>' . $req['phoneNice'] . '</td>';
        echo '<td>' . $notes . '</td>';
        echo '<td>' . $occasion . '</td>';
        echo '<td>' . $allergy . '</td>';
        echo '</tr>';            
    }

    echo <<< _END
                            </tbody>
                        </table>
                    </div>
_END;
}


// 7:30 reservations
$q = "SELECT * FROM reservations WHERE date='$resDate' AND time='1930'";
$r = queryMysql($q);
$row = $r->fetch_array(MYSQLI_ASSOC);
$numRows = $r->num_rows;

if ($numRows != "") {

    echo <<<_END
                        <!-- 7:30 reservations table -->
                        <h4 class="text-secondary">7:30pm ($covers1930)</h4>
                        <div class="table-responsive mb-4">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Party</th>
                                        <th>Phone</th>
                                        <th>Notes</th>
                                        <th>Occasion</th>
                                        <th>Allergy</th>
                                    </tr>
                                </thead>
                                <tbody>
_END;

    for ($j = 0; $j < $numRows; ++$j)
    {
        $r->data_seek($j);
        $row = $r->fetch_array(MYSQLI_ASSOC);
        $covers1930 += $row['party'];
        $reqId = $row['request_id'];

        $occasion = "";
        $allergy = "";

        if ($row['occasion'] == "birthday") $occasion = '<i class="fas fa-birthday-cake"></i> Birthday';
        if ($row['occasion'] == "anniversary") $occasion = '<i class="far fa-kiss-wink-heart"></i> Anniversary';
        if ($row['allergy'] == "unknown") $allergy = '<i class="fas fa-allergies"></i> Allergy';

        $query = "SELECT * FROM requests WHERE request_id=$reqId";
        $result = queryMysql($query);
        $rowNew = $result->fetch_array(MYSQLI_ASSOC);
        $req = parseJSONrequest($rowNew['JSON_request']);

        $notes = "";

        if ($row['notes']) $notes = $row['notes'];
        if ($req['notes']) $notes = $req['notes'];

        echo '<tr>';
        echo '<td>' . $req['l_name'] . ', ' . $req['f_name'] . '</td>';
        echo '<td>' . $row['party'] . '</td>';
        echo '<td>' . $req['phoneNice'] . '</td>';
        echo '<td>' . $notes . '</td>';
        echo '<td>' . $occasion . '</td>';
        echo '<td>' . $allergy . '</td>';
        echo '</tr>';            
    }

    echo <<< _END
                            </tbody>
                        </table>
                    </div>
_END;
}

// 9:30 reservations
$q = "SELECT * FROM reservations WHERE date='$resDate' AND time='2130'";
$r = queryMysql($q);
$row = $r->fetch_array(MYSQLI_ASSOC);
$numRows = $r->num_rows;

if ($numRows != "") {

    echo <<<_END
                        <!-- 9:30 reservations table -->
                        <h4 class="text-secondary">9:30pm ($covers2130)</h4>
                        <div class="table-responsive mb-4">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Party</th>
                                        <th>Phone</th>
                                        <th>Notes</th>
                                        <th>Occasion</th>
                                        <th>Allergy</th>
                                    </tr>
                                </thead>
                                <tbody>
_END;

    for ($j = 0; $j < $numRows; ++$j)
    {
        $r->data_seek($j);
        $row = $r->fetch_array(MYSQLI_ASSOC);
        $covers2130 += $row['party'];
        $reqId = $row['request_id'];

        $occasion = "";
        $allergy = "";

        if ($row['occasion'] == "birthday") $occasion = '<i class="fas fa-birthday-cake"></i> Birthday';
        if ($row['occasion'] == "anniversary") $occasion = '<i class="far fa-kiss-wink-heart"></i> Anniversary';
        if ($row['allergy'] == "unknown") $allergy = '<i class="fas fa-allergies"></i> Allergy';

        $query = "SELECT * FROM requests WHERE request_id=$reqId";
        $result = queryMysql($query);
        $rowNew = $result->fetch_array(MYSQLI_ASSOC);
        $req = parseJSONrequest($rowNew['JSON_request']);

        $notes = "";

        if ($row['notes']) $notes = $row['notes'];
        if ($req['notes']) $notes = $req['notes'];

        echo '<tr>';
        echo '<td>' . $req['l_name'] . ', ' . $req['f_name'] . '</td>';
        echo '<td>' . $row['party'] . '</td>';
        echo '<td>' . $req['phoneNice'] . '</td>';
        echo '<td>' . $notes . '</td>';
        echo '<td>' . $occasion . '</td>';
        echo '<td>' . $allergy . '</td>';
        echo '</tr>';            
    }

    echo <<< _END
                            </tbody>
                        </table>
                    </div>
_END;
}

$mysqli->close();

include '_includes/footer.inc.php';