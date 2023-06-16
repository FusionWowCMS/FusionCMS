/**
 * The installer now has a memory - it remembers your previous
 * configuration attempts to save you some keystrokes :-)
 * @author Jesper Lindström
 * @package FusionCMS
 * @version 6.1
 */

var Memory = (function()
{	
	"use strict";

	// Pass empty functions to older browsers to avoid errors
	if(typeof localStorage == "undefined")
	{
		return {
			save: function() { },
			populate: function() { }
		};
	}

	// Fields for each step
	var steps = {
		3: [
			"title",
			"server_name",
			"realmlist",
			"security_code",
			"max_expansion",
			"keywords",
			"description",
			"analytics",
			"captcha",
			"site_key",
			"secret_key",
			"cdn"
		],

		4: [
			"cms_hostname",
			"cms_username",
			"cms_database",
			"cms_password",
			"cms_port",
			"realmd_hostname",
			"realmd_username",
			"realmd_database",
			"realmd_password",
			"realmd_port"
		]
	};

	/**
	 * Populate all the fields with localStorage data
	 * Called upon initialization
	 */
	var populate = function()
	{
		// Make sure there is data available
		if(typeof localStorage != "undefined")
		{
			$.each(steps, function(step, fields)
			{
				fields.forEach(function(field)
				{
					if(typeof localStorage["installer_" + field] != "undefined")
					{
						console.log("Populated " + field);
						$("#" + field).val(localStorage["installer_" + field]);
					}
				});
			});
		}
	};

	/**
	 * Save all the fields of a certain step
	 * @param Int step
	 */
	var save = function(step)
	{

		// Make sure the step exists
		if(typeof steps[step] != "undefined")
		{
			// Loop through all the fields of the desired step
			steps[step].forEach(function(field)
			{
				localStorage["installer_" + field] = $("#" + field).val();
				console.log("Remembering the value of " + field);
			});
		}
	};
	
	/**
	 * Clears the memory
	 */
	var clear = function()
	{
		localStorage.clear();
	};

	// expose public methods
	return {
		save: save,
		populate: populate,
		clear: clear
	};
}());