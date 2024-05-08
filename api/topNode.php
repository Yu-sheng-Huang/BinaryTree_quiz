<?php
// 處理 /api/policyholders/{code}/top 的端點
require_once('../conn.php');
$conn = new MySQLConnection();
if(isset($_GET['code'])) {
    // 獲取參數
    $code = $_GET['code'];

    // 執行 SQL 查詢以獲取根結點的上一階結點的 ID
    $referrerIDSql = "SELECT ReferrerID FROM policyholders WHERE PolicyholderID = $code";
    $referrerIDResult = $conn->query($referrerIDSql);
    $referrerID = isset($referrerIDResult['ReferrerID']) ? $referrerIDResult['ReferrerID'] : null;

    // 檢查是否找到了上一階結點的 ID
    if($referrerID !== null) {
        // 執行 SQL 查詢以獲取上一階結點的信息
        $topPolicyholderSql = "SELECT * FROM policyholders WHERE PolicyholderID = $referrerID";
        $topPolicyholderResult = $conn->query($topPolicyholderSql);
        // 如果存在，回傳該保戶的數據
        $response = array(
            "code" => isset($topPolicyholderResult['PolicyholderID']) ? $topPolicyholderResult['PolicyholderID'] : '',
            "name" => isset($topPolicyholderResult['Name']) ? $topPolicyholderResult['Name'] : ''
        );

        // 將結果轉換為 JSON 格式並返回
        echo json_encode($response);
    } else {
        // 沒有找到上一階結點，返回錯誤消息
        echo json_encode(array("error" => "Policyholder has no top node"));
    }
} else {
    // 沒有提供保戶編號，返回錯誤消息
    echo json_encode(array("error" => "Policyholder number not provided"));
}
?>

