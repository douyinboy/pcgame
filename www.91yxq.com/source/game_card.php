<?php
define('EMPTY',0);
define('ERR',1);
class CardGenerate2 {
    CONST KEY = 'ed8642e4cb54f2783fdd258e63a8e28d';
    public $user;
    public $spid;
    public $server_num;
    public $card_type;
    public function __construct($user, $spid, $server_num, $card_type) {
        $this->user = $user;
        $this->spid = $spid;
        $this->server_num = $server_num;
        $this->card_type = $card_type;
    }
    function card_sn() {
        if (! $this->spid || ! $this->user || ! $this->server_num || ! $this->card_type) {
            return null;
        }
        $md5 = md5 ( $this->user . $this->card_type . $this->server_num . $this->spid . static::KEY );
        $str_first = substr ( $md5, 0, 16 );
        $str_end = substr ( $md5, 16 );
        $crc32_first = str_pad ( crc32 ( $str_first ), 10, 0 );
        $crc32_end = str_pad ( crc32 ( $str_end ), 10, 0 );
        $card_sn = $crc32_first . $crc32_end;
        $card_sn = substr ( $card_sn, 0, 18 );
        return $card_sn;
    }
}

class game_card{
    public $type ;
    public $server_id;
    public $uname;
    public $game;
    public $table;
    public $db;

    function __construct($type, $server_id, $uname, $game, $db){
        $this->type = $type;
        $this->game = $game;
        $this->server_id = $server_id;
        $this->db    = $db;
    }

    public function main(){
        $table = '';
        switch ($this->game) {
            case 1:
                $table='wj';
                break;
            case 2:
                $table='mhj';
                break;
            case 3:
                $table='wssb';
                break;
            case 4:
                $table='zlcq';
                break;
            case 6:
                $table='ws2';
                break;
            case 7:
                $table='rxsg2';
                break;
            default:;
                break;
        }
        $this->table = 'card_'.$table;
        $result='no';
        if($table=='wssb'){
            $result = md5("wssbs{$this->server_id}{$_SESSION["login"]["uid"]}6qwan-23hsh-n8g-sdbkj12");
        }else if($table=='zlcq'){
            $card = new CardGenerate2 ( $_SESSION["login"]["uid"].'_6qw', '6qw', $this ->server_id, $this ->type );
            $result = $card->card_sn();
        }else if($table=='ws2'){
            $result = md5("wssbs{$this->server_id}{$_SESSION["login"]["uid"]}6qwan2-2pj3-0u0-wjeoj-rr");
        }else if($this->table!='card_'){
            $result=$this->get_card();
        }
        echo $result;
    }


    /**
     * 1新手;2媒体大礼包;3武学至尊礼包;4仙宠黄金礼包
     * @var unknown_type
     */
    private function get_card(){
        $card = 'empty';
        $this->db->autocommit(FALSE);
        try {
            $sql = 'select id,card_id,state from '.$this->table.' where server_id='.$this->server_id.' and user_name="'.$_SESSION["login"]["username"].'" and type='.$this->type;
            $list=$this->db->get($sql);
            $card=$list['card_id'];
            if($list['state']==0){
                $card = $this->insert_card();
            }
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollback();
        }
        return $card;
    }

    private function insert_card(){
        $arr = array('card_wj','card_mhj','card_rxsg2');
        $where ='';
        if(!in_array($this->table,$arr)){
            $where = ' and server_id='.$this->server_id;
        }
        $sql='select id,card_id from '.$this->table.' where user_name IS NULL and state=0 and type='.$this->type.$where.' limit 1';
        $list=$this->db->get($sql);
        if($list['id']){
            $set ='';
            if(in_array($this->table,$arr)){
                $set = ', server_id='.$this->server_id;
            }
            $sql='update '.$this->table.' set user_name="'.$_SESSION["login"]["username"].'",state=1 '.$set.' where id='.$list['id'];
            $this->db->query($sql);
        }
        return $list['card_id'] ? $list['card_id'] : 'empty';
    }
}