<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/company.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare company object
$company = new Company($db);
 
// get id of company to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of company to be edited
$company->id = $data->id;
 
// set company property values
$company->name = $data->name;
$company->address = $data->address;
$company->city = $data->city;
$company->country = $data->country;
$company->pincode = $data->pincode;
$company->contact_person = $data->contact_person;
$company->contact_phone = $data->contact_phone;
$company->contact_mobile = $data->contact_mobile;
$company->contact_email = $data->contact_email;
 
// update the company
if($company->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Company was updated."));
}
 
// if unable to update the company, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update company."));
}
?>