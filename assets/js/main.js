const BARBER_INDEX = 0;
const APPOINTMENTS_INDEX = 1;
const CUSTOMER_INDEX = 2;
const SLOT_INTERVAL = 30;

let currentWeek;
let firstDayOfWeek;
let prevInputsData = [];

function getInputData() {
    const inputs = document.querySelectorAll('.userInput');
    let data = [];

    inputs.forEach((input) => data.push({date: input.dataset.date, time: input.dataset.time, value: input.value}));
    return data;
}

function deleteAppointment(e, userRole) {
    const id = e.target.dataset.appointmentId;
    const xhttp = new XMLHttpRequest();

    if (confirm("Willst du den Termin absagen?")) {
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                if (this.status === 200) {
                    alert('Dein Termin wurde gelöscht')
                } else if (this.status === 400) {
                    alert('Fehler')
                }
            }
        }

        xhttp.addEventListener("load", function () {
            getAppointmentsByBarber(userRole)
        });
        xhttp.open("POST", "../ajax.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`action=deleteAppointment&appointmentId=${id}`)
    }
}

function initDeleteButtons(userRole) {
    const buttons = document.querySelectorAll('.delete');
    const inputs = document.querySelectorAll('.userInput');

    buttons.forEach((button) => {
        inputs.forEach((input) => {
            if (button.dataset.date === input.dataset.date && button.dataset.time === input.dataset.time) {
                if (input.value !== '[Termin belegt]' && input.value !== '' && input.value !== null) {
                    button.addEventListener('click', (e) => deleteAppointment(e, userRole));
                    button.setAttribute('data-appointment-id', '' + input.dataset.appointmentId);
                } else button.disabled = true
            }
        })
    });
}

function createBarberSelector(barbers, currentBarber, userRole) {
    let html = `<select class="form-select form-select-sm text-start" name="barberView" id="barberView">`;

    barbers.forEach((barber) => html += `<option value="${barber.id}">${barber.firstName} ${barber.lastName}</option>`)

    html += `</select>`

    document.getElementById('barberSelector').innerHTML = html;
    document.getElementById('barberSelector').addEventListener('change', function() {getAppointmentsByBarber(userRole)})
    document.getElementById("barberView").value = currentBarber;
}

function getAppointmentsByBarber(userRole) {
    const currentBarber = document.querySelector('select').value;

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            const barbersCustomerTable = this.responseText;
            const response = JSON.parse(barbersCustomerTable);
            const barbers = response[BARBER_INDEX];
            const appointments = response[APPOINTMENTS_INDEX];
            let customers;

            if (userRole !== 'customer') {
                customers = response[CUSTOMER_INDEX];
            }

            document.getElementById('tableData').innerHTML = getEmptyTable(barbers, customers, userRole);
            fillInputs(appointments, userRole);
            initDeleteButtons(userRole);
            setWorkHours(barbers);
            document.getElementById("barberView").value = currentBarber;
        }
    }
    xhttp.open("POST", "../ajax.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`action=load&monday=${currentWeek}&barber_id=${currentBarber}`)
}

function setWorkHours(barbers) {
    const currentBarber = document.querySelector('select').value;
    const inputs = document.getElementsByClassName('userInput');

    let counter = 0;
    for (const barber of barbers) {
        if (Number(currentBarber) === barber.id) {
            const firstShift = barbers.map((barber) => [barber.workStart]).sort().shift();
            const firstShiftToDate = new Date(`2023-02-14 ${firstShift.join()}`);
            let shiftStart = new Date(`2023-02-14 ${barber.workStart}`);
            let shiftEnd = new Date(`2023-02-14 ${ barber.workEnd}`);
            let nextAvailableSlot = new Date((new Date(`2023-02-14 ${barber.workStart}`)).setMinutes((new Date(`2023-02-14 ${barber.workStart}`)).getMinutes() + SLOT_INTERVAL));

            if (shiftStart < firstShiftToDate) shiftStart = firstShiftToDate;

            for (const input of inputs) {
                if (input.value === '') input.disabled = true;

                if (input.dataset.time === formatTime(shiftStart)) {
                    if (input.value === '') input.disabled = false;
                }

                if (input.dataset.time === formatTime(nextAvailableSlot) && formatTime(nextAvailableSlot) !== formatTime(shiftEnd)) {
                    if (input.value === '') input.disabled = false;

                    counter += 1;
                }

                if (counter !== 0 && counter % 5 === 0) {
                    nextAvailableSlot = new Date(nextAvailableSlot.setMinutes(nextAvailableSlot.getMinutes() + SLOT_INTERVAL));
                }

                if (input.dataset.time === formatTime(shiftEnd)) {
                    shiftEnd = new Date(shiftStart.setMinutes(shiftEnd.getMinutes() + SLOT_INTERVAL));
                }

            }
        }
    }
}

function padTo2Digits(num) {
    return String(num).padStart(2, '0');
}

function formatTime(day) {
    return `${padTo2Digits(day.getHours())}:${padTo2Digits(day.getMinutes())}`
}

function formatDate(date) {
    let year = `${date.getFullYear()}-`;
    let month = date.getMonth();
    let day = date.getDate();
    
    month++;
    if (String(month).length === 1) {
        month = `0${month}-`;
    }
    
    if (String(day).length === 1) {
        day = `0${day}`;
    }
    
    return `${year}${month}${day}`
}

function fillCustomer(input, userName) {
    input.value = `${userName}`
}

function fillInputs(appointments, userRole) {
    const userId = document.getElementById('inputUserId').value;
    const inputs = document.getElementsByClassName('userInput');
    const userName = document.getElementById('inputUserName').value;

    for (const input of inputs) {
        if (userRole !== 'customer') {
            input.setAttribute('list', 'customerName');
        } else {
            input.addEventListener("click", () => fillCustomer(input, userName));
        }
    }

    for (const appointment of appointments) {
        const start = new Date(appointment.slotStart);
        const end = new Date(appointment.slotEnd);
        const appointmentSlotEnd = new Date(end.setMinutes(end.getMinutes() - SLOT_INTERVAL));
        let nextAvailableSlot = new Date((new Date(appointment.slotStart)).setMinutes((new Date(appointment.slotStart)).getMinutes() + SLOT_INTERVAL));

        for (const input of inputs) {
            if ((input.dataset.date === formatDate(start) && input.dataset.time === formatTime(start)) ||
                (input.dataset.date === formatDate(appointmentSlotEnd) && input.dataset.time === formatTime(appointmentSlotEnd))
            ) {
                if (userRole === 'customer') {
                    if (+appointment.user.id === +userId) {
                        input.disabled = true;
                        input.value = appointment.user.firstName + ' ' + appointment.user.lastName;
                        input.setAttribute('data-appointment-id', appointment.id);
                    } else {
                        input.disabled = true;
                        input.value = '[Termin belegt]';
                    }
                }
                else if (userRole !== 'customer') {
                    input.disabled = true;
                    input.value = appointment.user.firstName + ' ' + appointment.user.lastName;
                    input.setAttribute('data-appointment-id', appointment.id);
                }
            }

            if (input.dataset.date === formatDate(start) &&
                input.dataset.time === formatTime(nextAvailableSlot) &&
                formatTime(nextAvailableSlot) !== formatTime(appointmentSlotEnd) &&
                appointmentSlotEnd > nextAvailableSlot) {
                if (input.value === '' && userRole === 'customer') {
                    if (+appointment.user.id === +userId) {
                        input.disabled = true;
                        input.value = appointment.user.firstName + ' ' + appointment.user.lastName;
                        input.setAttribute('data-appointment-id', appointment.id);
                    } else {
                        input.disabled = true;
                        input.value = '[Termin belegt]';
                    }
                }

                else if (input.value === '' && userRole !== 'customer') {
                    input.disabled = true;
                    input.value = appointment.user.firstName + ' ' + appointment.user.lastName;
                    input.setAttribute('data-appointment-id', appointment.id);
                }

                nextAvailableSlot = new Date(nextAvailableSlot.setMinutes(nextAvailableSlot.getMinutes() + SLOT_INTERVAL));
            }
        }
    }

    prevInputsData = getInputData();
}

function getCurrentMonday(date) {
    if (!date) {
        firstDayOfWeek = new Date();
    } else {
        firstDayOfWeek = new Date(date);
    }

    if (firstDayOfWeek.getDay() === 0) {
        currentWeek = formatDate(new Date(firstDayOfWeek.setDate(firstDayOfWeek.getDate() - 6)))
        return currentWeek

    } else {
        currentWeek = formatDate(new Date(firstDayOfWeek.setDate(firstDayOfWeek.getDate() - (firstDayOfWeek.getDay() - 1))))
        return currentWeek
    }
}

function getLastMonday(mondayDateTime) {
    const userRole = document.getElementById('inputUserRole').value;
    currentWeek = formatDate(new Date(mondayDateTime.setDate(mondayDateTime.getDate() - 7)))
    getAppointmentsByBarber(userRole);
}

function getNextMonday(mondayDateTime) {
    const userRole = document.getElementById('inputUserRole').value;
    currentWeek = formatDate(new Date(mondayDateTime.setDate(mondayDateTime.getDate() + 7)));
    getAppointmentsByBarber(userRole);
}

// 1.
// loadDoc() wird beim Seitenaufruf /views/customerPage.php geladen
// mondayOfTheWeek ist ein Montag im SQL-Format[YYYY-MM-DD] und wird von loadCurrentMonday, loadLastMonday (<-) oder loadNextMonday (->) berechnet
function loadDoc(currentMonday) {
    const userRole = document.getElementById('inputUserRole').value;
    // bei initalisierung loadDoc(getCurrentMonday)
    currentWeek = currentMonday;
    let currentBarber;

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            // 3.
            // wir erhalten 3 Arrays mit Objekten im Array, das erste Array[0] enthaelt alle Barbers, das zweite Array[1] alle Appointments, das dritte Array[2] alle Users
            // this.responseText ist die Antwort vom Backend und ist ein String der umgeformt wird
            const response = JSON.parse(this.responseText);
            const barbers = response[BARBER_INDEX];
            const appointments = response[APPOINTMENTS_INDEX];
            let customers;

            if (userRole !== 'customer') {
                customers = response[CUSTOMER_INDEX];
            }

            // Wochentabelle ohne Daten erzeugen
            document.getElementById('tableData').innerHTML = getEmptyTable(barbers, customers, userRole);

            // if Bedingung damit createBarberSelector automatisch den ersten Barber aus der Liste waehlt
            if (!currentBarber) currentBarber = barbers[BARBER_INDEX].id

            // Tabelleninhalt wird befuellt
            fillInputs(appointments, userRole)

            // BarberSelector wird erzeugt
            createBarberSelector(barbers, currentBarber, userRole)

            // wenn der Barber nicht arbeitet, werden die Inputfelder deaktiviert
            setWorkHours(barbers)

            // delete Buttons werden neben jeden Inputfeld erstellt und funktionieren nur wenn ein Termin besteht
            initDeleteButtons(userRole)

            // erster Barber wird fuer den createBarberSelector gewahelt
            document.getElementById("barberView").value = currentBarber;
        }
    }
    xhttp.open("POST", "../ajax.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// 2.
// wir uebergeben action&monday ans backend (ajax.php) und bekommen als Antwort... siehe 3.
    xhttp.send(`action=load&monday=${currentWeek}`)
}

// ermittelt den frühesten Arbeitsbeginn
function getFirstShift(barbers) {
    const start = barbers.map(barber => [barber.workStart]).sort().shift();
    return new Date(`1970-01-01 ${start}`);
}

// ermittelt den spätesten Feierabend
function getLastShift(barbers) {
    const end = barbers.map(barber => [barber.workEnd]).sort().pop();
    return new Date(`1970-01-01 ${end}`);
}

// formatiert halbe Stunden in arithmetisches Äquivalent, um Anzahl der Zellen in der Tabelle zu ermitteln
function calcTimes(maxHours, maxMinutes, minHours, minMinutes) {
    if (maxMinutes === 30) {
        maxMinutes = 0.5
    }
    if (minMinutes === 30) {
        minMinutes = 0.5
    }
    return (((maxHours + maxMinutes) - (minHours + minMinutes)) * 2 + 1) * 5;
}

function getEmptyTable(barbers, customers, userRole) {
    const months = ["Januar", "Februar", "März", "April", "Mai", "Juni",
        "Juli", "August", "September", "Oktober", "November", "Dezember"
    ];

    const firstDay = new Date(firstDayOfWeek.setDate(firstDayOfWeek.getDate() + 1));
    const tuesday = new Date(firstDay);
    const wednesday = new Date(firstDay.setDate(firstDay.getDate() + 1));
    const thursday = new Date(firstDay.setDate(firstDay.getDate() + 1));
    const friday = new Date(firstDay.setDate(firstDay.getDate() + 1));
    const saturday = new Date(firstDay.setDate(firstDay.getDate() + 1));
    firstDayOfWeek = new Date(firstDayOfWeek.setDate(firstDayOfWeek.getDate() - 1));

    const maxHours = getLastShift(barbers).getHours();
    const maxMinutes = getLastShift(barbers).getMinutes();
    const minHours = getFirstShift(barbers).getHours();
    const minMinutes = getFirstShift(barbers).getMinutes();

    calcTimes(maxHours, maxMinutes, minHours, minMinutes);

    firstDay.setHours(minHours, minMinutes);

    let tbl = '';
    let j = 0;
    let weekday = '';

    tbl += '<tr class="no-gutters">';
    tbl += '<td ></td>';
    tbl += `<td class="weekday text-center">${tuesday.getDate()}. ${months[tuesday.getMonth()]} ${tuesday.getFullYear()}</td>`;
    tbl += `<td class="weekday text-center">${wednesday.getDate()}. ${months[wednesday.getMonth()]} ${wednesday.getFullYear()}</td>`;
    tbl += `<td class="weekday text-center">${thursday.getDate()}. ${months[thursday.getMonth()]} ${thursday.getFullYear()}</td>`;
    tbl += `<td class="weekday text-center">${friday.getDate()}. ${months[friday.getMonth()]} ${friday.getFullYear()}</td>`;
    tbl += `<td class="weekday text-center">${saturday.getDate()}. ${months[saturday.getMonth()]} ${saturday.getFullYear()}</td>`;

    for (let i = 0; i < calcTimes(maxHours, maxMinutes, minHours, minMinutes); i++) {
        if (i % 5 === 0) {
            tbl += '<tr class="no-gutters align-baseline text-center">';
            tbl += `<th scope="row">${formatTime(firstDay)}</th>`
        }

        j += 1;

        tbl += '<td>';

        if (j === 1) {
            weekday = tuesday;
        } else if (j === 2) {
            weekday = wednesday;
        } else if (j === 3) {
            weekday = thursday;
        } else if (j === 4) {
            weekday = friday;
        } else if (j === 5) {
            weekday = saturday;
        }

        tbl += `<div class="input-group input-group-sm">`
        tbl += `<input class="userInput form-control text-center" data-time= ${formatTime(firstDay)} data-date=${formatDate(weekday)} >`
        tbl += `<div class="input-group-append">`;
        tbl += `<button class="delete btn btn-outline-secondary" type="button" data-time= ${formatTime(firstDay)} data-date=${formatDate(weekday)}>X</button>`
        tbl += '</td>';
        tbl += `</div>`;
        tbl += `</div>`;

        if (j === 5) {
            j = 0;
        }

        if (i % 5 === 4) {
            tbl += '</tr>';
            firstDay.setMinutes(firstDay.getMinutes() + SLOT_INTERVAL);
        }
    }

    if (customers && userRole !== 'customer') {
        tbl += '<datalist id="customerName">';
        for (const customer of customers) {
            tbl += `<option class="customerID" data-userid=${customer.id} value="${customer.firstName} ${customer.lastName}">`;
        }
        tbl += '</datalist>';
    }
    return tbl;
}

function addAppointment() {
    const userRole = document.getElementById('inputUserRole').value;
    let userId = document.getElementById('inputUserId').value;
    const barberId = document.querySelector('select').value;
    const inputs = document.getElementsByClassName('userInput');
    const optionArray = document.getElementsByClassName('customerID');
    const currentInputsData = getInputData();
    let newAppointments = [];
    let allTimeSlots = [];

    for (const beforeSave of prevInputsData) {
        for (const afterSave of currentInputsData) {
            if (afterSave.date === beforeSave.date && afterSave.time === beforeSave.time && beforeSave.value !== afterSave.value) {
                newAppointments.push(afterSave);
            }
        }
    }

    for (const appointment1 of newAppointments) {
        for (const appointment2 of newAppointments) {
            if (appointment1.date !== appointment2.date) {
                alert('Bitte lege deine Termin an einem einzigen Tag fest!');
                return;
            }
        }
    }

    for (const appointment of newAppointments) {
        for (const option of optionArray) {
            if (option.value === appointment.value && userRole !== 'customer') {
                userId = option.dataset.userid;
            }
        }
        allTimeSlots.push(new Date(appointment.date + ' ' + appointment.time));
    }

    const dates = allTimeSlots.map((element) => new Date(element));
    let slotStart = new Date(Math.min(...dates));
    let slotStartSQLFormat = formatDate(slotStart) + ' ' + formatTime(slotStart);
    let slotEnd;

    if (allTimeSlots.length < 2) {
        slotEnd = new Date(slotStart.setMinutes(slotStart.getMinutes() + SLOT_INTERVAL));
    } else {
        slotEnd = new Date(Math.max(...dates));
        slotEnd = new Date(slotEnd.setMinutes(slotEnd.getMinutes() + SLOT_INTERVAL));
    }

    let slotEndSQLFormat = formatDate(slotEnd) + ' ' + formatTime(slotEnd);

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.status === 200) {
                alert('Dein Termin wurde angelegt!');
            } else if (this.status === 400) {
                alert('Fehler bei der Terminerstellung!');
            }
        }
    }
    xhttp.addEventListener("load", function() {getAppointmentsByBarber(userRole)});
    xhttp.open('POST', 'ajax.php');
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(`action=saveAppointment&user_id=${userId}&barber_id=${barberId}&slotStart=${slotStartSQLFormat}&slotEnd=${slotEndSQLFormat}`);

    for (const input of inputs) {
        if (input.value !== '') {
            input.disabled = true;
        }
    }
}
