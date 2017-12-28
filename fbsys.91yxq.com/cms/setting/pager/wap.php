<?php
$contentArray = wapautopage( web2wap( $publishInfo[$mainContentLabel] ) );
$PageNum = count( $contentArray );
$pagenum_pre = 0;
foreach ( $contentArray as $key => $var )
{
				if ( $publishInfo[SelfPublishFileName] != "" )
				{
								$publishFileName = $publishInfo[SelfPublishFileName];
				}
				else
				{
								eval( "\$publishFileName = \"{$PublishFileFormat}\";" );
				}
				$pagelist = wap_page( $PageNum, $key + 1, $publishFileName );
				if ( !empty( $this->NodeInfo[SubDir] ) && empty( $publishInfo[SelfPSNURL] ) )
				{
								if ( $this->NodeInfo[SubDir] == "auto" )
								{
												$publishFileName = $this->makeindexsavepath( $IndexID )."/".$publishFileName;
								}
								else
								{
												$publishFileName = date( $this->NodeInfo[SubDir], $this->publishInfo[CreationDate] )."/".$publishFileName;
								}
				}
				else if ( !empty( $publishInfo[SelfPSNURL] ) )
				{
								$publishFileName = $publishFileName;
				}
				$realURL = $this->gethtmlurl( $publishFileName );
				$template->assign( "URL", $realURL );
				if ( $key == 0 && ( $this->publishInfo[Type] == 1 || $this->publishInfo[Type] == 0 || $this->publishInfo[Type] == 3 ) )
				{
								$FieldsInfo = content_table_admin::gettablefieldsinfo( $NodeInfo[TableID] );
								$this->flushdata( );
								foreach ( $FieldsInfo as $keyIn => $varIn )
								{
												if ( empty( $varIn['EnablePublish'] ) )
												{
												}
												else
												{
																$this->adddata( $varIn[FieldName], $publishInfo[$varIn[FieldName]] );
												}
								}
								$this->adddata( "IndexID", $publishInfo[IndexID] );
								$this->adddata( "ContentID", $publishInfo[ContentID] );
								$this->adddata( "NodeID", $publishInfo[NodeID] );
								$this->adddata( "PublishDate", $publishInfo[PublishDate] );
								$this->adddata( "URL", $realURL );
								$publishInfo['URL'] = $realURL;
								$this->publishupdate( $NodeInfo['TableID'] );
								if ( !isset( $Plugin ) )
								{
												require_once( INCLUDE_PATH."admin/plugin.class.php" );
												$Plugin = new plugin( );
								}
								$Plugin->update( $publishInfo );
				}
				$template->assign( "PageNum", $key + 1 );
				$template->assign( $_pageList, $pagelist );
				$template->assign( $mainContentLabel, $contentArray[$key] );
				$output = $template->fetch( $tplname );
				if ( $pagenum_pre == 0 )
				{
								$sign = "";
				}
				else
				{
								$sign = "_".$pagenum_pre;
				}
				$publishFileName = preg_replace( "/\\.([A-Za-z0-9]+)\$/isU", $sign.".\\1", $publishFileName );
				if ( $this->_publishing( $publishFileName, $output ) )
				{
								$right = true;
				}
				else
				{
								$right = false;
				}
				++$pagenum_pre;
}
if ( $publishInfo[SelfPublishFileName] != "" )
{
				$publishFileName = $publishInfo[SelfPublishFileName];
}
else
{
				eval( "\$publishFileName = \"{$PublishFileFormat}\";" );
}
if ( !empty( $this->NodeInfo[SubDir] ) && empty( $publishInfo[SelfPSNURL] ) )
{
				$publishFileName = date( $this->NodeInfo[SubDir], $this->publishInfo[CreationDate] )."/".$publishFileName;
}
else if ( !empty( $publishInfo[SelfPSNURL] ) )
{
				$publishFileName = $publishFileName;
}
?>
