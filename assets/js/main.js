let baseday;

function getSQLFormat(dateobjectformat) {
    let year = dateobjectformat.getFullYear() + '-';
    let month = dateobjectformat.getMonth()
    month++
    if (String(month).length == 1) {
        month = '0' + month + '-';
    }
    let day = dateobjectformat.getDate();
    if (String(day).length == 1) {
        day = '0' + day;
    }
    return year + month + day
}

console.log(getSQLFormat(new Date()))

function loadCurrentMonday(date) {
    if (date === undefined) {
        baseday = new Date();
    } else {
        baseday = new Date(date)
        console.log(baseday)
    }

    let weekday = baseday.getDay()
    console.log(weekday)
    if (weekday === 0) {
        let monday = new Date(baseday.setDate(baseday.getDate() + 1))
        monday = getSQLFormat(monday)
        return monday

    } else {
        let monday = new Date(baseday.setDate(baseday.getDate() - (weekday - 1)))
        monday = getSQLFormat(monday)
        return monday

    }
}

function loadLastMonday(baseday) {
    let lastweek = new Date(baseday.setDate(baseday.getDate() - 7))
    let lastweekStr = getSQLFormat(lastweek)
    loadDoc(loadCurrentMonday(lastweekStr))
}

function loadNextMonday(baseday) {
    let nextweek = new Date(baseday.setDate(baseday.getDate() + 7))
    console.log(nextweek)
    let nextweekStr = getSQLFormat(nextweek)

    loadDoc(loadCurrentMonday(nextweekStr))
}


function loadDoc(load) {

    let monday = load
    console.log(monday)

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            const table = this.responseText;
            const obj = JSON.parse(table);
            console.log(obj)
            const firstDay = new Date(obj[0].day)

            let tbl = '';
            let j = 0;

            tbl += '<tr> '
            tbl += '<td></td>'
            tbl += '<td>' + firstDay.getDate() + '.' + firstDay.toLocaleString('default', {month: 'long'}) + ' ' + firstDay.getFullYear() + '</td>'

            tbl += '<td>' + (new Date(firstDay.setDate(firstDay.getDate() + 1))).getDate() + '.'
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).toLocaleString('default', {month: 'long'}) + ' '
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).getFullYear() + '</td>';

            tbl += '<td>' + (new Date(firstDay.setDate(firstDay.getDate() + 1))).getDate() + '.'
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).toLocaleString('default', {month: 'long'}) + ' '
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).getFullYear() + '</td>';

            tbl += '<td>' + (new Date(firstDay.setDate(firstDay.getDate() + 1))).getDate() + '.'
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).toLocaleString('default', {month: 'long'}) + ' '
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).getFullYear() + '</td>';

            tbl += '<td>' + (new Date(firstDay.setDate(firstDay.getDate() + 1))).getDate() + '.'
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).toLocaleString('default', {month: 'long'}) + ' '
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).getFullYear() + '</td>';

            tbl += '</tr>'

            for (let i = 0; i < obj.length; i++) {
                if (i % 5 === 0) {
                    tbl += '<tr>';
                    tbl += '<td>' + (9 + j) + ':00Uhr' + '</td>'
                    j += 1;
                }

                tbl += '<td>';

            if (obj[i].name != 'blocked' && obj[i].name != '') {
                tbl += '<input value="' + obj[i].name + '">'
                tbl += '</td>';
            } else if (obj[i].name === 'blocked') {
                tbl += '<input disabled>'
                tbl += '</td>';
            } else if (obj[i].name === '') {
                tbl += '<input type="text" data-hour="' + obj[i].hour + '" data-day="' + obj[i].day + '">'
                tbl += '</td>';
            }

            if (i % 5 === 4) {
                tbl += '</tr>';

            }}

            document.getElementById('tableData').innerHTML = tbl;
        }

    }

    xhttp.open("POST", "../ajax.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("monday=" + monday + "&isBarber="+ document.getElementById('isBarber').value);
}

function newUpdate() {
    let name = '';
    let hour = 0;
    let day = '';
    const inputfields = document.getElementsByTagName('input');
    for (const ipfield of inputfields) {
        if (ipfield.value != '') {
            name = ipfield.value
            day = ipfield.dataset.day
            hour = ipfield.dataset.hour
        }
    }
    console.log('newUpdate()')
    console.log(name)
    console.log(hour)
    console.log(day)
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementsByTagName('body')[0].innerHTML = this.responseText
            console.log(this.responseText);
        }
    }
    xhttp.open('POST', 'ajax.php');
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("name=" + name + "&day=" + day + "&hour=" + hour);
}