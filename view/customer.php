<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Termin Buchung</title>
</head>
<body onload="loadDoc()">
<div id="test"></div>
<script>
    function loadDoc() {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("test").innerHTML=
                    this.responseText
            }
        }
        xhttp.open("POST", "ajax.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("monday=30012023");
    }
</script>
</body>
</html>