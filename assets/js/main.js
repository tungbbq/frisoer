let baseday;

const login = document.querySelector('.login');
if (login) login.addEventListener('click', () => location.href = "?view=loginPage");

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

function padTo2Digits(num) {
    return String(num).padStart(2, '0');
}

function Arr2Arr(objArr) {
    const inputs = document.getElementsByTagName('input');

    function testFilter(obj) {
        return obj.name != ''
    }

    const newArray = objArr.filter(testFilter)

    // == weil vergleich int und string
    for (const obj of newArray) {
            for (const ipt of inputs) {

                if (ipt.dataset.weekday == obj.day && ipt.dataset.hour == obj.hour) {
                    ipt.value = obj.name
                }
            }
    }
}


function loadCurrentMonday(date) {
    if (date === undefined) {
        baseday = new Date();
    } else {
        baseday = new Date(date)
        console.log(baseday)
    }

    let weekday = baseday.getDay()
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
            const obj = JSON.parse(table)
            const firstDay = new Date(obj[0].day)
            const tuesday = getSQLFormat(firstDay)
            const wednesday = getSQLFormat(new Date(firstDay.setDate(firstDay.getDate() + 1)))
            const thursday = getSQLFormat(new Date(firstDay.setDate(firstDay.getDate() + 1)))
            const friday = getSQLFormat(new Date(firstDay.setDate(firstDay.getDate() + 1)))
            const saturday = getSQLFormat(new Date(firstDay.setDate(firstDay.getDate() + 1)))


            firstDay.setHours(8, 30, 0)
            let tbl = '';
            let j = 0;
            let weekday = '';

            tbl += '<tr> '
            tbl += '<td></td>'
            tbl += '<td class="weekday">' + tuesday + '</td>'
            tbl += '<td class="weekday">' + wednesday + '</td>'
            tbl += '<td class="weekday">' + thursday + '</td>'
            tbl += '<td class="weekday">' + friday + '</td>'
            tbl += '<td class="weekday">' + saturday + '</td>'

            tbl += '</tr>'

            for (let i = 0; i < obj.length; i++) {
                if (i % 5 === 0) {
                    tbl += '<tr>';
                    firstDay.setMinutes(firstDay.getMinutes() + 30)
                    tbl += '<td>' + padTo2Digits(firstDay.getHours()) + ':' + padTo2Digits(firstDay.getMinutes()) + '</td>'
                }
                j += 1;

                tbl += '<td>';

                if (j === 1) {
                    weekday = tuesday
                } else if (j === 2) {
                    weekday = wednesday
                } else if (j === 3) {
                    weekday = thursday
                } else if (j === 4) {
                    weekday = friday
                } else if (j === 5) {
                    weekday = saturday
                }

                tbl += '<input data-weekday="' + weekday + '" data-day="' + obj[i].day + '" data-hour="' + obj[i].hour + '">'


                tbl += '</td>';

                if (j === 5) {
                    j = 0
                }
                if (i % 5 === 4) {
                    tbl += '</tr>';

                }
            }
            document.getElementById('tableData').innerHTML = tbl;
            Arr2Arr(obj)

        }

        const tuesday = document.getElementById('tuesday')
        if (tuesday) {
            console.log(tuesday.innerText)
        }
    }
    xhttp.open("POST", "../ajax.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("monday=" + monday);
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