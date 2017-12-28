<?php
echo "<?php";
?>
<cms action="SQL" return="list" query="select g.GameName,p.GameImg,p.GameFeature,g.GameWeb,g.GiftUrl,g.ServerUrl,g.GameTypeId,g.GameThemeId,g.GameInitialId from 91yxq_publish_7 as p inner join 91yxq_publish_5 as g on g.PlatformId=p.PlatformId and g.GameId=p.GameId where p.NodeID=35 and p.SortPriority>0 order by p.SortPriority desc " />

return array(
<loop name="list" key="key" var="var">
<if test="$key>0">,
</if>
	[$key] => array(
		'GameName'=>'[$var.GameName]',
		'GameImg'=>'[$var.GameImg]',
		'GameFeature'=>'[$var.GameFeature]',
		'GameWeb'=>'[$var.GameWeb]',
		'GiftUrl'=>'[$var.GiftUrl]',
		'ServerUrl'=>'[$var.ServerUrl]',
		'GameTypeId'=>'[$var.GameTypeId]',
		'GameThemeId'=>'[$var.GameThemeId]',
		'GameInitialId'=>'[$var.GameInitialId]'

	)</loop>

);



<?php
echo "?>";
?>