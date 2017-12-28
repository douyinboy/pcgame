<?php
 /**==============================
  * 数据操作公共模型类
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ===============================*/
class comModel{
    public $db;
//表查询操作设置定义
    private $table ='';
    private $key = 'id';
    private $sql;
    public $fields =false; //仅支持数组，不设置则为*
    public $where ='';     //支持数组和字串赋值
    public $groupby ='';   //支持字串
    public $sort ='';     //支持数组和字串赋值
    public $limit = 0;   //接收指定条目和起止设置:【20 / '0, 20'】
    public $like ='';     //支持数组和字串赋值
    public $count;
    public $result;

    public function __construct(){
        global $db;
        $this ->db = $db;
    }

    //设置sql
    public function setSql($q){
        $this ->sql = $q;
    }

    //获取sql
    public function getSql(){
        return $this ->sql;
    }
    //获取sql
    public function csSql($countFlag = false){
        $wheres = ' WHERE 1 ';
        if(is_array($this ->where) && count($this ->where)>0){
            foreach($this ->where as $k =>$v){
                $wheres .= 'AND `'.$k.'` = "'.$v.'" ';
            }
        }else{
           $wheres .= $this ->where;
        }
        if(is_array($this ->like) && count($this ->like)>0){
            foreach($this ->like as $k =>$v){
                $wheres .= ' AND '.$k.' like "%'.$v.'%" ';
            }
        }else{
           $wheres .=  $this ->like;
        }
        $sorts = ' ORDER BY ';
        if(is_array($this ->sort) && count($this ->sort)>0){
            foreach($this ->where as $k =>$v){
                $sorts .= $k.' ' . $v . ',';
            }
            $sorts = substr($sorts, 0, -1);
        }else{
            if($this ->sort != '')
                $sorts .= $this ->sort;
            else
                $sorts ='';
        }
        $this ->groupby != '' && $this ->groupby = ' GROUP BY '.$this ->groupby;

        if($countFlag){
            $getFields = "count(*)";
        }else{
            $getFields = $this ->fields?implode(',', $this ->fields) : '*';
        }
        $this ->sql = "SELECT ".$getFields." FROM ".(is_array($this ->table)?implode(',', $this ->table):$this ->table) . $wheres . $this ->groupby;
        !$countFlag && $this ->sql .= $sorts . (($this ->limit != 0) ? ' LIMIT '.$this ->limit : '');
        return $this ->sql;
    }

    //获取列表
    public function find($sortKey = null){
        $this ->result = $this ->db ->find($this ->sql, $sortKey);
        return $this ->result;
    }

    //获取第一条记录
    public function getOne(){
        $this ->result = $this ->db ->get($this ->sql);
        return $this ->result;
    }
    
    //获取条目
    public function count(){
        $sqlT = $this ->csSql(true);
        $this ->count = $this ->db ->count($sqlT);
        return $this ->count;
    }

//===============================简单操作方法集=============================
    //设置key
    public function setKey($val){
        $this ->key = $val;
    }
    //设置table
    public function setTable($t){
        $this ->table = $t;
    }
     //设置key
    public function getKey(){
       return $this ->key;
    }
    //设置table
    public function getTable(){
        return $this ->table;
    }
    //获取单条
    public function getOneRecordByKey($id){
        $this ->result = $this ->db -> load($this ->table, $id, $this ->key);
        return $this ->result;
    }
    //添加一条记录
    public function addRecord($fieldsVal){
        $this ->result = $this ->db ->save($this ->table, $fieldsVal);
        return $this ->result;
    }
    //修改指定条目
    public function upRecordByKey($fieldsVal){
        $this ->result = $this ->db ->update($this ->table, $fieldsVal, $this ->key);
        return $this ->result;
    }
    //删除一条记录
    public function delRecordByKey($id){
        $this ->result = $this ->db ->remove($this ->table, $id, $this ->key);
        return $this ->result;
    }
    //删除多条记录
    public function delMultRowsByKey($keyarr){
        foreach($keyarr as $v)
            $this ->db ->remove($this ->table, $v, $this ->key);
        return true;
    }

//===============================简单操作方法集 END==============================
}
