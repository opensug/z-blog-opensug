<?php
define( "_NAME_", basename( __DIR__ ) );
RegisterPlugin( _NAME_, "ActivePlugin_opensug" );




function ActivePlugin_opensug() {
	Add_Filter_Plugin("Filter_Plugin_Zbp_MakeTemplatetags", "renderFooter" );
}

function InstallPlugin_opensug() {
	global $zbp;
	if( ! $zbp->HasConfig( _NAME_ ) ) {
		$zbp->Config( _NAME_ )->config = array(
			"ipt"			=> "",						// 输入框绑定ID
			"bgcolor"		=> "#ffffff",				// 背景颜色
			"bgcolorHI"		=> "#ededed",				// 背景高亮颜色
			"borderColor"	=> "#ced4da",				// 边框颜色
			"fontColor"		=> "#313131",				// 字体颜色
			"fontColorHI"	=> "#000000",				// 字体高亮颜色
			"fontFamily"	=> "Montserrat,sans-serif",	// 字体
			"fontSize"		=> "14",					// 字体大小
			"padding"		=> "4px 8px",				// 内边框
			"radius"		=> "2px",					// 圆角
			"shadow"		=> "0 16px 10px #00000080",	// 阴影
			"source"		=> "",						// 结果源
			"sugSubmit"		=> "1",						// 默认动作
			"width"			=> "",						// 宽度
			"XOffset"		=> "",						// X偏移量
			"YOffset"		=> "-3",					// Y偏移量
		);
		$zbp->SaveConfig( _NAME_ );
	}
    Redirect( "{$zbp->host}zb_users/plugin/". _NAME_ ."/main.php" );
}

function UninstallPlugin_opensug() {
	global $zbp;
	if( $zbp->HasConfig( _NAME_ ) )
		$zbp->DelConfig( _NAME_ );
}


function renderFooter(){
	global $zbp;
	$config = $zbp->Config( _NAME_ )->config;
	$config = is_array( $config ) ? $config : array(
		"ipt"			=> "",						// 输入框绑定ID
		"bgcolor"		=> "#ffffff",				// 背景颜色
		"bgcolorHI"		=> "#ededed",				// 背景高亮颜色
		"borderColor"	=> "#ced4da",				// 边框颜色
		"fontColor"		=> "#313131",				// 字体颜色
		"fontColorHI"	=> "#000000",				// 字体高亮颜色
		"fontFamily"	=> "Montserrat,sans-serif",	// 字体
		"fontSize"		=> "14",					// 字体大小
		"padding"		=> "4px 8px",				// 内边框
		"radius"		=> "2px",					// 圆角
		"shadow"		=> "0 16px 10px #00000080",	// 阴影
		"source"		=> "",						// 结果源
		"sugSubmit"		=> "1",						// 默认动作
		"width"			=> "",						// 宽度
		"XOffset"		=> "",						// X偏移量
		"YOffset"		=> "-3",					// Y偏移量
	);

	if( ! isset( $config["ipt"] ) || strlen($config["ipt"]) == 0 ) return false;
	if( ! preg_match( "/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $config["bgcolor"] ) )			$config["bgcolor"]		= "";
	if( ! preg_match( "/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $config["bgcolorHI"] ) )			$config["bgcolorHI"]	= "";
	if( ! preg_match( "/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $config["borderColor"] ) )		$config["borderColor"]	= "";
	if( ! preg_match( "/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $config["fontColor"] ) )			$config["fontColor"]	= "";
	if( ! preg_match( "/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $config["fontColorHI"] ) )		$config["fontColorHI"]	= "";
	if( ! preg_match( "/^(?:-?\d+)?$/", $config["XOffset"] ) ) 									$config["XOffset"]		= "";
	if( ! preg_match( "/^(?:-?\d+)?$/", $config["YOffset"] ) ) 									$config["YOffset"]		= "";
	if( ! preg_match( "/^\d+$/", $config["fontColorHI"] ) )										$config["width"]		= "";
	if( ! preg_match( "/^(\d+(px|em))( (\d+(px|em))){0,3}$/", $config["padding"] ) )			$config["padding"]		= "";
	if( ! preg_match( "/^(\d+(px|em))( (\d+(px|em))){0,3}$/", $config["radius"] ) )				$config["radius"]		= "";
	if( ! preg_match( "/\b(\d+(?:px|em)(?:\s+\d+(?:px|em)){0,3})\b/", $config["fontSize"] ) )	$config["fontSize"]		= "14px";

	$zbp->footer = "\r\n<script type=\"text/javascript\" src=\"https://opensug.github.io/js/opensug.js\"></script>\r\n<script type=\"text/javascript\">\"use strict\";(function(){\r\n	var ipt = document[\"getElementById\"](\"{$config["ipt"]}\");\r\n	if( ipt != null && (\r\n		(ipt[\"getAttribute\"](\"type\") || \"\")[\"toLocaleLowerCase\"]() === \"search\" || \r\n		(ipt[\"getAttribute\"](\"type\") || \"\")[\"toLocaleLowerCase\"]() === \"text\") && \r\n	   	\"function\" === typeof( window[\"openSug\"] )\r\n	) window[\"openSug\"]( \"{$config["ipt"]}\", {\r\n		// 提示框的背景色。\r\n		bgcolor : \"{$config["bgcolor"]}\",\r\n\r\n		// 提示框的高亮背景色。\r\n		bgcolorHI : \"{$config["bgcolorHI"]}\",\r\n\r\n		// 提示框的边框颜色。\r\n		borderColor : \"{$config["borderColor"]}\",\r\n\r\n		// 提示框中文本的颜色。\r\n		fontColor : \"{$config["fontColor"]}\",\r\n\r\n		// 高亮显示提示框中的文本颜色。\r\n		fontColorHI : \"{$config["fontColorHI"]}\",\r\n\r\n		// 提示框中文本的字体。\r\n		fontFamily : \"{$config["fontFamily"]}\",\r\n\r\n		// 提示框中的文本字体大小。\r\n		fontSize : \"{$config["fontSize"]}\",\r\n\r\n		// 提示框的内边距。\r\n		padding : \"{$config["padding"]}\",\r\n\r\n		// 边界的圆角半径。\r\n		radius : \"{$config["radius"]}\",\r\n\r\n		// 边框的阴影效果。\r\n		shadow : \"{$config["shadow"]}\",\r\n\r\n		// 搜索提示框的数据源。\r\n		source : \"{$config["source"]}\",\r\n\r\n		// 选择提示时是否自动提交表单。\r\n		sugSubmit : {$config["sugSubmit"]},\r\n\r\n		// 提示框的宽度。\r\n		// 建议的空值。\r\n		width : \"{$config["width"]}\",\r\n\r\n		// 提示框相对于输入框的横向偏移。\r\n		// 负值向右移动。\r\n		XOffset : \"{$config["XOffset"]}\",\r\n\r\n		// 提示框相对于输入框的纵向偏移。\r\n		// 负值向下偏移。\r\n		YOffset : \"{$config["YOffset"]}\"\r\n\r\n	}, function(callback){\r\n		/*  ...  */\r\n	});		\r\n}(this));</script>\r\n";
}