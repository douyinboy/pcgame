<?php
/*
 * 免登陆游戏账号 【分游戏】
 * 
*/
$gameid=$_REQUEST['game_id'];
$act=intval($_REQUEST['act'])+0;
if($gameid==45){  //混沌战域
    $user_name=array(
        array('id'=>1,'name'=>'qiquhdzy1'),
        array('id'=>2,'name'=>'qiquhdzy2'),
        array('id'=>3,'name'=>'qiquhdzy3'),
        array('id'=>4,'name'=>'qiquhdzy4'),
        array('id'=>5,'name'=>'qiquhdzy5'),
        array('id'=>6,'name'=>'qiquhdzy6'),
        array('id'=>7,'name'=>'qiquhdzy7'),
        array('id'=>8,'name'=>'qiquhdzy8'),
        array('id'=>9,'name'=>'qiquhdzy9'),
        array('id'=>10,'name'=>'qiquhdzy10')   
    );
}
elseif($gameid==55){  //诸神黄昏
    $user_name=array(
        array('id'=>1,'name'=>'zhushenbaqi'),
        array('id'=>2,'name'=>'78sd_ewes'),
        array('id'=>3,'name'=>'wanmei_582'),
        array('id'=>4,'name'=>'shenmingguihuan00'),
        array('id'=>5,'name'=>'9eee222ffz'),
        array('id'=>6,'name'=>'gas2eq4ws'),
        array('id'=>7,'name'=>'zhushengyui80'),
        array('id'=>8,'name'=>'dfasad_ewi88'),
        array('id'=>9,'name'=>'jzk990402'),
        array('id'=>10,'name'=>'esesq58521'),
        array('id'=>11,'name'=>'yeshizuile'),
        array('id'=>12,'name'=>'jiangshan_huo'),
        array('id'=>13,'name'=>'qoeiei')
    );
}
$data=$user_name;
if($act >0){
    echo json_encode($data); 
}
?>
