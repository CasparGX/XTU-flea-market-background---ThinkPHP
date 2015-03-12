<?php if (!defined('THINK_PATH')) exit();?><form action='<?php echo U("Goods/insert","","","");?>' method='POST' enctype='multipart/form-data'>
	<div id="inputFile">
        <input type='file' name='file[]'/><br/>
    </div>
        <button type='button' onclick='addInputFile();' >+</button><br/>
        <!--
        <input type='file' name='file[]'/><br/>
        <input type='file' name='file[]'/><br/>
         -->
        <input type='submit' value='上传'/>
    </form>

<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>小图:<img src='/Thinkphp/PUBLIC/Images/s_<?php echo ($vo["file_name"]); ?>'/>
大图：<img src='/Thinkphp/PUBLIC/Images/m_<?php echo ($vo["file_name"]); ?>'/><?php endforeach; endif; else: echo "" ;endif; ?>

<script type="text/javascript" src="/ershou/Public/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	function addInputFile() {
		$("#inputFile").append("<input type='file' name='file[]'/><br/>");
	}
</script>