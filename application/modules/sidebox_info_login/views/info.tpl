<section class="sidebox_info">
    <table width="100%">
        <tr>
            <td><img src="{$url}application/images/icons/computer_error.png" align="absmiddle"> {lang("last_ip", "sidebox_info")}</td>
            <td>{$lastIp}</td>
        </tr>
        <tr>
            <td><img src="{$url}application/images/icons/computer.png" align="absmiddle"> {lang("current_ip", "sidebox_info")}</td>
            <td>{$currentIp}</td>
        </tr>
        <tr>
            <td><img src="{$url}application/images/icons/lightning.png" align="absmiddle"> {lang("vp", "sidebox_info")}</td>
            <td id="info_vp">{$vp}</td>
        </tr>
        <tr>
            <td><img src="{$url}application/images/icons/coins.png" align="absmiddle"> {lang("dp", "sidebox_info")}</td>
            <td id="info_dp">{$dp}</td>
        </tr>
    </table>
    <center>
		<a href="{$url}ucp" class="nice_button mt-2">{lang("user_panel", "sidebox_info")}</a>
		<a href="{$url}logout" class="nice_button mt-2">{lang("log_out", "sidebox_info")}</a>
    </center>
</section>