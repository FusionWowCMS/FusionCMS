{if !$messages}
    <div class="text-center mt-3 font-weight-bold">Message not found</div>
{else}
    <div id="pm_read">
        {foreach from=$messages item=message}
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{$url}profile/{$message.sender_id}" data-tip="View profile" class="d-block" style="text-align:{if $message.sender_id == $me}right{else}left{/if};">
                            <img src="{$message.avatar}" class="rounded-circle" height="44" width="44" style="{if $message.sender_id == $me}margin-right:0;{/if}"/>
                            {$message.name}
                        </a>
                        <p >{date("Y/m/d", $message.time)}</p>
                    </h5>

                    <div class="message_text">{$message.message}</div>
                </div>
            </div>
        {/foreach}

        {if hasPermission('reply', 'messages')}
            <form onsubmit="Read.reply({$him}); return false;">
            <div id="pm_form">
                <textarea name="content" id="content" class="tinymce" cols="30" rows="10"></textarea>
                <div class="mt-3"></div>
                <div class="text-center">
                        <a class="nice_button" href="{$url}messages">&larr; {lang('inbox', 'messages')}</a>
                        <input type="submit" class="nice_button" value="{lang('send', 'messages')}" />
                </div>
            </div>
            </form>
        {/if}
    </div>
{/if}


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