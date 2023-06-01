<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Err0r">
        <link rel="icon" href="assets/images/favicon.png">
        <title>Installation - FusionGEN</title>
        <link rel='stylesheet' type='text/css' href='assets/bootstrap/css/bootstrap.min.css'>
        <link rel='stylesheet' type='text/css' href='assets/css/font-awesome/css/font-awesome.min.css'>
        <link rel='stylesheet' type='text/css' href='assets/css/install.css'>
        <script type='text/javascript' src="assets/js/realms.js"></script>
        <script type='text/javascript' src='assets/js/jquery-1.11.3.min.js'></script>
        <script type='text/javascript' src='assets/js/jquery-validation/jquery.validate.min.js'></script>
        <script type='text/javascript' src='assets/js/jquery-validation/jquery.form.js'></script>
        <script type='text/javascript' src='assets/js/jquery-persist.js'></script>
    </head>
    <body>
        <div class="install-box">
            <div class="panel panel-install">
                <div class="panel-heading text-center">                    
					<img src="assets/images/logo.png">
                </div>
                <div class="panel-body no-padding">
                    <div class="tab-container clearfix">
					<div id="introduction" class="tab-title col-sm-3 active"><i class="fa fa-circle-o"></i><strong> Introduction</strong></div>
                        <div id="requirements" class="tab-title col-sm-3"><i class="fa fa-circle-o"></i><strong> Requirements</strong></span></div>
						<div id="general" class="tab-title col-sm-3"><i class="fa fa-circle-o"></i><strong> General</strong></div>
                        <div id="database" class="tab-title col-sm-3"><i class="fa fa-circle-o"></i><strong> Database</strong></div>
						<div id="realms" class="tab-title col-sm-3"><i class="fa fa-circle-o"></i><strong> Realms</strong></div>
                        <div id="finished" class="tab-title col-sm-3"><i class="fa fa-circle-o"></i><strong> Finish</strong></div> 
                    </div>
                    <div id="alert-container"></div>

                    <div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="introduction-tab">
							<div class="section clearfix">
								<div>
									<div class="introduction">
										<center><h3>Welcome to FusionGEN</h3></center>
										<center><b>Dear User</b>, This is <b>FusionGEN</b>. </br>A continuation project continued by fellow web-developers under the conditions of Open-Source. Many people loved FusionCMS, But time is evolving and FusionCMS has been idle for quite some time. We are here to bring up a new Open-Source Project to bring <b>you</b> an optimized and cared for CMS that will evolve over time with love and passion from its contributors. FusionGEN is still powered by the Codeigniter Framework, it's Original PHP Code, It's Original HTML Code and It's Original Javascript Code. What we are focusing on is improving it all. Making it stronger, faster and more Modern. </br></br>Thank you for downloading FusionGEN</br>Enjoy!</center> 
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<button type="submit" class="btn btn-info form-next">
									<span class="loader hide"> Please wait...</span>
									<span class="button-text"><i class='fa fa-chevron-right'></i> Start the installer</span> 
								</button>
							</div>
						</div>
                        <div role="tabpanel" class="tab-pane" id="requirements-tab">
                            <div class="section">
                                <p>1. Please configure your PHP settings to match following requirements:</p>
                                <hr>
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th width="25%">PHP Settings</th>
                                                <th width="27%">Current Version</th>
                                                <th>Min Version</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>PHP Version</td>
                                                <td><?php echo $current_php_version; ?></td>
                                                <td><?php echo $php_version_min; ?></td>
                                                <td class="text-center">
                                                    <?php if ($php_version_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="section">
                                <p>2. Please make sure the extensions/settings listed below are installed/enabled:</p>
                                <hr>
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th width="25%">Extension/settings</th>
                                                <th width="27%">Current Settings</th>
                                                <th>Required Settings</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>MySQLi</td>
                                                <td> <?php if ($mysql_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($mysql_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>GD</td>
                                                <td> <?php if ($gd_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($gd_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>cURL</td>
                                                <td> <?php if ($curl_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($curl_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
											<tr>
                                                <td>json</td>
                                                <td> <?php if ($json_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($json_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
											<tr>
                                                <td>GMP</td>
                                                <td> <?php if ($gmp_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($gmp_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
											<tr>
                                                <td>SOAP</td>
                                                <td> <?php if ($soap_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($soap_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
											<tr>
                                                <td>MBString</td>
                                                <td> <?php if ($mbstring_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($mbstring_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>OpenSSL</td>
                                                <td> <?php if ($openssl_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($openssl_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>XML</td>
                                                <td> <?php if ($xml_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($xml_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>

							<!--<div class="section">
                                <p>3. Please make sure the modules listed below are installed/enabled:</p>
                                <hr>
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th width="25%">Extension/settings</th>
                                                <th width="27%">Current Settings</th>
                                                <th>Required Settings</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Rewrite</td>
                                                <td> <?php if ($rewrite_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($rewrite_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>-->

                            <div class="section">
                                <p>3. Please make sure you have set the <strong>writable</strong> permission on the following folders/files:</p>
                                <hr>
                                <div>
                                    <table>
                                        <tbody>
                                            <?php
                                            foreach ($writeable_directories as $value) {
                                                ?>
                                                <tr>
                                                    <td style="width:87%;"><?php echo $value; ?></td>  
                                                    <td class="text-center">
                                                        <?php if (is_writeable(".." . $value)) { ?>
                                                            <i class="status fa fa-check-circle-o"></i>
                                                            <?php
                                                        } else {
                                                            $all_requirement_success = false;
                                                            ?>
                                                            <i class="status fa fa-times-circle-o"></i>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="panel-footer">
                                <button <?php
                                if (!$all_requirement_success) {
                                    echo "disabled=disabled";
                                }
                                ?> class="btn btn-info form-next"><i class='fa fa-chevron-right'></i> Next</button>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="general-tab">
							<form name="general-form" id="general-form" action="do_general.php" method="post" autocomplete="off">
								<div class="section clearfix">
									<p>Enter general settings</p>
									<hr>
									<div>
										<div class="form-group clearfix">
											<label class="col-md-3" for="title">Website title</label>
											<div class="col-md-9">
												<input class="form-control" type="text" value="" id="title" name="title" placeholder="My Desired Website Title">
											</div>
										</div>
										<div class="form-group clearfix">
											<label class="col-md-3" for="server_name">Server name</label>
											<div class="col-md-9">
												<input class="form-control" type="text" value="" id="server_name" name="server_name" placeholder="My Desired Server Name">
											</div>
										</div>
										<div class="form-group clearfix">
											<label class="col-md-3" for="realmlist">Realmlist</label>
											<div class="col-md-9">
												<input class="form-control" type="text" value="" id="realmlist" name="realmlist" placeholder="logon.myserver.com">
											</div>
										</div>
										<div class="form-group clearfix">
											<label class=" col-md-3" for="security_code">Admin Panel (ACP) Security Password</label>
											<div class="col-md-9">
												<input class="form-control" type="text" value="" id="security_code" name="security_code">
											</div>
										</div>
										<div class="form-group clearfix">
											<label class="col-md-3" for="max_expansion">Max expansion</label>
											<div class="col-md-9">
												<select class="form-control" id="max_expansion" name="max_expansion">
													<option value="9">Dragonflight (10.x.x)</option>
													<option value="8">Shadowlands (9.x.x)</option>
													<option value="7">Battle for Azeroth (8.x.x)</option>
													<option value="6">Legion (7.x.x)</option>
													<option value="5">Warlords of Draenor (6.x.x)</option>
													<option value="4">Mists of Pandaria 5.x.x)</option>
													<option value="3">Cataclysm (4.3.4)</option>
													<option value="2">Wrath of the Lich King (3.3.5)</option>
													<option value="1">The Burning Crusade (2.4.3)</option>
													<option value="0">Vanilla / No Expansion (1.12.1)</option>
												</select>
											</div>
										</div>
										<div class="form-group clearfix">
											<label class="col-md-3" for="keywords">Search engine: keywords (recommended for a better SEO Ranking)(separated by comma)</label>
											<div class="col-md-9">
												<input class="form-control" type="text" value="" id="keywords" name="keywords" placeholder="world of warcraft,wow,private server,pvp">
											</div>
										</div>
										<div class="form-group clearfix">
											<label class="col-md-3" for="description">Search engine: description (recommended for a better SEO Ranking)</label>
											<div class="col-md-9">
												<input class="form-control" type="text" value="" id="description" name="description" placeholder="Best World of Warcraft private server in the entire world!">
											</div>
										</div>
										<div class="form-group clearfix">
											<label class=" col-md-3" for="analytics"><a href="https://analytics.google.com/analytics/web/" target="_blank">Google Analytics</a> website ID for advanced statistics (optional)</label>
											<div class="col-md-9">
											(A more in-depth Analytic System than what is provided within the Admin Panel [ACP])
												<input class="form-control" type="text" value="" id="analytics" name="analytics" placeholder="XX-YYYYYYYY-Z">
											</div>
										</div>
									</div>
								</div>

								<div class="panel-footer">
									<button type="submit" class="btn btn-info form-next">
										<span class="loader hide"> Please wait...</span>
										<span class="button-text"><i class='fa fa-chevron-right'></i> Next</span> 
									</button>
								</div>
							</form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="database-tab">
                            <form name="database-form" id="database-form" action="do_database.php" method="post" autocomplete="off">
                                <div class="section clearfix">
                                    <p>1. Please enter your <strong>FusionGen</strong> database connection details.</p>
                                    <hr>
                                    <div>
                                        <div class="form-group clearfix">
                                            <label for="host" class="col-md-3">Database Host</label>
                                            <div class="col-md-9">
                                                <input type="text" value="" id="host" name="host" class="form-control" placeholder="FusionGen Database Host (usually localhost)">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="dbuser" class="col-md-3">Database User</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="dbuser" class="form-control" autocomplete="off" placeholder="FusionGen Database user name">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="dbpassword" class="col-md-3">Password</label>
                                            <div class=" col-md-9">
                                                <input type="password" value="" name="dbpassword" class="form-control" autocomplete="off" placeholder="FusionGen Database user password">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="dbname" class="col-md-3">Database Name</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="dbname" class="form-control" placeholder="FusionGen Database Name">
                                            </div>
                                        </div>
										<div class="form-group clearfix">
                                            <label for="dbname" class="col-md-3">Database Port</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="dbport" class="form-control" placeholder="FusionGen Database Port">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section clearfix">
                                    <p>2. Please enter your <strong>Auth</strong> database connection details.</p>
                                    <hr>
                                    <div>
                                        <div class="form-group clearfix">
                                            <label for="auth_host" class="col-md-3">Database Host</label>
                                            <div class="col-md-9">
                                                <input type="text" value="" id="auth_host"  name="auth_host" class="form-control" placeholder="Auth Database Host (usually localhost)">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="auth_db_user" class="col-md-3">Database User</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="auth_db_user" class="form-control" autocomplete="off" placeholder="Auth Database user name">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="auth_db_pass" class="col-md-3">Password</label>
                                            <div class=" col-md-9">
                                                <input type="password" value="" name="auth_db_pass" class="form-control" autocomplete="off" placeholder="Auth Database user password">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="auth_db" class="col-md-3">Database Name</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="auth_db" class="form-control" placeholder="Auth Database Name">
                                            </div>
                                        </div>
										<div class="form-group clearfix">
                                            <label for="auth_db" class="col-md-3">Database Port</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="auth_port" class="form-control" placeholder="Auth Database Port">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-footer">
                                    <button type="submit" class="btn btn-info form-next">
                                        <span class="loader hide"> Please wait...</span>
                                        <span class="button-text"><i class='fa fa-chevron-right'></i> Finish</span> 
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="realms-tab">
							<form name="realms-form" id="realms-form" action="do_realms.php" method="post" autocomplete="off">
								<div class="section clearfix">
									<p>Realms settings</p>
									<hr>
									<span>You must specify a realm so that you can log in later</span><br>
									<span>If you host the realm databases on another host (i.e. not on the server where you are running the emulator), you can configure that via the admin panel afterwards</span>
									<div>
										<div class="form-group clearfix">
											<label for="hostname" class="col-md-3">Hostname</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="hostname" name="hostname" placeholder="127.0.0.1">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="username" class="col-md-3">Database username</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="username" name="username" placeholder="Realm Database username">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="password" class="col-md-3">Database password</label>
											<div class=" col-md-9">
												<input class="form-control" type="password" value="" id="password" name="password" placeholder="Realm Database password">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="characters" class="col-md-3">Characters database</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="characters" name="characters" placeholder="Characters database name">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="world" class="col-md-3">World database</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="world" name="world" placeholder="World database name">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="cap" class="col-md-3">Max allowed players online</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="cap" name="cap" placeholder="100">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="realmName" class="col-md-3">Realm name</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="realmName" name="realmName" placeholder="Realm name">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="db_port" class="col-md-3">Database port</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="db_port" name="db_port" placeholder="3306">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="console_username" class="col-md-3" data-toggle="tooltip" data-placement="top" title="For an ingame account with GM level high enough to connect to your<br>emulator console remotely (see your emulator's config files for more details)">Console username (only required for emulators that use remote console systems) (?)</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="console_username" name="console_username" placeholder="Username from GM LvL 4 Account">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="console_password" class="col-md-3" data-toggle="tooltip" data-placement="top" title="For an ingame account with GM level high enough to connect to your<br>emulator console remotely (see your emulator's config files for more details)">Console password (only required for emulators that use remote console systems) (?)</label>
											<div class=" col-md-9">
												<input class="form-control" type="password" value="" id="console_password" name="console_password" placeholder="Password from GM LvL 4 Account">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="console_port" class="col-md-3">Console port (only required for emulators that use remote console systems; usually 3443 for RA and 7878 for SOAP)</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="console_port" name="console_port" placeholder="7878 suggested">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="emulator" class="col-md-3">Emulator</label>
											<div class=" col-md-9">
											<select class="form-control" id="emulator" name="emulator">
												<option  value="" class="form-control" disabled="disabled">Loading...</option>
											</select>
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="realm_port" class="col-md-3">Realm port (usually 8085 for Trinity/AzerothCore based emulators)</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="realm_port" name="realm_port" placeholder="8085">
											</div>
										</div>
									</div>
								</div>

								<div class="panel-footer">
									<button type="submit" class="btn btn-info form-next">
										<span class="loader hide"> Please wait...</span>
										<span class="button-text"><i class='fa fa-chevron-right'></i> Next</span> 
									</button>
								</div>
							</form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="owner-tab">
							<form name="owner-form" id="owner-form" action="do_owner.php" method="post" autocomplete="off">
								<div class="section clearfix">
									<p>Homepage Owner</p>
									<hr>
									<span>Enter your account name to get owner access on the homepage (Case sensitive!)</span>
									<div>
										<div class="form-group clearfix">
											<label for="accname" class="col-md-3">Account Name</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="accname" name="accname" placeholder="">
											</div>
										</div>
									</div>
								</div>

								<div class="panel-footer">
									<button type="submit" class="btn btn-info form-next">
										<span class="loader hide"> Please wait...</span>
										<span class="button-text"><i class='fa fa-chevron-right'></i> Complete Installation</span> 
									</button>
								</div>
							</form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="finished-tab">
                            <div class="section">
                                <div class="clearfix">
                                    <i class="status fa fa-check-circle-o pull-left" style="font-size: 50px"> </i><span class="pull-left"  style="line-height: 50px;">Congratulation! You have successfully installed FusionGen!</span>  
                                </div>

                                <div style="margin: 15px 0 15px 60px; color: #d73b3b;">
                                    Don't forget to delete "install" folder!
                                </div>

								<a class="go-to-login-page" href="<?php echo $dashboard_url; ?>">
                                    <div class="text-center">
                                        <div style="font-size: 100px;"><i class="fa fa-desktop"></i></div>
                                        <div>GO TO YOUR HOMEPAGE</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">

    var onFormSubmit = function ($form) {
        $form.find('[type="submit"]').attr('disabled', 'disabled').find(".loader").removeClass("hide");
        $form.find('[type="submit"]').find(".button-text").addClass("hide");
        $("#alert-container").html("");
    };
    var onSubmitSussess = function ($form) {
        $form.find('[type="submit"]').removeAttr('disabled').find(".loader").addClass("hide");
        $form.find('[type="submit"]').find(".button-text").removeClass("hide");
    };

    $(document).ready(function () {
        var $introductionTab = $("#introduction-tab"),
            $requirementsTab = $("#requirements-tab"),
            $generalTab = $("#general-tab"),
            $databaseTab = $("#database-tab"),
            $realmsTab = $("#realms-tab"),
            $ownerTab = $("#owner-tab");

        $(".form-next").click(function () {
			if ($requirementsTab.hasClass("active")) {
                $requirementsTab.removeClass("active");
                $generalTab.addClass("active");
                $("#requirements").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                $("#general").addClass("active");
                $("#title").focus();
            }
			if ($introductionTab.hasClass("active")) {
                $introductionTab.removeClass("active");
                $requirementsTab.addClass("active");
                $("#introduction").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                $("#requirements").addClass("active");
            }
        });

		$("#general-form").submit(function () {
            var $form = $(this);
            onFormSubmit($form);
            $form.ajaxSubmit({
                dataType: "json",
                success: function (result) {
                    onSubmitSussess($form, result);
                    if (result.success) {
                        $generalTab.removeClass("active");
                        $("#general").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                        $("#database").addClass("active");
                        $("#database-tab").addClass("active");
                        $("#host").focus();
                    } else {
						$("#alert-container").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                    }
                }
            });
            return false;
        });

        $("#database-form").submit(function () {
            var $form = $(this);
            onFormSubmit($form);
            $form.ajaxSubmit({
                dataType: "json",
                success: function (result) {
                    onSubmitSussess($form, result);
                    if (result.success) {
                        $databaseTab.removeClass("active");
                        $("#database").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                        $("#realms").addClass("active");
                        $("#realms-tab").addClass("active");
                        Ajax.initialize();
                        $("#hostname").focus();
                    } else {
                        $("#alert-container").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                    }
                }
            });
            return false;
        });

        $("#realms-form").submit(function () {
            var $form = $(this);
            onFormSubmit($form);
            $form.ajaxSubmit({
                dataType: "json",
                success: function (result) {
                    onSubmitSussess($form, result);
                    if (result.success) {
                        $realmsTab.removeClass("active");
                        $("#realms").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                        $("#finished").addClass("active");
                        $("#owner-tab").addClass("active");
                        $("#accname").focus();
                    } else {
                        $("#alert-container").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                    }
                }
            });
            return false;
        });
        $("#owner-form").submit(function () {
            var $form = $(this);
            onFormSubmit($form);
            $form.ajaxSubmit({
                dataType: "json",
                success: function (result) {
                    onSubmitSussess($form, result);
                    if (result.success) {
                        $ownerTab.removeClass("active");
                        $("#finished").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                        $("#finished").addClass("active");
                        $("#finished-tab").addClass("active");
						$('input,select,textarea').unpersist();
                    } else {
                        $("#alert-container").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                    }
                }
            });
            return false;
        });

    });
</script>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('input,select,textarea').persist();
	});
</script>

<style>
.swal2-popup {
  font-size: 1.6rem !important;
}
</style>