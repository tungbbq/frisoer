let userObjectArrays;
let role;
let name;
let firstName;
let lastName;
let telephone;
let workStart;
let workEnd;
let password;

let getDataForAdminPages = () =>{
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            userObjectArrays = JSON.parse(this.responseText);
console.log(userObjectArrays)
        }
    }
    //xhttp.addEventListener("load", loadBarbersWithAppointments);
    xhttp.open('POST', '../ajax.php');
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(`action=loadUser`);
}

let loadUpdateUsers = () => {
    let html = ``;
    //for loop einbauen
    html += `<div className="form-group">`
    html += `<a href="adminCreatePage.php">User anlegen >>></a>`
    html += `</div>`

    html += `<div className="form-group">`
    html += `<input className="form-control" type="text" id="name" placeholder="userName">`
    html += `<input className="form-control" type="text" id="firstName" placeholder="Vorname">`
    html += `<input className="form-control" type="text" id="lastName" placeholder="Nachname">`
    html += `<input className="form-control" type="text" id="telephone" placeholder="Telefonnummer">`
    html += `<input className="form-control" type="text" id="workStart" placeholder="Arbeitsbeginn">`
    html += `<input className="form-control" type="text" id="workEnd" placeholder="Arbeitsende">`
    html += `<input className="form-control" type="text" id="role" placeholder="Rolle">`
    html += `<button class="btn btn-outline-secondary" type="button" onclick="updateUser()"> Ändern`
    html += `<button class="btn btn-outline-secondary" type="button" onclick="deleteUser()"> Löschen`
    html += `</div>`

    document.getElementById('outputUpdateUser').innerHTML = html;

let updateUser = () => {
    //...TODO
}

let deleteUser = () => {
    //...TODO
}

function loadCreateUser() {
    let html = '';
    html += `<div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">`
    html += `<button class="logout btn btn-primary me-md-2">Logout</button>`
    html += `</div>`

    html += `<div class="form-group">`
    html += `<input class="form-control" type="text" id="name" placeholder="userName">`
    let html = ``;

    html += `<div className="form-group">`
    html += `<a href="adminUpdatePage.php">Daten ändern >>></a>`
    html += `</div>`

    html += `<div className="form-group">`
    html += `<input className="form-control" type="text" id="name" placeholder="userName">`
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
    html += `<input class="form-control" type="text" id="workStart" placeholder="Arbeitsbeginn">`
    html += `</div>`

    html += `<div class="form-group">`
    html += `<input class="form-control" type="text" id="workEnd" placeholder="Arbeitsende">`
    html += `</div>`

    html += `<div class="form-group">`
    html += `<input class="form-control" type="text" id="password" placeholder="Passwort = userName" disabled>`
    html += `</div>`

    html += `<div class="form-check form-check-inline">`
    html += `<input class="form-check-input" type="radio" id ="customer" name="role" value ="customer"  checked="checked">`
    html += `<label class="form-check-label" for="customer" > Kunde </label>`
    html += `</div>`

    html += `<div class="form-check form-check-inline">`
    html += `<input class="form-check-input" type="radio" id="barber" name="role" value="barber">`
    html += `<label class="form-check-label" for="barber"> Friseur </label>`
    html += `</div> <br>`

    html += `<div class="d-grid gap-2 mt-3">`
    html += `<button class="btn btn-primary" type="button" onclick="createNewUser()"> speichern`
    html += `</div>`

    document.getElementById('outputCreateUser').innerHTML = html;
    logout()
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