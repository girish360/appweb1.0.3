<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate company object
include_once '../objects/company.php';
 
$database = new Database();
$db = $database->getConnection();
 
$company = new Company($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->name) 
){
 
    // set company property values
    $company->name = $data->name;
    $company->city = $data->city;
    $company->country = $data->country;
    $company->pincode = $data->pincode;
	$company->contact_person = $data->contact_person;
	$company->contact_phone = $data->contact_phone;
	$company->contact_mobile = $data->contact_mobile;
	$company->contact_email = $data->contact_email;
    $company->created = date('Y-m-d H:i:s');
 
    // create the company
    if($company->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "company was created."));
    }
 
    // if unable to create the company, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create company."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create company. Data is incomplete."));
}
?>