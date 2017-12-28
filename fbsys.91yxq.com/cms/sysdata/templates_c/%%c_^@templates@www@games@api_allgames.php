<?php
echo "<?php";
?>
<?php
 global $PageInfo,$params; 
 $params = array ( 
	'action' => "SQL",
	'return' => "list",
	'query' => "select g.GameName,p.GameImg,p.GameFeature,g.GameWeb,g.GiftUrl,g.ServerUrl,g.GameTypeId,g.GameThemeId,g.GameInitialId from 91yxq_publish_7 as p inner join 91yxq_publish_5 as g on g.PlatformId=p.PlatformId and g.GameId=p.GameId where p.NodeID=35 and p.SortPriority>0 order by p.SortPriority desc ",
 ); 
;
$this->_tpl_vars['list'] = CMS_SQL($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>

return array(
<?php if(!empty($this->_tpl_vars['list'] )): 
   foreach ($this->_tpl_vars['list'] as  $this->_tpl_vars['key']=>$this->_tpl_vars['var']): ?>
<?php if($this->_tpl_vars['key']>0): ?>,
<?php endif;?>
	<?php echo $this->_tpl_vars["key"];?> => array(
		'GameName'=>'<?php echo $this->_tpl_vars["var"]["GameName"];?>',
		'GameImg'=>'<?php echo $this->_tpl_vars["var"]["GameImg"];?>',
		'GameFeature'=>'<?php echo $this->_tpl_vars["var"]["GameFeature"];?>',
		'GameWeb'=>'<?php echo $this->_tpl_vars["var"]["GameWeb"];?>',
		'GiftUrl'=>'<?php echo $this->_tpl_vars["var"]["GiftUrl"];?>',
		'ServerUrl'=>'<?php echo $this->_tpl_vars["var"]["ServerUrl"];?>',
		'GameTypeId'=>'<?php echo $this->_tpl_vars["var"]["GameTypeId"];?>',
		'GameThemeId'=>'<?php echo $this->_tpl_vars["var"]["GameThemeId"];?>',
		'GameInitialId'=>'<?php echo $this->_tpl_vars["var"]["GameInitialId"];?>'

	)<?php endforeach; endif;?>

);



<?php
echo "?>";
?>