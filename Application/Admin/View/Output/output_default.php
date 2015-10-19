<extend name="Public:templet" />
<block name="title">导出预览</block>
<block name="main">
	<div class="col-sm-12">
		<button type="button" class="btn btn-primary" id="print-btn">打印</button>
		<button type="button" class="btn btn-success" id="refresh-btn">刷新</button>
		<button type="button" class="btn btn-default" id="return-btn">返回</button>
	</div>
	<div class="col-sm-12">
		<iframe src="/Admin-Output-view.html?<?=http_build_query($_POST)?>" name="view" height="750px" width="100%" id="view"></iframe>
	</div>
</block>
