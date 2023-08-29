/**
 * [MLI] MultiLanguageInput
 * @package FusionGen
 * @version 6.1
 * @author Jesper Lindström
 * @link https://fusiongen.net
 */

function MultiLanguageInput(field)
{
	var originalData = field.val(),
		isJson = true,
		data = {},
		area;

	/**
	 * Start it all; assign events and so on
	 */
	var initialize = function()
	{
		field.prop("type", "hidden");
		field.after('<div class="languages"></div>');

		area = field.next('.languages');

		// Check if it's JSON or not
		try
		{
			data = JSON.parse(originalData);

			for(var i in data)
			{
				area.append(createField(i, data[i]));
			}
		}
		catch(exception)
		{
			isJson = false;
			data = {};
			data[Config.defaultLanguage] = originalData;
			field.val(JSON.stringify(data));
			area.append(createField(Config.defaultLanguage, originalData));
		}

		var addTranslation = $('<br><a href="javascript:void(0)">(add translation)</a>');

		addTranslation.on('click', function()
		{
			var options = getLanguageOptions();

			var languages = '<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="insertLanguage">' + options + '</select>';

			if(options)
			{
				Swal.fire({
					title: 'Insert',
					html: languages,
					showCancelButton: true,
				}).then((result) => {
				if (result.isConfirmed) {
					data[$("#insertLanguage").val()] = "";
					area.append(createField($("#insertLanguage").val()));
				}
				})
			}
			else
			{
				Swal.fire('','There are no more languages','error');
			}
		});

		$("#languages").append(addTranslation);
	};

	var getLanguageOptions = function()
	{
		var html = "";

		Config.languages.forEach(function(language)
		{
			if(typeof data[language] == "undefined")
			{
				html += "<option value='" + language + "'>" + language + "</option>";
			}
		});

		return html;
	};

	/**
	 * Create the element for a text field
	 * @param String language
	 * @param String text
	 */
	var createField = function(language, text)
	{
		if(!text)
		{
			var text = "";
		}

		var newField = $("<input type='text' class='form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded' data-lang='" + language + "' value='" + text + "'>");


		// Assign blur event
		newField.on('blur', function()
		{
			// Update the data
			data[language] = $(this).val();	
			field.val(JSON.stringify(data));
		});

		var flag = '<label class="col-sm-2 col-form-label">' + language + '</label>';

		return [flag, newField];
	};

	// Start it all
	initialize();
}