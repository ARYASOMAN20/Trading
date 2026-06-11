<?php
require_once('../../../../modules/addCategory/admin/controllers/addCategoryController.php');
require_once("../../../../settings/path.php");
$objPath          = new Path();
if(isset($_POST['update']))
{
	$addCategoryController=new addCategoryController();
	$categoryId=$_POST['categoryId'];
	$updateCategorys=$addCategoryController->updateCategory($categoryId);
		while($updateCategoryResult=mysqli_fetch_array($updateCategorys))
			{
				$categoryId =$updateCategoryResult['categoryId'];
				$categoryName=$updateCategoryResult['categoryName'];
				$remarks=$updateCategoryResult['remarks'];
			 }
          }


if(isset($_POST['submit']))
{
	$addCategoryController=new addCategoryController();
	$categoryId=$_POST['categoryId'];
	$categoryName=$_POST['categoryName'];
	$remarks=$_POST['remarks'];
	require_once('../../../../modules/addCategory/admin/models/addCategoryModel.php');
	$objaddCategoryModel=new addCategoryModel();
	$noOfRows=$objaddCategoryModel->nameDuplicationCheck($categoryId,$categoryName);
	if($noOfRows==0){
	$update_Category=$addCategoryController->update_CategoryList($categoryId,$categoryName,$remarks);
	 $objPath->setHeader('addCategory','Success','addCategory');
	}
	else
		$objPath->setHeader('addCategory','categoryName Exist','addCategory');
}

?>


<h3>Edit Category</h3>
<div class="col-sm-3 col-md-3 col-lg-3">
    	<div class="box box-solid box-primary">
        	<div class="box-header">
            	<h4 class="box-title">Edit Category</h4>
            </div>
            <div class="box-body">
         	<form name="form1" method="post" action="">
			   <input type="hidden" name="categoryId" id="categoryId" value="<?php echo $categoryId; ?>" >
				<div class="form-group">
                	<label for="categoryName">Name :</label><span style="color:red;" class="mandatory">*</span>
                   <input type="text" name="categoryName" id="categoryName" value="<?php echo $categoryName; ?>" required="" onchange="nameDuplicationCheck();" class="form-control input-sm" autocomplete="off"/>
                </div>
            	<div class="form-group">
                	<label for="remarks">Remarks</label>
                    <textarea name="remarks" id="remarks" class="form-control input-sm"><?php echo $remarks; ?></textarea>
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

			

			 var categoryId    = $('#categoryId').val();

			 var categoryName = $('#categoryName').val();

            $.ajax({

                type: "POST",

                url: "../../../../modules/addCategory/admin/ajax/nameDuplicationCheck.php",

				 data:{categoryId:categoryId,categoryName:categoryName},

				 cache:false,

                success: function(data)

                {
					var val=$.trim(data);

                    if(val === '1')

                    {

                      
                             alert("categoryName Exist!!");
							document.getElementById("categoryName").value= "";

                    }

                    else 

                    {

                      

                    }

                }

            })              

        }	
   
 </script>     