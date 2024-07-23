<div id="pm_spot">
    <form onSubmit="Create.send(); return false">
        <div class="mb-3 row">
            <label for="pm_username" class="col-sm-2 col-form-label">{lang("recipient", "messages")}</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="pm_username" id="pm_username" placeholder="{lang("search", "messages")}" onKeyUp="Create.autoComplete(this)" {if $username}value="{$username}"{/if}/>
                <div id="pm_username_autocomplete" class="autocomplete"></div>
            </div>
            <div class="col-sm-1 text-end">
                <span id="pm_username_error">{if $username}<img src="{$url}application/images/icons/accept.png" alt="Accepted"/>{/if}</span>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="pm_title" class="col-sm-2 col-form-label">{lang("title", "messages")}</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="pm_title" id="pm_title" maxlength="50" placeholder="{lang("hi_there", "messages")}" onBlur="Create.validateTitle(this)"/>
            </div>
            <div class="col-sm-1 text-end">
                <span id="pm_title_error"></span>
            </div>
        </div>

        <div class="mb-3">
            <textarea name="content" id="content" class="tinymce" cols="30" rows="10"></textarea>
        </div>

        <div class="text-center">
            <input type="submit" class="nice_button" value="{lang("send", "messages")}"/>
        </div>
    </form>
</div>

<script src="{$url}application/js/tiny_mce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea.tinymce',

        height: 400,

        skin: 'oxide-dark',
        content_css: 'dark',

        /* display statusbar */
        statubar: false,
        mobile: {
            menubar: true
        },

        plugins: 'searchreplace autolink autosave directionality insertdatetime lists wordcount emoticons',
        toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter emoticons | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
        image_advtab: true
    });
</script>