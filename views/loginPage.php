<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Login</title>
</head>
<style>
    .container {
        width: 50vw;
        margin: auto;
        margin-top: 12vh;
    }

    .form-group {
        padding-bottom: 10px;
        display: flex;
        flex-direction: column;
        font-size: large;
    }

    button {
        font-size: large;
    }

    h1 {
        text-align: center;
    }
</style>

<body>

<div class="container">
    <h1 class="display-3">User Login</h1>
    <br><br>
    <form onsubmit="return false;" >
        <div class="form-group">
            <input class="form-control" type="text" name="userName" placeholder="username">
        </div>

        <div class="form-group">
            <input class="form-control" type="password" name="pwd" placeholder="password">
        </div>

        <div class="form-group">
            <!-- <label for=""></label> -->
            <input type="hidden" name="action" value="login">
        </div>
        <div class="form-group">

            <button class="login btn btn-warning" type="submit" name="submit">Sign in</button>
        </div>
    </form>
</div>

<script type="module" src="/assets/js/login.js"></script>
</body>
</html>