let barbers;
let baseDay;


const login = document.querySelector('.login');
if (login) login.addEventListener('click', () => location.href = "?view=loginPage");


function deleteAppointment() {
    const appointmentId = this.dataset.appointmentid
    const inputs = document.getElementsByClassName('userInput')

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            alert(this.responseText)
            console.log('testtest');
        }
    }
    xhttp.open("POST", "../ajax.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("appointmentId=" + appointmentId)

    for (const input of inputs) {
        if (input.dataset.appointmentid === appointmentId) {
            input.value = '';
            input.removeAttribute('data-appointmentid')
            input.disabled = false;
        }
    }
}

function initiateDeleteButtons() {
    const deleteButtons = document.getElementsByClassName('delete')
    const inputs = document.getElementsByClassName('userInput')

    for (const deleteButton of deleteButtons) {
        for (const input of inputs) {
            if (deleteButton.dataset.date === input.dataset.date && deleteButton.dataset.time === input.dataset.time) {
                if (input.value !== '[Termin belegt]' && input.value !== '' && input.value !== null) {
                    deleteButton.addEventListener('click', deleteAppointment)
                    deleteButton.setAttribute('data-appointmentId', '' + input.dataset.appointmentid)
                }
            }
        }
    }
}

function createBarberSelector(barberObjects) {
    let html = '';
    html += '<label htmlFor="cars">Lieblingsmensch:</label>'
    html += '<select name="barberView" id="barberView">'
    html += '<option value="" >---</option>'
    for (const barberObject of barberObjects) {
        html += '<option dataset-id="' + barberObject.id + '" value="' + barberObject.id + '">' + barberObject.firstName + ' ' + barberObject.lastName + '</option>'
    }
    html += '</select>'
    document.getElementById('barberSelector').innerHTML = html;
    document.getElementById('barberSelector').addEventListener('change', barberWorkSchedule)
}


function barberWorkSchedule() {
    const barberViewValue = document.querySelector('select').value
    const inputs = document.getElementsByClassName('userInput');
    let k = 0;
    for (const barber of barbers) {

        if (Number(barberViewValue) === barber.id) {

            const workerShiftStart = barber.workStart
            const workerShiftEnd = barber.workEnd

            const storeOpeningTime = new Date('2023-02-14 09:00:00')

            let workStart = new Date('2023-02-14 ' + workerShiftStart)
            let workEnd = new Date('2023-02-14 ' + workerShiftEnd)

            if (workStart < storeOpeningTime) {
                workStart = storeOpeningTime
            }

            let workerShiftStartTimeFormat = formatTime(workStart)
            let workerShiftEndTimeFormat = formatTime(workEnd)

            let nextAvailableSlot = new Date(workStart.setMinutes(workStart.getMinutes() + 30))
            let nextAvailableSlotTimeFormat = formatTime(nextAvailableSlot)


            for (const input of inputs) {
                input.disabled = true

                if (input.dataset.time === workerShiftStartTimeFormat) {
                    input.disabled = false
                }

                if (input.dataset.time === nextAvailableSlotTimeFormat && nextAvailableSlotTimeFormat !== workerShiftEndTimeFormat) {
                    if (input.value === '') {
                        input.disabled = false
                    }

                    k += 1
                }
                if (k !== 0 && k % 5 === 0) {
                    nextAvailableSlot = new Date(nextAvailableSlot.setMinutes(nextAvailableSlot.getMinutes() + 30))
                    nextAvailableSlotTimeFormat = formatTime(nextAvailableSlot)
                }

                if (input.dataset.time === workerShiftEndTimeFormat) {
                    workEnd = new Date(workStart.setMinutes(workEnd.getMinutes() + 30))
                    workerShiftEndTimeFormat = formatTime(workEnd)
                }


            }
        }
    }
}

function formatTime(firstDay) {
    return padTo2Digits(firstDay.getHours()) + ':' + padTo2Digits(firstDay.getMinutes())
}

function getSQLFormat(dateObjectFormat) {
    let year = dateObjectFormat.getFullYear() + '-';
    let month = dateObjectFormat.getMonth()
    month++
    if (String(month).length == 1) {
        month = '0' + month + '-';
    }
    let day = dateObjectFormat.getDate();
    if (String(day).length == 1) {
        day = '0' + day;
    }
    return year + month + day
}

function padTo2Digits(num) {
    return String(num).padStart(2, '0');
}

function fillInputNameValue(appointments) {
    const userId = document.getElementById('inputUserId').value
    const userRole = document.getElementById('inputUserRole').value
    const inputs = document.getElementsByClassName('userInput');

    for (const appointment of appointments) {
        const appointmentSlotStart = new Date(appointment.slotStart)
        const slotStartDateFormat = getSQLFormat(appointmentSlotStart)
        const slotStartTimeFormat = formatTime(appointmentSlotStart)

        const appointmentSlotEnd = new Date(appointment.slotEnd)
        // const slotEndDateFormat = getSQLFormat(appointmentSlotEnd)
        const slotEndTimeFormat = formatTime(appointmentSlotEnd)

        let nextAvailableSlot = new Date(appointmentSlotStart.setMinutes(appointmentSlotStart.getMinutes() + 30))
        let nextAvailableSlotTimeFormat = formatTime(nextAvailableSlot)

        for (const input of inputs) {
            if (input.dataset.date === slotStartDateFormat && input.dataset.time === slotStartTimeFormat) {

                if (userRole === 'customer' && +appointment.user.id === +userId) {
                    input.value = appointment.user.firstName + ' ' + appointment.user.lastName
                    input.setAttribute('data-appointmentId', '' + appointment.id)
                    input.disabled = true
                } else if (userRole !== 'customer') {
                    input.value = appointment.user.firstName + ' ' + appointment.user.lastName
                    input.setAttribute('data-appointmentId', '' + appointment.id)
                    input.disabled = true
                } else
                    input.value = '[Termin belegt]'
                input.disabled = true

            }


            if (input.dataset.date === slotStartDateFormat && input.dataset.time === nextAvailableSlotTimeFormat && nextAvailableSlotTimeFormat != slotEndTimeFormat) {
                if (input.value === '') {
                    if (userRole === 'customer' && +appointment.user.id === +userId) {
                        input.value = appointment.user.firstName + ' ' + appointment.user.lastName
                        input.disabled = true
                    } else if (userRole !== 'customer') {
                        input.value = appointment.user.firstName + ' ' + appointment.user.lastName
                        input.disabled = true
                    } else
                        input.value = '[Termin belegt]'
                    input.disabled = true
                    nextAvailableSlot = new Date(nextAvailableSlot.setMinutes(nextAvailableSlot.getMinutes() + 30))
                    nextAvailableSlotTimeFormat = formatTime(nextAvailableSlot)
                }
            }


        }
    }

    for (const inputField of inputs) {
        for (const iptField of inputs) {
            if (inputField.value === iptField.value && inputField.dataset.appointmentid) {
                iptField.setAttribute('data-appointmentId', '' + inputField.dataset.appointmentid)
            }
        }
    }

}

function loadCurrentMonday(date) {
    if (date === undefined) {
        baseDay = new Date();
    } else {
        baseDay = new Date(date)
    }

    let weekDay = baseDay.getDay()
    if (weekDay === 0) {
        let monday = new Date(baseDay.setDate(baseDay.getDate() - 6))
        monday = getSQLFormat(monday)
        return monday

    } else {
        let monday = new Date(baseDay.setDate(baseDay.getDate() - (weekDay - 1)))
        monday = getSQLFormat(monday)
        return monday

    }
}

function loadLastMonday(baseDay) {
    let lastWeek = new Date(baseDay.setDate(baseDay.getDate() - 7))
    let lastWeekStr = getSQLFormat(lastWeek)
    loadDoc(loadCurrentMonday(lastWeekStr))
}

function loadNextMonday(baseDay) {
    let nextWeek = new Date(baseDay.setDate(baseDay.getDate() + 7))
    console.log(nextWeek)
    let nextWeekStr = getSQLFormat(nextWeek)

    loadDoc(loadCurrentMonday(nextWeekStr))
}

// alle Frisöre laden
function loadBarbaers() {

}

// load ist ein Montag im SQL-Format
function loadDoc(load) {
    let monday = load
    console.log(monday)

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            const barbersCustomerTable = this.responseText;
            // const table = barberObjects
            let formatAjax = JSON.parse(barbersCustomerTable);
            // barbers = formatAjax.barbers
            // formatAjax = formatAjax.appointments;

            // Wochentabelle ohne Daten erzeugen
            let tbl = emptyTable(formatAjax[1]);
            barbers = formatAjax[0];
            document.getElementById('tableData').innerHTML = tbl;
            fillInputNameValue(formatAjax[1])
            createBarberSelector(barbers)
            initiateDeleteButtons()
        }
    }

    const emptyTable = function (formatAjax) {
        const firstDay = new Date(baseDay.setDate(baseDay.getDate() + 1))
        const tuesday = getSQLFormat(firstDay)
        const wednesday = getSQLFormat(new Date(firstDay.setDate(firstDay.getDate() + 1)))
        const thursday = getSQLFormat(new Date(firstDay.setDate(firstDay.getDate() + 1)))
        const friday = getSQLFormat(new Date(firstDay.setDate(firstDay.getDate() + 1)))
        const saturday = getSQLFormat(new Date(firstDay.setDate(firstDay.getDate() + 1)))

        // @todo Startzeit und Endzeit aus backend abholen
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

        for (let i = 0; i < 80; i++) {
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
            tbl += `<input class="userInput" data-time= ${formatTime(firstDay)} data-date=${weekday} >`
            tbl += `<button class="delete" type="button" data-time= ${formatTime(firstDay)} data-date=${weekday}>X</button>`


            tbl += '</td>';

            if (j === 5) {
                j = 0
            }
            if (i % 5 === 4) {
                tbl += '</tr>';
                firstDay.setMinutes(firstDay.getMinutes() + 30)

            }
        }
        return tbl;
    }


    // const inputBarberId = document.getElementById('inputBarberId')
    // const barberId = inputBarberId ? inputBarberId.value : null
    // const barberId = inputBarberId.value

    xhttp.open("POST", "../ajax.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("monday=" + monday + "&barber_id=all")
}

function newUpdate() {
    let name = '';
    let hour = 0;
    let day = '';
    const inputFields = document.getElementsByTagName('input');
    for (const inputField of inputFields) {
        if (inputField.value != '') {
            name = inputField.value
            day = inputField.dataset.day
            hour = inputField.dataset.hour
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