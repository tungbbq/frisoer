let role;
let name;
let firstName;
let lastName;
let telephone;
let workStart;
let workEnd;
let password;

function loadCreateUser() {
    let html = '';
    html += `
        <div class="d-flex justify-content-between">
            <div class="btn-group" role="group" aria-label="Basic example">
                <input class="btn-check " type="radio" id ="customerRadio" name="role" value ="customer" checked>
                <label class="btn btn-outline-primary" for="customerRadio" > Kunde </label>
                <input class="btn-check" type="radio" id ="barberRadio" name="role" value ="barber" checked>
                <label class="btn btn-outline-primary" for="barberRadio" > Friseur </label>
            </div>
            <div class="d-grid gap-2">
                <button class="logout btn btn-primary">Logout</button>
            </div>
        </div>
    `


    html += `<div class="form-group">`
    html += `<input class="form-control" type="text" id="name" placeholder="userName">`
    html += `</div>`

    html += `<div class="form-group">`
    html += `<input class="form-control" type="text" id="firstName" placeholder="Vorname">`
    html += `</div>`

    html += `<div class="form-group">`
    html += `<input class="form-control" type="text" id="lastName" placeholder="Nachname">`
    html += `</div>`

    html += `<div class="form-group">`
    html += `<input class="form-control" type="text" id="telephone" placeholder="Telefonnummer">`
    html += `</div>`

    html += `<div class="form-group">`
    html += `<input class="form-control" type="text" id="workStart" placeholder="Arbeitsbeginn" disabled>`
    html += `</div>`

    html += `<div class="form-group">`
    html += `<input class="form-control" type="text" id="workEnd" placeholder="Arbeitsende" disabled>`
    html += `</div>`

    html += `<div class="form-group">`
    html += `<input class="form-control" type="text" id="password" placeholder="Passwort = userName" disabled>`
    html += `</div>`

    html += `<div class="d-grid gap-2 mt-4">`
    html += `<button class="btn btn-primary" type="button" onclick="createNewUser()"> Speichern`
    html += `</div>`

    document.querySelector('#outputCreateUser').innerHTML = html;
    logout()
    document.querySelector('#customerRadio').addEventListener('change', disableCustomerInputs)
    document.querySelector('#barberRadio').addEventListener('change', disableCustomerInputs)

}

function createNewUser() {

    name = document.querySelector('#name').value
    firstName = document.querySelector('#firstName').value
    lastName = document.querySelector('#lastName').value
    telephone = document.querySelector('#telephone').value
    workStart = document.querySelector('#workStart').value
    workEnd = document.querySelector('#workEnd').value
    password = name
    role = document.querySelector('input[name="role"]:checked').value;

    console.log(role, name, firstName, lastName, telephone, workStart, workEnd, password)

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.status === 200) {
                alert(`${name} wurde neu angelegt.`)
            } else if (this.status === 400) {
                alert('Fehler')
            }
        }
    }
    xhttp.open("POST", "../ajax.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if (role === 'barber') {
        xhttp.send(`action=saveUser&roleToSave=${role}&name=${name}&firstName=${firstName}&lastName=${lastName}
&telephone=${telephone}&workStart=${workStart}&workEnd=${workEnd}&password=${password}`)
    } else if (role === 'customer') {
        xhttp.send(`action=saveUser&roleToSave=${role}&name=${name}&firstName=${firstName}&lastName=${lastName}&password=${password}
&telephone=${telephone}`)
    }
}

function disableCustomerInputs(){
    role = document.querySelector('input[name="role"]:checked').value

    if (role === 'customer'){
        document.querySelector('#workStart').disabled = true
        document.querySelector('#workEnd').disabled = true
    } else if (role === 'barber'){
        document.querySelector('#workStart').disabled = false
        document.querySelector('#workEnd').disabled = false
    }
}