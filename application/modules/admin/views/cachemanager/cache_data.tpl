<div class="card mb-3">
	<div class="card-body">
	<table class="table table-responsive-md table-hover">
		<thead>
			<tr>
				<th>Cache</th>
				<th>Size</th>
			</tr>
		</thead>
		<tbody>
		<tr>
			<td>Item cache</td>
			<td id="row_item">{$item.files} files ({$item.sizeString})</td>
		</tr>
		<tr>
			<td>Website cache</td>
			<td id="row_website">{$website.files} files ({$website.sizeString})</td>
		</tr>

		<tr>
			<td><b>Total</b></td>
			<td id="row_total"><b>{$total.files} files ({$total.size})</b></td>
		</tr>
		</tbody>
	</table>
	</div>
</div>