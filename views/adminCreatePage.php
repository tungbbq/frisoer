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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>admin</title>

</head>

<body onload="loadCreateUser()">
<div>
    <div class="text-center">
        <h1 class="display-4 mt-2">neuen Benutzer anlegen</h1>
    </div>

    <div id=outputCreateUser class="container "></div>

    <input type="hidden" id="inputUserId" name="userId" value="<?php echo $userId ?>">
    <input type="hidden" id="inputUserRole" name="userRole" value="<?php echo $role ?>">
    <input type="hidden" id="inputUserName" name="userName" value="<?php echo $firstName . ' ' . $lastName; ?>">
</div>

<script src="/assets/js/main.js"></script>
<script src="/assets/js/admin.js"></script>
<script src="/assets/js/logout.js"></script>

</body>

</html>