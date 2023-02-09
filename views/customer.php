<?php
//echo '<pre>'; print_r($_SERVER['REMOTE_USER']); echo '</pre>';
if (isset($_SERVER['REMOTE_USER']) && $_SERVER['REMOTE_USER'] === 'frisoer'){
    $isBarber = 'true';
} else $isBarber = 'false';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Termin Buchung</title>
</head>

<body onload="loadDoc(loadCurrentMonday())">
<input type="hidden" id="isBarber" value="<?php echo $isBarber ?>">
<table>
    <thead>
    <tr>
        <th></th>
        <th>Dienstag</th>
        <th>Mittwoch</th>
        <th>Donnerstag</th>
        <th>Freitag</th>
        <th>Samstag</th>

    </tr>
    </thead>

    <tbody id="tableData">
    </tbody>

</table>
<button type="button" onclick="loadLastMonday(baseday)"><-</button>
<button type="button" onclick="newUpdate()">speichern</button>
<button type="button" onclick="loadNextMonday(baseday)">-></button>

<script src="../assets/js/main.js">

</script>
</body>
</html>