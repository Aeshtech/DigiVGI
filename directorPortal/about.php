<!-- =======================================================JAI SHREE KRISHNA============================================ -->
<?php
require("template.php");
require('../adminstrative/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About US</title>
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../nivo-slider/themes/default/default.css" type="text/css" media="screen" />   
    <link rel="stylesheet" href="../nivo-slider/nivo-slider.css" type="text/css" media="screen" />
    <style>
        .founder_coloumn{
            position: absolute;
            margin: 0;
            top: 13vh;
            left: 57%;
            width: 65%;
            transform: translateX(-50%);
            border-bottom: 5px double blueviolet;

        }
        .main-section{
            position: absolute;
            width: 65%;
            top: 70vh;
            left: 57%;
            transform: translateX(-50%);
            font-family: sans-serif;
            margin-bottom: 5vh;
        }
        div.dropdown-content{
            right: 0;
        }
        .logodiv2 #logo{
            left:54%;
            top: 10px;
        }
    </style>
</head>
<body>

    <div class="founder_coloumn">

        <div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider"> 
                <img src="../nivo-slider/demo/images/toystory.jpg" data-thumb="nivo-slider/demo/images/toystory.jpg" alt="" />
                <img src="../nivo-slider/demo/images/up.jpg" data-thumb="nivo-slider/demo/images/up.jpg" alt="" title="This is an example of a caption" />
                <img src="../nivo-slider/demo/images/walle.jpg" data-thumb="nivo-slider/demo/images/walle.jpg" alt="" data-transition="slideInLeft" />
                <img src="../nivo-slider/demo/images/nemo.jpg" data-thumb="nivo-slider/demo/images/nemo.jpg" alt="" title="#htmlcaption" />
            </div>
            <div id="htmlcaption" class="nivo-html-caption"> <strong>Welcome</strong> to DigiVGI <em>Nice</em>
                slider with <a href="#">a link</a>. </div>
        </div>
        
    </div>
    <div class="main-section">
        
        <section>
            <h2 style="margin-top: 20px;color:blueviolet;">About us:</h2><br>
            <p><b>DigiVGI</b> which can be expanded as Digital Vishveshwarya Group of Instiutions (VGI) was established
                in the year 2020 in order to impart high quality digital education concerned services. DigiVGI is a
                students attendance management system (SAMS) originated by a VGI B.Tech(CSE) student to manage all
                record from their mobile phone just in couple of seconds. </p><br>

            <p>DigiVGI provides great priviledes to all faculty members to make students attendance subject wise which
                are assigned by respective admin of Digivgi together with access of update their record. Faculty members
                can view their respective subjects attendance record by selecting date of previous record as well as
                export it on excel for further assistance.</p><br>
            
            <p>It provides time to time updates to students about their attendance status so that they can cross check
                    it via status blinkers in green (Snipshot-1) or red (Snipshot-2) color showing Present or Absent on each subject only for current
                    date. You can also view your desired attendance record by selecting first and last date. You can also
                    take backup for your attendance.
            </p>
            <img src="../assets/snipshot3.jpg" alt="!" width="45%" style="margin-right: 10px;">
            <img src="../assets/snipshot4.jpg" alt="!" width="45%">
                </section>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
    <script type="text/javascript" src="../nivo-slider/jquery.nivo.slider.js"></script> 
    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
    </script> 
</body>
</html>