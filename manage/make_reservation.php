<?php
/*
 * B!B! console requests script - make_reservation.php
 */
// page title
$pageTitle = 'Reservations';
// include header and top nav
include '_includes/header.inc.php';
// include console sidebar
include '_includes/sidebar.inc.php';

$id = htmlspecialchars($_GET["id"]);

$q = 'SELECT * FROM requests WHERE request_id=' . $id;
$r = queryMysql($q);
// fetch result
$reqRow = $r->fetch_array(MYSQLI_ASSOC);
$req = parseJSONrequest($reqRow['JSON_request']);

$q = 'SELECT * FROM guests WHERE email="' . $req['email'] . '"';
$r = queryMysql($q);
$emailRows = $r->num_rows;

echo '<h1 class="h2 my-4">Make Reservation</h1>';

echo '<table>';

echo '<tr>';
echo '<td class="pr-2">' . 'Request#: ' . '</td>';
echo '<td>' . $id . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="pr-2">' . 'Date: ' . '</td>';
echo '<td>' . $req['dateNice'] . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="pr-2">' . 'Time: ' . '</td>';
echo '<td>' . $req['timeNice'] . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="pr-2">' . 'Party: ' . '</td>';
echo '<td>' . $req['party'] . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="pr-2">' . 'Name: ' . '</td>';
echo '<td>' . $req['f_name'] . ' ' . $req['l_name'] . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="pr-2">' . 'Phone: ' . '</td>';
echo '<td>' . $req['phoneNice'] . '</td>';
echo '</tr>';
echo '<tr>';

echo '<td class="pr-2">' . 'Email: ' . '</td>';
echo '<td>' . $req['email'] . '</td>';
echo '</tr>';

if ($req['notes']) {
echo '<tr>';
echo '<td class="pr-2">' . 'Notes: ' . '</td>';
echo '<td>' . $req['notes'] . '</td>';
echo '</tr>';
}

if ($req['birthday'] || $req['anniversary'] || $req['allergy']) {
    echo '<tr>';
    echo '<td class="pr-2">' . 'Addt\'l info: ' . '</td>';
    if ($req['birthday']) { echo '<td>' . '<i class="fas fa-birthday-cake"></i> Birthday' . '</td>'; }
    if ($req['anniversary']) { echo '<td>' . '<i class="far fa-kiss-wink-heart"></i> Anniversary' . '</td>'; }
    if ($req['allergy']) { echo '<td>' . '<i class="fas fa-allergies"></i> Allergy' . '</td>'; }
    echo '</tr>';
}

echo '</table><br>';

$f_name = $req['f_name'];
$l_name = $req['l_name'];
$phone = $req['phone'];
$email = $req['email'];
$reqDate = $req['date'];
$reqTime = $req['time'];
$reqParty = $req['party'];
$occasion = "";
$allergy = "";

if ($req['birthday']) $occasion = "birthday";
if ($req['anniversary']) $occasion = "anniversary";
if ($req['allergy']) $allergy = "unknown";


if ($emailRows == 0) {
    $query     = "INSERT INTO guests " .
    "(f_name, l_name, phone, email) " .
    "VALUES ('$f_name', '$l_name', '$phone', '$email')";
    $result    = queryMysql($query);
    if (!$result) echo "INSERT failed: $query<br>" .
        $mysqli->error . "<br><br>";
}

if ($req['birthday'] && $req['anniversary'] && $req['allergy']) {
    $query = "INSERT INTO reservations " .
        "(date, time, party, email, request_id, occasion, allergy) " .
        "VALUES ('$reqDate', '$reqTime', '$reqParty', '$email', '$id', 'birthday', 'unknown')";
} elseif ($req['birthday'] && $req['anniversary']) {
    $query = "INSERT INTO reservations " .
        "(date, time, party, email, request_id, occasion) " .
        "VALUES ('$reqDate', '$reqTime', '$reqParty', '$email', '$id', 'birthday')";
} elseif ($req['birthday'] && $req['allergy']) {
    $query = "INSERT INTO reservations " .
        "(date, time, party, email, request_id, occasion, allergy) " .
        "VALUES ('$reqDate', '$reqTime', '$reqParty', '$email', '$id', 'birthday', 'unknown')";
} elseif ($req['anniversary'] && $req['allergy']) {
    $query = "INSERT INTO reservations " .
        "(date, time, party, email, request_id, occasion, allergy) " .
        "VALUES ('$reqDate', '$reqTime', '$reqParty', '$email', '$id', 'anniversary', 'unknown')";
} elseif ($req['birthday']) {
    $query = "INSERT INTO reservations " .
        "(date, time, party, email, request_id, occasion) " .
        "VALUES ('$reqDate', '$reqTime', '$reqParty', '$email', '$id', 'birthday')";
} elseif ($req['anniversary']) {
    $query = "INSERT INTO reservations " .
        "(date, time, party, email, request_id, occasion) " .
        "VALUES ('$reqDate', '$reqTime', '$reqParty', '$email', '$id', 'anniversary')";
} elseif ($req['allergy']) {
    $query = "INSERT INTO reservations " .
        "(date, time, party, email, request_id, allergy) " .
        "VALUES ('$reqDate', '$reqTime', '$reqParty', '$email', '$id', 'unknown')";
} else {
    $query = "INSERT INTO reservations " .
        "(date, time, party, email, request_id) " .
        "VALUES ('$reqDate', '$reqTime', '$reqParty', '$email', '$id')";
}

$result    = queryMysql($query);
if (!$result) echo "INSERT failed: $query<br>" .
    $mysqli->error . "<br><br>";

$query = "UPDATE requests SET contacted=1 WHERE request_id=$id";

$result    = queryMysql($query);
if (!$result) echo "INSERT failed: $query<br>" .
    $mysqli->error . "<br><br>";

echo '<h6 class="my-2">Reservation made!</h6>';
echo ' <a href="requests.php" class="btn btn-outline-primary">back to Requests</a>';

$mysqli->close();
?>
                            </tbody>
                        </table>
                    </div>
                <!-- End content -->
<?php include '_includes/footer.inc.php'; ?>