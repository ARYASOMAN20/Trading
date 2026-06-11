<?php
require_once('../../../../modules/addBrand/admin/controllers/addBrandController.php');
require_once("../../../../settings/path.php");
$objPath          = new Path();
if(isset($_POST['update']))
{
	$addBrandController=new addBrandController();
	$brandId=$_POST['brandId'];
	$updateBrands=$addBrandController->updateBrand($brandId);
		while($updateBrandResult=mysqli_fetch_array($updateBrands))
			{
				$brandId     =$updateBrandResult['brandId'];
				$brandCode   =$updateBrandResult['brandCode'];
				$brandName   =$updateBrandResult['brandName'];
				//$brandFormat =$updateBrandResult['brandFormat'];
			 }
          }
		  
		  
if(isset($_POST['submit']))
{
	$addBrandController=new addBrandController();
	$brandId      =$_POST['brandId'];
	$brandName    =$_POST['brandName'];
	$brandCode    =$_POST['brandCode'];
	$brandFormat  ='';
	require_once('../../../../modules/addBrand/admin/models/addBrandModel.php');
	$objaddCategoryModel=new addBrandModel();
	$noOfRows=$objaddCategoryModel->nameDuplicationCheck($brandId,$brandCode);
	if($noOfRows==0){
	$update_Brand=$addBrandController->update_BrandList($brandId,$brandCode,$brandName,$brandFormat);
	 $objPath->setHeader('addBrand','Success','addBrand');
	}
	else
		$objPath->setHeader('addBrand','BrandCode Exist','addBrand');  
}		  

?>


<h3>Edit Brand</h3>
<div class="col-sm-3 col-md-3 col-lg-3">
    	<div class="box box-solid box-primary">
        	<div class="box-header">
            	<h4 class="box-title">Edit Brand</h4>
            </div>
            <div class="box-body">
         	<form name="form1" method="post" action="">
			   <input type="hidden" name="brandId" id="brandId" value="<?php echo $brandId; ?>" >
			    <div class="form-group">
                	<label for="brandCode">Brand Code :</label>
                   <input type="text" name="brandCode" id="brandCode" required class="form-control input-sm"  value="<?php echo $brandCode; ?>" autocomplete="off"/>
                </div>
				<div class="form-group">
                	<label for="brandName">Name :</label><span style="color:red;" class="mandatory">*</span>
                   <input type="text" name="brandName" id="brandName" value="<?php echo $brandName; ?>" required="" onChange="nameDuplicationCheck();" class="form-control input-sm" autocomplete="off"/>
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

			

			 var brandId    = $('#brandId').val();

			 var brandName = $('#brandName').val();

            $.ajax({

                type: "POST",

                url: "../../../../modules/addBrand/admin/ajax/nameDuplicationCheck.php",

				 data:{brandId:brandId,brandName:brandName},

				 cache:false,

                success: function(data)

                {
					var val=$.trim(data);

                    if(val === '1')

                    {

                      
                             alert("BrandName Exist!!");
							document.getElementById("brandName").value= "";

                    }

                    else 

                    {

                      

                    }

                }

            })              

        }	
   
 </script>     
