<?php
require_once('../../../../settings/connect_db.php');
include_once("../../../../libraries/class/constants.php");
class customerVoucherModel
{
	
	
	function searchByCustomerId($customerId){
		//$sessionBranchId   = $_SESSION['sessionBranchId'];
		global  $con;
		$query   = " SELECT regularCustomerId,currentBalanceReceiverAmount
					 FROM  regularCustomer 
					 WHERE regularCustomerId ='".$customerId."'
					
				   ";
				//$result  = mysqli_query($con,$query);
		//echo '<br>'.$query.'<br>';
		$result  = mysqli_query($con,$query);
		
		return $result;
	}					
	
	function updateCustomerDetails($regularCustomerId, $currentBalance)
	{
		global $con;
        $query  = "UPDATE regularCustomer SET currentBalanceReceiverAmount = '" . $currentBalance . "' 
                   WHERE regularCustomerId = $regularCustomerId ";
		//echo '<br>'.$query.'<br>';
        $result = mysqli_query($con, $query);
	}
	
	function saveCustomerDetails($regularCustomerId, $amount, $formatedDate)

	{
		 $status=CUSTOMER_SUBSTRACT_FROM_BALANCE;
		 
		 global $con;
        $query  = "INSERT INTO currentBalanceCustomerTrack(regularCustomerId,amount,amountStatus,amountdate) VALUES
                       ('" . $regularCustomerId . "', '" . $amount . "','" . $status . "' , '" . $formatedDate . "') ";
       // echo '<br>'.$query.'<br>';
        $result = mysqli_query($con, $query);
	}
	
	
	
	
	
	
	
	
    function searchByAdmissionNo($admissionNo)
    {
        global $con;
        $query = "SELECT student.studentId,CONCAT_WS(' ',student.firstName,student.middleName,student.lastName)AS name,
                         student.admissionNo,student.nationality,N.nationality,enrollmentDetails.enrollmentId,
                         enrollment.enrollmentId,enrollment.classSemesterId,enrollment.divisionId, 
                         companyPaidLog.companyPaidStatus,division.divisionId,division.divisionName,
                         classSemester.classSemesterId,classSemester.classSemesterName
                         FROM student 
                         INNER JOIN companyPaidLog ON companyPaidLog.studentId=student.studentId 
                         INNER JOIN enrollmentDetails ON enrollmentDetails.studentId=student.studentId
                         INNER JOIN enrollment ON enrollment.enrollmentId=enrollmentDetails.enrollmentId 
                         INNER JOIN division ON division.divisionId=enrollment.divisionId 
                         INNER JOIN classSemester ON classSemester.classSemesterId=enrollment.classSemesterId
                         INNER JOIN nationality N ON N.nationalityId=student.nationality 
                         WHERE student.admissionNo='$admissionNo'  ORDER BY `enrollmentDetails`.`enrollmentDetailsId` DESC LIMIT 1 ";
        //echo '<br>'.$query.'<br>';
        $result = mysqli_query($con, $query);
        return $result;
    }
	
	
	/* function searchByAdmissionNo($admissionNo)
    {
        global $con;
        $query = "SELECT student.studentId,CONCAT_WS(' ',student.firstName,student.middleName,student.lastName)AS name,
                         student.admissionNo,enrollmentDetails.enrollmentId,
                         enrollment.enrollmentId,enrollment.classSemesterId,enrollment.divisionId, 
                         companyPaidLog.companyPaidStatus,division.divisionId,division.divisionName,
                         classSemester.classSemesterId,classSemester.classSemesterName
                         FROM student 
                         INNER JOIN companyPaidLog ON companyPaidLog.studentId=student.studentId 
                         INNER JOIN enrollmentDetails ON enrollmentDetails.studentId=student.studentId
                         INNER JOIN enrollment ON enrollment.enrollmentId=enrollmentDetails.enrollmentId 
                         INNER JOIN division ON division.divisionId=enrollment.divisionId 
                         INNER JOIN classSemester ON classSemester.classSemesterId=enrollment.classSemesterId
                         
                         WHERE student.admissionNo='$admissionNo'  ORDER BY `enrollmentDetails`.`enrollmentDetailsId` DESC LIMIT 1 ";
        //echo '<br>'.$query.'<br>';
        $result = mysqli_query($con, $query);
        return $result;
    }*/
	
	
    function resListAllAcademicPeriod()
    {
        global $con;
        $resListAllAcademicPeriod = "SELECT academicPeriodId,YEAR(fromDate) AS fromDate , YEAR(toDate) AS toDate,activeStatus 
                                     FROM   academicPeriod   
                                    ";
        // echo "<br>".$resListAllAcademicPeriod."<br>";
        $result                   = mysqli_query($con, $resListAllAcademicPeriod);
        return $result;
    }
    function resListAllClassSemester()
    {
        global $con;
        $resListAllClassSemester = "SELECT classSemesterId,classSemesterName,status 
                                    FROM   classSemester  
                                    WHERE   status = 1  ";
        //echo "<br>".$query."<br>";
        $result                  = mysqli_query($con, $resListAllClassSemester);
        return $result;
    }
    function resListDivisionByClass($classSemesterId)
    {
        //echo $classSemesterId;
        global $con;
        $resListDivisionByClass = "SELECT classSemesterId,divisionId,divisionName,status 
                                   FROM   division  
                                   WHERE classSemesterId=$classSemesterId";
        // echo "<br>".$resListDivisionByClass."<br>";
        $result                 = mysqli_query($con, $resListDivisionByClass);
        //die("Error: " . mysqli_error($con));
        return $result;
    }
    function saveReadmissionDetails($systemUser, $studentId, $academicPeriodId, $formatedDate)
    {
        global $con;
        $query  = "INSERT INTO readmission(studentId,academicPeriodId,readmissionDate,status,systemUser) VALUES
                       ('" . $studentId . "', '" . $academicPeriodId . "', '" . $formatedDate . "', '1','" . $systemUser . "') ";
        //echo '<br>'.$query.'<br>';
        $result = mysqli_query($con, $query);
    }
    function updateStudentChildLog($studentId, $academicPeriodId)
    {
        global $con;
        $query  = "UPDATE studentChildLog SET status = '0' 
                   WHERE studentId = $studentId AND academicPeriodId=$academicPeriodId";
        $result = mysqli_query($con, $query);
    }
    function insertStudentChildLog($studentId, $academicPeriodId, $systemUser)
    {
        global $con;
        $query  = "INSERT INTO studentChildLog(studentId,academicPeriodId,status,systemUser) VALUES
                       ('" . $studentId . "', '" . $academicPeriodId . "', '1', '" . $systemUser . "') ";
        //echo '<br>'.$query.'<br>';
        $result = mysqli_query($con, $query);
    }
    function updateCompanyPaidLog($studentId, $academicPeriodId)
    {
        global $con;
        $query  = "UPDATE companyPaidLog SET status = '0' 
                   WHERE studentId = $studentId AND academicPeriodId=$academicPeriodId";
        $result = mysqli_query($con, $query);
    }
    function insertCompanyPaidLog($studentId, $academicPeriodId,$companyPaidStatus, $systemUser)
    {
        global $con;
        $query  = "INSERT INTO companyPaidLog(studentId,academicPeriodId,companyPaidStatus,status,systemUser) VALUES
                       ('" . $studentId . "', '" . $academicPeriodId . "', '" . $companyPaidStatus . "', '1', '" . $systemUser . "') ";
       //echo '<br>'.$query.'<br>';
        $result = mysqli_query($con, $query);
    }
    function searchEnrolment($academicPeriodId, $classSemesterId, $divisionId)
    {
        global $con;
        $query  = "SELECT enrollmentId 
                   FROM enrollment
                   WHERE academicPeriodId=$academicPeriodId AND classSemesterId=$classSemesterId AND divisionId=$divisionId AND                   status=1";
        //echo '<br>'.$query.'<br>';              
        $result = mysqli_query($con, $query);
        return $result;
    }
    function insertEnrolmentDetails($studentId, $enrollmentId, $systemUser)
    {
        global $con;
        $query  = "INSERT INTO enrollmentDetails(studentId,enrollmentId,status,systemUser) VALUES
                       ('" . $studentId . "', '" . $enrollmentId . "', '1', '" . $systemUser . "') ";
        //echo '<br>'.$query.'<br>';
        $result = mysqli_query($con, $query);
    }
    function insertEnrolment($academicPeriodId, $classSemesterId, $divisionId, $systemUser)
    {
        global $con;
        $query  = "INSERT INTO enrollment(academicPeriodId,classSemesterId,divisionId,status,systemUser) VALUES
                       ('" . $academicPeriodId . "','" . $classSemesterId . "', '" . $divisionId . "', '1', '" . $systemUser . "') ";
        //echo '<br>'.$query.'<br>';
        $result = mysqli_query($con, $query);
    }
    function updateEnrolmentDetails($studentId)
    {
        global $con;
        $query  = "UPDATE enrollmentDetails SET status = '0' 
                   WHERE studentId = $studentId";
        $result = mysqli_query($con, $query);
    }
    function updateStudent($studentId, $academicPeriodId, $classSemesterId, $divisionId)
    {
        global $con;
        $query  = "UPDATE student SET status = '1',
				   academicPeriodId = $academicPeriodId,classSemesterId=$classSemesterId,divisionId=$divisionId						                   WHERE studentId = '$studentId' ";
       // echo '<br>'.$query.'<br>';
        $result = mysqli_query($con, $query);
    }
}
?>