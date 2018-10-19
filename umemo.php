/**
 * @author 王森 1414044963
 * 
 */
 
 //html代码 
 <html>
	<head>客户页面修改备注</head><!--只是写需要添加的代码,html代码不需要添加-->
	<link href="../js/layui/css/layui.css" rel="stylesheet" type="text/css" /> <!--引进 layui css-->
	<body>
			<!-- html 不需要复制在GuestInfo.php存在-->
		<tr>
    <td class="td">病情信息</td>
    <td colspan="3" class="td2"><span id="his_memo" "></span>
      <input name="g_memo" type="text" id="g_memo" style="width:99%;" /></td>
  </tr>
  <script type="text/javascript" src="../javascripts/jquery/jquery-1.8.2.min.js"></script><!--引进 jquery 默认GustInfo.php文件中有不需要复制改文件-->
  <script language="javascript" src="../js/layui/layui.all.js" type="text/javascript"></script><!--引进 layui js-->
	</body>
 </html>
 //js代码
 <script>
	jQuery("#his_memo").dblclick(function(){readhismemo(); return false;}  );//改代码放在jquery().ready();方法中,即dom加载完立即执行
	
	function readhismemo(){ //该方法为修改备注/病情信息的核心代码
	//$('#his_memo').append('<button class="layui-btn layui-btn-normal">修改</button>');
	$('#his_memo').after('<div id="hidhismemo"><textarea name="desc" id="texhis" class="layui-textarea" style=" color:blue;width:66%"  >'+$("#his_memo").text()+'</textarea><a class="layui-btn layui-btn-normal" style="text-decoration:none" id="edithismemo"  >修改</a><a style="text-decoration:none" class="layui-btn layui-btn-danger" id="delhismemo" >删除</a></div>');
	$("#his_memo").hide();
	//多条备注时,添加头号分行
	$("#texhis").on('focus',function(){
		alert("不要忘记添加英文逗号!");
		$("#texhis").unbind('focus');
		return false;
		 
	});
	
	//修改病情信息
	$("#edithismemo").click(function(){
		var edithis_memo=$("#edithismemo").attr('id'); 
		var edithismemo=$("#texhis").val(); 
	
		$.post('../guest/GuestInfoAjax.php?action='+edithis_memo,'texhis='+edithismemo+'&gid='+guestid,function(data){
			if(data=='success'){
				layer.open({
					title:'修改成功!',
					content:'详细病情信息修改成功!',
					success:function(){
						$("#hidhismemo").remove();
						readGuestMemo();
						$("#his_memo").show();
					}
				});
			}else{
				layer.open({
					title:'修改失败!',
					content:'详细病情信息修改失败!请联系开发人员'
				});
			}
		});
	});
	
	
	//删除病情信息
	$("#delhismemo").click(function(){
		$.post('../guest/GuestInfoAjax.php?action=delhismemo','gid='+guestid,function(data){
			 if(data=='success'){
				 layer.open({
					 title:'删除成功!',
					 content:'详细病情信息删除成功!',
					 success:function(){
						$("#hidhismemo").remove();
					 }
				 });
			 }else{
				 layer.open({
					 title:'删除失败!',
					 content:'详细病情信息删除失败!'
				 });
			 }
		});
	});
}
	
 </script>
 
 //php代码 该代码为后台代码,即GuestInfoAjax.php中的直接复制
 <?else if ($action=="edithismemo"){
		if($gid&&$gid>0){
				$texhis=str_replace(',','<br>',$texhis);
		
				$memo=$texhis.'<br>';
		//echo "update guest set memo='".$memo."' where id='".$gid."'";
			$l=$sqs_db->query("update guest set memo='".$memo."' where id='".$gid."'");
			if($l){
				echo 'success';
				}else{
					echo 'error';
				}
			}
		
}else if ($action=="delhismemo"){
		if($gid&&$gid>0){
			//echo "update guest set memo='' where id='".$gid."'";
			$l=$sqs_db->query("update guest set memo='' where id='".$gid."'");
			if($l){
				echo 'success';
			}else{
				echo 'error';
			}
		}
}
?>