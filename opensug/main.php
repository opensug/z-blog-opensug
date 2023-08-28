<?php

$sources = array(
	"baidu"		=> "百度",
	"google"	=> "谷歌",
	"haoso"		=> "好搜",
	"kugou"		=> "酷狗",
	"yahoo"		=> "雅虎",
	"yandex"	=> "Yandex",
	"youku"		=> "优酷视频",
	"taobao"	=> "淘宝",
	"attayo"	=> "Attayo",
	"mgtv"		=> "芒果视频",
	"sm"		=> "神马搜索",
	"weibo"		=> "微博",
	"rambler"	=> "Rambler",
	"soft"		=> "软件",
	"naver"		=> "Naver",
	"car"		=> "新浪汽车",
	"car2"		=> "网易汽车",
	"qunar"		=> "去哪儿",
	"lagou"		=> "拉钩网"
);
require "../../../zb_system/function/c_system_base.php";
require "../../../zb_system/function/c_system_admin.php";

$zbp->Load();
if( ! $zbp->CheckRights( "root" ) ) {
	$zbp->ShowError(6);
	die();
}

if( ! $zbp->CheckPlugin( "opensug") ) {
	$zbp->ShowError(48);
	die();
}

if( strtolower( $_SERVER['REQUEST_METHOD'] ) === "post" && count( $_POST ) > 0 ){
	if(!preg_match("/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $_POST["bgcolor"]))		$_POST["bgcolor"]		= "";
	if(!preg_match("/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $_POST["bgcolorHI"]))	$_POST["bgcolorHI"]		= "";
	if(!preg_match("/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $_POST["borderColor"]))	$_POST["borderColor"]	= "";
	if(!preg_match("/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $_POST["fontColor"]))	$_POST["fontColor"]		= "";
	if(!preg_match("/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $_POST["fontColorHI"]))	$_POST["fontColorHI"]	= "";

	if(!preg_match("/^(?:-?\d+)?$/", $_POST["XOffset"])) $_POST["XOffset"]	= "";
	if(!preg_match("/^(?:-?\d+)?$/", $_POST["YOffset"])) $_POST["YOffset"]	= "";
	if(!preg_match("/^\d+$/", $_POST["fontColorHI"]))	$_POST["width"]		= "";

	if(!preg_match("/^(\d+(px|em))( (\d+(px|em))){0,3}$/", $_POST["padding"]))	$_POST["padding"]	= "";
	if(!preg_match("/^(\d+(px|em))( (\d+(px|em))){0,3}$/", $_POST["radius"]))	$_POST["radius"]	= "";

	if(!preg_match("/(px|em)$/", $_POST["fontSize"])) $_POST["fontSize"] .= "px";
	if(!preg_match("/\b(\d+(?:px|em)(?:\s+\d+(?:px|em)){0,3})\b/", $_POST["fontSize"])) $_POST["fontSize"] = "14px";

	$_POST["sugSubmit"] = $_POST["sugSubmit"] == "0" ? "0" : "1";

	$zbp->Config( _NAME_ )->config = array(
		"ipt"			=> $_POST["iptid"],			// 输入框绑定ID
		"bgcolor"		=> $_POST["bgcolor"],		// 背景颜色
		"bgcolorHI"		=> $_POST["bgcolorHI"],		// 背景高亮颜色
		"borderColor"	=> $_POST["borderColor"],	// 边框颜色
		"fontColor"		=> $_POST["fontColor"],		// 字体颜色
		"fontColorHI"	=> $_POST["fontColorHI"],	// 字体高亮颜色
		"fontFamily"	=> $_POST["fontFamily"],	// 字体
		"fontSize"		=> $_POST["fontSize"],		// 字体大小
		"padding"		=> $_POST["padding"],		// 内边框
		"radius"		=> $_POST["radius"],		// 圆角
		"shadow"		=> $_POST["shadow"],		// 阴影
		"source"		=> $_POST["source"],		// 结果源
		"sugSubmit"		=> $_POST["sugSubmit"],		// 默认动作
		"width"			=> $_POST["width"],			// 宽度
		"XOffset"		=> $_POST["XOffset"],		// X偏移量
		"YOffset"		=> $_POST["YOffset"],		// Y偏移量
	);
	$zbp->SaveConfig( _NAME_ );
}


require $blogpath . "zb_system/admin/admin_header.php";
require $blogpath . "zb_system/admin/admin_top.php";
$config = $zbp->Config( _NAME_ )->config;

function openSug_option($cfg = "", $var = "", $str = ""){
	$sel = $cfg == $var ? "selected=\"selected\" " : "";
	return "<option {$sel}value=\"{$var}\">{$str}</option>";
}
?>
<style type="text/css">
.item{width:10%;text-align:right;user-select: none;}
label{display:block}
td input{outline:none}
</style>
<div id="divMain">
	<div class="divHeader">openSug.js</div>
	<div class="SubMenu">d</div>
	<div id="divMain2">
		<div>
			请根据您的主题模板实际输入框填写此处的ID，如您需要帮助请添加社群获取支援!&nbsp;<a target="_blank" href="//qm.qq.com/cgi-bin/qm/qr?k=tWNFxRGRyYkvfgVhUAMQSf-Pkqly4SU_&jump_from=webapi&authKey=VNsawBRaz2HqY8rpDrpDAt4vFX/yWz4NOktEXOdNVP5O85KHOSg2cEqKWAPQFAhl"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="openSug.js" title="openSug.js"></a>
		</div>
		<div style="margin:0!important;padding:0 3px 0 10px!important;line-height:18px;list-style:decimal-leading-zero;border-left:3px solid #6ce26c;color:#5c5c5c;background-color:#f8f8f8;">&lt;<span style="color:#c18401">input</span>&nbsp;<span style="color:#c18401">type</span>=<span style="color:#50a14f">&quot;text&quot;</span>&nbsp;name=<span style="color:#50a14f">&quot;kw&quot;</span>&nbsp;id=<span style="color:#50a14f">&quot;输入框ID&quot;</span>&nbsp;...</div>
		<form action="" method="post" name="config">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td class="item" style="color:#f00"><label for="iptid">(*) 输入框ID</label></td>
				<td><input autocomplete="off" x-webkit-speech="false" spellcheck="false" type="text" name="iptid" id="iptid" value="<?php echo $config["ipt"];?>" required="required" autofocus="autofocus" placeholder="iptID" /></td>
			</tr>
			<tr>
				<td class="item"><label for="XOffset">XOffset</label></td>
				<td><input autocomplete="off" x-webkit-speech="false" spellcheck="false" type="number" name="XOffset" id="XOffset" value="<?php echo $config["XOffset"];?>" placeholder="-1" /></td>
			</tr>
			<tr>
				<td class="item"><label for="YOffset">YOffset</label></td>
				<td><input autocomplete="off" x-webkit-speech="false" spellcheck="false" type="number" name="YOffset" id="YOffset" value="<?php echo $config["YOffset"];?>" placeholder="-3" /></td>
			</tr>
			<tr>
				<td class="item"><label for="bgcolor">背景颜色</label></td>
				<td><input autocomplete="off" x-webkit-speech="false" spellcheck="false" type="color" name="bgcolor" id="bgcolor" value="<?php echo $config["bgcolor"];?>" placeholder="#ffffff" /></td>
			</tr>
			<tr>
				<td class="item"><label for="bgcolorHI">背景高亮颜色</label></td>
				<td><input autocomplete="off" x-webkit-speech="false" spellcheck="false" type="color" name="bgcolorHI" id="bgcolorHI" value="<?php echo $config["bgcolorHI"];?>" placeholder="#11a7db" /></td>
			</tr>
			<tr>
				<td class="item"><label for="borderColor">边框颜色</label></td>
				<td><input autocomplete="off" x-webkit-speech="false" spellcheck="false" type="color" name="borderColor" id="borderColor" value="<?php echo $config["borderColor"];?>" placeholder="#d4ac20" /></td>
			</tr>
			<tr>
				<td class="item"><label for="fontColor">字体颜色</label></td>
				<td><input autocomplete="off" x-webkit-speech="false" spellcheck="false" type="color" name="fontColor" id="fontColor" value="<?php echo $config["fontColor"];?>" placeholder="#6b00c2" /></td>
			</tr>
			<tr>
				<td class="item"><label for="fontColorHI">字体高亮颜色</label></td>
				<td><input autocomplete="off" x-webkit-speech="false" spellcheck="false" type="color" name="fontColorHI" id="fontColorHI" value="<?php echo $config["fontColorHI"];?>" placeholder="#f14f4f" /></td>
			</tr>
			<tr>
				<td class="item"><label for="fontFamily">字体</label></td>
				<td><input autocomplete="off" x-webkit-speech="false" spellcheck="false" type="text" name="fontFamily" id="fontFamily" value="<?php echo $config["fontFamily"];?>" placeholder="Geneva" /></td>
			</tr>
			<tr>
				<td class="item"><label for="fontSize">字体大小</label></td>
				<td><input autocomplete="off" x-webkit-speech="false" spellcheck="false" type="number" name="fontSize" id="fontSize" value="<?php echo $config["fontSize"];?>" placeholder="14" /></td>
			</tr>
			<tr>
				<td class="item"><label for="padding">内填充</label></td>
				<td><input autocomplete="off" x-webkit-speech="false" spellcheck="false" type="text" name="padding" id="padding" value="<?php echo $config["padding"];?>" placeholder="1px 1px 1px 1px" /></td>
			</tr>
			<tr>
				<td class="item"><label for="radius">边框圆角</label></td>
				<td><input autocomplete="off" x-webkit-speech="false" spellcheck="false" type="text" name="radius" id="radius" value="<?php echo $config["radius"];?>" placeholder="1px 1px 1px 1px" /></td>
			</tr>
			<tr>
				<td class="item"><label for="shadow">边框阴影</label></td>
				<td><input autocomplete="off" x-webkit-speech="false" spellcheck="false" type="text" name="shadow" id="shadow" value="<?php echo $config["shadow"];?>" placeholder="0 16px 10px #00000080" /></td>
			</tr>
			<tr>
				<td class="item"><label for="width">宽度</label></td>
				<td><input autocomplete="off" x-webkit-speech="false" spellcheck="false" type="number" name="width" id="width" value="<?php echo $config["width"];?>" placeholder="推荐留空" /></td>
			</tr>
			<tr>
				<td class="item"><label for="sugSubmit">选中默认动作</label></td>
				<td><select id="sugSubmit" name="sugSubmit"><option value="1"<?php if( $config["sugSubmit"] != "0") echo " selected=\"selected\""; ?>>自动提交</option><option value="0"<?php if( $config["sugSubmit"] == "0") echo " selected=\"selected\""; ?>>手动提交</option></select></td>
			</tr>
			<tr>
				<td class="item"><label for="source">结果源</label></td>
				<td><select id="source" name="source"><?php foreach($sources as $k => $v) echo openSug_option($config["source"], $k, $v);?></select></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" class="btn btn-success btn-sm" value="保存" /></td>
			</tr>
		</tbody>
		</table>
		</form>
	</div>
</div>
<?php
require $blogpath . "zb_system/admin/admin_footer.php";
RunTime();