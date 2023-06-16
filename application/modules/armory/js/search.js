var Search = {

    show_data: function()
	{
        var table = $('select[name="table"]').val();
        var search = $('input[name="search_field"]').val();

        if (search.length > 2)
        {
            if (table == "items")
            {
                Search.show_items();
            }
            else if (table == "guilds")
            {
                Search.show_guilds();
            }
            else if (table == "characters")
            {
                Search.show_characters();
            }
        }
        else
        {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: lang("search_too_short", "armory"),
            })
        }
	},

	show_items: function() {
        var results = $('#search_box');
		var realm = $('select[name="realm"]').val();
		var table = $('select[name="table"]').val();
		var search = $('input[name="search_field"]').val();
		$.fn.dataTable.ext.errMode = 'none';

        $('#search_results_items')
        .on( 'error.dt', function ( e, settings, techNote, message ) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            })
        } )
        .DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ordering": false,
            "lengthChange": false,
            "bAutoWidth": false,
            "fnDrawCallback": function() {
                $('#search_results_characters_wrapper, #search_results_guilds, #search_results_characters, #search_results_guilds_wrapper').hide();
                $('#search_results_items').show();
                results.show();
                Tooltip.refresh();
            },
            "ajax": {
                "url": Config.URL + "armory/get_data",
                "type": "POST",
                "data": function(d) {
                    d.realm = realm;
                    d.table = table;
                    d.search = search;
                    d.start = d.start;
                    d.length = d.length;
                    d.csrf_token_name = Config.CSRF;
                }
            },
            "columns": [
                { "data": "name", "render": function(data, type, row, meta) {
                    return ''+row.icon+'<a href="'+Config.URL +'item/'+row.realm+'/'+row.id+'" class="q'+row.quality+'" data-realm="'+row.realm+'" rel="item='+row.id+'"">'+row.name+'</a>';
                }},
                { "data": "level" },
                { "data": "required" },
                { "data": "type" }
            ]
        });
	},

    show_characters: function() {
        var results = $('#search_box');
		var realm = $('select[name="realm"]').val();
		var table = $('select[name="table"]').val();
		var search = $('input[name="search_field"]').val();
		$.fn.dataTable.ext.errMode = 'none';

        $('#search_results_characters')
        .on( 'error.dt', function ( e, settings, techNote, message ) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            })
        } )
        .DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ordering": false,
            "lengthChange": false,
            "bAutoWidth": false,
            "fnDrawCallback": function() {
                $('#search_results_items_wrapper, #search_results_guilds, #search_results_items, #search_results_guilds_wrapper').hide();
                $('#search_results_characters').show();
                results.show();
            },
            "ajax": {
                "url": Config.URL + "armory/get_data",
                "type": "POST",
                "data": function(d) {
                    d.realm = realm;
                    d.table = table;
                    d.search = search;
                    d.start = d.start;
                    d.length = d.length;
                    d.csrf_token_name = Config.CSRF;
                }
            },
            "columns": [
                { "data": "", "render": function(data, type, row, meta) {
                    return '<img src="'+Config.URL +'application/images/avatars/'+row.avatar+'.gif" class="char_avatar">';
                }},
                { "data": "name", "render": function(data, type, row, meta) {
                    return '<span class="color-c'+row.class+'">'+row.name+'</span>';
                }},
                { "data": "", "render": function(data, type, row, meta) {
                    return '<span class="faction-'+row.race+'"></span>';
                }},
                { "data": "level" },
                { "data": "", "render": function(data, type, row, meta) {
                    return '<a href="'+Config.URL +'character/'+row.realm+'/'+row.guid+'" target="_blank">View</a>';
                }},
            ]
        });
	},

    show_guilds: function() {
        var results = $('#search_box');
		var realm = $('select[name="realm"]').val();
		var table = $('select[name="table"]').val();
		var search = $('input[name="search_field"]').val();
		$.fn.dataTable.ext.errMode = 'none';

        $('#search_results_guilds')
        .on( 'error.dt', function ( e, settings, techNote, message ) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            })
        } )
        .DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ordering": false,
            "lengthChange": false,
            "bAutoWidth": false,
            "fnDrawCallback": function() {
                $('#search_results_items_wrapper, #search_results_characters, #search_results_items, #search_results_characters_wrapper').hide();
                $('#search_results_guilds').show();
                results.show();
            },
            "ajax": {
                "url": Config.URL + "armory/get_data",
                "type": "POST",
                "data": function(d) {
                    d.realm = realm;
                    d.table = table;
                    d.search = search;
                    d.start = d.start;
                    d.length = d.length;
                    d.csrf_token_name = Config.CSRF;
                }
            },
            "columns": [
                { "data": "", "render": function(data, type, row, meta) {
                    return '<a href="'+Config.URL +'guild/'+row.realm+'/'+row.id+'" target="_blank">'+row.name+'</a>';
                }},
                { "data": "members" },
                { "data": "", "render": function(data, type, row, meta) {
                    return '<a href="'+Config.URL +'character/'+row.realm+'/'+row.ownerGuid+'" target="_blank">'+row.ownerName+'</a>';
                }},
            ]
        });
	},

	toggle: function()
	{
        var table = $('select[name="table"]').val();
        var search = $('input[name="search_field"]').val();

        if (search.length > 2)
        {
            if (table == "items")
            {
                Search.show_items();
            }
            else if (table == "guilds")
            {
                Search.show_guilds();
            }
            else if (table == "characters")
            {
                Search.show_characters();
            }
        }
        else
        {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: lang("search_too_short", "armory"),
            })
        }
	}
}