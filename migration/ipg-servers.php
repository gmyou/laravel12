<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// sqlsrv connection
$serverName = $_ENV['DB_HOST'];
$connectionOptions = array(
    "Database" => $_ENV['DB_DATABASE'],
    "Uid" => $_ENV['DB_USERNAME'],
    "PWD" => $_ENV['DB_PASSWORD'],
    "TrustServerCertificate" => "true",
);

$sql = "select top 10 
TXT_ALIAS
, CD_SVR_KIND -- 'I' => 'INTERNAL', 'E' => 'EXTERNAL'
, IP_SVR
, CD_STATUS -- D: del_flag=>'Y', status_flag ('T' =>'N', 'A' =>'Y')
, CD_TX_TYPE -- 10 => INCOME, 20 => OUTGOINGS, 30 => ALL
, DATE_REG
, DATE_CHG
from BX_TB_IPG_SERVER;";


$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Execute the query
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the results
$servers = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $servers[] = (object) $row; // Convert to object for easier access
}

print_r($servers); // Debugging: dump the servers $arrayName = array();
foreach ($servers as $server) {    
    // Insert into the database
    $insertSql = "INSERT INTO ipg_servers (server_name, server_position, ip_address, del_flag, status_flag, transaction_type, created_at, updated_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $server->position = $server->CD_SVR_KIND === 'I' ? 'INTERNAL' : ($server->CD_SVR_KIND === 'E' ? 'EXTERNAL' : 'UNKNOWN');
    $server->del_flag = 'N';
    $server->status_flag = 'N'; 
    if ($server->CD_STATUS === 'D') {
        $server->del_flag = 'Y'; // Convert 'D' to 'Y' for del_flag
    } elseif ($server->CD_STATUS === 'A') {
        $server->status_flag = 'Y'; // Convert 'A' to 'Y'
    }

    $server->transaction_type = $server->CD_TX_TYPE === 10 ? 'INCOME' : ($server->CD_TX_TYPE === 20 ? 'OUTGOINGS' : 'ALL');

    $params = [
        $server->TXT_ALIAS,
        $server->position,
        $server->IP_SVR,
        $server->del_flag,
        $server->status_flag,
        $server->transaction_type,
        $server->DATE_REG ? $server->DATE_REG->format('Y-m-d H:i:s') : null, // Format date if not null
        $server->DATE_CHG ? $server->DATE_CHG->format('Y-m-d H:i:s') : null // Format date if not null
    ];
    $insertStmt = sqlsrv_query($conn, $insertSql, $params);
    if ($insertStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}
echo "Migration completed successfully.";

?>