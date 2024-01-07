{$head}
<body>
   {$modals}
   <div align="center">
      <div id="container">
         <div id="header">
            <div class="menu">
               <ul class="clearfix">
                  <li>
                     <a id="home" href="{$url}">
                        <p></p>
                        <span></span>
                     </a>
                  </li>
                  <li>
                     <a id="forums" href="{$url}forum">
                        <p></p>
                        <span></span>
                     </a>
                  </li>
                  <li>
                     <a id="connection" href="{$url}page/connect">
                        <p></p>
                        <span></span>
                     </a>
                  </li>
                  <li><a id="logo" href="{$url}"></a></li>
				  {if $isOnline}
                  <li>
                     <a id="account" href="{$url}ucp">
                        <p></p>
                        <span></span>
                     </a>
                  </li>
				  {else}
					<li>
					   <a id="register" href="{$url}register">
						  <p></p>
						  <span></span>
					   </a>
					</li>
					{/if}
                  <li>
                     <a id="gameplay" href="{$url}armory">
                        <p></p>
                        <span></span>
                     </a>
                  </li>
				  {if $isOnline}
                  <li>
                     <a id="logout" href="{$url}logout">
                        <p></p>
                        <span></span>
                     </a>
                  </li>
				  {else}
					<li>
					   <a id="login" href="{$url}login">
						  <p></p>
						  <span></span>
					   </a>
					</li>
				  {/if}
               </ul>
               <ul class="logo-cont">
                  <li><a href="{$url}"></a></li>
               </ul>
            </div>
         </div>
         <div id="content">
            <table class="content" cellpadding="0" cellspacing="0">
               <tbody>
                  <tr>
                     <td>
                        <div>
                           <section id="slider_bg" {if !$show_slider}style="display:none;"{/if}>
						<div id="slider">
							<div id="slider_frame">
							{foreach from=$slider item=image}
								<a href="{$image.link}"><img src="{$image.image}" title="{$image.text}"/></a>
							{/foreach}
							</div>
						</div>
					</section>
                           <div class="quick-menu-container box-shadow">
                              <ul class="clearfix">
                                 <li id="vote">
                                    <a href="{$url}vote"></a>
                                 </li>
                                 <li id="shop">
                                    <a href="{$url}store"></a>
                                 </li>
                                 <li id="forum">
                                    <a href="#"></a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                        {$page}
                        <center></center>
                     </td>
                     <td class="sidebar">
                        <div class="sidebar-container">
						{if $isOnline}
                           <a class="banner box-shadow" id="ladder" href="#"></a>
						   {else}
						   <a class="banner box-shadow" id="register" href="{$url}register"></a>
						   {/if}
                        </div>
                        <div class="side-r">
                           {if $isOnline}
                           <div class="sidebar-container membersip_b box-shadow-inset box">
                              <div class="mems-b-head">
                                 <p id="membership-text"></p>
                              </div>
                              <div class="mem-b-cont text-shadow">
                                 <div style="padding: 5px 15px 15px 5px">
                                    Username: <strong><font color="#5b5851">{$CI->user->getUsername()}</font></strong><br><br>
                                    Donation Points: <font color="#6f5933">{$CI->user->getDp()}</font><br>
                                    Vote Points: <font color="#6f5933">{$CI->user->getVp()}</font><br>
                                    PM: <a href="messages">{$CI->cms_model->getMessagesCount()}</a><br><br><a href="setting">» Change pass now!</a><br>
                                    <div class="acc-p-b"><a href="ucp">» Account Panel</a></div>
                                    <div class="acc-p-b"><a href="logout">» Logout</a></div>
                                 </div>
                              </div>
                              <div class="mems-b-down"></div>
                           </div>
                           {else}
                           <div class="sidebar-container membersip_a box-shadow-inset box">
                              <div class="mems-b-head">
                                 <p id="login-text"></p>
                              </div>
                              <div class="mem-b-cont">
                                 {form_open('login')}
                                    <div class="username-container clearfix">
                                       <label>
                                          <input autocomplete="off" id="username" maxlength="32" name="login_username" class="loginbox_username" type="text">
                                          <div id="label"></div>
                                       </label>
                                    </div>
                                    <div class="password-container clearfix">
                                       <label>
                                          <input id="password" name="login_password" class="loginbox_password" type="password">
                                          <div id="label"></div>
                                       </label>
                                    </div>
                                    <input name="action" value="Login" type="hidden">
                                    <div class="clearfix" align="right">
                                       <label class="label_check">
                                       <input name="login_remember" type="checkbox"> Remember me &nbsp; &nbsp;
                                       </label>
                                    </div>
                                    <hr>
                                    <div class="clearfix">
                                       <input style="display:block;float:left;" value="Login" type="submit">
                                       <div class="quick-links" align="right">
                                          <p><a href="password_recovery">Retrieve Password</a></p>
                                          <p><a href="register">Create new Account</a></p>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                              <div class="mems-b-down"></div>
                           </div>
                           {/if}
                           <div class="realmlist sidebar-container box-shadow-inset box">
                              <center>set realmlist <font color="#43500d">{$CI->config->item('realmlist')}</font></center>
                           </div>
						   <article class="sidebox">
						   <h1 class="top">
                                 <p>Main Menu</p>
                              </h1>
						   <section class="body">
						   {foreach from=$menu_side item=menu_2}
								<li><a {$menu_2.link}><img src="{$image_path}bullet.png">{$menu_2.name}</a></li>
							{/foreach}
						   </section>
						   </article>
                           {foreach from=$sideboxes item=sidebox}
                           <article class="sidebox">
                              <h1 class="top">
                                 <p>{$sidebox.name}</p>
                              </h1>
                              <section class="body">
                                 {$sidebox.data}
                              </section>
                           </article>
                           {/foreach}
                           <div class="sidebar-container">
                              <a class="banner box-shadow" id="teamspeak" href="{$url}page/teamspeak"></a>
                           </div>
                           <div class="sidebar-container">
                              <a class="banner box-shadow" id="donate" href="{$url}donate"></a>
                           </div>
                        </div>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="footer clearfix">
            <div id="left">
               All righs reserved <font color="5d5d24">®</font> {$serverName}<br>
               This website and its content was created for {$serverName}<br>
               Design by Evil Coded by <a href="ymsgr:sendIM?keramatjokar">Nightprince</a><br>
            </div>
            <div id="right">
               <a href="{$url}">home</a>
               <a href="{$url}forum">forum</a>
               <a href="{$url}page/connect">how to connect</a>
               <a href="{$url}armory">armory</a>
               <a href="#">gameplay</a>
               <a href="#">wiki</a>
            </div>
         </div>
      </div>
   </div>
</body>
</html>