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




    
  // Scripting for azax call to track record at directorPortal .
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);
  let chartarray = [];
  function drawChart() {
    var data = google.visualization.arrayToDataTable(chartarray);

    var options = {
      title: 'Attendance Status of slected credentials',
      pieHole: 0.4,
      chartArea: {
            left: "22%",
            top: "10%",
            height: "100%",
            width: "100%"
        }
    };

    var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
    chart.draw(data, options);
  }


  // azax---!
  function showUser() {
    var course = document.getElementById("dir_course").value;
    var semester = document.getElementById("dir_semester").value;
    var branch = document.getElementById("dir_branch").value;
    console.log(branch);
    var startdate = document.getElementById("dir_startdate").value;
    var enddate = document.getElementById("dir_enddate").value;
  if (course == ""){
    document.getElementById("chart").innerHTML = '<h2>Please select any course.</h2>';
    return;
  }else if(startdate == "" || enddate ==""){
    document.getElementById("chart").innerHTML = '<h2>Please select the date.</h2>';
  }else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        chartarray = [   ['Status', 'Total Present Or Absent'],
      ['Present', parseInt(this.responseText,10)],
      ['Absent',100-parseInt(this.responseText,10)]];
      document.getElementById("chart").innerHTML = '<div id="donutchart"></div>';
      drawChart();  
    }
    }
    xmlhttp.open("POST","azax.php",true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("course="+course+"&semester="+semester+"&branch="+branch+"&startdate="+startdate+"&enddate="+enddate);
  }}