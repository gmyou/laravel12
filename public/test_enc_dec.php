<?php
function euckr_urlencode($string) {
    return urlencode(iconv("UTF-8", "EUC-KR//IGNORE", $string));
}

function euckr_urldecode($string) {
    return iconv("EUC-KR", "UTF-8//IGNORE", urldecode($string));
}

function build_query_string($params) {
    $pairs = [];
    foreach ($params as $key => $value) {
        $encodedValue = euckr_urlencode($value);
        $pairs[] = "{$key}={$encodedValue}";
    }
    return implode("&", $pairs);
}

function encrypt_data($params, $key, $iv) {
    $queryString = build_query_string($params);
    $encrypted = openssl_encrypt($queryString, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    $base64Encoded = base64_encode($encrypted);
    return euckr_urlencode($base64Encoded); // 최종 DATA 값
}

function decrypt_data($data, $key, $iv) {
    $base64Decoded = base64_decode(euckr_urldecode($data));
    $decrypted = openssl_decrypt($base64Decoded, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    
    // QueryString을 파싱
    $result = [];
    parse_str($decrypted, $parsed);
    foreach ($parsed as $k => $v) {
        $result[$k] = euckr_urldecode($v);
    }
    return $result;
}

// 예제 사용

$key = '12345678901234567890123456789012'; // 32바이트 AES-256 키
$iv = '1234567890123456';                 // 16바이트 IV

// 요청 시 데이터
$params = [
    'userName' => '홍길동',
    'amount' => '10000',
    'productName' => '테스트상품',
    // CPID 제외
];

$encryptedData = encrypt_data($params, $key, $iv);
echo "요청 DATA = $encryptedData\n";

// 응답 시 복호화
$decryptedData = decrypt_data($encryptedData, $key, $iv);
echo "복호화된 응답:\n";
print_r($decryptedData);
