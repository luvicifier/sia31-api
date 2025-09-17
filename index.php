<?php
// Set headers to allow API requests from anywhere and to output JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight OPTIONS request from browsers
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Define the path to our data file
$dataFile = 'lost_items.json';

// Function to read and decode JSON data
function readData($filePath) {
    if (!file_exists($filePath)) {
        return [];
    }
    $json = file_get_contents($filePath);
    return json_decode($json, true) ?: [];
}

// Function to save data to the JSON file
function saveData($filePath, $data) {
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $json);
}

// **SIMPLIFIED ROUTING USING QUERY PARAMETERS**
// Get the 'action' from the query string (e.g., ?action=get_items)
$action = $_GET['action'] ?? '';

// GET /index.php?action=get_items - Get all lost items
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'get_items') {
    $data = readData($dataFile);
    http_response_code(200);
    echo json_encode($data);
    exit();
}

// POST /index.php?action=add_item - Add a new lost item
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'add_item') {
    // Get the JSON data from the request body
    $input = json_decode(file_get_contents('php://input'), true);

    // Simple validation
    if (empty($input['item_name']) || empty($input['location_found'])) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Missing required fields: item_name and location_found']);
        exit();
    }

    $data = readData($dataFile);

    // Create the new item
    $newItem = [
        'id' => count($data) + 1,
        'item_name' => $input['item_name'],
        'location_found' => $input['location_found'],
        'description' => $input['description'] ?? ''
    ];

    // Add it to our data array and save
    $data[] = $newItem;
    saveData($dataFile, $data);

    http_response_code(201); // Created
    echo json_encode($newItem);
    exit();
}

// If no action matches, show API info
echo json_encode([
    "message" => "Welcome to the Campus Lost & Found API",
    "endpoints" => [
        "GET /sia31-api/?action=get_items" => "Get all lost items",
        "POST /sia31-api/?action=add_item" => "Report a new lost item"
    ]
]);
?>