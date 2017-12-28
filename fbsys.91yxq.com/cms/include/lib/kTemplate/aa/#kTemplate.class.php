<?php
class kTemplate
{

				public $template_dir = "templates";
				public $compile_dir = "templates_c";
				public $compile_check = true;
				public $force_compile = false;
				public $caching = 0;
				public $cache_dir = "cache";
				public $lang_dir = "";
				public $compile_lang = true;
				public $cache_lifetime = 3600;
				public $client_caching = false;
				public $left_delimiter = "<";
				public $right_delimiter = ">";
				public $compilefile_prefix = "%%c_";
				public $tag_left_delim = "[";
				public $tag_right_delim = "]";
				public $registerParseFunArray = array( );
				public $regPreFilterArray = array( );
				public $_tpl_vars = array( );
				public $checkTplModify = true;
				public $forceCompile = false;
				public $autoRepair = false;
				public $enableMark = true;
				public $source = NULL;
				public $compiler_file = "kTemplate_Compiler.class.php";
				public $compiler_class = "kTemplate_Compiler";
				public $is_compile_php = true;
				public $cache_use_sub_dirs = false;
				public $add_meta_mark = true;

				public function kTemplate( $params = NULL )
				{
								if ( isset( $params['template_dir'] ) )
								{
												$this->template_dir = $params['template_dir'];
								}
								else
								{
												$this->template_dir = SYS_PATH."skin/admin/";
								}
								if ( isset( $params['compile_dir'] ) )
								{
												$this->compile_dir = $params['compile_dir'];
								}
								else
								{
												$this->compile_dir = CACHE_DIR."templates_c/";
								}
								if ( isset( $params['cache_dir'] ) )
								{
												$this->cache_dir = $params['cache_dir'];
								}
								else
								{
												$this->cache_dir = CACHE_DIR."cache/";
								}
								if ( isset( $params['lang_dir'] ) )
								{
												$this->cache_dir = $params['lang_dir'];
								}
				}

				public function assign( $tpl_var, $value = null )
				{
								if ( is_array( $tpl_var ) )
								{
												foreach ( $tpl_var as $key => $val )
												{
																if ( $key != "" )
																{
																				$this->_tpl_vars[$key] = $val;
																}
												}
								}
								else if ( $tpl_var != "" )
								{
												$this->_tpl_vars[$tpl_var] = $value;
								}
				}

				public function assign_by_ref( $tpl_var, &$value )
				{
								if ( $tpl_var != "" )
								{
												$this->_tpl_vars[$tpl_var] =& $value;
								}
				}

				public function getVar( $tpl_var )
				{
								return $this->_tpl_vars[$tpl_var];
				}

				public function _compile( $file_name )
				{
								if ( file_exists( KTPL_DIR.$this->compiler_file ) )
								{
												require_once( KTPL_DIR.$this->compiler_file );
								}
								else
								{
												exit( "Compiler does not exits!" );
								}
								$kTemplate_compiler = new $this->compiler_class( );
								$kTemplate_compiler->template_dir = $this->template_dir;
								$kTemplate_compiler->compile_dir = $this->compile_dir;
								$kTemplate_compiler->lang_dir = $this->lang_dir;
								$kTemplate_compiler->compile_lang = $this->compile_lang;
								$kTemplate_compiler->registerParseFunArray = $this->registerParseFunArray;
								$kTemplate_compiler->regPreFilterArray = $this->regPreFilterArray;
								$kTemplate_compiler->compilefile_prefix = $this->compilefile_prefix;
								$kTemplate_compiler->left_delimiter = $this->left_delimiter;
								$kTemplate_compiler->right_delimiter = $this->right_delimiter;
								$kTemplate_compiler->tag_left_delim = $this->tag_left_delim;
								$kTemplate_compiler->tag_right_delim = $this->tag_right_delim;
								$kTemplate_compiler->autoRepair = $this->autoRepair;
								$kTemplate_compiler->template_name = $this->template_name;
								$kTemplate_compiler->is_compile_php = $this->is_compile_php;
								$kTemplate_compiler->add_meta_mark = $this->add_meta_mark;
								if ( $kTemplate_compiler->compile( $file_name, $this->compilefile_prefix.$this->format( $this->template_name ) ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function _compile_output( &$content )
				{
								if ( file_exists( KTPL_DIR.$this->compiler_file ) )
								{
												require_once( KTPL_DIR.$this->compiler_file );
								}
								else
								{
												exit( "Compiler does not exits!" );
								}
								$kTemplate_compiler = new $this->compiler_class( );
								$kTemplate_compiler->template_dir = $this->template_dir;
								$kTemplate_compiler->compile_dir = $this->compile_dir;
								$kTemplate_compiler->lang_dir = $this->lang_dir;
								$kTemplate_compiler->compile_lang = $this->compile_lang;
								$kTemplate_compiler->registerParseFunArray = $this->registerParseFunArray;
								$kTemplate_compiler->regPreFilterArray = $this->regPreFilterArray;
								$kTemplate_compiler->compilefile_prefix = $this->compilefile_prefix;
								$kTemplate_compiler->left_delimiter = $this->left_delimiter;
								$kTemplate_compiler->right_delimiter = $this->right_delimiter;
								$kTemplate_compiler->tag_left_delim = $this->tag_left_delim;
								$kTemplate_compiler->tag_right_delim = $this->tag_right_delim;
								$kTemplate_compiler->autoRepair = $this->autoRepair;
								$kTemplate_compiler->_compile_php( $content );
				}

				public function registerParseFun( $functionName )
				{
								$this->registerParseFunArray[] = $functionName;
				}

				public function registerPreFilter( $functionName )
				{
								$this->regPreFilterArray[] = $functionName;
				}

				public function registerCacheFun( $functionName )
				{
								$this->registerCacheFunArray[] = $functionName;
				}

				public function cachePreFilter( &$contents )
				{
								if ( !empty( $this->registerCacheFunArray ) )
								{
												foreach ( $this->registerCacheFunArray as $var )
												{
																if ( function_exists( $var ) )
																{
																				$contents = $var( $contents );
																}
												}
								}
				}

				public function isCompiled( )
				{
								if ( !file_exists( $this->compile_name ) )
								{
												return false;
								}
								$expire = filemtime( $this->compile_name ) == filemtime( $this->template_name ) ? true : false;
								if ( $expire )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function is_cached( $file_name, $cache_id = NULL )
				{
								if ( $this->cached )
								{
												return true;
								}
								$this->cache_name = $this->getCacheFileName( $file_name, $cache_id );
								if ( !file_exists( $this->cache_name ) )
								{
												return false;
								}
								if ( !( $mtime = filemtime( $this->cache_name ) ) )
								{
												return false;
								}
								$this->cache_expire_time = $mtime + $this->cache_lifetime - time( );
								if ( $mtime + $this->cache_lifetime < time( ) )
								{
												unlink( $this->cache_name );
												return false;
								}
								else
								{
												$this->cached = true;
												return true;
								}
				}

				public function clear_all_assign( )
				{
								$this->_tpl_vars = array( );
				}

				public function _fetch( $file, $compile = 0 )
				{
								ob_start( );
								if ( file_exists( $this->lang_name ) )
								{
												include_once( $this->lang_name );
								}
								if ( file_exists( $this->template_name.".php" ) )
								{
												include( $this->template_name.".php" );
								}
								if ( file_exists( $this->global_lang_name ) )
								{
												include( $this->global_lang_name );
								}
								include( $file );
								$contents = ob_get_contents( );
								ob_end_clean( );
								if ( $this->enableMark )
								{
												$contents = empty( $SYS_ENV['CMSware_Mark'] ) ? $contents : $contents.$SYS_ENV['CMSware_Mark'];
								}
								$contents = empty( $SYS_ENV['CMSware_Powered'] ) ? $contents : preg_replace( "'(<title>)(.*)(</title>)'isU", "\\1\\2".$SYS_ENV['CMSware_Powered']."\\3", $contents );
								if ( $compile )
								{
												$this->_compile_output( $contents );
								}
								return $contents;
				}

				public function format( $file_name )
				{
								$file_name = str_replace( ":", "_", $file_name );
								$file_name = str_replace( "/", "@", $file_name );
								$file_name = str_replace( "\\", "@", $file_name );
								$file_name = str_replace( "..", "^", $file_name );
								return $file_name;
				}

				public function getCacheFileName( $_tplname, $_cacheid )
				{
								return $this->_get_auto_filename( $this->cache_dir, $_tplname.$_cacheid.".cache" );
				}

				public function _get_auto_filename( $auto_base, $auto_source = null, $auto_id = null )
				{
								$_compile_dir_sep = $this->cache_use_sub_dirs ? DIRECTORY_SEPARATOR : "^";
								$_return = $auto_base.DIRECTORY_SEPARATOR;
								if ( isset( $auto_id ) )
								{
												$auto_id = str_replace( "%7C", $_compile_dir_sep, urlencode( $auto_id ) );
												$_return .= $auto_id.$_compile_dir_sep;
								}
								if ( isset( $auto_source ) )
								{
												$_filename = urlencode( basename( $auto_source ) );
												$_crc32 = sprintf( "%08X", crc32( $auto_source ) );
												$_crc32 = substr( $_crc32, 0, 2 ).$_compile_dir_sep.substr( $_crc32, 0, 3 ).$_compile_dir_sep.$_crc32;
												$_return .= "%%".$_crc32."%%".$_filename;
								}
								return $_return;
				}

				public function fetch( $file_name, $compile = 0 )
				{
								global $Error;
								global $TemplateError;
								if ( is_object( $Error ) )
								{
												if ( !is_object( $TemplateError ) && file_exists( SYS_PATH."include/templateError.php" ) )
												{
																require_once( SYS_PATH."include/templateError.php" );
																$TemplateError = new TemplateError( );
												}
												if ( is_object( $TemplateError ) )
												{
																$TemplateError->setErrorHander( );
												}
								}
								$this->template_name = $this->template_dir.$file_name;
								$this->compile_name = $this->compile_dir.$this->compilefile_prefix.$this->format( $this->template_name );
								if ( empty( $this->lang_dir ) )
								{
												$this->lang_dir = $this->template_dir;
								}
								$this->lang_name = $this->lang_dir.$file_name.".php";
								if ( $this->forceCompile )
								{
												if ( $this->_compile( $this->template_name ) )
												{
																$contents = $this->_fetch( $this->compile_name, $compile );
												}
								}
								else
								{
												if ( $this->checkTplModify )
												{
																if ( !$this->isCompiled( ) )
																{
																				if ( $this->_compile( $this->template_name ) )
																				{
																								$contents = $this->_fetch( $this->compile_name, $compile );
																				}
																}
																else
																{
																				$contents = $this->_fetch( $this->compile_name, $compile );
																}
												}
												else
												{
																ob_start( );
																if ( file_exists( $this->lang_name ) )
																{
																				include( $this->lang_name );
																}
																if ( file_exists( $this->template_name.".php" ) )
																{
																				include( $this->template_name.".php" );
																}
																include( $this->global_lang_name );
																if ( !include( $this->compile_name ) && $this->_compile( $this->template_name ) )
																{
																				include( $this->compile_name );
																}
																$contents = ob_get_contents( );
																ob_end_clean( );
																if ( $this->enableMark )
																{
																				$contents = empty( $SYS_ENV['CMSware_Mark'] ) ? $contents : $contents.$SYS_ENV['CMSware_Mark'];
																}
																if ( $compile )
																{
																				$contents = $this->_compile_output( $contents );
																}
												}
								}
								if ( is_object( $Error ) )
								{
												$Error->setErrorHander( );
								}
								return $contents;
				}

				public function fetch_cache( $file_name, $cache_id, $compile = 0 )
				{
								$this->cache_name = $this->getCacheFileName( $file_name, $cache_id );
								if ( $fp = @fopen( $this->cache_name, "r" ) )
								{
												$contents = fread( $fp, filesize( $this->cache_name ) );
												fclose( $fp );
												return $contents;
								}
								else
								{
												$contents = $this->fetch( $file_name, $compile );
												$this->cachePreFilter( $contents );
												if ( File::autowrite( $this->cache_name, $contents ) )
												{
												}
												else
												{
																exit( "Unable to write cache." );
												}
												return $contents;
								}
				}

				public function clear_cache( $file_name, $cache_id )
				{
								$this->cache_name = $this->getCacheFileName( $file_name, $cache_id );
								if ( file_exists( $this->cache_name ) )
								{
												return unlink( $this->cache_name );
								}
								else
								{
												return true;
								}
				}

				public function display( $file_name, $enable_gzip = NULL )
				{
								$this->is_compile_php = false;
								if ( !empty( $enable_gzip ) || $SYS_ENV['enable_gzip'] )
								{
												$buffer = $this->fetch( $file_name );
												if ( !ini_get( "zlib.output_compression" ) )
												{
																ob_start( "ob_gzhandler" );
												}
												print $buffer;
								}
								else
								{
												print $this->fetch( $file_name );
								}
				}

				public function display_cache( $file_name, $cache_id = NULL, $enable_gzip = NULL )
				{
								if ( $this->client_caching )
								{
												header( "Last-Modified: ".gmdate( "D, d M Y H:i:s", time( ) + $this->cache_expire_time )." GMT" );
												header( "Expires: ".gmdate( "D, d M Y H:i:s", time( ) + $this->cache_expire_time )." GMT" );
								}
								if ( empty( $enable_gzip ) )
								{
												print $this->fetch_cache( $file_name, $cache_id );
								}
								else
								{
												$buffer = $this->fetch_cache( $file_name, $cache_id );
												ob_start( "ob_gzhandler" );
												print $buffer;
								}
				}

				public function run_cache( $file_name, $cache_id = NULL, $enable_gzip = NULL )
				{
								$this->cache_name = $this->getCacheFileName( $file_name, $cache_id );
								if ( empty( $enable_gzip ) )
								{
												if ( file_exists( $this->cache_name ) )
												{
																include( $this->cache_name );
												}
												else
												{
																$contents = $this->fetch( $file_name, 1 );
																if ( File::autowrite( $this->cache_name, $contents ) )
																{
																}
																else
																{
																				exit( "Unable to write cache." );
																}
																include( $this->cache_name );
												}
								}
								else
								{
												ob_start( "ob_gzhandler" );
												if ( file_exists( $this->cache_name ) )
												{
																include( $this->cache_name );
												}
												else
												{
																$contents = $this->fetch( $file_name, 1 );
																if ( File::autowrite( $this->cache_name, $contents ) )
																{
																}
																else
																{
																				exit( "Unable to write cache." );
																}
																include( $this->cache_name );
												}
								}
				}

}

?>
