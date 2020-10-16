// ===================================================================JAI SHREE KRISHNA=================================================== //

// --------------------Scripting for Searching in Faculty Record-------------------------------------!

function filterTable(event) {
    var filter = event.target.value.toUpperCase();
    var rows = document.querySelector("#facultyList tbody").rows;
    for (var i = 0; i < rows.length; i++){
        var firstCol = rows[i].cells[1].textContent.toUpperCase();
        var secondCol = rows[i].cells[2].textContent.toUpperCase();
        var thirdCol = rows[i].cells[3].textContent.toUpperCase();
        var fourthCol = rows[i].cells[4].textContent.toUpperCase();
        var fifthCol = rows[i].cells[5].textContent.toUpperCase();
        if ( firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1 || thirdCol.indexOf(filter) > -1 || fourthCol.indexOf(filter) > -1 || fifthCol.indexOf(filter) > -1 ) {
            rows[i].style.display = "";}
            else{
                rows[i].style.display = "none";}
        }

    }


// --------------------Scripting for Searching in Student Record-------------------------------------!

function filterTable2(event) {
    var filter = event.target.value.toUpperCase();
    var rows = document.querySelector("#studentList tbody").rows;
    for (var i = 0; i < rows.length; i++){
        var firstCol = rows[i].cells[1].textContent.toUpperCase();
        var secondCol = rows[i].cells[2].textContent.toUpperCase();
        var thirdCol = rows[i].cells[3].textContent.toUpperCase();
        var fourthCol = rows[i].cells[4].textContent.toUpperCase();
        var fifthCol = rows[i].cells[5].textContent.toUpperCase();
        var sixthCol = rows[i].cells[6].textContent.toUpperCase();
        var seventhCol = rows[i].cells[7].textContent.toUpperCase();
        var eightCol = rows[i].cells[8].textContent.toUpperCase();
        var ninthCol = rows[i].cells[9].textContent.toUpperCase();
        if ( firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1 || thirdCol.indexOf(filter) > -1 || fourthCol.indexOf(filter) > -1 || fifthCol.indexOf(filter) > -1 || sixthCol.indexOf(filter) >-1 || seventhCol.indexOf(filter) >-1 || eightCol.indexOf(filter) >-1 || ninthCol.indexOf(filter) >-1) {
            rows[i].style.display = "";}
            else{
                rows[i].style.display = "none";}
        }

    }


// --------------------Scripting for Searching in Subject Record-------------------------------------!

function filterTable3(event) {
    var filter = event.target.value.toUpperCase();
    var rows = document.querySelector("#subjectList tbody").rows;
    for (var i = 0; i < rows.length; i++){
        var firstCol = rows[i].cells[1].textContent.toUpperCase();
        var secondCol = rows[i].cells[2].textContent.toUpperCase();
        var thirdCol = rows[i].cells[3].textContent.toUpperCase();
        var fourthCol = rows[i].cells[4].textContent.toUpperCase();
        var fifthCol = rows[i].cells[5].textContent.toUpperCase();
        if ( firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1 || thirdCol.indexOf(filter) > -1 || fourthCol.indexOf(filter) > -1 || fifthCol.indexOf(filter) > -1 ) {
            rows[i].style.display = "";}
            else{
                rows[i].style.display = "none";}
        }

    }


// --------------------Scripting for Searching in Assign Subject Record-------------------------------------!

function filterTable4(event) {
    var filter = event.target.value.toUpperCase();
    var rows = document.querySelector("#assignSubjectList tbody").rows;
    for (var i = 0; i < rows.length; i++){
        var firstCol = rows[i].cells[1].textContent.toUpperCase();
        var secondCol = rows[i].cells[2].textContent.toUpperCase();
        var thirdCol = rows[i].cells[3].textContent.toUpperCase();
        var fourthCol = rows[i].cells[4].textContent.toUpperCase();
        var fifthCol = rows[i].cells[5].textContent.toUpperCase();
        if ( firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1 || thirdCol.indexOf(filter) > -1 || fourthCol.indexOf(filter) > -1 || fifthCol.indexOf(filter) > -1 ) {
            rows[i].style.display = "";}
            else{
                rows[i].style.display = "none";}
        }

    }