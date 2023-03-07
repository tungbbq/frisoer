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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>admin</title>

</head>

<body onload="loadCreateUser()"><div id="usersList"></div>

<script src="/assets/js/main.js"></script>
<script src="/assets/js/admin.js"></script>
<script src="/assets/js/logout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
<!--
<div class="vh-100">
    <div class="text-center">
        <h1 class="display-4 mb-4 mt-5" >neuen Benutzer anlegen</h1>
    </div>

    <div id=outputCreateUser class="container"></div>

    <input type="hidden" id="inputUserId" name="userId" value="<?php echo $userId ?>">
    <input type="hidden" id="inputUserRole" name="userRole" value="<?php echo $role ?>">
    <input type="hidden" id="inputUserName" name="userName" value="<?php echo $firstName . ' ' . $lastName; ?>">
</div>
-->
</html>