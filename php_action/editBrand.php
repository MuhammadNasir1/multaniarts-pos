<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$brandName = $_POST['editBrandName'];
    $brandStatus = $_POST['editBrandStatus']; 
    $brandId = $_POST['brandId'];
    $edit_maker_id = $_POST['edit_maker_id'];

	$sql = "UPDATE brands SET brand_name = '$brandName', brand_active = '$brandStatus', maker_id = '$edit_maker_id' WHERE brand_id = '$brandId'";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST