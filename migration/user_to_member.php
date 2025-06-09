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

$sql = "select top 10 CD_COMPANY
, NO_USER
, ID_USER
, NM_USER
, TXT_EMAIL
, CD_USER_SEX
, DT_BIRTHDAY
, DATE_REG
, DATE_CHG
, AMT_CASH_CONTENTS
, AMT_CASH_BONUS
, SUM_CASH_CONTENTS
, SUM_CASH_BONUS
from BX_TB_USER_INFO;";


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
$users = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $users[] = (object) $row; // Convert to object for easier access
}

print_r($users); // Debugging: dump the users $arrayName = array();
foreach ($users as $user) {    
    // Insert into the database
    $insertSql = "INSERT INTO customers (membership_code, user_no, user_id, user_name, user_email, gender, birth, created_at, updated_at, total_cash, total_bonus, remain_cash, remain_bonus) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [
        $user->CD_COMPANY,
        $user->NO_USER,
        $user->ID_USER,
        $user->NM_USER,
        $user->TXT_EMAIL,
        $user->CD_USER_SEX,
        $user->DT_BIRTHDAY,
        $user->DATE_REG,
        $user->DATE_CHG,
        $user->AMT_CASH_CONTENTS,
        $user->AMT_CASH_BONUS,
        $user->SUM_CASH_CONTENTS,
        $user->SUM_CASH_BONUS
    ];
    $insertStmt = sqlsrv_query($conn, $insertSql, $params);
    if ($insertStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}
echo "Migration completed successfully.";

?>