<div class="card">
    <div class="card-header">
        Edit article <a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="{$url}news/admin">Back</a>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="tabs">
                <ul class="nav nav-tabs mb-2">
                    {foreach from=$languages item=language key=flag}
                        <li class="nav-item mx-1">
                            <a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl {if $language@iteration == 1}active{/if}" href="#article_{$flag}" data-bs-target="#article_{$flag}" data-bs-toggle="tab"><img class="align-baseline mx-1" src="{$url}application/images/flags/{$flag}.png" alt="{$language}"> {$language}</a>
                        </li>
                    {/foreach}
                </ul>
                <div class="tab-content" style="background-color: transparent;">
                    {foreach from=$languages item=language key=flag}
                        <div class="tab-pane {if $language@iteration == 1}active{/if}" id="article_{$flag}">
                            <form role="form" onSubmit="News.send(); return false">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-2 col-form-label" for="headline_{$flag}">Headline</label>
                                    <div class="col-sm-10">
                                        <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" id="headline_{$flag}" __headline__="{$language}" value="{$article.headline[$language]}">
                                    </div>
                                </div>
                            </form>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label" for="description_{$flag}">Content</label>
                                <div class="col-sm-10">
                                    <textarea name="description_{$flag}" class="tinymce_{$flag} form-control max-h-52 nui-focus border-muted-300 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full border bg-white font-monospace transition-all duration-300 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 min-h-[2.5rem] text-sm leading-[1.6] rounded-xl resize-none p-2" id="description_{$flag}" __content__="{$language}" cols="30" rows="10">{$article.content[$language]}</textarea>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>

        <form role="form" onSubmit="News.send(this, {$article.id}); return false">
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label" for="headline">Article settings</label>
                <div class="col-sm-10">
                    <label for="comments" class="flex cursor-pointer items-center">
						<span class="relative block">
							<input type="checkbox" id="comments" class="peer absolute z-0 h-full w-full cursor-pointer opacity-0" {if $article.comments != -1}checked="yes"{/if} value="1"><span class="border-muted-300 dark:border-muted-600 dark:bg-muted-700 absolute start-0.5 top-1/2 z-10 flex h-5 w-5 -translate-y-1/2 items-center justify-center rounded-full border bg-white shadow transition focus:w-6 peer-checked:-translate-y-1/2 peer-checked:translate-x-full rtl:peer-checked:-translate-x-full"></span><span class="bg-muted-300 peer-focus:outline-muted-300 dark:bg-muted-600 dark:peer-focus:outline-muted-600 block h-6 w-11 rounded-full shadow-inner outline-1 outline-transparent transition-all duration-300 peer-focus:outline-dashed peer-focus:outline-offset-2 peer-focus:ring-0 peer-checked:bg-primary-400"></span>
							<svg aria-hidden="true" viewBox="0 0 17 12" class="pointer-events-none absolute start-2 top-1/2 z-10 h-2.5 w-2.5 translate-y-0 fill-current text-white opacity-0 transition duration-300 peer-checked:-translate-y-1/2 peer-checked:opacity-100">
								<path fill="currentColor" d="M16.576.414a1.386 1.386 0 0 1 0 1.996l-9.404 9.176A1.461 1.461 0 0 1 6.149 12c-.37 0-.74-.139-1.023-.414L.424 6.998a1.386 1.386 0 0 1 0-1.996 1.47 1.47 0 0 1 2.046 0l3.68 3.59L14.53.414a1.47 1.47 0 0 1 2.046 0z"></path>
							</svg>
						</span>
                        <span class="text-muted-400 relative ms-3 cursor-pointer select-none font-sans text-sm"></span>
                        Allow comments
                    </label>
                </div>
            </div>
        </form>

        <form role="form" onSubmit="News.send(this, {$article.id}); return false" enctype="multipart/form-data">
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Thumbnail Type</label>
                <div class="col-sm-10">
                    <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded"
                            id="type" onChange="News.changeType(this)">
                        <option value="0">None</option>
                        <option value="1" {if $article.type == 1}selected{/if}>Image</option>
                        <option value="2" {if $article.type == 2}selected{/if}>Video</option>
                    </select>
                </div>
            </div>

            <div id="video" {if $article.type == 2}style="display:block" {else}style="display:none;"{/if}>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="type_video">Video url</label>
                    <div class="col-sm-10">
                        <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="type_video" name="type_video" value="{$article.type_content}">
                    </div>
                </div>
            </div>

            <div id="image" {if $article.type == 1}style="display:block" {else}style="display:none;"{/if}>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="type_image">Thumbnail(s)</label>
                    <div class="col-sm-10">
                        <div class="row" data-type="imagesloader" data-modifyimagetext="Modify image">

                            <!-- Progress bar -->
                            <div class="col-12 order-1 mt-2">
                                <div data-type="progress" class="progress" style="height: 25px; display:none;">
                                    <div data-type="progressBar"
                                         class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                         role="progressbar" style="width: 100%;">Load in progress...
                                    </div>
                                </div>
                            </div>

                            <!-- Model -->
                            <div data-type="image-model" class="col-4 ps-2 pe-2 pt-2" style="max-width:200px; display:none;">
                                <div class="ratio-box text-center" data-type="image-ratio-box">
                                    <img data-type="noimage" class="btn btn-dark ratio-img img-fluid p-2 image nui-focus border-muted-300 dark:border-muted-700 hover:border-muted-400 focus:border-muted-400 dark:hover:border-muted-600 dark:focus:border-muted-700 group cursor-pointer rounded-lg border-[3px] border-dashed p-8 transition-colors duration-300" src="{$url}application/themes/admin/assets/vendor/imagesloader/img/photo-camera-gray.svg" style="cursor:pointer;">
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
                                            <button data-operation="main" class="btn btn-block btn-success btn-sm rounded-pill" type="button">
                                                <span class="fa fa-angle-double-up me-2"></span>Main
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-6 p-0 pe-1">
                                            <button data-operation="left" class="btn btn-block btn-outline-success btn-sm rounded-pill" type="button"><span class="fa fa-angle-left me-2"></span>Left
                                            </button>
                                        </div>
                                        <div class="col-6 p-0 ps-1">
                                            <button data-operation="right" class="btn btn-block btn-outline-success btn-sm rounded-pill" type="button">Right<span class="fa fa-angle-right ms-2"></span>
                                            </button>
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
</div>
<script>
    // Ready
    $(window).on('load', function () {
        News.selectedType = {if $article.type}{$article.type}{else}0{/if};
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
<script src="{$url}application/js/tiny_mce/tinymce.min.js"></script>
<script type="text/javascript">
    var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

    tinymce.init({
        selector : "textarea",

        height: 400,

        skin: useDarkMode ? 'oxide-dark' : 'oxide',
        content_css: useDarkMode ? 'dark' : 'default',

        /* display statusbar */
        statusbar: false,

        plugins: 'preview searchreplace autolink autosave directionality visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help code',
        toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | addcomment | code',
        image_advtab: true
    });
</script>