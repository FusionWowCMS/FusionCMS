<div class="card mb-3">
	<div class="card-body">
	<table class="table table-responsive-md table-hover">
		<thead>
			<tr>
				<th>{lang('cache', 'admin')}</th>
				<th>{lang('size', 'admin')}</th>
			</tr>
		</thead>
		<tbody>
		<tr>
			<td>{lang('item_cache', 'admin')}</td>
			<td id="row_item">{lang('files_count', 'admin', [$item.files])} ({$item.sizeString})</td>
		</tr>
		<tr>
			<td>{lang('website_cache', 'admin')}</td>
			<td id="row_website">{lang('files_count', 'admin', [$website.files])} ({$website.sizeString})</td>
		</tr>
		<tr>
			<td>{lang('theme_minify_cache', 'admin')}</td>
			<td id="row_theme">{lang('files_count', 'admin', [$theme.files])} ({$theme.sizeString})</td>
		</tr>
		<tr>
			<td><b>{lang('total', 'admin')}</b></td>
			<td id="row_total"><b>{lang('files_count', 'admin', [$total.files])} ({$total.size})</b></td>
		</tr>
		</tbody>
	</table>
	</div>
</div>
