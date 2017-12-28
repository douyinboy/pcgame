<?php

function done( $a, $b, $c, $d, $e1, $f, $g, $h, $i, $j, $k, $l, $m )
{
	if ( !empty( $h ) )
	{
		$WhereH = "where=\"".$h."\"";
	}
	else
	{
		$WhereH = "";
	}
	switch ( $a )
	{
	case 1 :
		switch ( $e1 )
		{
		case 1 :
			if ( $i != "Default" )
			{
				$CustomName = $i;
			}
			else
			{
				$CustomName = "ListTable_".$c;
			}
			if ( $l != 2 )
			{
				$Rk = " returnKey=\"".$k."\"";
			}
			else
			{
				$Rk = "";
			}
			if ( $j != "Dis" )
			{
				$Ob = " Orderby=\"".$j."\"";
			}
			else
			{
				$Ob = "";
			}
			if ( $m != "Dis" )
			{
				$Od = " Order=\"".$m."\"";
			}
			else
			{
				$Od = "";
			}
			$reval = "";
			$reval .= "<!--#CW# This Code Lode TableID (".$c."), NodeID(".$b."), Content List Num(".$d.").  Add By CTLM #CW#-->\n";
			$reval .= "<CMS action=\"LIST\" return=\"".$CustomName."\"".$Rk." NodeID=\"".$b."\" TableID=\"".$c."\" ".$WhereH." Cache=\"1\" num=\"".$d."\"".$Ob.$Od." />\n";
			$reval .= "<ul>\n";
			$reval .= "<LOOP name=\"".$CustomName."\" var=\"var\" key=\"key\" start=\"1\">\n";
			$reval .= "<li><a href=\"[\$var.URL]\">[\$var.Title]</a></li>\n";
			$reval .= "</LOOP>\n";
			$reval .= "</ul>";
			return $reval;
		case 2 :
			if ( $i != "Default" )
			{
				$CustomName = $i;
			}
			else
			{
				$CustomName = "ListTable_".$c;
			}
			if ( $l != 2 )
			{
				$Rk = " returnKey=\"".$k."\"";
			}
			else
			{
				$Rk = "";
			}
			if ( $j != "Dis" )
			{
				$Ob = " Orderby=\"".$j."\"";
			}
			else
			{
				$Ob = "";
			}
			if ( $m != "Dis" )
			{
				$Od = " Order=\"".$m."\"";
			}
			else
			{
				$Od = "";
			}
			$reval = "";
			$reval .= "<!--#CW# This Code Lode TableID (".$c."), NodeID(".$b."), Content List Num(".$d.").  Add By CTLM #CW#-->\n";
			$reval .= "<CMS action=\"LIST\" return=\"".$CustomName."\"".$Rk." NodeID=\"".$b."\" TableID=\"".$c."\" ".$WhereH." Cache=\"1\" num=\"page-".$d."\"".$Ob.$Od." />\n";
			$reval .= "<ul>\n";
			$reval .= "<LOOP name=\"".$CustomName."\" var=\"var\" key=\"key\" start=\"1\">\n";
			$reval .= "<li><a href=\"[\$var.URL]\">[\$var.Title]</a></li>\n";
			$reval .= "</LOOP>\n";
			$reval .= "</ul>\n";
			$reval .= "<p>\n";
			$reval .= "[@list_page( \$PageInfo.TotalPage, \$PageInfo.CurrentPage, \$PageInfo.URL)]\n";
			$reval .= "</p>";
			return $reval;
		case 3 :
			if ( $i != "Default" )
			{
				$CustomName = $i;
			}
			else
			{
				$CustomName = "ListTable_".$c;
			}
			if ( $l != 2 )
			{
				$Rk = " returnKey=\"".$k."\"";
			}
			else
			{
				$Rk = "";
			}
			if ( $j != "Dis" )
			{
				$Ob = " Orderby=\"".$j."\"";
			}
			else
			{
				$Ob = "";
			}
			if ( $m != "Dis" )
			{
				$Od = " Order=\"".$m."\"";
			}
			else
			{
				$Od = "";
			}
			$reval = "";
			$reval .= "<!--#CW# This Code Lode TableID (".$c."), NodeID(".$b."), Content List Num(".$d.").  Add By CTLM #CW#-->\n";
			$reval .= "<CMS action=\"LIST\" return=\"".$CustomName."\"".$Rk." NodeID=\"".$b."\" TableID=\"".$c."\" ".$WhereH." Cache=\"1\" num=\"page-".$d."\"".$Ob.$Od." />\n";
			$reval .= "<ul>\n";
			$reval .= "<LOOP name=\"".$CustomName."\" var=\"var\" key=\"key\" start=\"1\">\n";
			$reval .= "<li><a href=\"[\$var.URL]\">[\$var.Title]</a></li>\n";
			$reval .= "</LOOP>\n";
			$reval .= "</ul>\n";
			$reval .= "<p>\n";
			$reval .= "[@IndexPage(\$PageInfo.TotalPage, \$PageInfo.CurrentPage, \$PageInfo.URL)]\n";
			$reval .= "</p>";
			return $reval;
		case 2 :
			switch ( $e1 )
			{
			case 1 :
				if ( $i != "Default" )
				{
					$CustomName = $i;
				}
				else
				{
					$CustomName = "SearchTable_".$c;
				}
				$reval = "";
				$reval .= "<!--#CW# This Code Search Field(Keywords) Contents.  Add By CTLM #CW#-->\n";
				$reval .= "<CMS action=\"SEARCH\" return=\"".$CustomName."\" NodeID=\"".$b."\" TableID=\"".$c."\" Exact=\"1\" Field=\"Keywords\" Keywords=\"{\$Keywords}\" Num=\"".$d."\" Separator=\",\" IgnoreContentID=\"{\$ContentID}\" />\n";
				$reval .= "<ul>\n";
				$reval .= "<LOOP name=\"".$CustomName."\" var=\"var\" key=\"key\" start=\"1\">\n";
				$reval .= "<li><a href=\"[\$var.URL]\">[\$var.Title]</a></li>\n";
				$reval .= "</LOOP>\n";
				$reval .= "</ul>";
				return $reval;
			case 2 :
				if ( $i != "Default" )
				{
					$CustomName = $i;
				}
				else
				{
					$CustomName = "SearchTable_".$c;
				}
				$reval = "";
				$reval .= "<!--#CW# This Code Search Field(Keywords) Contents.  Add By CTLM #CW#-->\n";
				$reval .= "<CMS action=\"SEARCH\" return=\"".$CustomName."\" NodeID=\"".$b."\" TableID=\"".$c."\" Exact=\"1\" Field=\"Keywords\" Keywords=\"{\$Keywords}\" Num=\"page-".$d."\" Separator=\",\" IgnoreContentID=\"{\$ContentID}\" />\n";
				$reval .= "<ul>\n";
				$reval .= "<LOOP name=\"".$CustomName."\" var=\"var\" key=\"key\" start=\"1\">\n";
				$reval .= "<li><a href=\"[\$var.URL]\">[\$var.Title]</a></li>\n";
				$reval .= "</LOOP>\n";
				$reval .= "</ul>\n";
				$reval .= "\n";
				$reval .= "<p>\n";
				$reval .= "[@list_page( \$PageInfo.TotalPage, \$PageInfo.CurrentPage, \$PageInfo.URL)]\n";
				$reval .= "</p>";
				return $reval;
			case 2 :
				if ( $i != "Default" )
				{
					$CustomName = $i;
				}
				else
				{
					$CustomName = "SearchTable_".$c;
				}
				$reval = "";
				$reval .= "<!--#CW# This Code Search Field(Keywords) Contents.  Add By CTLM #CW#-->\n";
				$reval .= "<CMS action=\"SEARCH\" return=\"".$CustomName."\" NodeID=\"".$b."\" TableID=\"".$c."\" Exact=\"1\" Field=\"Keywords\" Keywords=\"{\$Keywords}\" Num=\"page-".$d."\" Separator=\",\" IgnoreContentID=\"{\$ContentID}\" />\n";
				$reval .= "<ul>\n";
				$reval .= "<LOOP name=\"".$CustomName."\" var=\"var\" key=\"key\" start=\"1\">\n";
				$reval .= "<li><a href=\"[\$var.URL]\">[\$var.Title]</a></li>\n";
				$reval .= "</LOOP>\n";
				$reval .= "</ul>\n";
				$reval .= "\n";
				$reval .= "<p>\n";
				$reval .= "[@IndexPage(\$PageInfo.TotalPage, \$PageInfo.CurrentPage, \$PageInfo.URL)]\n";
				$reval .= "</p>";
				return $reval;
			case 3 :
				if ( $i != "Default" )
				{
					$CustomName = $i;
				}
				else
				{
					$CustomName = "ListContent";
				}
				$reval = "";
				$reval .= "<!--#CW# This Code Lode Content(".$f.").  Add By CTLM #CW#-->\n";
				$reval .= "<CMS action=\"CONTENT\" return=\"".$CustomName."\" IndexID=\"".$f."\" LoopMode=\"1\" />\n";
				$reval .= "<ul>\n";
				$reval .= "<loop name=\"".$CustomName."\" var=\"var\" key=\"key\" >\n";
				$reval .= "<li><a href=\"[\$var.URL]\">[\$var.Title]</a></li>\n";
				$reval .= "</loop>\n";
				$reval .= "</ul>";
				return $reval;
			case 4 :
				switch ( $e1 )
				{
				case 1 :
					if ( $i != "Default" )
					{
						$CustomName = $i;
					}
					else
					{
						$CustomName = "SQLList";
					}
					$reval = "";
					$reval .= "<!--#CW# This Code Lode SQL (".$g.").  Add By CTLM #CW#-->\n";
					$reval .= "<CMS action=\"SQL\" return=\"".$CustomName."\" query=\"".$g."\" />\n";
					$reval .= "<ul>\n";
					$reval .= "<loop name=\"".$CustomName."\" var=\"var\" key=\"key\" >\n";
					$reval .= "<li><a href=\"[\$var.URL]\">[\$var.Title]</a></li>\n";
					$reval .= "</loop>\n";
					$reval .= "</ul>";
					return $reval;
				case 2 :
					if ( $i != "Default" )
					{
						$CustomName = $i;
					}
					else
					{
						$CustomName = "SQLList";
					}
					$reval = "";
					$reval .= "<!--#CW# This Code Lode SQL (".$g.").  Add By CTLM #CW#-->\n";
					$reval .= "<CMS action=\"SQL\" return=\"".$CustomName."\" query=\"".$g."\" num=\"page-".$d."\" />\n";
					$reval .= "<ul>\n";
					$reval .= "<loop name=\"".$CustomName."\" var=\"var\" key=\"key\" >\n";
					$reval .= "<li><a href=\"[\$var.URL]\">[\$var.Title]</a></li>\n";
					$reval .= "</loop>\n";
					$reval .= "</ul>\n";
					$reval .= "\n";
					$reval .= "<p>\n";
					$reval .= "[@list_page( \$PageInfo.TotalPage, \$PageInfo.CurrentPage, \$PageInfo.URL)]\n";
					$reval .= "</p>";
					return $reval;
				case 3 :
					if ( $i != "Default" )
					{
						$CustomName = $i;
					}
					else
					{
						$CustomName = "SQLList";
					}
					$reval = "";
					$reval .= "<!--#CW# This Code Lode SQL (".$g.").  Add By CTLM #CW#-->\n";
					$reval .= "<CMS action=\"SQL\" return=\"".$CustomName."\" query=\"".$g."\" num=\"page-".$d."\"  />\n";
					$reval .= "<ul>\n";
					$reval .= "<loop name=\"".$CustomName."\" var=\"var\" key=\"key\" >\n";
					$reval .= "<li><a href=\"[\$var.URL]\">[\$var.Title]</a></li>\n";
					$reval .= "</loop>\n";
					$reval .= "</ul>\n";
					$reval .= "\n";
					$reval .= "<p>\n";
					$reval .= "[@IndexPage(\$PageInfo.TotalPage, \$PageInfo.CurrentPage, \$PageInfo.URL)]\n";
					$reval .= "</p>";
					return $reval;
				}
			}
		}
	}
}

function sub( $a, $b )
{
	return $a - $b;
}

include( "phprpc_server.php" );
new phprpc_server( array( "done", "sub" ) );
?>
