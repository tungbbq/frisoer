<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    * {
        font-family: sans-serif;
        color: white;
        font-size: 20px;
    }

    body {
        background-image: url("https://i.pinimg.com/originals/86/c6/a8/86c6a89a391eb2993428def042e57ee9.jpg");
    }

    input, button {
        color: black;
    }

    input:hover, button:hover {
        background-color: lightblue;
        border-style: solid;
    }

    h1 {
        text-align: center;
        font-size: 40px;
    }

    .container {
        width: 30vw;
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
</style>

<body>

<div class="container">
    <h1>User Login</h1>
    <form onsubmit="return false;" >
        <div class="form-group">
            <label for="">User Name</label>
            <input type="text" name="userName">
        </div>

        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="pwd">
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