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

<style>
    #outterContainer{
        display: flex;
        position:relative;
        width:100vw;
        margin:auto
    }

    #wholeView{

        position:relative;
        width:90vw;
        margin:auto;
    }
    #h1Logout{
        display: flex;
        background-color:lightgray;
        align-items: center;
    }

    #buttons{
        background-color:lightgray;
        5px 5px 15px 5px #d3d3d3;
    }
 h1{
     color:white
 }
</style>
</head>

<body onload="loadDoc(getCurrentMonday())">



<div id="outterContainer">
    <div id="wholeView" class="mt-5" >
        <div id="h1Logout" class="d-flex justify-content-between mb-2 fixed-top">
            <div id="h1">
                <h1 class="display-5 mt-2 mb-2">Terminkalender</h1>
            </div>

            <div id="logoutButton">
                <button class="logout btn btn-light btn-sm mt-2 mb-2">Logout</button>
            </div>
        </div>
            <div id="tableContainer" class="mt-4 mb-5">
                <table class="table table-hover table-borderless table-sm text-center">
                    <thead>
                        <tr>
                            <th scope="col"
                            <div id="barberSelector"></div>
                            </th>
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

            <div id="hiddenInput">
                <input type="hidden" id="inputUserId" name="userId" value="<?php echo $userId ?>">
                <input type="hidden" id="inputUserRole" name="userRole" value="<?php echo $role ?>">
                <input type="hidden" id="inputUserName" name="userName" value="<?php echo $firstName . ' ' . $lastName; ?>">
            </div>

            <div id="buttons" class="text-center fixed-bottom">
                <button type="button" class="btn btn-light btn-sm mt-2 mb-2" onclick="getLastMonday(firstDayOfWeek)"> ← </button>

                <button type="button" class="btn btn-light btn-sm mt-2 mb-2" onclick="addAppointment()">Speichern</button>

                <button type="button" class="btn btn-light btn-sm mt-2 mb-2" onclick="getNextMonday(firstDayOfWeek)"> → </button>
            </div>

    </div>
</div>

<script src="/assets/js/main.js"></script>
<script src="/assets/js/logout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>