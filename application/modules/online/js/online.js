let table;

function showSpinner() {
	$('#playersTableContainer').html(`
        <div class="text-center p-4">
            <i class="fas fa-spinner fa-spin fa-2x"></i>
        </div>
    `);
}

function loadRealm(realmId) {
	if (!realmId) {
		$('#playersTableContainer').hide();
		return;
	}
	showSpinner();
	$('#playersTableContainer').show();

	$.ajax({
		url: Config.URL + 'online/online_refresh/' + realmId,
		method: 'GET',
		dataType: 'json',
		success: function (response) {
			if (table) {
				table.clear().destroy();
				$('#playersTable').remove();
			}

			if (response.status === "offline") {
				$('#playersTableContainer').html('<div class="alert alert-danger text-center">' + lang("offline", "online") + '</div>');
				return;
			}

			if (response.status === "empty") {
				$('#playersTableContainer').html('<div class="alert alert-warning text-center">' + lang("no_players", "online") + '</div>');
				return;
			}

			$('#playersTableContainer').html('<table id="playersTable" class="nice_table"></table>');

			const tableData = response.data.map(char => {
				return [
					`<a href="${Config.URL}character/${realmId}/${char.guid}">${char.name}</a>`,
					char.level,
					`<img src="${Config.URL}application/images/stats/${char.race}-${char.gender}.gif">`,
					`<img src="${Config.URL}application/images/stats/${char.class}.gif">`,
					char.zone
				];
			});

			table = $('#playersTable').DataTable({
				data: tableData,
				columns: [
					{ title: "Character" },
					{ title: "Level" },
					{ title: "Race" },
					{ title: "Class" },
					{ title: "Location" }
				],
				deferRender: true,
				paging: true,
				searching: true,
				processing: true
			});
		},
		error: function () {
			$('#playersTableContainer').html('<div class="alert alert-danger text-center">Error loading players</div>');
		}
	});
}

$(document).ready(function () {
	$('#realmSelect').on('change', function () {
		loadRealm($(this).val());
	});

	const firstRealmId = $('#realmSelect option:nth-child(1)').val();
	if (firstRealmId) {
		$('#realmSelect').val(firstRealmId).trigger('change');
	}
});