<div class="card">
    <div class="card-header">
        Edit Page → {$title}<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="{$url}page/admin">Back</a>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="tabs">
                <ul class="nav nav-tabs mb-2">
                    {foreach from=$languages item=language key=flag}
                        <li class="nav-item mx-1">
                            <a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl {if $language@iteration == 1}active{/if}" href="#pages_{$flag}" data-bs-target="#pages_{$flag}" data-bs-toggle="tab"> <img class="align-baseline mx-1" src="{$url}application/images/flags/{$flag}.png" alt="{$language}"> {$language}</a>
                        </li>
                    {/foreach}
                </ul>
                <form id="pages" onSubmit="Pages.send({$page.id}); return false">
                    <div class="tab-content" style="background-color: transparent;">
                        {foreach from=$languages item=language key=flag}
                            <div class="tab-pane {if $language@iteration == 1}active{/if}" id="pages_{$flag}">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" for="headline_{$flag}">Headline</label>
                                    <div class="col-sm-10">
                                        <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" id="headline_{$flag}" __headline__="{$language}" value="{is_array($page.name) ? (isset($page.name[$language]) ? $page.name[$language] : '') : $page.name}">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label class="col-sm-2 col-form-label" for="pages_content_{$flag}">Content</label>
                                    <div class="col-sm-10">
                                        <textarea name="pages_content_{$flag}" class="tinymce_{$flag} form-control max-h-52 nui-focus border-muted-300 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full border bg-white font-sans transition-all duration-300 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 min-h-[2.5rem] text-sm leading-[1.6] rounded-xl resize-none p-2" id="pages_content_{$flag}" __content__="{$language}" cols="30" rows="10">{is_array($page.content) ? (isset($page.content[$language]) ? $page.content[$language]: '') : $page.content}</textarea>
                                    </div>
                                </div>
                            </div>
                        {/foreach}

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="identifier">Unique link identifier (as in mywebsite.com/page/<b>mypage</b>)</label>
                            <div class="col-sm-10">
                                <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="identifier" name="identifier" placeholder="mypage" value="{$page.identifier}" required />
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-sm-2 col-form-label" for="visibility">Visibility mode</label>
                            <div class="col-sm-10">
                                <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" name="visibility" id="visibility" name="visibility" onChange="if(this.value == 'group'){ $('#groups').fadeIn(300); } else { $('#groups').fadeOut(300); }">
                                    <option value="everyone" {if !$page.permission}selected{/if}>Visible to everyone</option>
                                    <option value="group" {if $page.permission}selected{/if}>Controlled per group</option>
                                </select>

                                <div {if !$page.permission}style="display:none"{/if} id="groups">
                                    Please manage the group visibility via <a href="{$url}admin/aclmanager/groups">the group manager</a>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Submit page</button>

                    </div>
                </form>
           </div>
        </div>
    </div>
</div>
<script src="{$url}application/js/tiny_mce/tinymce.min.js"></script>
<script type="text/javascript">
    var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

    tinymce.init({
        selector: "textarea",

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