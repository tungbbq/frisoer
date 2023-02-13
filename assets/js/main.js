const testObjects = [{
    slotStart: '2023-02-09 09:00:00',
    slotEnd: '2023-02-09 15:30:00',
    barber_id: 1,
    user_id: 2,
    id: 1
},
    {
        slotStart: '2023-02-10 15:00:00',
        slotEnd: '2023-02-10 16:00:00',
        barber_id: 1,
        user_id: 8,
        id: 7
    },
    {
        slotStart: '2023-02-11 15:00:00',
        slotEnd: '2023-02-11 15:30:00',
        barber_id: 1,
        user_id: 14,
        id: 13
    }]
let baseday;

const login = document.querySelector('.login');
if (login) login.addEventListener('click', () => location.href = "?view=loginPage");

function formatTime(firstDay) {
    return padTo2Digits(firstDay.getHours()) + ':' + padTo2Digits(firstDay.getMinutes())
}

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

function fillInputNameValue(appointments) {

    const inputs = document.getElementsByTagName('input');

    for (const appointment of appointments) {
        const appointmentSlotStart = new Date(appointment.slotStart)
        const slotStartDateFormat = getSQLFormat(appointmentSlotStart)
        const slotStartTimeFormat = formatTime(appointmentSlotStart)

        const appointmentSlotEnd = new Date(appointment.slotEnd)
        const slotEndDateFormat = getSQLFormat(appointmentSlotEnd)
        const slotEndTimeFormat = formatTime(appointmentSlotEnd)

        let nextAvailableSlot = new Date(appointmentSlotStart.setMinutes(appointmentSlotStart.getMinutes() + 30))
        let nextAvailableSlotTimeFormat = formatTime(nextAvailableSlot)


        for (const input of inputs) {
            if (input.dataset.date === slotStartDateFormat && input.dataset.time === slotStartTimeFormat) {
                input.value = appointment.user.firstName + ' ' + appointment.user.lastName
                input.disabled = true


            }
            if (input.dataset.date === slotEndDateFormat && input.dataset.time === slotEndTimeFormat) {
                input.value = appointment.user.firstName + ' ' + appointment.user.lastName
                input.disabled = true
            }
            // console.log(nextAvailableSlotTimeFormat)
            if (input.dataset.date === slotStartDateFormat && input.dataset.time === nextAvailableSlotTimeFormat) {
                if (input.value === '') {
                    input.value = appointment.user.firstName + ' ' + appointment.user.lastName
                    input.disabled = true
                    nextAvailableSlot = new Date(nextAvailableSlot.setMinutes(nextAvailableSlot.getMinutes() + 30))
                    nextAvailableSlotTimeFormat = formatTime(nextAvailableSlot)
                }
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
        let monday = new Date(baseday.setDate(baseday.getDate() - 6))
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
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            const table = this.responseText;
            // const table = testObjects
            const formatAjax = JSON.parse(table)
            console.log(formatAjax)

            const firstDay = new Date(baseday.setDate(baseday.getDate() + 1))
            const tuesday = getSQLFormat(firstDay)
            const wednesday = getSQLFormat(new Date(firstDay.setDate(firstDay.getDate() + 1)))
            const thursday = getSQLFormat(new Date(firstDay.setDate(firstDay.getDate() + 1)))
            const friday = getSQLFormat(new Date(firstDay.setDate(firstDay.getDate() + 1)))
            const saturday = getSQLFormat(new Date(firstDay.setDate(firstDay.getDate() + 1)))

            firstDay.setHours(9, 0, 0)

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

            for (let i = 0; i < 85; i++) {
                if (i % 5 === 0) {
                    tbl += '<tr>';
                    tbl += '<td>' + formatTime(firstDay) + '</td>'

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
                tbl += `<input data-time= ${formatTime(firstDay)} data-date=${weekday} >`


                tbl += '</td>';

                if (j === 5) {
                    j = 0
                }
                if (i % 5 === 4) {
                    tbl += '</tr>';
                    firstDay.setMinutes(firstDay.getMinutes() + 30)

                }
            }
            document.getElementById('tableData').innerHTML = tbl;
            fillInputNameValue(formatAjax)

        }

    }
    const inputBarberId = document.getElementById('inputBarberId')
    const barberId = inputBarberId ? inputBarberId.value : null
    // const barberId = inputBarberId.value
    console.log(monday)
    console.log(barberId)

    xhttp.open("POST", "../ajax.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("monday=" + monday +"&barber_id="+ barberId )
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