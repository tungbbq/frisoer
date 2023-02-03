function loadCurrentMonday(){
    let currentday = new Date();
    let weekday = currentday.getDay()
    if (weekday === 1){
        let monday = currentday.getFullYear() + '-' + currentday.getMonth() + 1 + '-' + currentday.getDate()
        return monday
    } else if (weekday === 0){
        let monday = new Date(currentday.setDate(currentday.getDate() + 1))
        monday = monday.getFullYear() + '-' + monday.getMonth() + 1 + '-' + monday.getDate()
        return monday
    } else{
        let monday = new Date(currentday.setDate(currentday.getDate() - (weekday - 1)))
        monday = monday.getFullYear() + '-' + monday.getMonth() + 1 + '-' + monday.getDate()
        return monday
    }
}

function  loadLastMonday(){
    let currentday = new Date();
    let lastweek = new Date(currentday.setDate(currentday.getDate() - 7))
    let lastweekday = lastweek.getDay()
    // wenn letzte woche ein montag ist
    if (lastweekday === 1){
        let lastmonday = lastweek.getFullYear() + '-' + lastweek.getMonth() + 1 + '-' + lastweek.getDate()
        return lastmonday
        // wenn letzte woche ein sonntag ist
    } else if (lastweekday === 0){
        let lastmonday = new Date(lastweek.setDate(lastweek.getDate() + 1))
        lastmonday = lastmonday.getFullYear() + '-' + lastmonday.getMonth() + 1 + '-' + lastmonday.getDate()
        return lastmonday
    } else{
        let lastmonday = new Date(lastweek.setDate(lastweek.getDate() - (lastweekday - 1)))
        lastmonday = lastmonday.getFullYear() + '-' + lastmonday.getMonth() + 1 + '-' + lastmonday.getDate()
        return lastmonday
    }
}

function  loadNextMonday(){
    let currentday = new Date();
    let nextweek = new Date(currentday.setDate(currentday.getDate() + 7))
    let nextweekday = nextweek.getDay()
    if (nextweekday === 1){
        let nextmonday = nextweek.getFullYear() + '-' + nextweek.getMonth() + 1 + '-' + nextweek.getDate()
        return nextmonday
    } else if (nextweekday === 0){
        let nextmonday = new Date(nextweek.setDate(nextweek.getDate() + 1))
        nextmonday = nextmonday.getFullYear() + '-' + nextmonday.getMonth() + 1 + '-' + nextmonday.getDate()
        return nextmonday
    } else{
        let nextmonday = new Date(nextweek.setDate(nextweek.getDate() - (nextweekday - 1)))
        nextmonday = nextmonday.getFullYear() + '-' + nextmonday.getMonth() + 1 + '-' + nextmonday.getDate()
        return nextmonday
    }
}


function loadDoc(load) {

    let monday = load
    console.log(monday)

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const table = this.responseText
            const obj = JSON.parse(table);

            const firstDay = new Date(obj[0].day)

            let tbl = '';
            let j = 0;

            tbl += '<tr>'
            tbl += '<td></td>'
            tbl += '<td>' + firstDay.getDate() + '.' + firstDay.toLocaleString('default', {month: 'long'})+ ' ' +  firstDay.getFullYear() + '</td>'

            tbl += '<td>' + (new Date(firstDay.setDate(firstDay.getDate() + 1))).getDate() + '.'
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).toLocaleString('default', {month: 'long'}) + ' '
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).getFullYear()  + '</td>';

            tbl += '<td>' + (new Date(firstDay.setDate(firstDay.getDate() + 1))).getDate() + '.'
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).toLocaleString('default', {month: 'long'}) + ' '
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).getFullYear()  + '</td>';

            tbl += '<td>' + (new Date(firstDay.setDate(firstDay.getDate() + 1))).getDate() + '.'
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).toLocaleString('default', {month: 'long'}) + ' '
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).getFullYear()  + '</td>';

            tbl += '<td>' + (new Date(firstDay.setDate(firstDay.getDate() + 1))).getDate() + '.'
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).toLocaleString('default', {month: 'long'}) + ' '
            tbl += (new Date(firstDay.setDate(firstDay.getDate()))).getFullYear()  + '</td>';

            tbl += '</tr>'

            for (let i = 0; i < obj.length; i++) {
                if (i % 5 === 0) {
                    tbl += '<tr>';
                    tbl += '<td>' + (9 + j) + ':00Uhr' +'</td>'
                    j += 1;
                }

                tbl += '<td>';


                if (obj[i].name === 'blocked') {
                    tbl += '<input disabled>'
                } else
                    tbl += '<input type="text" data-hour="'+ obj[i].hour +'" data-day="'+ obj[i].day +'">'
                tbl += '</td>';

                if (i % 5 === 4) {
                    tbl += '</tr>';
                }

            }

            document.getElementById('tableData').innerHTML = tbl;


        }
    }
    xhttp.open("POST", "ajax.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("monday="+monday);
}

function newUpdate() {
    let name = '';
    let hour = 0;
    let day = '';
    const inputfields = document.getElementsByTagName('input');
    for (const ipfield of inputfields) {
        if (ipfield.value != ''){
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
        }
    }
    xhttp.open('POST', 'ajax.php');
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("name=" + name + "&day=" + day +"&hour="+ hour);
}