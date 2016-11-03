<center>
	<table>
		<form action="index.php?r=add/add" method="post">
		<input type="hidden" id="_csrf" name="<?php echo Yii::$app->request->csrfParam;?>" value="<?php echo yii::$app->request->csrfToken?>" />
			<tr>
				<td>标题：</td>
				<td><input type="text" name='title'></td>
			</tr>
			<tr>
				<td>内容：</td>
				<td><textarea name="connet" placeholder="请输入内容"></textarea></td>
			</tr>
			<tr>
				<td><input type="submit" value="提交"></td>
			</tr>
		</form>
	</table>
</center>