<?php
class CMS_Plugin
{

				public $plugin = NULL;

				public function CMS_Plugin( )
				{
								require_once( INCLUDE_PATH."admin/plugin.class.php" );
								$this->plugin = new Plugin( );
				}

				public function &getInstance( )
				{
								return $this->plugin;
				}

}

?>
