<div class="row">
	<div class="col">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title font-heading font-light text-muted-800 dark:text-white md:block">{lang('sent_email_log', 'admin')}</h2>
			</header>
			<div class="card-body">
				<table class="table table-bordered table-striped mb-0" id="emaillogs">
					<thead>
						<tr>
							<th>#</th>
							<th>{lang('user', 'admin')}</th>
							<th>{lang('email', 'admin')}</th>
							<th>{lang('subject', 'admin')}</th>
							<th>{lang('time', 'admin')}</th>
							<th>{lang('message', 'admin')}</th>
							<th style="display:none;"></th>
						</tr>
					</thead>
					<tbody>
					{if $emaillogs}
						{foreach from=$emaillogs item=log}
							<tr>
								<td>{$log.id}</td>
								<td>{$CI->user->getUsername($log.uid)}</td>
								<td>{$log.email}</td>
								<td>{$log.subject}</td>
								<td>{date("Y-m-d H:i:s", $log.timestamp)}</td>
								<td>{character_limiter($log.message, 20)}</td>
								<td style="display:none;">{$log.message}</td>
							</tr>
						{/foreach}
					{/if}
					</tbody>
				</table>
			</div>
		</section>
	</div>
</div>

<script>
(function($) {

	'use strict';

	var datatableInit = function() {
		var $table = $('#emaillogs');

		// format function for row details
		var fnFormatDetails = function( datatable, tr ) {
			var data = datatable.fnGetData( tr );

			return [
				'<table class="table table-striped mb-0">',
					'<tr class="b-top-0">',
						'<td><label class="mb-0">{lang('message', 'admin')}:</label></td>',
						'<td>' + data[7] + '</td>',
					'</tr>',
				'</table>'
			].join('');
		};

		// insert the expand/collapse column
		var th = document.createElement( 'th' );
		var td = document.createElement( 'td' );
		td.innerHTML = '<i data-toggle class="far fa-plus-square text-primary h5 m-0" style="cursor: pointer;"></i>';
		td.className = "text-center";

		$table
			.find( 'thead tr' ).each(function() {
				this.insertBefore( th, this.childNodes[0] );
			});

		$table
			.find( 'tbody tr' ).each(function() {
				this.insertBefore(  td.cloneNode( true ), this.childNodes[0] );
			});

		// initialize
		var datatable = $table.dataTable({
			dom: '<"row"<"col-lg-6"l><"col-lg-6"f>><"table-responsive"t>p',
			aoColumnDefs: [{
				bSortable: false,
				aTargets: [ 0 ]
			}],
			aaSorting: [
				[1, 'asc']
			]
		});

		// add a listener
		$table.on('click', 'i[data-toggle]', function() {
			var $this = $(this),
				tr = $(this).closest( 'tr' ).get(0);

			if ( datatable.fnIsOpen(tr) ) {
				$this.removeClass( 'fa-minus-square' ).addClass( 'fa-plus-square' );
				datatable.fnClose( tr );
			} else {
				$this.removeClass( 'fa-plus-square' ).addClass( 'fa-minus-square' );
				datatable.fnOpen( tr, fnFormatDetails( datatable, tr), 'details' );
			}
		});
	};

	$(function() {
		datatableInit();
	});

}).apply(this, [jQuery]);
</script>

<script>
$(document).ready(function () {
	$('input[type="search"]').addClass('form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 h-10 text-sm leading-5 rounded-xl !bg-muted-100 dark:!bg-muted-700 focus:!bg-white dark:focus:!bg-muted-900 mb-3');
});
</script>