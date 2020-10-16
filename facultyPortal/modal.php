<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
    <style>
    * {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.modalDialog {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    text-align: center;
    background: rgba(0, 0, 0, 0.8);
    z-index: 99999;
    opacity:0;
    -webkit-transition: opacity 100ms ease-in;
    -moz-transition: opacity 100ms ease-in;
    transition: opacity 0.5s ease-in;
    pointer-events: none;
}
.modalDialog:target {
    opacity:1;
    pointer-events: auto;
}
.modalDialog > div {
    max-width: 800px;
    width: 90%;
    position: relative;
    margin: 10% auto;
    padding: 20px;
    border-radius: 20px;
    background: #fff;
}
.close {
    font-family: Arial, Helvetica, sans-serif;
    background: #f26d7d;
    color: #fff;
    line-height: 25px;
    position: absolute;
    right: -12px;
    text-align: center;
    top: -10px;
    width: 34px;
    height: 34px;
    text-decoration: none;
    font-weight: bold;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
    -moz-box-shadow: 1px 1px 3px #000;
    -webkit-box-shadow: 1px 1px 3px #000;
    box-shadow: 1px 1px 3px #000;
    padding-top: 5px;
}
.close:hover {
    background: #fa3f6f;
}
#openModal-about input{
				margin:20px 0px;
				border:none;
				outline:none;
				background:yellow;
				}
				
    </style>
</head>
<body>
<!--position: absolute;
				top:20px;
				bottom:20px;
				left:50%;
				transform: translateX(-50%);-->
    <a href="#openModal-about">View Record</a>
<!--modals-->
  <div id="openModal-about" class="modalDialog">
      <div>
         <a href="#close" title="Close" class="close">X</a>
         <h2>View Attendance Record</h2>
         <b>Enter the starting date until you want to see the record!</b><br>
         <input type="date"></input><br>
         <b>Enter the last date you want to see the record!</b><br>
         <input type="date"></input>
       </div>
   </div>
</body>
</html>
