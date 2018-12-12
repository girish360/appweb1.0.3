<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/company.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare company object
$company = new company($db);
 
// set ID property of record to read
$company->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of company to be edited
$company->readOne();
 
if($company->name!=null){
    // create array
    $company_arr = array(
        "id" =>  $company->id,
        "name" => $company->name,
        "address" => $company->address,
        "city" => $company->city,
        "country" => $company->country,
        "pincode" => $company->pincode,
		"contact_person" => $company->contact_person,
		"contact_phone" => $company->contact_phone,
		"contact_mobile" => $company->contact_mobile,
		"contact_email" => $company->contact_email
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($company_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user company does not exist
    echo json_encode(array("message" => "Company does not exist."));
}
?>