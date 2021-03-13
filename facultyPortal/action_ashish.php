<!-- -------------------------------------------------*** JAI SHRI KRISHNA ***--------------------------------------- -->
<?php 
session_start();
require('../adminstrative/config.php');

// Import PHPMailer classes into the global namespace
       // These must be at the top of your script, not inside a function
       use PHPMailer\PHPMailer\PHPMailer;
       use PHPMailer\PHPMailer\SMTP;
       use PHPMailer\PHPMailer\Exception;
       
       // Load Composer's autoloader
       require '../vendor/autoload.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE );
// ------------------------------------------------

if(isset($_POST['make_attendance'])){
    foreach ($_POST['attendance'] as $key => $attendance_status){
        $student_name = $_POST['student_name'][$key];
        $roll_no = $_POST['roll_no'][$key];
        $subject_name = $_POST['subject_name'][$key];
        $subject_code = $_POST['subject_code'][$key];
        $course = $_POST['course'][$key];
        $branch = $_POST['branch'][$key];
        $semester = $_POST['semester'][$key];
        $section = $_POST['section'][$key];
        $date = $_POST['date'][$key];
        $query = "INSERT INTO `attendance`(`status`,`roll_no`,`student_name`,`date`,`subject_name`,`subject_code`,`course`,`branch`,`semester`,`section`) VALUES('$attendance_status','$roll_no','$student_name','$date','$subject_name','$subject_code','$course','$branch','$semester','$section')";
        $result = mysqli_query($conn,$query);
    }
    if(mysqli_affected_rows($conn)){
        $_SESSION['mssg'] = "Attendance taken successfully of ".$subject_name." for the date ".$date;
        echo "Attendance Taken Successfully!";
    }
header("location:index.php");
}


if(isset($_POST['update_attendance'])){
    foreach ($_POST['attendance'] as $key => $attendance_status){
        $subject_code = $_POST['subject_code'][$key];
        $subject_name = $_POST['subject_name'][$key];
        $roll_no = $_POST['roll_no'][$key];
        $course = $_POST['course'][$key];
        $branch = $_POST['branch'][$key];
        $semester = $_POST['semester'][$key];
        $section = $_POST['section'][$key];
        $date = $_POST['date'][$key];
        $modified_date = date('y-m-d');

        $query = " UPDATE `attendance` SET `status`='$attendance_status',`modified_date`='$modified_date' WHERE `course`='$course' AND `branch`='$branch' AND `semester`='$semester' AND `section`='$section' AND `date`='$date' AND `subject_code`='$subject_code' AND `roll_no`='$roll_no'";
        $result = mysqli_query($conn,$query);
    }
    if(mysqli_affected_rows($conn)){
        $_SESSION['mssg'] = "Attendance Updated Successfully of ".$subject_name." for the date ".$date;
    }
    header("location:index.php");
}

//  Analysing the each student status of previous three working days if all three previous days status is `Absent` then send an email to their registerd email-id !!

    $query4 = "SELECT Distinct `date` FROM `attendance` WHERE `subject_code`='$subject_code' AND `date` BETWEEN subdate(CURRENT_DATE(),2) AND CURRENT_DATE";
    $result4 = mysqli_query($conn,$query4);
    $numrows = mysqli_num_rows($result4);

    if($numrows !==""){
        $i=0;
        while($row4 = mysqli_fetch_assoc($result4)){
            static $date = [];
            $date[$i]= $row4['date'];
            $i++;
        }
    }
    $query5 = "SELECT DISTINCT `a`.`roll_no`,`s`.`email` FROM `attendance` as `a`,`student` as `s`  WHERE `a`.`roll_no`=`s`.`registration` AND `a`.`course`='$course' AND `a`.`branch`='$branch' AND `a`.`semester`='$semester' AND `a`.`section`='$section' AND `a`.`status`='Absent' AND `a`.`subject_code`='$subject_code' AND `a`.`date`='$date[0]'
    INTERSECT (SELECT DISTINCT `a`.`roll_no`,`s`.`email` FROM `attendance` as `a`,`student` as `s`  WHERE `a`.`roll_no`=`s`.`registration` AND `a`.`course`='$course' AND `a`.`branch`='$branch' AND `a`.`semester`='$semester' AND `a`.`section`='$section' AND `a`.`status`='Absent' AND `a`.`subject_code`='$subject_code' AND `a`.`date`='$date[1]')
    INTERSECT (SELECT DISTINCT `a`.`roll_no`,`s`.`email` FROM `attendance` as `a`,`student` as `s`  WHERE `a`.`roll_no`=`s`.`registration` AND `a`.`course`='$course' AND `a`.`branch`='$branch' AND `a`.`semester`='$semester' AND `a`.`section`='$section' AND `a`.`status`='Absent' AND `a`.`subject_code`='$subject_code' AND `a`.`date`='$date[2]')";

    $result5 = mysqli_query($conn,$query5);


    $output='<strong style="color:Green;">Dear Parent </strong> ';
    $output.='<p style="color:red;bakground:yellow;">Your ward is absent from three working days contniuously.</p>';
    $output.='<p>-------------------------------------------------------------</p>';
    $output.='<p>Thanks,</p>';
    $output.='<p>From-<b>DigiVGI</p>';
    $body = $output; 
    $subject = "Absent Notice - DigiVgi Team";
    

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                    // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                      // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                 // Enable SMTP authentication
        $mail->Username   = 'ashishpandit5376@gmail.com';          // SMTP username
        $mail->Password   = '@dev.digivgi2020';                      // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
        
        //Recipients
        $mail->setFrom('ashishpandit5376@gmail.com', 'DigiVgi');

        if(mysqli_num_rows($result5)!==""){
            while($row5=mysqli_fetch_assoc($result5)){
                $mail->addBCC($row5['email']);     // Add a recipient
            }
        }
        $mail->isHTML(true);                
        $mail->Subject = $subject;
        $mail->Body    = $body;
    
        $mail->send();
        $_SESSION['mail_success'] = 'Check your mail to reset password!';
     }catch (Exception $e) {
         $_SESSION['mail_fail'] = "Message could not be sent-Mailer Error!";
     }