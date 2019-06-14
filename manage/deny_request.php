<?php
/*
 * B!B! console requests script - deny_request.php
 */
// page title
$pageTitle = 'Requests';
// include header and top nav
include '_includes/header.inc.php';
// include console sidebar
include '_includes/sidebar.inc.php';

$id = htmlspecialchars($_GET["id"]);

$q = 'SELECT * FROM requests WHERE request_id=' . $id;
$r = queryMysql($q);
// fetch result
$row = $r->fetch_array(MYSQLI_ASSOC);
$req = parseJSONrequest($row['JSON_request']);

echo '<h1 class="h2 my-4">Deny Request</h1>';

if (isset($_GET["action"])) {
    $q = 'UPDATE requests SET contacted = 1 WHERE request_id=' . $id;
    $r = queryMysql($q);
    if (!r) echo "DENY failed";

    echo '<div class="my-4">Request #' . $id . ' has been denied and <a href="mailto:' . $req['email'] .'">' . $req['email'] . '</a> has been contacted.</div>';
} else {
    echo '<table>';

    echo '<tr>';
    echo '<td class="pr-2">' . 'Request id: ' . '</td>';
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

    echo '<div class="my-4">Are you sure you want to deny request #' . $id . '?</div>';

    echo '<a href="deny_request.php?action=deny&id=' . $id . '" class="btn btn-outline-danger">Deny Request</a> ';
}
echo ' <a href="requests.php" class="btn btn-outline-primary">back to Requests</a>';


$mysqli->close();
?>
                            </tbody>
                        </table>
                    </div>
                <!-- End content -->
<?php include '_includes/footer.inc.php'; ?>