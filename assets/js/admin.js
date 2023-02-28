let userObjectArrays;

let getData4adminPages = () =>{
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            userObjectArrays = JSON.parse(this.responseText);
console.log(userObjectArrays)
        }
    }
    //xhttp.addEventListener("load", loadBarbersWithAppointments);
    xhttp.open('POST', '../ajax.php');
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(`action=loadUser`);
}

let listUsers = () => {

}


