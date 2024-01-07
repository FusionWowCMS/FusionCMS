{if $email_activation}
    <span id="success">{lang("the_account", "register")} <b>{$account}</b> {lang("has_been_created", "register")}</span>
{else}
    <script type="text/javascript">
        setTimeout(function(){
            window.location = "{$url}ucp";
        }, 1000);
    </script>

    <span id="success">{lang("the_account", "register")} <b>{$account}</b> {lang("has_been_created_redirecting", "register")} {anchor("ucp", lang("user_panel", "register"))}...</span>
{/if}
