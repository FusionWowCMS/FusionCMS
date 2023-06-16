/**
 * Validation object for the registration page
 * @package FusionCMS
 * @author Jesper Lindström
 */
var Validate = {
	/**
	 * Mark the field as valid
	 * @param String field
	 */
	valid: function(field)
	{
		var field = $(field.replace("register_", "") + "_error");
		
		field.html('<img src="' + Config.URL + 'application/images/icons/accept.png" />');
	},

	/**
	 * Mark the field as invalid
	 * @param String field
	 * @param String error
	 */
	invalid: function(field, error)
	{
		var field = $(field.replace("register_", "") + "_error");

		if(error.length > 0)
		{
			field.html('<img src="' + Config.URL + 'application/images/icons/exclamation.png" data-tip="' + error + '" />');
			Tooltip.refresh();
		}
		else
		{
			field.html('<img src="' + Config.URL + 'application/images/icons/exclamation.png" />');
		}
	},

	/**
	 * Show loading image
	 * @param String field
	 */
	ajax: function(field, error)
	{
		var field = $(field.replace("register_", "") + "_error");
		
		field.html('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>');
		
	},

	/**
	 * Validate username
	 */
	checkUsername: function()
	{
		var field_name = "#register_username",
			field = $(field_name),
			value = field.val();

		// Length check
		if(value.length < 4 || value.length > 24)
		{
			this.invalid(field_name, lang("username_limit_length", "register"));
		}

		// Alpha-numeric check
		else if(!/^[a-z0-9]+$/i.test(value))
		{
			this.invalid(field_name, lang("username_limit", "register"));
		}

		// Availability check
		else
		{
			this.ajax(field_name);

			// Perform an ajax call to check if username is available
			$.get(Config.URL + "register/check/username/" + value, function(data)
			{
				if(data == "1")
				{
					Validate.valid(field_name);
				}
				else
				{
					Validate.invalid(field_name, lang("username_not_available", "register"));
				}
			});
		}
	},

	/**
	 * Validate email
	 */
	checkEmail: function()
	{
		var field_name = "#register_email",
			field = $(field_name),
			value = field.val();

		// Email check
		if(!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(value))
		{
			this.invalid(field_name, lang("email_invalid", "register"));
		}

		// Availability check
		else
		{
			this.ajax(field_name);

			// Perform an ajax call to check if username is available
			$.post(Config.URL + "register/check/email", {email: value, csrf_token_name: Config.CSRF}, function(data)
			{
				if(data == "1")
				{
					Validate.valid(field_name);
				}
				else
				{
					Validate.invalid(field_name, lang("email_not_available", "register"));
				}
			});
		}
	},

	/**
	 * Validate password
	 */
	checkPassword: function()
	{
		var field_name = "#register_password",
			field = $(field_name),
			value = field.val();

		if(value.length < 6)
		{
			this.invalid(field_name, lang("password_short", "register"));
		}
		else
		{
			this.valid(field_name);
		}
	},

	/**
	 * Validate password confirm
	 */
	checkPasswordConfirm: function()
	{
		var field_name = "#register_password_confirm",
			field = $(field_name),
			value = field.val();

		if(value !== $("#register_password").val())
		{
			this.invalid(field_name, lang("password_match", "register"));
		}
		else
		{
			this.valid(field_name);
		}
	},
}