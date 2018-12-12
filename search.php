<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/company.php';
 
// instantiate database and company object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$company = new Company($db);
 
// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
 
// query products
$stmt = $company->search($keywords);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // company array
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
            "description" => $description,
            "city" => $city,
            "country" => $country,
            "pincode" => $pincode,
			"contact_person" => $contact_person,
			"contact_phone" => $contact_phone,
			"contact_mobile" => $contact_mobile,
			"contact_email" => $contact_email
        );
 
        array_push($company_arr["records"], $company_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show company data
    echo json_encode($company_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no company found
    echo json_encode(
        array("message" => "No company found.")
    );
}
?>