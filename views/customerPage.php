<?php
/* @var int $barberId */
/* @var int $userId */
/* @var string $role */
/* @var string $firstName */
/* @var string $lastName */

?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Termin Buchung</title>

</head>

<body onload="loadDoc(loadCurrentMonday())">

<div class="h-100">

    <div>
        <h1 class="text-center display-5 mt-1">Terminkalender</h1>
    </div>

    <div class="float-end">
        <button class="logout btn btn-primary btn-sm">Logout</button>
    </div>

    <div>
        <table class="table table-hover table-borderless table-sm text-center">
            <thead>
            <tr>
                <th scope="col" <div  id="barberSelector"></div> ></th>
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
    </div>

    <input type="hidden" id="inputUserId" name="userId" value="<?php echo $userId ?>">
    <input type="hidden" id="inputUserRole" name="userRole" value="<?php echo $role ?>">
    <input type="hidden" id="inputUserName" name="userName" value="<?php echo $firstName . ' ' . $lastName; ?>">
    <div class="text-center">
        <button type="button" class="btn btn-primary btn-sm " onclick="loadLastMonday(mondayDateTime)"><--</button>
        &nbsp
        <button type="button" class="btn btn-primary btn-sm " onclick="newAppointment()">speichern</button>
        &nbsp
        <button type="button" class="btn btn-primary btn-sm " onclick="loadNextMonday(mondayDateTime)">--></button>
    </div>

</div>


<script src="/assets/js/main.js"></script>
<script src="/assets/js/logout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>