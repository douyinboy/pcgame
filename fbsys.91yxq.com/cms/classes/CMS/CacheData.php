<?php
class CMS_CacheData
{

				public $cacheData = NULL;

				public function CMS_CacheData( )
				{
								require_once( INCLUDE_PATH."admin/cache.class.php" );
								$this->cacheData = new CacheData( );
				}

				public function &getInstance( )
				{
								return $this->cacheData;
				}

}

?>
