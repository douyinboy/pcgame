<?php
 /**================================
  * 数据库操作工具类
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package: 游戏柜交易平台
 ==================================*/
! IN_SYS && exit('forbiden 403!');
class Mysql{
    private $conn;
    public function __construct($c){
        ! isset($c['port']) && $c['port'] = '3306';
        $server = $c['host'] . ':' . $c['port'];
        $this->conn = new mysqli($c['host'], $c['username'], $c['password'], $c['dbname'], $c['port']) or die('connect db error');
        $c['charset'] && $this->conn->set_charset("utf8");

    }
    /**
     * 执行 mysql_query 并返回其结果.
     */
    public function query($sql){
        $result = $this->conn->query($sql);
        return $result;
    }
    /**
     * 执行 SQL 语句, 返回结果的第一条记录(是一个对象).
     */
    public function get($sql){
        $result = $this->query($sql);
        if($row = $result->fetch_assoc()){
            return $row;
        }else{
            return false;
        }
    }
    /**
     * 返回查询结果集, 以 key 为键组织成关联数组, 每一个元素是一个对象.
     * 如果 key 为空, 则将结果组织成普通的数组.
     */
    public function find($sql, $key=null){
        $data = array();
        $result = $this->query($sql);
        if ($result) {
            while($row = $result->fetch_assoc()){
                if(!empty($key)){
                    $data[$row[$key]] = $row;
                }else{
                    $data[] = $row;
                }
            }
        }

        return $data;
    }

    public function last_insert_id(){
        return $this->conn->insert_id;
    }

    /**
     * 执行一条带有结果集计数的 count SQL 语句, 并返该计数.
     */
    public function count($sql){
        $result = $this->query($sql);
        return $result->num_rows+0;
    }

    /**
     * 获取指定编号的记录.
     * @param int $id 要获取的记录的编号.
     * @param string $field 字段名, 默认为'id'.
     */
    public function load($table, $id, $field='id'){
        $sql = "SELECT * FROM `{$table}` WHERE `{$field}`='{$id}'";
        $row = $this->get($sql);
        return $row;
    }
    
    
    /**
     * 获取质变编号的记录(多字段查询)
     * @param type $table 表名
     * @param type $field 字段数组
     * @return type 返回一个结果集
     */
    public function load_array($table, $field = array(), $get = '*')
    {
        $text = '';
        foreach ($field as $k => $v) {
            $text .= "`$k`='$v' AND ";
        }
        unset($k, $v);
        $text = substr($text, 0, -5);
        $field_data = '';
        if (is_array($get)) {
            foreach ($get as $v) {
                $field_data .= "`$v`,";
            }
            unset($v);
            $field_data = substr($field_data, 0, -1);
        } else {
            $field_data = $get;
        }
        $sql = "SELECT $field_data FROM `$table` WHERE $text";
        $row = $this->find($sql);
        return $row;
    }

    /**
     * 保存一条记录
     * @param object $row
     */
    public function save($table, &$row){
        $sqlA = '';
        foreach($row as $k=>$v){
            $sqlA .= "`$k` = '$v',";
        }
        $sqlA = substr($sqlA, 0, -1);
        $sql  = "INSERT INTO `{$table}` SET $sqlA";
        if($this->query($sql)){
            return $this->last_insert_id();
        }else{
            return false;
        }
    }

    /**
     * 更新$arr[id]所指定的记录.
     * @param array $row 要更新的记录, 键名为id的数组项的值指示了所要更新的记录.
     * @return int 影响的行数.
     * @param string $field 字段名, 默认为'id'.
     */
    public function update($table, &$row, $field='id'){
        $sqlF = '';
        foreach($row as $k=>$v){
            $sqlF .= "`$k` = '$v',";
        }
        $sqlF = substr($sqlF, 0, -1);
        if(is_object($row)){
            $id = $row->{$field};
        }else{
            $id = $row[$field];
        }
        $sql  = "UPDATE `{$table}` SET $sqlF WHERE `{$field}`='$id'";
        return $this->query($sql);
    }
    
    /**
     * 更新$arr[id]所指定的记录.
     * @param array $row 要更新的记录, 键名为id的数组项的值指示了所要更新的记录.
     * @return int 影响的行数.
     * @param string $field 字段名, 默认为'id'.
     */
    public function update_array($table, $row = array(), $field = array(), $content = 'AND'){
        if (strpos($table, '.') !== false) {
            $table_array = explode('.', $table);
            if (isset($table_array[2])) {
                return false;
            }
            $table = "`{$table_array[0]}`.`{$table_array[1]}`";
        } else {
            $table = "`$table`";
        }
        $sqlF = '';
        foreach($row as $k=>$v){
            $sqlF .= "`$k` = '$v',";
        }
        unset($k, $v);
        $sqlF = substr($sqlF, 0, -1);
        $where = '';
        foreach ($field as $k => $v) {
            $where .= "`$k`='$v' $content";
        }
        unset($k, $v);
        $where = substr($where, 0, -3);
        $sql  = "UPDATE $table SET $sqlF WHERE $where";
        return $this->query($sql);
    }

    /**
     * 删除一条记录.
     * @param int $id 要删除的记录编号.
     * @return int 影响的行数.
     * @param string $field 字段名, 默认为'id'.
     */
    public function remove($table, $id, $field='id'){
        $sql  = "DELETE FROM `{$table}` WHERE `{$field}`='{$id}'";
        return $this->query($sql);
    }
    
    /*设置事务自动提交方式,默认是false，即手动提交*/
    public function setAutoCommit($check=false)
    {
        $this->conn->autocommit($check);
    }
    
    /*开始一个事务.*/
    public function begin(){
        $this->conn->autocommit(false);
    }
    /* 提交一个事务.*/
    public function commit(){
        $this->conn->commit();
    }
    /*回滚一个事务.*/
    public function rollback(){
        $this->conn->rollback();
    }
    //析构函数释放连接资源
    public function __destruct()
    {
       $this->conn->close();
    }
    
    public function real_escape_string($data)
    {
        return $this->conn->real_escape_string($data);
    }
    
//    function escape(&$val){
//        if(is_object($val) || is_array($val)){
//            $this->escape_row($val);
//        }
//    }
//
//    function escape_row(&$row){
//        if(is_object($row)){
//            foreach($row as $k=>$v){
//                $row->$k = mysql_real_escape_string($v);
//            }
//        }else if(is_array($row)){
//            foreach($row as $k=>$v){
//                $row[$k] = mysql_real_escape_string($v);
//            }
//        }
//    }
//
//    function escape_like_string($str){
//        $find = array('%', '_');
//        $replace = array('\%', '\_');
//        $str = str_replace($find, $replace, $str);
//        return $str;
//    }
}