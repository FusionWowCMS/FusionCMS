/**
 * @package FusionCMS
 * @version 6.X
 * @author Jesper Lindström
 * @author Xavier Geernick
 * @link http://fusion-hub.com
 */

var FusionEditor = {
	
	Tools: {

		bold: function(id)
		{
			FusionEditor.wrapSelection(id, document.createElement('b'));
			FusionEditor.addEvents(id);
		},

		italic: function(id)
		{
			FusionEditor.wrapSelection(id, document.createElement('i'));
			FusionEditor.addEvents(id);
		},

		underline: function(id)
		{
			FusionEditor.wrapSelection(id, document.createElement('u'));
			FusionEditor.addEvents(id);
		},

		left: function(id)
		{
			var element = document.createElement('div');
			element.style.textAlign = "left";
			FusionEditor.wrapSelection(id, element);
		},

		center: function(id)
		{
			var element = document.createElement('div');
			element.style.textAlign = "center";
			FusionEditor.wrapSelection(id, element);
		},

		right: function(id)
		{
			var element = document.createElement('div');
			element.style.textAlign = "right";
			FusionEditor.wrapSelection(id, element);
		},

		image: function(id)
		{
			var editor = '<form onSubmit="FusionEditor.Tools.addImage(\'' + id + '\'); return false">'
						+ '<input type="text" placeholder="http://path.to/my/image.jpg" id="editor_image_' + id + '" />'
						+ '<input type="submit" value="Add" />'
						+ '</form>';
			
			FusionEditor.open(id, editor);
		},

		addImage: function(id)
		{
			var field = $("#editor_image_" + id);

			if(field.val().length > 0
			&& /^https?:\/\/.*$/.test(field.val()))
			{
				var element = document.createElement('img');
				element.src = field.val();
				FusionEditor.wrapSelection(id, element);
				FusionEditor.close(id);
				field.val("");
				FusionEditor.addEvents(id);	
			}
			else
			{
				UI.alert("Image must be a valid link");
			}
		},

		color: function(id)
		{
			var colors = "",
				colorArr = [
				"cc0000",
				"cc006e",
				"c500cc",
				"4d00cc",
				"000acc",
				"0043cc",
				"008bcc",
				"00ccc5",
				"00cc48",
				"13cc00",
				"73cc00",
				"c0cc00",
				"cc9e00",
				"cc7300",
				"333333",
				"666666"
			];

			for(i in colorArr)
			{
				colors += '<a class="fusioneditor_color" href="javascript:void(0)" onClick="FusionEditor.Tools.addColor(\'' + id + '\', \'#' + colorArr[i] + '\')" data-tip="#' + colorArr[i] + '" style="background-color:#' + colorArr[i] + '"></a>';
			}

			FusionEditor.open(id, colors, 32);
			Tooltip.refresh();
		},

		addColor: function(id, color)
		{
			var span = document.createElement("span");
			span.style.color = color;
			FusionEditor.wrapSelection(id, span);
			FusionEditor.close(id);
		},

		size: function(id)
		{
			var sizes = "",
				sizeArr = [
				"8",
				"10",
				"12",
				"14",
				"16",
				"18",
				"20",
				"22",
				"24",
				"32",
				"42",
				"52",
				"62",
				"72",
			];

			for(i in sizeArr)
			{
				sizes += '<a class="fusioneditor_size" href="javascript:void(0)" onClick="FusionEditor.Tools.addSize(\'' + id + '\', \'' + sizeArr[i] + '\')">' + sizeArr[i] + '</a>';
			}

			FusionEditor.open(id, sizes, 32);
		},

		addSize: function(id, size)
		{
			var span = document.createElement("span");
			span.style.fontSize = size + "px";

			FusionEditor.wrapSelection(id, span);
			FusionEditor.close(id);
		},

		link: function(id)
		{
			var editor = '<form onSubmit="FusionEditor.Tools.addLink(\'' + id + '\'); return false">'
						+ '<input type="text" placeholder="http://domain.com" id="editor_link_' + id + '" />'
						+ '<input type="submit" value="Add" />'
						+ '</form>';
			
			FusionEditor.open(id, editor);
		},

		addLink: function(id)
		{
			var field = $("#editor_link_" + id);

			if(field.val().length > 0
			&& /^http:\/\/.*$/.test(field.val()))
			{
				var element = document.createElement('a');
				element.href = field.val();
				element.target = "_blank";
				FusionEditor.wrapSelection(id, element, field.val());
				FusionEditor.close(id);
				field.val("");
				FusionEditor.addEvents(id);	
			}
			else
			{
				UI.alert("Link must be valid");
			}
		},

		html: function(id)
		{
			// Prepare the HTML
			var field = '<textarea id="html_field_' + id + '" style="width:95%;height:300px;font-family:Courier" spellcheck="false">' + $("#" + id).html() + '</textarea>';

			// Get the original confirm box sizes
			var originalWidth = $("#confirm").css("width"),
				originalMargin = $("#confirm").css("margin-left");

			// Make the box bigger
			$("#confirm").css({width:"600px",marginLeft:"-300px"});

			// Show the box
			UI.confirm(field, "Save", function()
			{
				// Save and return the box to normal size
				$("#" + id).html($("#html_field_" + id).val());
				FusionEditor.addEvents(id);
				$("#confirm").css({width:originalWidth,marginLeft:originalMargin});
			});
		},

		tidy: function(id)
		{
			var regex = /\<(\/)?(b|span|i|u|div)\b([A-Za-z0-9 :;,#-="']*)?\>/g,
				field = $("#" + id),
				html = field.html();

			field.html(html.replace(regex, ""));
		}
	},

	create: function(id)
	{
		$("#" + id).attr("contenteditable", "true");

		FusionEditor.addEvents(id);

		// Prevent all other click events when clicked on the toolbox
		$("#fusioneditor_" + id + "_toolbox").bind('click', function(e)
		{
			e.stopPropagation();
		});
	},

	/**
	 * Toggle the toolbox and add content
	 * @param String id
	 * @param String content
	 */
	open: function(id, content, size)
	{
		if(size)
		{
			$("#fusioneditor_" + id + "_toolbox").css({height:size});
		}
		else
		{
			// I'm sorry for this cheap fix // Jesper
			if(Config.isACP)
			{
				$("#fusioneditor_" + id + "_toolbox").css({height:"40"});
			}
			else
			{
				$("#fusioneditor_" + id + "_toolbox").css({height:"50"});
			}
		}

		if($("#fusioneditor_" + id + "_toolbox").is(":visible"))
		{
			$("#fusioneditor_" + id + "_toolbox").transition({rotateX: '90deg', opacity: 0}, 200, function()
			{
				$(this).html(content).transition({rotateX: '0deg', opacity:1}, 200);
			});
		}
		else
		{
			$("#fusioneditor_" + id + "_toolbox").transition({rotateX: '90deg', opacity:0}, 0);

			$("#fusioneditor_" + id + "_toolbox").html(content).slideDown(100, function()
			{
				$(this).transition({rotateX: '0deg', opacity:1}, 200);
			});

			//$("#fusioneditor_" + id + "_toolbox").html(content).slideToggle(200);
			$("#fusioneditor_" + id + "_close").fadeToggle(200);
		}
	},

	/**
	 * Close the toolbox
	 * @param String id
	 */
	close: function(id)
	{
		$("#fusioneditor_" + id + "_toolbox").transition({rotateX: '90deg', opacity: 0}, 200, function()
		{
			$(this).slideUp(50);
			$("#fusioneditor_" + id + "_toolbox").transition({rotateX: '0deg'});
		});

		//$("#fusioneditor_" + id + "_toolbox").slideUp(200);
		$("#fusioneditor_" + id + "_close").fadeOut(200);
	},

	/**
	 * Make images and links editable via tooltip
	 * @param String id
	 */
	addEvents: function(id, element)
	{
		var object;

		if(element)
		{
			object = $(element);
		}
		else
		{
			object = $("#" + id);
		}
		
		object.children().each(function()
		{
			// Add the event
			FusionEditor.addEvent(id, this);

			// If it has children
			if($(this).children().length > 0)
			{
				// Loop through this element
				FusionEditor.addEvents(id, this);
			}
		});
		
	},

	addEvent: function(id, element)
	{
		if(typeof $(element).data('events') == "undefined")
		{
			// Add event
			switch(element.nodeName.toLowerCase())
			{
				case "img":
					$(element).bind('click', function(e)
					{
						FusionEditor.imageMenu(e, element, id);
					});
				break;
				
				case "a":
					$(element).bind('click', function(e)
					{
						FusionEditor.linkMenu(e, element, id);
					});
				break;
			}
		}
	},

	currentImage: false,

	saveImage: function(id)
	{
		FusionEditor.currentImage.src = $("#editor_edit_image_" + id).val();
		FusionEditor.close(id);
	},

	/**
	 * Link popup helper menu
	 */
	imageMenu: function(e, element, id)
	{
		FusionEditor.currentImage = element;

		var editor = '<form onSubmit="FusionEditor.saveImage(\'' + id + '\'); return false">'
						+ '<input type="text" value="' + element.src + '" id="editor_edit_image_' + id + '" />'
						+ '<input type="submit" value="Save" />'
						+ '</form>';

		// Show menu
		FusionEditor.open(id, editor);

		// Prevent further click event handling
		e.stopPropagation();

		// Make sure we don't stack the events
		$(document).unbind('click');

		// Add the "close" click event
		$(document).bind('click', function()
		{
			$(document).unbind('click');
			FusionEditor.close(id);
		});
	},

	currentLink: false,

	saveLink: function(id)
	{
		FusionEditor.currentLink.href = $("#editor_edit_link_" + id).val();
		FusionEditor.close(id);
	},

	/**
	 * Link popup helper menu
	 */
	linkMenu: function(e, element, id)
	{
		FusionEditor.currentLink = element;

		var editor = '<form onSubmit="FusionEditor.saveLink(\'' + id + '\'); return false">'
						+ '<input type="text" value="' + element.href + '" id="editor_edit_link_' + id + '" />'
						+ '<input type="submit" value="Save" />'
						+ '</form>';

		// Show menu
		FusionEditor.open(id, editor);

		// Prevent further click event handling
		e.stopPropagation();

		// Make sure we don't stack the events
		$(document).unbind('click');

		// Add the "close" click event
		$(document).bind('click', function()
		{
			$(document).unbind('click');
			FusionEditor.close(id);
		});
	},

	/**
	 * Add the selected content to an element
	 * @param String id
	 * @param String beginTag
	 * @param String endTag
	 * @param String extra
	 */
	wrapSelection: function(id, element, extra)
	{
		// Get the selection values
		var selection = window.getSelection();
		var string = selection.toString();

		// Make sure we're modifying the correct element
		if(string.length > 0
		&& FusionEditor.hasParent(selection.anchorNode.parentElement, document.getElementById(id)))
		{
			// Get the selection
			var selectedText = selection.getRangeAt(0).extractContents();
			
			// Add the content to the element
			element.appendChild(selectedText);

			// Replace the selected text with the element
			selection.getRangeAt(0).insertNode(element);
		}
		else
		{
			if(extra)
			{
				element.innerHTML = extra;
			}
			
			$("#" + id).append(element);
		}
	},

	/**
	 * Check if element is the child of a specific element
	 * @param Object element
	 * @param Object goal
	 * @return Boolean
	 */
	hasParent: function(element, goal)
	{
		// Check if current parent is the goal
		if(element == goal)
		{
			return true;
		}
		else
		{
			// We have to go deeper :o
			var test = element.parentNode;

			while(test != goal)
			{
				try
				{
					test = test.parentNode;
				}
				catch(error)
				{
					return false;
				}
			}

			return true;
		}
	}
}