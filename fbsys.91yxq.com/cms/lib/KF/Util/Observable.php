<?php
class KF_Util_Observable
{

				public $changed = false;
				public $observers = array( );

				public function KF_Util_Observable( )
				{
				}

				public function addObserver( &$o )
				{
								if ( $o == null )
								{
												return false;
								}
								$i = 0;
								for ( ;	$i < count( $this->observers );	++$i	)
								{
												if ( $this->observers[$i] == $o )
												{
																return false;
												}
								}
								$this->observers[] =& $o;
								return true;
				}

				public function removeObserver( &$o )
				{
								$i = 0;
								for ( ;	$i < count( $this->observers );	++$i	)
								{
												if ( $this->observers[i] == $o )
												{
																array_splice( $this->observers, $i, 1 );
																return true;
												}
								}
								return false;
				}

				public function notifyObservers( &$infoObj )
				{
								if ( !$this->changed )
								{
												return;
								}
								$this->clearChanged( );
								$i = count( $this->observers ) - 1;
								for ( ;	0 <= $i;	--$i	)
								{
												$tmp =& $this->observers[$i];
												$tmp->update( $this, $infoObj );
								}
				}

				public function clearObservers( )
				{
								$this->observers = array( );
				}

				public function setChanged( )
				{
								$this->changed = true;
				}

				public function clearChanged( )
				{
								$this->changed = false;
				}

				public function hasChanged( )
				{
								return $this->changed;
				}

				public function countObservers( )
				{
								return count( $this->observers );
				}

}

?>
