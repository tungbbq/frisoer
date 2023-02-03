<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Termin Buchung</title>
</head>
<body onload="loadDoc(loadCurrentMonday())">

<table>
    <thead>
    <tr>
        <th></th>
        <th>Dienstag</th>
        <th>Mittwoch</th>
        <th>Donnerstag</th>
        <th>Freitag</th>
        <th>Samstag</th>

    </tr>
    </thead>

    <tbody id="tableData">
    </tbody>

</table>
<button type="button" onclick="loadLastMonday(baseday)"><-</button>
<button type="button" onclick="newUpdate()">speichern</button>
<button type="button" onclick="loadNextMonday(baseday)">-></button>

<script src="functions.js">

</script>

</body>
</html>