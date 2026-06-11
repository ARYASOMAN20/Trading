<?php
 
 /* ----------Developed By AK 07/11/2019 ---------------- */

	require_once('../../../../modules/itemMaster/admin/models/Itemmastermodel.php');
	$objItemmastermodel=new Itemmastermodel();
	require_once("../../../../settings/path.php");
	$objPath          = new Path();

	if(isset($_POST['itemMasterId']))	{
		$categoryId=$brandIdForCompare=$description=$packingSize=$packingSizeArabic=$vat=$remarks=null;
		$costPrice=$sellingPrice=$tbodyDetails=$geUnitsForEdit=null;

		$itemMasterId=$_POST['itemMasterId'];
		$getItemsDetailsForUpdate=$objItemmastermodel->getItemsDetailsForUpdate($itemMasterId);
			
		while($fetch_rowsItemsDetailsForUpdate= mysqli_fetch_assoc($getItemsDetailsForUpdate)){
				$categoryId=$fetch_rowsItemsDetailsForUpdate['categoryId'];
				$brandIdForCompare=$fetch_rowsItemsDetailsForUpdate['brandId'];
				$description=$fetch_rowsItemsDetailsForUpdate['description'];
				$packingSize=$fetch_rowsItemsDetailsForUpdate['packingSize'];
				$packingSizeArabic=$fetch_rowsItemsDetailsForUpdate['packingSizeArabic'];
				$vat=$fetch_rowsItemsDetailsForUpdate['vat'];
				$remarks=$fetch_rowsItemsDetailsForUpdate['remarks'];
				$costPrice=$fetch_rowsItemsDetailsForUpdate['costPrice'];
				$sellingPrice=$fetch_rowsItemsDetailsForUpdate['sellingPrice'];
	}
	
	$geUnitsForEdit=$objItemmastermodel->geUnitsForEdit($itemMasterId);	

	while($fetch_rowsgeUnitsForEdit= mysqli_fetch_array($geUnitsForEdit)){
	
	$tbodyDetails .='<tr>
				<input type="hidden" name="itemUnitIdUpdate[]" value="'.$fetch_rowsgeUnitsForEdit['itemUnitId'].'">
				<td style="width: 34%;"><input type="text" name="unitNameUpdate[]" class="form-control input-sm" value="'.$fetch_rowsgeUnitsForEdit['unitName'].'"></td>
				<td style="width: 34%;"><input type="text" name="multipleUpdate[]" class="form-control input-sm" value="'.$fetch_rowsgeUnitsForEdit['multiple'].'"></td>
				<td>&nbsp;</td>
				</tr>';
	}

	
	/*  ------------------- Get All Category  ------------------- */
	$allCategory=$objItemmastermodel->getAllCategory();
	$categorySelectBox=null;
	$selected=null;
	while($fetch_rowsOfCategory= mysqli_fetch_array($allCategory)){
		if($categoryId==$fetch_rowsOfCategory['categoryId']){
			$selected='selected="selected"';
		}else{
			$selected='';
		}
		$categorySelectBox .= '<option value="'.$fetch_rowsOfCategory['categoryId'].'" '.$selected.'>'.$fetch_rowsOfCategory['categoryName'].'</option>';
	}
	/*  ------------------- Get All Category End ------------------- */
	
	/*  ------------------- Get All Brands  ------------------- */
	$allBrands=$objItemmastermodel->getAllBrand();
	$brandSelectBox=null;
	$selected=null;
	while($fetch_rowsOfBrands= mysqli_fetch_array($allBrands)){
		if($brandIdForCompare==$fetch_rowsOfBrands['brandId']){
			$selected='selected="selected"';
		}else{
			$selected='';
		}
		
		$brandSelectBox .= '<option value="'.$fetch_rowsOfBrands['brandId'].'" '.$selected.'>'.$fetch_rowsOfBrands['brandName'].'</option>';
	}
	/*  ------------------- Get All Brands End  ------------------- */
	}

	if(isset($_POST['updateItemMaster'])){
		$itemMasterId=$_POST['itemMasterId'];
		$categoryId=$_POST['categoryId'];
		$brandId=$_POST['brandId'];
		$description=$_POST['description'];
		$packingSize=$_POST['packingSize'];
		$packingSizeArbic=$_POST['packingSizeArbic'];
		$vatPer=$_POST['vatPer'];
		$remarks=$_POST['remarks'];
		$costPrice=$_POST['costPrice'];
		$sellingPrice=$_POST['sellingPrice'];
		
		$itemUnitIdUpdate=$_POST['itemUnitIdUpdate'];
		$unitName=$_POST['unitNameUpdate'];
		$fractionValue=$_POST['multipleUpdate'];
		
		/* ------------------- itemMaster Update -------------------------- */
		$objItemmastermodel->updateIntoItemMaster($categoryId,$brandId,$description,$packingSize,$packingSizeArbic,$vatPer,$remarks,$costPrice,$sellingPrice,$itemMasterId);
		/*  -------------------  itemMaster Update End   -------------------  */
		
		/*  -------------------  itemUnit Update  -------------------  */
		$objItemmastermodel->updateIntoUnitItems($itemUnitIdUpdate,$unitName,$fractionValue,$itemMasterId);
		/*  -------------------   itemUnit Update End  ------------------- */
		
		$objPath->setHeader('itemMaster','Updated Success !!','itemMaster');

}


	
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Item</title>
 
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<style>
table, td,th{
	border: 0px !important ;
	
}
th {
	width:20% !important;
}
</style>

<script>

    $(document).ready(function() {
        var i = 1;
        $('#addUnitsBtn').click(function() {
			i++;
			
			$('#unitTableShow').css('display','block');
            var unitName        = $('#unitName').val();
			var fractionValue   = $('#fractionValue').val();
			if(unitName=='' || fractionValue==''){
					alert("enter valid data");
			}else{

            content = '<tr id="row' + i + '"><td style="width: 34%;"><input type="hidden" class="form-control input-sm" name="itemUnitIdUpdate[]" value="newUnit" readonly /><input type="text" class="form-control input-sm" name="unitNameUpdate[]" value="' + unitName + '" readonly /></td><td style="width: 34%;"><input type="text" class="form-control input-sm"  name="multipleUpdate[]" value="' + fractionValue + '" readonly /></td><td><button type="button" onclick="" class="btn btn-danger btnRemoveTd btn-xs" style="font-size: 16px;" id="'+i+'"><i class="fa fa-times"></i></button></td></tr>"';

            $('#addUnitsTable').append(content);
			document.getElementById("unitName").value	= "";
			document.getElementById("fractionValue").value	= "";
			}
        });
	});
	
$(document).on('click','.btnRemoveTd',function(){
					var id=$(this).attr('id');
					$('#row'+id).remove();				
				});
				

</script>
<script>
  function checkNumber(a)
{	var x=document.getElementById(a).value;
		if(isNaN(x))
			{
			alert("Enter a Valid Number");
			document.getElementById(a).value		=	null;
			a.focus();
	}		
}
</script>
</head>
    <body>
        
   <div class="container" id="printDiv">
        <div class="col-sm-10 col-md-10 col-lg-10">
	<div class="panel panel-primary">
		<div class="panel-heading" style="padding: 16px 15px;" >Item Master</div>
		<div class="panel-body">
           <form action="" method="POST" > 
                <table class="table" >	
                    <tbody>
						    <tr><input type='hidden' value='<?php echo $itemMasterId; ?>' name='itemMasterId'>
    							<th>Category</th>
    							<th>
									<select class="form-control input-sm" name='categoryId' id='categoryId' onchange='getBrandsOfCategory()'>
										<option>Select</option>
										<?php echo $categorySelectBox; ?>
									</select>
								</th>
							    <th>Brand</th>
    							<th >	
									<select class="form-control input-sm" name='brandId'>
										<option>Select</option>
										<?php echo $brandSelectBox; ?>
									</select>
								</th>
    							<th></th>
						    </tr>
						    <tr>
    							<th>Description</th>
    							<th colspan='3' ><input type='text' value="<?php echo $description;?>" name='description' class="form-control input-sm" /></th>
								<th></th>
						    </tr>
						    <tr>
    							<th>Packing Size:</th>
    							<th ><input type='text' value="<?php echo $packingSize;?>" name='packingSize' class="form-control input-sm" /></th>
						  
    							<th>Packing Size (Arabic):</th>
    							<th  ><input type='text' value="<?php echo $packingSizeArabic;?>" name='packingSizeArbic' class="form-control input-sm" /></th>
    							<th></th>
						    </tr>
						  <tbody>		
					</table>
				<table class="table">
							<tr>
							    <th>Vat%</th>
							    <th><input type='text' name='vatPer' value="<?php echo $vat;?>" 
								onkeyup='checkNumber(this.id)' id='vatPer' class="form-control input-sm" /></th>
						
							    <th>Remarks</th>
							    <th><input type='text' name='remarks'  value="<?php echo $remarks;?>"  id='remarks' class="form-control input-sm" /></th>
								<th></th>
							</tr>
							 <tr>
							    <th>Cost Price</th>
							    <th><input type='text' name='costPrice' onkeyup='checkNumber(this.id)'  value="<?php echo $costPrice;?>" id='costPrice' class="form-control input-sm" /></th>
							
							    <th>Selling Price</th>
							    <th><input type='text' name='sellingPrice' onkeyup='checkNumber(this.id)' value="<?php echo $sellingPrice;?>"  id='sellingPrice' class="form-control input-sm" />
								<th></th>
								</th>
							</tr>
				</table>
				<div class=" box box-solid box-warning col-sm-5 col-md-5 col-lg-5" style="background: #77ebb582;"> 		
						<table class="table" style="width:100% !important">
									<tr>
										
										<th><input type='text' placeholder="Unit"   id='unitName' class="form-control input-sm" /></th>
										
										<th><input type='text' placeholder="Fraction" onkeyup='checkNumber(this.id)'  id='fractionValue' class="form-control input-sm" /></th>
										<th><button type='button' class='btn btn-success btn-xs' style="font-size: 16px;" id="addUnitsBtn"><i class='fa fa-plus'></i></button></th>
									</tr>
						</table>
						<table class="table" id='unitTableShow' style='width:100%  !important' >
							<thead>
								<tr>
									<th>Unit</th>
									<th>Fraction</th>
								</tr>
							</thead>
							<tbody id='addUnitsTable'>
								<?php echo $tbodyDetails;?>
							</tbody>
						</table>
				</div>
				<div class="col-sm-10 col-md-10 col-lg-10 row">
					<center><button type='submit' name='updateItemMaster' class='btn btn-success' ><i class="fa fa-save"></i>&nbsp;Update</button></center>
				</div>
			 </div>
           </form>
      </div>
    </div>
</div>
</body>
</html>

