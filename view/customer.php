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
        <th></th>
        <th>Dienstag</th>
        <th>Mittwoch</th>
        <th>Donnerstag</th>
        <th>Freitag</th>
        <th>Samstag</th>

    </tr>
    </thead>

    <form action="ajax.php">
    <tbody id="tableData">
    </tbody>

</table>
<button type="submit" name=monday id=monday value="2023-01-30"><-</button>
<button type="submit" name=monday id=monday value="2023-01-30">speichern</button>
<button type="submit" name=monday id=monday value="2023-01-30">-></button>
</form>
<script>
    function loadDoc() {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const table = this.responseText
                const obj = JSON.parse(table);

                const firstDay = new Date(obj[0].day)

                let tbl = '';
                let j = 0;

                tbl += '<tr>'
                tbl += '<td></td>'
                tbl += '<td>' + firstDay.getDate() + '.' + firstDay.toLocaleString('default', {month: 'long'})+ ' ' +  firstDay.getFullYear() + '</td>'

                tbl += '<td>' + (new Date(firstDay.setDate(firstDay.getDate() + 1))).getDate() + '.'
                tbl += (new Date(firstDay.setDate(firstDay.getDate()))).toLocaleString('default', {month: 'long'}) + ' '
                tbl += (new Date(firstDay.setDate(firstDay.getDate()))).getFullYear()  + '</td>';

                tbl += '<td>' + (new Date(firstDay.setDate(firstDay.getDate() + 1))).getDate() + '.'
                tbl += (new Date(firstDay.setDate(firstDay.getDate()))).toLocaleString('default', {month: 'long'}) + ' '
                tbl += (new Date(firstDay.setDate(firstDay.getDate()))).getFullYear()  + '</td>';

                tbl += '<td>' + (new Date(firstDay.setDate(firstDay.getDate() + 1))).getDate() + '.'
                tbl += (new Date(firstDay.setDate(firstDay.getDate()))).toLocaleString('default', {month: 'long'}) + ' '
                tbl += (new Date(firstDay.setDate(firstDay.getDate()))).getFullYear()  + '</td>';

                tbl += '<td>' + (new Date(firstDay.setDate(firstDay.getDate() + 1))).getDate() + '.'
                tbl += (new Date(firstDay.setDate(firstDay.getDate()))).toLocaleString('default', {month: 'long'}) + ' '
                tbl += (new Date(firstDay.setDate(firstDay.getDate()))).getFullYear()  + '</td>';

                tbl += '</tr>'

                for (let i = 0; i < obj.length; i++) {
                    if (i % 5 === 0) {
                        tbl += '<tr>';
                        tbl += '<td>' + (9 + j) + ':00Uhr' +'</td>'
                        j += 1;
                    }

                    tbl += '<td>';


                    if (obj[i].name === 'blocked') {
                        tbl += '<input disabled>'
                    } else
                        tbl += '<input type="text" >'
                    tbl += '</td>';

                    if (i % 5 === 4) {
                        tbl += '</tr>';
                    }

                }




                document.getElementById('tableData').innerHTML = tbl;

            }
        }
        xhttp.open("POST", "ajax.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("monday=2023-01-30");
    }

</script>

</body>
</html>