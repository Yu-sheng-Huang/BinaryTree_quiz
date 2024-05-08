<?php
class MySQLConnection {
    private $conn;

    public function __construct(){
        require_once('config.php');
        $this->conn = new mysqli($servername, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("連接失敗: " . $this->conn->connect_error);
        }
    }

    public function query($sql){
        $result = $this->conn->query($sql);

        if ($result === false) {
            die("查詢失敗: " . $this->conn->error);
        }
        $row = $result->fetch_assoc();

        // $rows = array();
        // while ($row = $result->fetch_assoc()) {
        //     $rows[] = $row;
        // }
        return $row;
    }
    
    public function queryAll($sql,$direct) {
        $result = $this->conn->query($sql);

        if ($result === false) {
            die("查詢失敗: " . $this->conn->error);
        }
        $row_count = mysqli_num_rows($result);
        
        $rows = array();
        if($direct == 'Y'){
            while ($row = $result->fetch_assoc()) {
                $row['direct'] = 'Y';
                $rows[] = $row;
            }
        }else{
            while ($row = $result->fetch_assoc()) {
                $row['direct'] = 'N';
                $rows[] = $row;
            }
        }
        $rows['count'] = $row_count;
        return $rows;
    }

    public function close(){
        $this->conn->close();
    }
}
?>
