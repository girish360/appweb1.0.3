<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/company.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$company = new Company($db);
 
// read companies will be here
// query companies
$stmt = $company->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // companies array
    $company_arr=array();
    $company_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $company_item=array(
            "id" => $id,
            "name" => $name,
            //"address" => html_entity_decode($address),
			"address" => $address,
            "city" => $city,
            "country" => $country,
            "pincode" => $pincode,
			"contact_person" => $contact_person,
			"contact_phone" => $contact_phone,
			"contact_mobile" => $contact_mobile,
			"contact_email" => $contact_email,
			"created" => $created
        );
 
        array_push($company_arr["records"], $company_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show companies data in json format
    echo json_encode($products_arr);
}
 
// no companies found will be here
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no companies found
    echo json_encode(
        array("message" => "No Companies found.")
    );
}