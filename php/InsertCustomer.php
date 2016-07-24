<?php

$sql = 'call InsertCustomerWithTransaction(:prm_cust_last_name,:prm_cust_frst_name,
        :prm_area_code,:prm_phone_number,:prm_email,:prm_artist_lst_name,:prm_work_title,:prm_work_copy,:prm_sales_price)';

		//get input from HTML
$inputLName = $_POST["inputLName"];
$inputFName = $_POST["inputFName"];
$inputAreaCode = $_POST["inputAreaCode"];
$inputPhoneNumber = $_POST["inputPhoneNumber"];
$inputEmail = $_POST["inputEmail"];
$inputALastName = $_POST["inputALastName"];
$inputtitle = $_POST["inputtitle"];
$inputCopy = $_POST["inputCopy"];
$inputSalePrice = $_POST["inputSalePrice"];


$connection = ocilogon("vrami2","oracle", "oracle.uis.edu");

if (!$connection) {

echo "Couldnt make a connection!";

exit;

}

//$conn = oci_connect('stg_ext', 'STG_EXT61086', 'stgfmt');

//if (!$conn) {
  //  $e = oci_error();
    //trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
//}

$stmt = oci_parse($connection, $sql);
if (!$stmt)
    print "Error parsing SQL";

$prm_policy_details = oci_new_cursor($connection);
$prm_success = 'Record Inserted into database succesfully';

oci_bind_by_name($stmt, ':prm_cust_last_name', $inputLName) 
or die('Error binding string');

oci_bind_by_name($stmt, ':prm_cust_frst_name', $inputFName) 
or die('Error binding string');

oci_bind_by_name($stmt, ':prm_area_code', $inputAreaCode) 
or die('Error binding string');

oci_bind_by_name($stmt, ':prm_phone_number', $inputPhoneNumber) 
or die('Error binding string');

oci_bind_by_name($stmt, ':prm_email', $inputEmail) 
or die('Error binding string');

oci_bind_by_name($stmt, ':prm_artist_lst_name', $inputALastName) 
or die('Error binding string');

oci_bind_by_name($stmt, ':prm_work_title', $inputtitle) 
or die('Error binding string');

oci_bind_by_name($stmt, ':prm_work_copy', $inputCopy) 
or die('Error binding string');

oci_bind_by_name($stmt, ':prm_sales_price', $inputSalePrice) 
or die('Error binding string');

// Execute Statement
$execute_return = oci_execute($stmt);
if (!$execute_return)
    print "Error Execution Stored Procedure";

//execute the CURSORS (this is one of the weird things about ref cursors
// w/ Oracle-- they must get EXECUTED

oci_execute($prm_policy_details);

print "<pre>";
print "Returned parameters<br/>\"";
print_r($prm_policy_details);
print "\"<br/>";
print "Sucess Code:" . $prm_success . "<br/>";
print "</pre>";
?>