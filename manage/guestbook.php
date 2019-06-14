<?php
/*
 * B!B! console requests script - guestbook.php
 */
// page title
$pageTitle = 'Guestbook';
// include header and top nav
include '_includes/header.inc.php';
// include console sidebar
include '_includes/sidebar.inc.php';

echo '<h1 class="h2 my-4">Guestbook</h1>';
if (isset($_POST['delete']) && isset($_POST['email']))
{
    $email = get_post($mysqli, 'email');
    $query = "DELETE FROM guests WHERE email='$email'";
    $result = queryMysql($query);
    if (!result) echo "DELETE failed: $query<br>" .
        $mysqli->error . "<br><br>";
}

if (isset($_POST['f_name'])   &&
    isset($_POST['l_name'])   &&
    isset($_POST['phone'])    &&
    isset($_POST['email'])    &&
    isset($_POST['notes'])    )

{
    $f_name    = get_post($mysqli, 'f_name');
    $l_name    = get_post($mysqli, 'l_name');
    $phone     = get_post($mysqli, 'phone');
    $email     = get_post($mysqli, 'email');
    $notes     = get_post($mysqli, 'notes');

    $query = "SELECT * FROM guests WHERE email='$email'";
    $result    = queryMysql($query);
    if (!$result) echo "SELECT failed: $query<br>" .
        $mysqli->error . "<br><br>";
    $emailRows = $result->num_rows;
    if ($emailRows == 1) {
        echo 'Email already in use. Try again with another email.';
    } else {
        $query     = "INSERT INTO guests " .
            "(f_name, l_name, phone, email, notes) " .
            "VALUES ('$f_name', '$l_name', '$phone', '$email', '$notes')";
        $result    = queryMysql($query);
        if (!$result) echo "INSERT failed: $query<br>" .
            $mysqli->error . "<br><br>";
    }
}
?>

    <h3>Add guests</h3>

    <form action="guestbook.php" method="post">
    <pre>
    First name <input type="text" name="f_name">
     Last name <input type="text" name="l_name">
         Phone <input type="text" name="phone">
         Email <input type="text" name="email">
         Notes <input type="text" name="notes">

               <input type="submit" value="ADD GUEST">
    </pre>
    </form>

    <h3>View/delete guests</h3>

<?php
// query
$query = "SELECT * FROM guests";
$result = queryMysql($query);
if (!$result) die("Database access failed: " . $mysqli->error);

// fetch result
$rows = $result->num_rows;

for ($j = 0; $j < $rows; ++$j)
{
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    echo '<br>';
    echo "&nbsp;"                               . "First name: " . $row['f_name'] . "<br>";
    echo "&nbsp;&nbsp;"                         . "Last name: "  . $row['l_name'] . "<br>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "Phone: "      . $row['phone']  . "<br>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "Email: "      . $row['email']  . "<br>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "Notes: "      . $row['notes']  . "<br>";
    echo '<br>';
    echo '
    <form action"console-test-sqltest.php" method="post">
        <input type="hidden" name="delete" value="yes">
        <input type="hidden" name="email" value="' .
        $row['email'] . '">
        <input type="submit" value="DELETE GUEST">
    </form>
    ';
    echo '<br>';
}

$result->close();
$mysqli->close();

function get_post($conn, $var)
{
    return $conn->real_escape_string($_POST[$var]);
}

include '_includes/footer.inc.php';