<?php

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Löschen und Ändern von Daten</title>
</head>
<body id="DeleteAndUpdate" onload="getDataForAdminPages()">

<a href="adminCreatePage.php">link text</a>
<table>
    <tr>
        <th>Name</th>
        <th>Vorname</th>
        <th>Username</th>
        <th>Telefon</th>
        <th>Arbeitsbeginn</th>
        <th>Arbeitsende</th>
        <th>Rolle</th>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <!-- Buttons under construction !!! Buttons under construction !!! <td><button type="button" class="showUpdate" id="update' . $employee->getId() . '">Update</button></td>;
        <td><button type="button" class="delete" id="delete' . $employee->getId() . '">Löschen</button></td>;-->
    </tr>
</table>

<script src="/assets/js/admin.js"></script>
</body>
</html>
