<?php
require_once('../conn.php');
$conn = new MySQLConnection();
class TreeNode {
    public $value;
    public $left;
    public $right;
    public $parentValue;

    public function __construct($value , $parentValue = null) {
        $this->value = $value;
        $this->left = null;
        $this->right = null;
        $this->parentValue = $parentValue;// 設置父節點值
    }
}

// $_GET['number'] = 05; //test
if(isset($_GET['code'])){
    $n_id = $_GET['code'];
}
$n_id = $_GET['number'] ?:null;
// 檢查是否有傳入參數
if(isset($n_id)) {
    $searchNumber = $n_id;
    $sql = "SELECT * FROM policyholders WHERE PolicyholderID = $searchNumber";
    $policyholder = $conn->query($sql);
    // 檢查是否存在對應的保戶編號
    if($policyholder) {
       // 如果存在，回傳該保戶的數據
        $result = array(
            "code" => isset($policyholder['PolicyholderID']) ? $policyholder['PolicyholderID'] : '',
            "name" => isset($policyholder['Name']) ? $policyholder['Name'] : '',
            "registration_date" => isset($policyholder['JoinDate']) ? $policyholder['JoinDate'] : '',
            "introducer_code" => isset($policyholder['ReferrerID']) ? $policyholder['ReferrerID'] : 'null',
            "direct" => isset($policyholder['direct']) ? $policyholder['direct'] : 'null'
        );
    }else{
        echo json_encode(array("error" => "Policyholder not found"));
    }
    $directSql = "SELECT * FROM Policyholders WHERE ReferrerID = $searchNumber AND ReferrerID IS NOT NULL";
    $direct_tree = $conn->queryAll($directSql,'Y');
    $direct_num = $direct_tree['count'];
    unset($direct_tree['count']);
    
    $indirectSql = "SELECT * FROM policyholders WHERE ReferrerID IN (SELECT PolicyholderID FROM policyholders WHERE ReferrerID = $searchNumber )";
    $indirect_tree = $conn->queryAll($indirectSql,'N');
    $indirect_num = $indirect_tree['count'];
    unset($indirect_tree['count']);
    // 合併直接與非直接關係
    $merge_tree = array_merge($direct_tree , $indirect_tree);
    // 將陣列填入二元樹中，並將左右子樹分開返回
    function fillDataIntoTree($data,$parentValue = null) {
        // 建立一個空的二元樹
        $root = createEmptyBinaryTree();
        $queue = [$root];
        $index = 0;
    
        while ($index < count($data)) {
            $node = array_shift($queue);
    
            if ($node->left === null) {
                $node->left = new TreeNode($data[$index++],$node->value);// 建立父子關係
                $queue[] = $node->left;
            }
    
            if ($index < count($data) && $node->right === null) {
                $node->right = new TreeNode($data[$index++], $node->value);// 建立父子關係
                $queue[] = $node->right;
            }

        }
    
        // 分別提取左右樹
        $leftTree = extractData($root->left);
        $rightTree = extractData($root->right);
    
        return ['left' => $leftTree, 'right' => $rightTree];
    }
    
    // 空2元樹
    function createEmptyBinaryTree() {
        return new TreeNode(null);
    }
    
    // 從2元樹取值，同時返回父節點
    function extractData($node) {
        if ($node === null) {
            return [];
        }
        
        $result = [$node->value];
        $result[0]["parent"] = isset($node->parentValue['PolicyholderID']) ? $node->parentValue['PolicyholderID'] : '';

        $result = array_merge($result, extractData($node->left));
        $result = array_merge($result, extractData($node->right));

        return $result;
    }
    // 將資料填入二元樹中，並將左右子樹分開返回
    $re = fillDataIntoTree($merge_tree);
    // var_dump($re);
    $array['right'] = array_map(function($item) {
        return [
            'code' => $item['PolicyholderID'],
            'name' => $item['Name'],
            'registration_date' => $item['JoinDate'],
            'introducer_code' => $item['ReferrerID'],
            'direct' => $item['direct'],
            'parent' => $item['parent']
        ];
    }, $re['right']);
    $array['left'] = array_map(function($item) {
        return [
            'code' => $item['PolicyholderID'],
            'name' => $item['Name'],
            'registration_date' => $item['JoinDate'],
            'introducer_code' => $item['ReferrerID'],
            'direct' => $item['direct'],
            'parent' => $item['parent']
        ];
    }, $re['left']);
    $result['l'] = $array['left'];
    $result['r'] = $array['right'];
    echo json_encode($result);
} else {
    // 如果沒有傳入參數，回傳錯誤消息
    echo json_encode(array("error" => "Policyholder number not provided"));
}

?>
