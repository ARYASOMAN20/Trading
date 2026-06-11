<?php
require_once('../../../../modules/addUnit/admin/controllers/addUnitController.php');
require_once("../../../../settings/path.php");
$objPath          = new Path();
if(isset($_POST['update']))
{
	$addUnitController=new addUnitController();
	$unitId=$_POST['unitId'];
	$updateUnits=$addUnitController->update_Unit($unitId);
		while($updateUnitResult=mysqli_fetch_array($updateUnits))
			{
				$unitId    = $updateUnitResult['unitId'];
				$unitName  = $updateUnitResult['unitName'];
				
			 }
          }


if(isset($_POST['submit']))
{
	$addUnitController=new addUnitController();
	$unitId=$_POST['unitId'];
	$unitName=$_POST['unitName'];
	
	require_once('../../../../modules/addUnit/admin/models/addUnitModel.php');
	$objaddUnitModel=new addUnitModel();
	$noOfRows=$objaddUnitModel->nameDuplicationCheck($unitId,$unitName);
	if($noOfRows==0){
	$update_UnitList=$addUnitController->update_UnitList($unitId,$unitName);
	 $objPath->setHeader('addUnit','Success','addUnit');
	}
	else
		$objPath->setHeader('addUnit','Unit Name Exist','addUnit');
}

?>


<h3>Edit Unit</h3>
<div class="col-sm-3 col-md-3 col-lg-3">
    	<div class="box box-solid box-primary">
        	<div class="box-header">
            	<h4 class="box-title">Edit Unit</h4>
            </div>
            <div class="box-body">
         	<form name="form1" method="post" action="">
			   <input type="hidden" name="unitId" id="unitId" value="<?php echo $unitId; ?>" >
				<div class="form-group">
                	<label for="unitName">Unit Name :</label><span style="color:red;" class="mandatory">*</span>
                   <input type="text" name="unitName" id="unitName" required="" class="form-control input-sm" value="<?php echo $unitName; ?>" autocomplete="off" onchange="nameDuplication();"/>
                   <span id="user"></span></td>
				</div>
                <div class="form-group">
                	<center>
               			<button type="submit" name="submit" value="submit" class="btn btn-primary">
                        	<i class="fa fa-plus"></i> update
                        </button>
           		 	</center>
             	</div>
			</form> 	
            </div>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>		
 function nameDuplicationCheck()

        {

			

			 var unitId    = $('#unitId').val();

			 var unitName = $('#unitName').val();

            $.ajax({

                type: "POST",

                url: "../../../../modules/addUnit/admin/ajax/nameDuplicationCheck.php",

				 data:{unitId:unitId,unitName:unitName},

				 cache:false,

                success: function(data)

                {
					var val=$.trim(data);

                    if(val === '1')

                    {

                      
                             alert("unitName Exist!!");
							document.getElementById("unitName").value= "";

                    }

                    else 

                    {

                      

                    }

                }

            })              

        }	
   
 </script>     