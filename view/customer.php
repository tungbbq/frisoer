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

<table>
    <thead>
    <tr>

        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Thursday</th>
        <th>Friday</th>
        <th>Saturday</th>

    </tr>
    </thead>


    <tbody id="tableData">

    </tbody>
</table>

<script>
    function loadDoc() {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // document.getElementById("test").innerHTML=
                const table = this.responseText
                const obj = JSON.parse(table);
                let tbl = '';

                for (let i = 0; i < obj.length; i++) {
                    if (i%5 === 0){
                        tbl += '<tr>';}

                    tbl += '<td>' + obj[i].hour + ':00Uhr ';
                    tbl += obj[i].name + ' ';
                    tbl += obj[i].day + '</td>';

                    if (i%5 === 4){
                        tbl += '</tr>';}

                }

                document.getElementById('tableData').innerHTML = tbl;

            }
        }
        xhttp.open("POST", "ajax.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("monday=30012023");
    }

</script>
</body>
</html>