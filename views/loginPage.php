<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <h1>User Login</h1>
    <form onsubmit="return false;" >
        <div>User Name: barber1</div><div>Password:  11barber1</div>
        <div class="form-group">
            <label for="">User Name</label>
            <input type="text" name="userName" value="barber1">
        </div>

        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="pwd" value="11barber1">
        </div>

        <div class="form-group">
            <!-- <label for=""></label> -->
            <input type="hidden" name="action" value="login">
        </div>
        <div class="form-group">

            <button class="login" type="submit" name="submit">Login</button>
        </div>
    </form>
</div>

<script type="module" src="/assets/js/login.js"></script>
</body>
</html>