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
}

let updateUser = () => {
    //...TODO
}

let deleteUser = () => {
    //...TODO
}

function loadCreateUser() {
    let html = '';
    html += `
        <div class="d-flex justify-content-end mb-4">
        
            <div>
                <button class="btn btn-outline-primary" onclick="window.location.href ='views/adminUpdatePage.php'" type="button">Benutzer bearbeiten</button>
            </div>
            <div>
                <button class="logout btn btn-primary">Logout</button>
            </div>
        </div>
        <div>
            <div class="btn-group mb-2" role="group" aria-label="Basic example">
                <input class="btn-check " type="radio" id ="customerRadio" name="role" value ="customer" checked>
                <label class="btn btn-outline-secondary" for="customerRadio" > Kunde </label>
                <input class="btn-check" type="radio" id ="barberRadio" name="role" value ="barber">
                <label class="btn btn-outline-secondary" for="barberRadio" > Friseur </label>
            </div>
            
            <div class="form-group">
                <input class="form-control mb-2" type="text" id="name" placeholder="userName">
            </div>
            <div class="form-group ">
                <input class="form-control mb-2" type="text" id="firstName" placeholder="Vorname">
            </div>
            <div class="form-group ">
                 <input class="form-control mb-2" type="text" id="lastName" placeholder="Nachname">
            </div>
            <div class="form-group ">
                <input class="form-control mb-2" type="text" id="telephone" placeholder="Telefonnummer">
            </div>
            
            <div class="form-group mb-2">
                <select class="form-select" id="workStartSelect" disabled>
                <option value="" disabled selected>Arbeitsbeginn</option>
                </select>
            </div>
    
            <div class="form-group mb-2">
                <select class="form-select" id="workEndSelect" disabled>
                <option value="" disabled selected>Arbeitsende</option>
                </select>
            </div>
    
            <div class="form-group mb-2">
                <input class="form-control" type="text" id="password" placeholder="Passwort = userName" disabled>
            </div>
        </div>

        <div class="d-grid gap-2 mt-5">
            <button class="btn btn-primary" type="button" onclick="createNewUser()"> Speichern
        </div>
        `

    document.querySelector('#outputCreateUser').innerHTML = html;
    logout()
    document.querySelector('#customerRadio').addEventListener('change', disableCustomerInputs)
    document.querySelector('#barberRadio').addEventListener('change', disableCustomerInputs)
    createSelectDatepicker('workStartSelect')
    createSelectDatepicker('workEndSelect')

}

function createNewUser() {
    name = document.querySelector('#name')
    firstName = document.querySelector('#firstName')
    lastName = document.querySelector('#lastName')
    telephone = document.querySelector('#telephone')
    workStart = document.querySelector('#workStartSelect')
    workEnd = document.querySelector('#workEndSelect')
    password = name
    role = document.querySelector('input[name="role"]:checked');
    console.log(role)
    console.log(workStart.value)
    if (validate()) {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                if (this.status === 200) {
                    alert(`${name.value} wurde neu angelegt.`)
                    loadCreateUser()
                } else if (this.status === 400) {
                    alert('Fehler')
                }
            }
        }
        xhttp.open("POST", "../ajax.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        if (role === 'barber') {
            xhttp.send(`action=saveUser&roleToSave=${role.value}&name=${name.value}&firstName=${firstName.value}&lastName=${lastName.value}
&telephone=${telephone.value}&workStart=${workStart.value}&workEnd=${workEnd.value}&password=${password.value}`)
        } else if (role.value === 'customer') {
            xhttp.send(`action=saveUser&roleToSave=${role.value}&name=${name.value}&firstName=${firstName.value}&lastName=${lastName.value}&password=${password.value}
&telephone=${telephone.value}`)
        }
    }
}

function disableCustomerInputs(){
    role = document.querySelector('input[name="role"]:checked')

    if (role.value === 'customer'){
        document.querySelector('#workStartSelect').disabled = true
        document.querySelector('#workEndSelect').disabled = true
    } else if (role.value === 'barber'){
        document.querySelector('#workStartSelect').disabled = false
        document.querySelector('#workEndSelect').disabled = false
    }
}

function createSelectDatepicker(selectId){
    const workSelect = document.querySelector(`#${selectId}`);
    const minimumHour = 6;
    const maximumHour= 24 - minimumHour;
    const fullHour = '00';
    const halfHour = '30';

    let hour;

for (let i = 0; i < maximumHour ; i++) {
    hour = padTo2Digits(minimumHour + i)

    const opt1 = document.createElement("option");
    opt1.text = `${hour}:${fullHour} Uhr`;
    opt1.value = `${hour}:${fullHour}:00`;

    const opt2 = document.createElement("option");
    opt2.text = `${hour}:${halfHour} Uhr`;
    opt2.value = `${hour}:${halfHour}:00`;

    workSelect.add(opt1, null);
    workSelect.add(opt2, null);

}

}

function validate()
{
    if(name.value === '')
    {
        alert('userName fehlt! ');
        name.style.borderColor="red";
        name.style.backgroundColor="yellow";
        name.style.borderWidth=2;
        return false;
    }
    else if (firstName.value==='')
    {
        alert('Vorname fehlt!');
        firstName.style.borderColor="red";
        firstName.style.backgroundColor="yellow";
        firstName.style.borderWidth=2;
        return false;
    }
    else if (lastName.value==='')
    {
        alert('Nachname fehlt!');
        lastName.style.borderColor="red";
        lastName.style.backgroundColor="yellow";
        lastName.style.borderWidth=2;
        return false;
    }
    else if (telephone==='')
    {
        alert('Telefonnummer fehlt!');
       telephone.style.borderColor="red";
       telephone.style.backgroundColor="yellow";
       telephone.style.borderWidth=2;
        return false;
    }
    else if (workStart.value==='' && role.value === 'barber')
    {
        alert('Arbeitsbeginn fehlt!');
        workStart.style.borderColor="red";
        workStart.style.backgroundColor="yellow";
        workStart.style.borderWidth=2;
        return false;
    }
    else if (workEnd.value==='' && role.value === 'barber')
    {
        alert('Arbeitsende fehlt!');
       workEnd.style.borderColor="red";
       workEnd.style.backgroundColor="yellow";
       workEnd.style.borderWidth=2;
        return false;
    }

    else
    {
        return true
    }

}
