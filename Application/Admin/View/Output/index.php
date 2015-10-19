<extend name="Public:templet" />
<block name="title">导出申请</block>
<block name="main">
	<?php foreach($outputs as $name => $title){?>
		<a class="btn btn-default" href="/Admin-Output-option.html?type=<?=$name?>" role="button"><?=$title?></a>
	<?php }?>
</block>