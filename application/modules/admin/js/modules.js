var Modules = {
	enableModule: function(moduleId, element)
	{
		Swal.fire({
			title: "Are you sure you want to enable '" + moduleId + "'?",
			showDenyButton: false,
			showCancelButton: true,
			confirmButtonText: 'Enable',
		}).then((result) => {
			if (result.isConfirmed)
			{
				$.post(Config.URL + 'admin/modules/enable/' + moduleId, {csrf_token_name: Config.CSRF}, function(data)
				{
					if(data == 'SUCCESS')
					{
						$(element).attr("onClick", "Modules.disableModule('" + moduleId + "', this)").html("Disable");
						$(element).removeClass("btn-success text-success");
						$(element).addClass("text-danger");
						
						var parent = $(element).parent().closest('.pull-right');

						$("#enabled_modules").append(parent.parent()[0]);
						$("#disabled_count").html(parseInt($("#disabled_count").html()) - 1);
						$("#enabled_count").html(parseInt($("#enabled_count").html()) + 1);
						
						Swal.fire('Saved!', '', 'success')
					}
				});
			}
		})
	},
	
	disableModule: function(moduleId, element)
	{
		Swal.fire({
			title: "Are you sure you want to disable '" + moduleId + "'?",
			showDenyButton: false,
			showCancelButton: true,
			confirmButtonText: 'Disable',
		}).then((result) => {
			if (result.isConfirmed)
			{
				$.post(Config.URL + 'admin/modules/disable/' + moduleId, {csrf_token_name: Config.CSRF}, function(data)
				{
					if(data == 'SUCCESS')
					{
						$(element).attr("onClick", "Modules.enableModule('" + moduleId + "', this)").html("Enable");
						
						$(element).removeClass("btn-danger text-danger");
						$(element).addClass("text-success");
						
						var parent = $(element).parent().closest('.pull-right');

						$("#disabled_modules").append(parent.parent()[0]);
						$("#enabled_count").html(parseInt($("#enabled_count").html()) - 1);
						$("#disabled_count").html(parseInt($("#disabled_count").html()) + 1);
						
						Swal.fire('Saved!', '', 'success')
					}
					else
					{
						Swal.fire(moduleId + " is a core module that can not be disabled!", '', 'error')
					}
				});
			}
		});
	}
}

var FGEN = FGEN || {};
    FGEN = {
        init: function ()
		{
            var self = this,
                obj;

            for (obj in self) {
                if (self.hasOwnProperty(obj))
				{
                    var _method = self[obj];
                    if (_method.selector !== undefined && _method.init !== undefined)
					{
                        if ($(_method.selector).length > 0) {
                            _method.init();
                        }
                    }
                }
            }
        },

        userFilesDropzone:
		{
            selector: 'form.dropzone',
            init: function () {
                var base = this,
                    container = $(base.selector);

                base.initFileUploader(base, 'form.dropzone');
            },
            initFileUploader: function (base, target)
			{
                var previewNode = document.querySelector('#FGEN-dropzone-template');

                previewNode.id = '';

                var previewTemplate = previewNode.parentNode.innerHTML;
                previewNode.parentNode.removeChild(previewNode);

                var FGENDropzone = new Dropzone(target, {
                    url: 'modules/upload',
                    maxFiles: 99,
                    maxFilesize: 2,
                    acceptedFiles: ".zip",
                    previewTemplate: previewTemplate,
                    previewsContainer: '#previews',
                    clickable: true,

                    createImageThumbnails: false,

                    dictDefaultMessage: '<i class="fa-solid fa-cloud-arrow-up fa-3x"></i><br>Drop module here to upload.',

                    dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.",

                    dictFileTooBig: 'File is too big ({{filesize}}MiB).', // Max filesize: {{maxFilesize}}MiB.
                    dictInvalidFileType: "You can't upload files of this type.",

                    dictResponseError: 'Server responded with {{statusCode}} code.',

                    dictCancelUpload: 'Cancel upload.',

                    dictUploadCanceled: 'Upload canceled.',

                    dictCancelUploadConfirmation: 'Are you sure you want to cancel this upload?',

                    dictRemoveFile: 'Remove file',

                    dictRemoveFileConfirmation: null,

                    dictMaxFilesExceeded: 'You can not upload any more files.',

                    dictFileSizeUnits: { tb: 'TB', gb: 'GB', mb: 'MB', kb: 'KB', b: 'b' }
                });

                FGENDropzone.on('addedfile', function (file)
				{
                    $('.preview-container').css('visibility', 'visible');
                    file.previewElement.classList.add('type-' + base.fileType(file.name));
                });

                FGENDropzone.on('totaluploadprogress', function (progress)
				{
                    var progr = document.querySelector('.progress .determinate');

                    if (progr === undefined || progr === null) return;

                    progr.style.width = progress + '%';
                });

                FGENDropzone.on('dragenter', function ()
				{
                    $(target).addClass('hover');
                });

                FGENDropzone.on('dragleave', function ()
				{
                    $(target).removeClass('hover');
                });

                FGENDropzone.on('drop', function ()
				{
                    $(target).removeClass('hover');
                });

                FGENDropzone.on('addedfile', function ()
				{
                    $('.no-files-uploaded').slideUp('easeInExpo');
                });

                FGENDropzone.on('success', function (file, response)
				{
                    var data = JSON.parse(response);

                    if (data["status"] !== 'error')
					{
                        Swal.fire('', data["message"], 'success')
                    }
					else
					{
						Swal.fire('', data["message"], 'error')
						FGENDropzone.removeFile(file);
					}
					console.log(data["message"]);

					//FGENDropzone.removeFile(file);
                });

				FGENDropzone.on("error", function (file, message)
				{
					Swal.fire('', message, 'error')
                    FGENDropzone.removeFile(file);
                });

				FGENDropzone.on("sending", function (file, xhr, formData)
				{
					formData.append("csrf_token_name", Config.CSRF);
					formData.append("module", file);
					console.log(file);
					console.log(xhr);
				});
            },

            fileType: function (fileName) {
                var fileType = /[.]/.exec(fileName) ? /[^.]+$/.exec(fileName) : undefined;
                return fileType[0];
            }
        }
    };