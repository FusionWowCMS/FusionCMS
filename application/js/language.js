/**
 * Client side language layer
 * @author Jesper Lindström
 * @package FusionCMS
 * @version 6.0
 */

var Language = (function()
{
	var self = {},
		items = {};

	/** 
	 * Add a language string
	 * @param String key
	 * @param String file
	 * @param String value
	 */
	self.add = function(key, file, value)
	{
		if(typeof items[file] == "undefined")
		{
			items[file] = [];
		}

		items[file][key] = value;
	}

	/**
	 * Set the language items
	 * @param String data
	 */
	self.set = function(data)
	{
		console.log(data);
		data = data.replace(/\//, "");
		items = {};
		items = JSON.parse(data);
	}

	/**
	 * Get a language string
	 * @param String id
	 * @param String file
	 * @return String
	 */
	self.get = function(id, file)
	{
		// Default to "main"
		if(!file)
		{
			var file = "main";
		}

		// Make sure it exists
		if(typeof items[file] != "undefined" && typeof items[file][id] != "undefined")
		{
			return items[file][id];
		}
		else
		{
			console.log("Language string " + id + " in " + file + " was not found");

			return false;
		}
	}

	return self;
}());

/**
 * Shortcut function for Language.get()
 * @param String id
 * @param String file
 * @return String
 */
function lang(id, file)
{
	return Language.get(id, file);
}