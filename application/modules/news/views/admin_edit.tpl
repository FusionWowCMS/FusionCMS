<div class="card">
	<div class="card-header">
		Edit article <a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="{$url}news/admin">Back</a>
	</div>
	
	<div class="card-body">
		<div class="row">
			<div class="tabs">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" href="#article_en" data-bs-target="#article_en" data-bs-toggle="tab"> <img class="align-baseline" src="{$url}application/images/flags/en.png"> English</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#article_de" data-bs-target="#article_de" data-bs-toggle="tab"> <img class="align-baseline" src="{$url}application/images/flags/de.png"> German</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#article_es" data-bs-target="#article_es" data-bs-toggle="tab"> <img class="align-baseline" src="{$url}application/images/flags/es.png"> Español</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#article_fr" data-bs-target="#article_fr" data-bs-toggle="tab"> <img class="align-baseline" src="{$url}application/images/flags/fr.png"> Français</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#article_no" data-bs-target="#article_no" data-bs-toggle="tab"> <img class="align-baseline" src="{$url}application/images/flags/no.png"> Norsk</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#article_ro" data-bs-target="#article_ro" data-bs-toggle="tab"> <img class="align-baseline" src="{$url}application/images/flags/ro.png"> Română</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#article_se" data-bs-target="#article_se" data-bs-toggle="tab"> <img class="align-baseline" src="{$url}application/images/flags/se.png"> Svenska</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#article_ru" data-bs-target="#article_ru" data-bs-toggle="tab"> <img class="align-baseline" src="{$url}application/images/flags/ru.png"> Русский</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#article_zh" data-bs-target="#article_zh" data-bs-toggle="tab"> <img class="align-baseline" src="{$url}application/images/flags/cn.png"> 中国人</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#article_ko" data-bs-target="#article_ko" data-bs-toggle="tab"> <img class="align-baseline" src="{$url}application/images/flags/kr.png"> 한국어</a>
					</li>
				</ul>
				<div class="tab-content" style="background-color: transparent;">
					<div class="tab-pane active" id="article_en">
						<form role="form" onSubmit="News.send(this, {$article.id}); return false">
						<div class="form-group row mb-3">
						<label class="col-sm-2 col-form-label" for="headline_en">Headline</label>
						<div class="col-sm-10">
							<input class="form-control" id="headline_en" value="{$article.headline_en}"/>
						</div>
						</div>
						</form>

						<div class="form-group row mb-3">
							<label class="col-sm-2 col-form-label" for="description_en">Content</label>
							<div class="col-sm-10">
								<textarea name="description_en" class="tinymce_en form-control" id="description_en" cols="30" rows="10">{$article.content_en}</textarea>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="article_de">
						<form role="form" onSubmit="News.send(this, {$article.id}); return false">
						<div class="form-group row mb-3">
						<label class="col-sm-2 col-form-label" for="headline_de">Headline</label>
						<div class="col-sm-10">
							<input class="form-control" id="headline_de" value="{$article.headline_de}"/>
						</div>
						</div>
						</form>

						<div class="form-group row mb-3">
							<label class="col-sm-2 col-form-label" for="description_de">Content</label>
							<div class="col-sm-10">
								<textarea name="description_de" class="tinymce_de form-control" id="description_de" cols="30" rows="10">{$article.content_de}</textarea>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="article_es">
						<form role="form" onSubmit="News.send(this, {$article.id}); return false">
						<div class="form-group row mb-3">
						<label class="col-sm-2 col-form-label" for="headline_es">Headline</label>
						<div class="col-sm-10">
							<input class="form-control" id="headline_es" value="{$article.headline_es}"/>
						</div>
						</div>
						</form>

						<div class="form-group row mb-3">
							<label class="col-sm-2 col-form-label" for="description_es">Content</label>
							<div class="col-sm-10">
								<textarea name="description_es" class="tinymce_es form-control" id="description_es" cols="30" rows="10">{$article.content_es}</textarea>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="article_fr">
						<form role="form" onSubmit="News.send(this, {$article.id}); return false">
						<div class="form-group row mb-3">
						<label class="col-sm-2 col-form-label" for="headline_fr">Headline</label>
						<div class="col-sm-10">
							<input class="form-control" id="headline_fr" value="{$article.headline_fr}"/>
						</div>
						</div>
						</form>

						<div class="form-group row mb-3">
							<label class="col-sm-2 col-form-label" for="description_fr">Content</label>
							<div class="col-sm-10">
								<textarea name="description_fr" class="tinymce_fr form-control" id="description_fr" cols="30" rows="10">{$article.content_fr}</textarea>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="article_no">
						<form role="form" onSubmit="News.send(this, {$article.id}); return false">
						<div class="form-group row mb-3">
						<label class="col-sm-2 col-form-label" for="headline_no">Headline</label>
						<div class="col-sm-10">
							<input class="form-control" id="headline_no" value="{$article.headline_no}"/>
						</div>
						</div>
						</form>

						<div class="form-group row mb-3">
							<label class="col-sm-2 col-form-label" for="description_no">Content</label>
							<div class="col-sm-10">
								<textarea name="description_no" class="tinymce_no form-control" id="description_no" cols="30" rows="10">{$article.content_no}</textarea>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="article_ro">
						<form role="form" onSubmit="News.send(this, {$article.id}); return false">
						<div class="form-group row mb-3">
						<label class="col-sm-2 col-form-label" for="headline_ro">Headline</label>
						<div class="col-sm-10">
							<input class="form-control" id="headline_ro" value="{$article.headline_ro}"/>
						</div>
						</div>
						</form>

						<div class="form-group row mb-3">
							<label class="col-sm-2 col-form-label" for="description_ro">Content</label>
							<div class="col-sm-10">
								<textarea name="description_ro" class="tinymce_ro form-control" id="description_ro" cols="30" rows="10">{$article.content_ro}</textarea>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="article_se">
						<form role="form" onSubmit="News.send(this, {$article.id}); return false">
						<div class="form-group row mb-3">
						<label class="col-sm-2 col-form-label" for="headline_se">Headline</label>
						<div class="col-sm-10">
							<input class="form-control" id="headline_se" value="{$article.headline_se}"/>
						</div>
						</div>
						</form>

						<div class="form-group row mb-3">
							<label class="col-sm-2 col-form-label" for="description_se">Content</label>
							<div class="col-sm-10">
								<textarea name="description_se" class="tinymce_se form-control" id="description_se" cols="30" rows="10">{$article.content_se}</textarea>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="article_ru">
						<form role="form" onSubmit="News.send(this, {$article.id}); return false">
						<div class="form-group row mb-3">
						<label class="col-sm-2 col-form-label" for="headline_ru">Headline</label>
						<div class="col-sm-10">
							<input class="form-control" id="headline_ru" value="{$article.headline_ru}"/>
						</div>
						</div>
						</form>

						<div class="form-group row mb-3">
							<label class="col-sm-2 col-form-label" for="description_ru">Content</label>
							<div class="col-sm-10">
								<textarea name="description_ru" class="tinymce_ru form-control" id="description_ru" cols="30" rows="10">{$article.content_ru}</textarea>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="article_zh">
						<form role="form" onSubmit="News.send(this, {$article.id}); return false">
						<div class="form-group row mb-3">
						<label class="col-sm-2 col-form-label" for="headline_zh">Headline</label>
						<div class="col-sm-10">
							<input class="form-control" id="headline_zh" value="{$article.headline_zh}"/>
						</div>
						</div>
						</form>

						<div class="form-group row mb-3">
							<label class="col-sm-2 col-form-label" for="description_zh">Content</label>
							<div class="col-sm-10">
								<textarea name="description_zh" class="tinymce_zh form-control" id="description_zh" cols="30" rows="10">{$article.content_zh}</textarea>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="article_ko">
						<form role="form" onSubmit="News.send(this, {$article.id}); return false">
						<div class="form-group row mb-3">
						<label class="col-sm-2 col-form-label" for="headline_ko">Headline</label>
						<div class="col-sm-10">
							<input class="form-control" id="headline_ko" value="{$article.headline_ko}"/>
						</div>
						</div>
						</form>

						<div class="form-group row mb-3">
							<label class="col-sm-2 col-form-label" for="description_ko">Content</label>
							<div class="col-sm-10">
								<textarea name="description_ko" class="tinymce_ko form-control" id="description_ko" cols="30" rows="10">{$article.content_ko}</textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
					
		<form role="form" onSubmit="News.send(this, {$article.id}); return false">
			<div class="form-group row mb-3">
				<label class="col-sm-2 col-form-label" for="headline">Article settings</label>
				<div class="col-sm-10">
					<div class="checkbox-custom checkbox-default">
						<input type="checkbox" class="custom-control-input" id="comments" {if $article.comments != -1}checked="yes"{/if} value="1"/>
						<label for="comments" class="custom-control-label">Allow comments</label>
					</div>
				</div>
			</div>
		</form>
		
		<form role="form" onSubmit="News.send(this, {$article.id}); return false" enctype="multipart/form-data">
		<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label">Thumbnail Type</label>
			<div class="col-sm-10">
			<select class="form-control" id="type" onChange="News.changeType(this)">
				<option value="0">None</option>
				<option value="1" {if $article.type == 1}selected{/if}>Image</option>
				<option value="2" {if $article.type == 2}selected{/if}>Video</option>
			</select>
			</div>
		</div>

		<div id="video" {if $article.type == 2}style="display:block"{else}style="display:none;"{/if}>
			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="type_video">Video url</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="type_video" name="type_video" value="{$article.type_content}">
			</div>
			</div>
		</div>

		<div id="image" {if $article.type == 1}style="display:block"{else}style="display:none;"{/if}>
			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="type_image">Thumbnail(s)</label>
			<div class="col-sm-10">
				<div class="row" data-type="imagesloader" data-modifyimagetext="Modify image">
					<!-- Progress bar -->
					<div class="col-12 order-1 mt-2">
					<div data-type="progress" class="progress" style="height: 25px; display:none;">
						<div data-type="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%;">Load in progress...</div>
					</div>
					</div>

					<!-- Model -->
					<div data-type="image-model" class="col-4 ps-2 pe-2 pt-2" style="max-width:200px; display:none;">
				
					<div class="ratio-box text-center" data-type="image-ratio-box">
						<img data-type="noimage" class="btn btn-dark ratio-img img-fluid p-2 image border dashed rounded" src="{$url}application/themes/admin/assets/vendor/imagesloader/img/photo-camera-gray.svg" style="cursor:pointer;">
						<div data-type="loading" class="img-loading" style="color:#218838; display:none;">
						<span class="fa fa-2x fa-spin fa-spinner"></span>
						</div>
						<img data-type="preview" class="btn btn-dark ratio-img img-fluid p-2 image border dashed rounded" src="" style="display: none; cursor: default;">
						<span class="badge badge-pill badge-success p-2 w-50 main-tag" style="display:none;">Main</span>
					</div>

					<!-- Buttons -->
					<div data-type="image-buttons" class="row justify-content-center mt-2">
						<button data-type="add" class="btn btn-outline-success w-auto" type="button"><i class="fa fa-camera m2-2"></i>Add</button>
						<button data-type="btn-modify" type="button" class="btn btn-outline-success m-0 w-auto" data-toggle="popover" data-placement="right" style="display:none;">
						<i class="fa fa-pencil-alt me-2"></i>Modify
						</button>
					</div>
					</div>

					<!-- Popover operations -->
					<div data-type="popover-model" style="display:none">
					<div data-type="popover" class="ms-3 me-3 " style="min-width:150px;">
						<div class="row">
						<div class="col p-0">
							<button data-operation="main" class="btn btn-block btn-success btn-sm rounded-pill" type="button"><span class="fa fa-angle-double-up me-2"></span>Main</button>
						</div>
						</div>
						<div class="row mt-2">
						<div class="col-6 p-0 pe-1">
							<button data-operation="left" class="btn btn-block btn-outline-success btn-sm rounded-pill" type="button"><span class="fa fa-angle-left me-2"></span>Left</button>
						</div>
						<div class="col-6 p-0 ps-1">
							<button data-operation="right" class="btn btn-block btn-outline-success btn-sm rounded-pill" type="button">Right<span class="fa fa-angle-right ms-2"></span></button>
						</div>
						</div>
						<div class="row mt-2">
							<button data-operation="remove" class="btn btn-outline-danger btn-sm btn-block" type="button"><span class="fa fa-times me-2"></span>Remove</button>
						</div>
					</div>
					</div>
				</div>

				<!--Hidden file input for images-->
				<input id="files" type="file" name="files[]" data-button="" multiple="" accept="image/jpeg, image/png, image/gif," style="display:none;">
			</div>
			</div>
			<div id="image_preview"></div>
		</div>
		
		<button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Submit article</button>
	</form>
</div>
<script>
	// Ready
	$(window).on('load', function() {
		News.selectedType = {$article.type};
		//Image loader var to use when you need a function from object
		var auctionImages = {if !$article.type_content} null {else} [
			{foreach from=json_decode($article.type_content) item=image}
			{ "Url":"{$url}uploads/news/{$image}" },
			{/foreach}
		];
		{/if}

		// Create image loader plugin
		News.imagesloader = $('[data-type=imagesloader]').imagesloader({
			maxFiles: 4,
			minSelect: 1,
			imagesToLoad: auctionImages
		});

	});
</script>
<script type="text/javascript">
	var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
	
    require([
		"{$url}application/js/tiny_mce/tinymce.min.js"
	], function () {
		tinymce.init({
			mode : "textareas",

			height: 400,

			skin: useDarkMode ? 'oxide-dark' : 'oxide',
			content_css: useDarkMode ? 'dark' : 'default',

			/* display statusbar */
			statusbar: false,

			plugins: 'print preview searchreplace autolink autosave directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount textpattern help',
			toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | addcomment',
			image_advtab: true
		});
		
    });
</script>