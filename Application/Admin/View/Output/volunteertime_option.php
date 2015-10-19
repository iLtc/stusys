<extend name="Public:templet" />
<block name="title">导出选项</block>
<block name="main">
	<form class="form-horizontal" method="post" action="/Admin-Output-show.html">
		<div class="form-group">
			<label for="time" class="col-sm-2 control-label">日期范围</label>
			<div class="col-sm-10">
				<div class="radio">
					<label>
						<input type="radio" name="times" id="times1" value="whole" checked>
						全部
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="times" id="times2" value="specific">
						<div class="input-daterange input-group col-sm-8" id="datepicker">
							<input type="text" class="input-sm form-control" name="start" />
							<span class="input-group-addon">to</span>
							<input type="text" class="input-sm form-control" name="end" />
						</div>
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="student" class="col-sm-2 control-label">学生范围</label>
			<div class="col-sm-10">
				<?php foreach($students as $i=>$v){?>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="students[]" value="<?=$i?>" checked>
							<?=$v?>
						</label>
					</div>
				<?php }?>
			</div>
		</div>
		<input type="hidden" name="type" value="Volunteertime">
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">导出</button>
			</div>
		</div>
	</form>
</block>
<block name="script">
	<script>
		$(".input-daterange").datepicker({
			todayBtn: "linked",
			language: "zh-CN",
			autoclose: true,
			format: "yyyy-mm-dd"
		})
	</script>
</block>