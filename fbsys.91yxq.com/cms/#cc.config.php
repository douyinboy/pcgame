<?php
//CC视频联盟for cmsware新闻编辑器插件配置文件，请先到CC视频联盟申请帐号并记下数字用户ID
//注意：请在CC管理后台中"域名管理"页增加好放插件的域名，增加域名时选择“思维CMS”

$cc_userid = "45606"; //请填入你在CC视频联盟网站申请的用户ID号(数字)




//以下代码在不理解的情况下请勿随意更改
print "<!-- cc视频插件代码 --><object width='32' height='16'><param name='wmode' value='transparent' /><param name='allowScriptAccess' value='always' /><param name='movie' value='http://union.bokecc.com/flash/plugin/plugin_20.swf?userID={$cc_userid}&type=cmsware' /><embed src='http://union.bokecc.com/flash/plugin/plugin_20.swf?userID={$cc_userid}&type=cmsware' type='application/x-shockwave-flash' width='32' height='16' allowScriptAccess='always' wmode='transparent'></embed></object><!-- cc视频插件代码 -->";
?>