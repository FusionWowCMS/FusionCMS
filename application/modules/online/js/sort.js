var Sort = {
	
	nameASC: true,
	levelASC: true,
	locationASC: true,

	name: function(realm)
	{
		$("#online_realm_" + realm + " table tr:not(:first-child)").sortElements(function(a, b)
		{
			if(Sort.nameASC)
			{
				return $(a).find("th:first-child a").html() > $(b).find("th:first-child a").html() ? 1 : -1;
			}
			else
			{
				return $(a).find("th:first-child a").html() < $(b).find("th:first-child a").html() ? 1 : -1;
			}
		});

		if(Sort.nameASC)
		{
			Sort.nameASC = false;
		}
		else
		{
			Sort.nameASC = true;
		}
	},

	level: function(realm)
	{
		$("#online_realm_" + realm + " table tr:not(:first-child)").sortElements(function(a, b)
		{
			if(Sort.levelASC)
			{
				return $(a).find("th:nth-child(2)").html() > $(b).find("th:nth-child(2)").html() ? 1 : -1;
			}
			else
			{
				return $(a).find("th:nth-child(2)").html() < $(b).find("th:nth-child(2)").html() ? 1 : -1;
			}
		});

		if(Sort.levelASC)
		{
			Sort.levelASC = false;
		}
		else
		{
			Sort.levelASC = true;
		}
	},

	location: function(realm)
	{
		$("#online_realm_" + realm + " table tr:not(:first-child)").sortElements(function(a, b)
		{
			if(Sort.locationASC)
			{
				return $(a).find("th:nth-child(5)").html() > $(b).find("th:nth-child(5)").html() ? 1 : -1;
			}
			else
			{
				return $(a).find("th:nth-child(5)").html() < $(b).find("th:nth-child(5)").html() ? 1 : -1;
			}
		});

		if(Sort.locationASC)
		{
			Sort.locationASC = false;
		}
		else
		{
			Sort.locationASC = true;
		}
	}
}