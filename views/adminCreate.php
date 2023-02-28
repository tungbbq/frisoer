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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>admin</title>

</head>

<body onload="loadCreateUser()">

<div>
    <h1 class="text-center display-4 mt-1">neuen Benutzer anlegen</h1>
</div>

<div class="text-right">
    <button class="logout btn btn-dark btn-sm mb-3" >Logout</button>
</div>
<div id=outputCreateUser class="container"></div>
        <input type="hidden" id="inputUserId" name="userId" value="<?php echo $userId ?>">
        <input type="hidden" id="inputUserRole" name="userRole" value="<?php echo $role ?>">
        <input type="hidden" id="inputUserName" name="userName" value="<?php echo $firstName . ' ' . $lastName; ?>">


<script src="/assets/js/main.js"></script>
<script src="/assets/js/logout.js"></script>
<script src="/assets/js/adminCRUD.js"></script>

</body>

</html>