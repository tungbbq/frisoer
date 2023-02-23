<?php
/* @var int $barberId */
/* @var int $userId */
/* @var string $role */

?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Termin Buchung</title>

</head>

<body onload="loadDoc(loadCurrentMonday())">
<h1>Terminkalender</h1>
<br>
<div id="barberSelector"></div>

<div style="height: 100px" class="row no-gutters">
    <div class="col-12 col-sm-6 col-md-8">
        <table class="table table-hover table-sm table-responsive">
            <thead class="thead-dark">
            <tr>
                <th scope="col"></th>
                <th scope="col">Dienstag</th>
                <th scope="col">Mittwoch</th>
                <th scope="col">Donnerstag</th>
                <th scope="col">Freitag</th>
                <th scope="col">Samstag</th>
            </tr>
            </thead>

            <tbody id="tableData">
            </tbody>

        </table>


        <input type="hidden" id="inputUserId" name="userId" value="<?php echo $userId ?>">
        <input type="hidden" id="inputUserRole" name="userRole" value="<?php echo $role ?>">
<div>
        <button type="button" onclick="loadLastMonday(mondayDateTime)"><-</button>
        <button type="button" onclick="newAppointment()">speichern</button>
        <button type="button" onclick="loadNextMonday(mondayDateTime)">-></button>
</div>
        <div>
            <button class="logout">Logout</button>
        </div>
    </div>
</div>

<script src="/assets/js/main.js"></script>
<script src="/assets/js/logout.js"></script>
</body>
</html>