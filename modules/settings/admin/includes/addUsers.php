<?php
    require_once("../../../../modules/settings/admin/class/users.php");
    require_once("../../../../libraries/class/dbUtils.php");
    require_once("../../../../settings/connect_db.php");
    require_once("../../../../settings/path.php");
    $objPath    = new Path();
    $objDbUtils = new DbUtils();
    
     if (isset($_POST['delete'])) {
            $objUsers  = new Users();
           $userId     = $_POST['userId'];
             $blnInsert = $objUsers->deleteUser($userId);
              $objPath->setHeader('addUsers', 'Deleted Successfully');
      }
    
    
    if (isset($_POST['addUser'])) {
        $duplicate    = 0;
        $message      = 'Failure';
        $username     = $_POST['username'];
        $privelegeId  = $_POST['userType'];
		
		$branch  = $_POST['branchId'];
		
		
		
        $password     = $_POST['password'];
		if($privelegeId==2 || $privelegeId==3 || $privelegeId==6)
		$warehouseOrSalesarea = $_POST['warehouseOrSalesarea'];
	else
		$warehouseOrSalesarea ='';
		
        $resDuplicate = $objDbUtils->isDuplicate('username', 'login', 'username', $username);
        if (mysqli_num_rows($resDuplicate) == 0)
            $blnInsert = insertNewUser($username,$privelegeId,$password,$warehouseOrSalesarea,$branch);
        else
            $message = 'Username Already Exists';
        if ($blnInsert == TRUE)
            $message = 'Success';
        $objPath->setHeader('addUsers', $message);
    }
    function insertNewUser($username, $privelegeId, $password,$branchId,$mainBranch)
    {
        global $con;
        $objUsers  = new Users();
        $username  = mysqli_real_escape_string($con, $username);
        $password  = mysqli_real_escape_string($con, $password);
        $blnInsert = $objUsers->blnInsertUsers($username, $privelegeId, $password,$branchId,$mainBranch);
        return $blnInsert;
    }
    function resListUser()
    {
        $objUsers = new Users();
        $objPath  = new Path();
        $resUsers = $objUsers->resListUsers();
        $usersTbl = $type = '';
        $i        = 1;
        while ($listUsers = mysqli_fetch_array($resUsers)) {
			$branchName = null;
			
			if($listUsers['mainBranch']=='D'){
				$branchName ='DAMMAM';
			}else if($listUsers['mainBranch']=='R'){
				$branchName ='RIYAD';
			}else if($listUsers['mainBranch']=='M'){
				$branchName ='MAKKAH';
			}else if($listUsers['mainBranch']=='J'){
				$branchName ='JEDDAH';
			}else
				$branchName ='';
			
			if($listUsers['privilegeId']==2)
				$type='Warehouse';
			else if($listUsers['privilegeId']==3)
				$type='SalesArea';
			else if($listUsers['privilegeId']==4)
				$type='Cashier';
			else if($listUsers['privilegeId']==5)
			     $type='Bank Manager';
			else if($listUsers['privilegeId']==12)
			     $type='Accountant';
			 else if($listUsers['privilegeId']==13)
			     $type='User Edit';
			 else if($listUsers['privilegeId']==6)
			     $type='Counter Sales';
			 else
				 $type='';
			 
			 
            $usersTbl .= '<tr>
                            <td align="center">' . $i . '</td>
							 <td align="center">' . $branchName . '</td>
                            <td >' . $type . '</td>
                            <td>' . $listUsers['username'] . '</td>
                               <td>' . $listUsers['password'] . '</td>
                            <td align="center">
                                <form name= "restPasswordForm" method="post"
                                      action="' . $objPath->setAction('resetPassword') . '" >
                                    <input name="userId" type="hidden" value=' . $listUsers['loginId'] . '>
									<button type="submit" name="Reset" value="update" class="btn btn-sm" style="border-radius: 50%;background-color:#efefef">
									<i class="fa fa-edit" style="color:#1af516;"></i></button>
                                    
                                </form>
                                    </td><td align="center">    
                                <form  method="post"
                                      action="" >
                                    <input name="userId" type="hidden" value=' . $listUsers['loginId'] . '>
									<button type="submit" name="delete" value="delete" class="btn btn-sm" style="border-radius: 50%;background-color:#red">
									<i class="fa fa-times" style="color:#1af516;"></i></button>
                                </form>
                            </td>
                          
                        </tr>';
            $i++;
        }
        return $usersTbl;
    }
?>
<script type="text/javascript">
function pvalidate() {
	  if (document.addUsersForm.password.value != document.addUsersForm.confirmPassword.value){
			  document.getElementById("errorMsg").innerHTML = 'Passwords did not match!';
			  //alert('Passwords did not match!');
			  return false;
	  }
	  else{
		  document.getElementById("errorMsg").innerHTML = ' ';
		  return true;
	  }
}
</script>


<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
    	<form name="addUsersForm" action="<?=$objPath->setAction('addUsers');?>" method="post"
    		 onsubmit="return pvalidate()">
  		<div class="panel panel-info">
        <div class="panel-heading"><i class="fa fa-plus"></i><strong>&nbsp;&nbsp;ADD USER</strong></div>
        <div class="panel-body">
				<div class="form-group">
                	<label for="branchId">Branch :</label> <strong class="mandatory" style="color:red"> * </strong>
                    <select name="branchId" id="branchId" required="required" autocomplete="off" class="form-control input-sm" onchange="getWarehouseOrSalesarea();">
                        <option value="" selected="selected"> Select</option>
                        <option value="D">DAMMAM BRANCH</option>
                        <option value="R">RIYAD BRANCH</option>
						<option value="M">MAKKAH BRANCH</option>
                        <option value="J">JEDDAH BRANCH</option>
                    </select>
                </div>
            	<div class="form-group">
                	<label for="userType">Type :</label> <strong class="mandatory" style="color:red"> * </strong>
                    <select name="userType" id="userType" required="required" autocomplete="off" class="form-control input-sm" onchange="getWarehouseOrSalesarea();setWrehoseOrSalesarea();">
                        <option value="" selected="selected"> Select</option>
						<option value="2">Ware House</option>
						<option value="3">Sales Area</option>
                        <option value="4">Cashier</option>
                        <option value="5">Branch Manager</option>
						 <option value="6">Counter Sales</option>
                        <option value="12">Accountant</option>
						<option value="13">User Edit</option>
                    </select>
                </div>
				<div class="form-group warehouseOrSalesarea" style="display:none">
                	<label for="userType">Warehouse/Sales Area :</label> <strong class="mandatory" style="color:red"> * </strong>
                    <select name="warehouseOrSalesarea" id="warehouseOrSalesarea" autocomplete="off"  class="form-control input-sm">
                        
                    </select>
                </div>
                <div class="form-group">
                	<label for="username">Username :</label> <strong class="mandatory" style="color:red">*</strong>
                    <input name="username" type="text" id="username" autocomplete="off" maxlength="20" required class="form-control input-sm" />
                </div>
                <div class="form-group">
                	<label for="password">Password :</label> <strong class="mandatory" style="color:red">*</strong>
                    <input name="password" type="password" id="password" autocomplete="off" maxlength="20" required="required"
                     		class="form-control input-sm" onkeyup="pvalidate()" onblur="pvalidate()"  />
                </div>
                <div class="form-group">
                	<label for="password">Confirm Password :</label> <strong class="mandatory" style="color:red"> * </strong>
                    <input name="confirmPassword" type="password" autocomplete="off" id="confirmPassword" maxlength="20" required
                    		 class="form-control input-sm" onkeyup="pvalidate()" onblur="pvalidate()" />
                   	<label id="errorMsg" style="color:red"></label>
               	</div>
                <div class="form-group" style="padding-top: 5px; border-top: 1px solid #ccc;">
                	<center>
                        <button type="submit" name="addUser" id="addUser" value="Add" class="btn btn-success">
                            <i class="fa fa-save"></i> &nbsp; Add
                        </button>
                    </center>
                </div>
            </div>
        </div>
       	</form>	
    </div>
	<div class="col-sm-8 col-md-8 col-lg-8">
		<div class="panel panel-info">
        <div class="panel-heading"><i class="fa fa-list-ul"></i><strong>&nbsp;&nbsp;ALL USER</strong></div>
        <div class="panel-body">

            	<table width="100%" id="table_id">
                    <thead style="background-color:#d0e8d2">
                        <tr>
                            <th width="10%">#</th>
							 <th width="20%">Branch</th>
                            <th width="15%">Type</th>
                            <th width="20%">Username</th>
                            <th width="12%">Password</th>
                             <th width="30%">ResetPassword</th>
                             <th width="5%">Delete</th>
                        </tr>
                    </thead>
                    <tbody>	
                		<?=resListUser(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript"  src="https://code.jquery.com/jquery-3.5.1.js"></script> 

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

<STYLE>
.dataTables_filter {
   float: left !important;
}

#table_id_paginate .paginate_button current{
	background-color:#000 !important;
}

#table_id_length{
	 margin-left:10%;
}

table.dataTable thead th {
    border-bottom: 0px solid #111;
}
 
table.dataTable tfoot td {
    border-top: 0px solid  #111;
}

table td ,table th {
	border:0.5px solid #e4e4da;
	border-collapse:collapse;
}

.paginate_button{
	background: #d9edf7 !important;
    border-radius: 50px !important;
	
}

#table_id th , #table_id td {
	font-size:13px !important;
}
#table_id td {
	padding : 2px !important;
}



</STYLE>

<script>

function getWarehouseOrSalesarea(){
	var userType  = $('#userType').val();
	var branch1  = $('#branchId').val();
	
	$.ajax({
        type:"POST",
        url: "../../../../modules/settings/admin/ajax/getWarehuseOrSalesarea.php",
                    data:{userType:userType,branch1:branch1},
        success:function(response)
	
         {
			// alert(response);
           $("#warehouseOrSalesarea").html(response);
     }   
    });
	
}



function setWrehoseOrSalesarea(){
	var privillageId = $('#userType').val();
	if(privillageId==3 || privillageId==2 || privillageId==6){
	$(".warehouseOrSalesarea").show();
	document.getElementById("warehouseOrSalesarea").required = true;
	}
else{
	$(".warehouseOrSalesarea").hide();
	document.getElementById("warehouseOrSalesarea").required = false;
}
}


$(document).ready( function () {
	$.noConflict();
    $('#table_id').DataTable({
		"dom": '<"toolbar">frltip',
		'aoColumnDefs': [{'bSortable': false,'aTargets':[]}]
		

		 
	});
});
 </script>