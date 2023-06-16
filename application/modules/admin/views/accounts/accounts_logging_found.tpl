<div class="timeline timeline-simple">
	<div class="tm-body">
		{foreach from=$logs item=log}
		<ol class="tm-items">
			<li>
				<div class="tm-box">
					<p class="text-muted mb-0">{date("d.m.Y H:i:s", $log.time)} <span class="float-end"><a href="https://db-ip.com/{$log.ip}" target="_blank">{$log.ip}</a></span></p>
					<p>{$log.type} ({$log.message})</p>
				</div>
			</li>
		</ol>
		{/foreach}
	</div>
	<div id="show_more_count" {if $show_more <= 0}style="display:none;"{/if}>
		<div class="timeline-item" >
			<h3 class="timeline-header border-0">
				<!--<a class="btn btn-primary btn-sx" id="button_log_count" onClick="Accounts.loadMore({$userid}); return false;">Load more ({$show_more})</a>-->
				<input type="hidden" id="js_load_more" value="{$show_more}">
			</h3>
		</div>
	</div>
</div>