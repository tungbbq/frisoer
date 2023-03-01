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
    html += `<div className="form-group">`
    html += `<input className="form-control" type="text" id="name" placeholder="userName">`
    html += `</div>`

    html += `<div className="form-group">`
    html += `<input className="form-control" type="text" id="firstName" placeholder="Vorname">`
    html += `</div>`

    html += `<div className="form-group">`
    html += `<input className="form-control" type="text" id="lastName" placeholder="Nachname">`
    html += `</div>`

    html += `<div className="form-group">`
    html += `<input className="form-control" type="text" id="telephone" placeholder="Telefonnummer">`
    html += `</div>`

    html += `<div className="form-group">`
    html += `<input className="form-control" type="text" id="workStart" placeholder="Arbeitsbeginn">`
    html += `</div>`

    html += `<div className="form-group">`
    html += `<input className="form-control" type="text" id="workEnd" placeholder="Arbeitsende">`
    html += `</div>`

    html += `<div className="form-group">`
    html += `<input className="form-control" type="text" id="password" placeholder="Passwort = userName" disabled>`
    html += `</div>`

    html += `<input type="radio" id ="customer" name="role" value ="customer"  checked="checked">`
    html += `<label for="customer" > Kunde </label>`
    html += `<input type="radio" id="barber" name="role" value="barber">`
    html += `<label for="barber"> Friseur </label> <br>`

    html += `<button class="btn btn-outline-secondary" type="button" onclick="createNewUser()"> speichern`

    document.getElementById('outputCreateUser').innerHTML = html;

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

    userRole = document.getElementById('inputUserRole').value

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
    xhttp.addEventListener("load", loadBarbersWithAppointments);
    xhttp.open("POST", "../ajax.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if (userRole === 'barber') {
        xhttp.send(`action=saveUser&role=${role}&name=${name}&firstName=${firstName}&lastName=${lastName}
&telephone=${telephone}&workStart=${workStart}&workEnd=${workEnd}`)
    } else if (userRole === 'customer') {
        xhttp.send(`action=saveUser&role=${role}&name=${name}&firstName=${firstName}&lastName=${lastName}
&telephone=${telephone}`)
    }
}