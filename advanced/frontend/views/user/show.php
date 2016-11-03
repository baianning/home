<?php
use yii\widgets\LinkPager?>
<center>
<table border="1">
<th>标题</th>
<th>内容</th>
<th>操作</th>

<?php foreach($model as $key=>$val){ ?>
 		<tr>
        <td><?= $val->title; ?>  </td>  
        <td><?= $val->connet; ?> </td>
        <td>
        	<a href="?r=user/del&id=<?= $val->id; ?>">删除</a>|
        	|<a href="?r=user/update&id=<?= $val->id; ?>">修改</a>
        </td>
</tr>
<?php } ?>
</table>

<?=
LinkPager::widget([
      'pagination' => $pages,
    ]);
?>
</center>