<?php
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="assets/scripts/jquery/jquery-1.7.1.js"></script>
<link href="assets/style/authority/basic_layout.css" rel="stylesheet" type="text/css">
<link href="assets/style/authority/common_style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="assets/scripts/authority/commonAll.js"></script>
<script type="text/javascript" src="assets/scripts/fancybox/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="assets/scripts/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="assets/style/authority/jquery.fancybox-1.3.4.css" media="screen"></link>
<script type="text/javascript" src="assets/scripts/artDialog/artDialog.js?skin=default"></script>
<title>信息管理系统</title> 
<script type="text/javascript">
//	$(document).ready(function(){
//		/** 新增   **/
//	    $("#addBtn").fancybox({
//	    	'href'  : 'house_edit.html',
//	    	'width' : 733,
//	        'height' : 530,
//	        'type' : 'iframe',
//	        'hideOnOverlayClick' : false,
//	        'showCloseButton' : false,
//	        'onClosed' : function() { 
//	        	window.location.href = 'public/house_list.php';
//	        }
//	    });
//		
//	    /** 导入  **/
//	    $("#importBtn").fancybox({
//	    	'href'  : '/xngzf/archives/importFangyuan.action',
//	    	'width' : 633,
//	        'height' : 260,
//	        'type' : 'iframe',
//	        'hideOnOverlayClick' : false,
//	        'showCloseButton' : false,
//	        'onClosed' : function() { 
//	        	window.location.href = 'house_list.php';
//	        }
//	    });
//		
//	    /**编辑   **/
//	    $("a.edit").fancybox({
//	    	'width' : 733,
//	        'height' : 530,
//	        'type' : 'iframe',
//	        'hideOnOverlayClick' : false,
//	        'showCloseButton' : false,
//	        'onClosed' : function() { 
//	        	window.location.href = 'house_list.php';
//	        }
//	    });
//	});
	/** 用户角色   **/
	var userRole = '';

	/** 模糊查询来电用户  **/
	function search(){
		$("#submitForm").attr("action", "public/house_list.php?page=" + 1).submit();
	}

	/** 新增   **/
	function add(){
		$("#submitForm").attr("action", "/xngzf/archives/luruFangyuan.action").submit();	
	}
	 
	/** Excel导出  **/
	function exportExcel(){
		if( confirm('您确定要导出吗？') ){
			var fyXqCode = $("#fyXq").val();
			var fyXqName = $('#fyXq option:selected').text();
//	 		alert(fyXqCode);
			if(fyXqCode=="" || fyXqCode==null){
				$("#fyXqName").val("");
			}else{
//	 			alert(fyXqCode);
				$("#fyXqName").val(fyXqName);
			}
			$("#submitForm").attr("action", "/xngzf/archives/exportExcelFangyuan.action").submit();	
		}
	}
	
	/** 删除 **/
	function del(fyID){
		// 非空判断
		if(fyID == '') return;
		if(confirm("您确定要删除吗？")){
			$("#submitForm").attr("action", "/xngzf/archives/delFangyuan.action?fyID=" + fyID).submit();			
		}
	}
	
	/** 批量删除 **/
	function batchDel(){
		if($("input[name='IDCheck']:checked").size()<=0){
			art.dialog({icon:'error', title:'友情提示', drag:false, resize:false, content:'至少选择一条', ok:true,});
			return;
		}
		// 1）取出用户选中的checkbox放入字符串传给后台,form提交
		var allIDCheck = "";
		$("input[name='IDCheck']:checked").each(function(index, domEle){
			bjText = $(domEle).parent("td").parent("tr").last().children("td").last().prev().text();
// 			alert(bjText);
			// 用户选择的checkbox, 过滤掉“已审核”的，记住哦
			if($.trim(bjText)=="已审核"){
// 				$(domEle).removeAttr("checked");
				$(domEle).parent("td").parent("tr").css({color:"red"});
				$("#resultInfo").html("已审核的是不允许您删除的，请联系管理员删除！！！");
// 				return;
			}else{
				allIDCheck += $(domEle).val() + ",";
			}
		});
		// 截掉最后一个","
		if(allIDCheck.length>0) {
			allIDCheck = allIDCheck.substring(0, allIDCheck.length-1);
			// 赋给隐藏域
			$("#allIDCheck").val(allIDCheck);
			if(confirm("您确定要批量删除这些记录吗？")){
				// 提交form
				$("#submitForm").attr("action", "/xngzf/archives/batchDelFangyuan.action").submit();
			}
		}
	}

	/** 普通跳转 **/
	function jumpNormalPage(page){
		$("#submitForm").attr("action", "public/house_list.php?page=" + page).submit();
	}
	
	/** 输入页跳转 **/
	function jumpInputPage(totalPage){
		// 如果“跳转页数”不为空
		if($("#jumpNumTxt").val() != ''){
			var pageNum = parseInt($("#jumpNumTxt").val());
			// 如果跳转页数在不合理范围内，则置为1
			if(pageNum<1 | pageNum>totalPage){
				art.dialog({icon:'error', title:'友情提示', drag:false, resize:false, content:'请输入合适的页数，\n自动为您跳到首页', ok:true,});
				pageNum = 1;
			}
			$("#submitForm").attr("action", "house_list.php?page=" + pageNum).submit();
		}else{
			// “跳转页数”为空
			art.dialog({icon:'error', title:'友情提示', drag:false, resize:false, content:'请输入合适的页数，\n自动为您跳到首页', ok:true,});
			$("#submitForm").attr("action", "house_list.php?page=" + 1).submit();
		}
	}
</script>
<style>
	.alt td{ background:black !important;}
</style>
</head>
<body>
	<!--<form id="submitForm" name="submitForm" action="" method="post">-->
		<input type="hidden" name="allIDCheck" value="" id="allIDCheck"/>
		<input type="hidden" name="fangyuanEntity.fyXqName" value="" id="fyXqName"/>
		<div id="container">
			<div class="ui_content">
				<div class="ui_text_indent">
					<div id="box_border">
						<div id="box_top">搜索</div>
						<div id="box_center">
							
								<?php
									$form=ActiveForm::begin([
									'action'=>Url::toRoute('search')
									])
								?>
							位置
                            <input type="text" name='wei' id="wei" class="ui_select01" />
							户型
							<select name="hu" id="fyHx" class="ui_select01">
                                <option value="">--请选择--</option>
                                <option value="一室一厅一卫">一室一厅一卫</option>
                                <option value="二室一厅一卫">二室一厅一卫</option>
                                <option value="三室一厅一卫">三室一厅一卫</option>
                                <option value="三室两厅一卫">三室两厅一卫</option>
                            </select>
							状态
							<select name="zhuang" id="fyStatus" class="ui_select01">
                                <option value="">--请选择--</option>
                                <option value="1">未出租</option>
                                <option value="0">已出租</option>
                                <option value="">欠费</option>
                                <option value="">其他</option>
                            </select>
						</div>
						<div id="box_bottom">
							<input type="button" value="查询" class="ui_input_btn01" id="cha" /> 
							<input type="button" value="新增" class="ui_input_btn01" id="addBtn" /> 
							<input type="button" value="删除" class="ui_input_btn01" id="dels" /> 
						</div>
						<?php ActiveForm::end();?>
					</div>
				</div>
			</div>
			<div class="ui_content">
				<div class="ui_tb">
					<table class="table" cellspacing="0" cellpadding="0" width="100%" align="center" border="0">
						<tr>
							<th width="30"><input type="checkbox" id="all" />
							</th>
							<th>位置</th>
							<th>房源</th>
							<th>房源面积</th>
							<th>户型</th>
							<th>带看次数</th>
							<th>关注人数</th>
							<th>租赁性质</th>
							<th>状态</th>
							<th>操作</th>
						</tr>
						<tbody id="search">
						<?php foreach($model as $key=>$val){?>
							<tr>
								<td><input type="checkbox" class="che" name="check" value="<?=$val->h_id?>"/></td>
								<td><?= $val->address; ?></td>
								<td><?= $val->name; ?></td>
								<td><?= $val->area; ?></td>
								<td><?= $val->model; ?></td>
								<td><?= $val->count; ?></td>
								<td><?= $val->attention; ?></td>
								<td>公租房</td>
								<td>
									<?php
										if($val["state"]==1)
										{
											echo "未出租";
										}else
										{
											echo "已出租";
										}
										
										?>
								</td>
								<td>
									<a href="javascript:void(0);" id="update" title="<?=$val->h_id;?>">编辑</a> 
									<a href="javascript:void(0);" id="del" title="<?=$val->h_id;?>">删除</a>
								</td>
							</tr>
							<?php };?>
							</tbody>
					</table>
				</div>
			共有：<?php echo $rs?> 条数据
			<div style="display:inline" id='feu'>
				<?=
				LinkPager::widget([
     		 	'pagination' => $pages,
    			]);			
				?>
				</div>
			</div>
		</div>
	<!--</form>-->
<div style="display:none"><script src='http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language='JavaScript' charset='gb2312'></script></div>
</body>
</html>
<script src='/home/advanced/jquery-2.1.1.min.js'></script>
<script>
	/**
	 * 无页面刷新搜索
	 */
	$(document).on("click","#cha",function()
	{
		
		var zhuang=$("#fyStatus").val();
		var xing=$("#fyHx").val();
		var wei=$("#wei").val();
		$.ajax({
		   type: "POST",	   
		   dataType:"json",
		   data: {zhuang:zhuang,xing:xing,wei:wei},
		   url:"<?php echo Url::toRoute('user/search')?>",
		   success: function(msg){
		  	 var str="";
				for(i in msg)
				{
					str+="<tr>";
		   	 		str+="<td><input type='checkbox' class='che' name='check' value='<?=$val->h_id?>'></td>";
		   	 		str+="<td>"+msg[i].address+"</td>";
		   	 		str+="<td>"+msg[i].name+"</td>";
		   	 		str+="<td>"+msg[i].area+"</td>";
		   	 		str+="<td>"+msg[i].model+"</td>";
		   	 		str+="<td>"+msg[i].count+"</td>";
		   	 		str+="<td>"+msg[i].attention+"</td>";
		   	 		str+="<td>公租房</td>";
		   	 		if(msg[i].state==1)
		   	 		{
		   	 			str+="<td>未出租</td>";
		   	 		}else{
		   	 			str+="<td>已出租</td>";
		   	 			
		   	 		}
		   	 		str+="<td><a href='javascript:void(0);' id='update' title='<?=$val->h_id;?>'>编辑</a> <a href='javascript:void(0);' id='del' title='<?=$val->h_id;?>'>删除</a></td>";
		   	 		str+="</tr>";
				}
		   	 $("#search").html(str);
		   }
		});
	})
	/**
	 * 全选反选
	 */
	$(document).on("click","#all",function()
	{		
		if(this.checked)
		{
			$(".che").prop("checked", true);
		}else
		{
			$(".che").prop("checked", false);
		}
	})
	/**
	 * 删除
	 */
	$(document).on("click","#del",function()
	{
		var id=$(this).eq(0).attr('title');
		$.ajax({
			type: "get",	   
		   data: {id:id},
		   url:"<?php echo Url::toRoute('user/del')?>",
		   success: function(msg)
		   {
		   		
		   }
		})
	})
	/**
	 * 修改
	 */
	$(document).on("click","#update",function()
	{
		var id=$(this).eq(0).attr('title');
//		alert(id);
		$.ajax({
			type: "get",	   
		   data: {id:id},
		   url:"<?php echo Url::toRoute('user/upda')?>",
		   success: function(msg)
		   {
		   		
		   }
		})
	})
	/**
	 * 批量删除
	 */
	$("#dels").click(function(){
//		alert("ds");
            var checkedNum = $("input[name='check']:checked").length;
            if(checkedNum == 0) {
                alert("请选择至少一项！");
                return;
            }
//	// 批量选择
            if(confirm("确定要删除所选项目？")) {
                var che = $("input[name='check']:checked");
//              alert(che)
                var hh = new Array();
                for(var a=0;a<che.length;a++){
                    hh[a] = che[a].value;
                }
                $.ajax({
                    type: "POST",
                    url: "?r=user/dels",
                    data: {'delitems':hh},
                    success: function(result) {
                        alert("删除成功");
                    }
                });
            }
        });
//  });

</script>