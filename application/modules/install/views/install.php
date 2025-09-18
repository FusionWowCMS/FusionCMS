<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
		<title>Installation - FusionCMS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" href="<?= base_url() . $INSTALL_PATH ?>images/favicon.png" />
		<link rel="stylesheet" href="<?= base_url() . $css ?>" />

		<script src="//cdnjs.cloudflare.com/ajax/libs/Kraken/3.8.2/js/html5.min.js"></script>
		<script src="<?= base_url() ?>node_modules/jquery/dist/jquery.min.js"></script>
        <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

		<script src="<?= base_url() . $INSTALL_PATH ?>js/lang.js"></script>
		<script src="<?= base_url() . $INSTALL_PATH ?>js/ui.js"></script>
		<script src="<?= base_url() . $INSTALL_PATH ?>js/ajax.js"></script>
		<script src="<?= base_url() . $INSTALL_PATH ?>js/memory.js"></script>
		<script>
		    const Config = {
		        url: '<?= base_url() ?>'
		    };

			$(document).ready(function()
			{
				UI.initialize();
				Ajax.initialize();
				Memory.populate();

                let theme=localStorage.getItem("mode")||" dark";
                document.documentElement.classList.add(theme);

                const Theme = {
                    moon: $("#moon"), sun: $("#sun"), Light: function () {
                        document.documentElement.classList.remove("dark"), document.documentElement.classList.add("light"), window.localStorage.setItem("mode", "light"), Theme.moon.removeClass("-translate-y-1/2").addClass("translate-y-[-150%]").removeClass("opacity-100").addClass("opacity-0"), Theme.sun.removeClass("translate-y-[-150%]").addClass("-translate-y-1/2").removeClass("opacity-0"), theme = "light"
                    }, Dark: function () {
                        document.documentElement.classList.remove("light"), document.documentElement.classList.add("dark"), window.localStorage.setItem("mode", "dark"), Theme.moon.addClass("-translate-y-1/2").removeClass("translate-y-[-150%]").addClass("opacity-100").removeClass("opacity-0"), Theme.sun.addClass("translate-y-[-150%]").removeClass("-translate-y-1/2").addClass("opacity-0"), theme = "dark"
                    }
                };
                theme === "dark" ? Theme.Dark() : Theme.Light();

                const modeBtn=document.getElementById("mode");modeBtn.onchange=e=>{
                theme === "dark" ? Theme.Light():Theme.Dark()};
			})
		</script>
	</head>

    <body>
		<div id="popup_bg"></div>

		<!-- confirm box -->
		<div id="confirm" class="popup">
			<h1 class="popup_question" id="confirm_question"></h1>

			<div class="popup_links">
				<button href="javascript:void(0)" id="confirm_button" class="is-button rounded bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500"></button>
				<button href="javascript:void(0)" id="confirm_hide" class="is-button rounded is-button-default" onClick="UI.hidePopup()">{{cancel}}</button>
				<div style="clear:both;"></div>
			</div>
		</div>

		<!-- alert box -->
		<div id="alert" class="popup">
			<h1 class="popup_message" id="alert_message"></h1>

			<div class="popup_links">
				<a href="javascript:void(0)" id="alert_button" class="is-button rounded bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500">{{okay}}</a>
				<div style="clear:both;"></div>
			</div>
		</div>

		<div class="bg-muted-100 dark:bg-muted-900 pb-20 bg-muted-100 dark:bg-muted-900 min-h-screen w-full">
			<div role="button" tabindex="0" class="bg-muted-800 dark:bg-muted-900 fixed start-0 top-0 z-[59] block size-full transition-opacity duration-300 lg:hidden opacity-0 pointer-events-none"></div>
			<div class="mx-auto w-full max-w-7xl">
				<div class="dark:bg-muted-800 absolute start-0 top-0 h-16 w-full bg-white">
					<div class="relative flex h-16 w-full items-center justify-between px-4">
						<div class="flex items-center">
							<img class="border-muted-200 dark:border-muted-700 flex w-56 items-center justify-center border-r pe-6" src="<?= base_url() . $INSTALL_PATH ?>images/fusion.svg" alt="FusionCMS">
							<div class="hidden items-center gap-2 ps-6 font-sans sm:flex" _lang_='{"step": "{{step}}"}' _step_>
								<p class="text-muted-500 dark:text-muted-400" _step_number_>{{step}} 1: </p>
								<h2 class="text-muted-800 font-semibold dark:text-white" _step_name_>{{language}}</h2>
							</div>
							<div class="relative hidden sm:block">
								<button type="button" class="option-menu flex size-10 items-center justify-center">
									<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon text-muted-400 size-4 transition-transform duration-300" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9l6 6l6-6"></path></svg>
								</button>
								<ul class="menus border-muted-200 dark:border-muted-700 dark:bg-muted-800 shadow-muted-300/30 dark:shadow-muted-900/30 absolute start-0 top-8 z-20 w-52 rounded-xl border bg-white p-2 shadow-xl transition-all duration-300 opacity-0 translate-y-1">
									<div class="space-y-1">
										<li id="1" class="hover:bg-muted-100 dark:hover:bg-muted-700 flex w-full items-center gap-2 rounded-lg px-3 py-2 font-sans disabled:cursor-not-allowed disabled:opacity-70">
											<a href="#" class="router-link-active">
												<p class="text-muted-500 dark:text-muted-400 text-xs">Step 1: </p>
												<h4 class="text-muted-800 text-xs font-medium dark:text-white">{{language}}</h4>
											</a>
										</li>
										<li id="2" class="hover:bg-muted-100 dark:hover:bg-muted-700 flex w-full items-center gap-2 rounded-lg px-3 py-2 font-sans disabled:cursor-not-allowed disabled:opacity-70">
											<a href="#">
												<p class="text-muted-500 dark:text-muted-400 text-xs">Step 2: </p>
												<h4 class="text-muted-800 text-xs font-medium dark:text-white">{{introduction}}</h4>
											</a>
										</li>
										<li id="3" class="hover:bg-muted-100 dark:hover:bg-muted-700 flex w-full items-center gap-2 rounded-lg px-3 py-2 font-sans disabled:cursor-not-allowed disabled:opacity-70">
											<a href="#">
												<p class="text-muted-500 dark:text-muted-400 text-xs">Step 3: </p>
												<h4 class="text-muted-800 text-xs font-medium dark:text-white">{{requirements}}</h4>
											</a>
										</li>
										<li id="4" class="hover:bg-muted-100 dark:hover:bg-muted-700 flex w-full items-center gap-2 rounded-lg px-3 py-2 font-sans disabled:cursor-not-allowed disabled:opacity-70">
											<a href="#">
												<p class="text-muted-500 dark:text-muted-400 text-xs">Step 4: </p>
												<h4 class="text-muted-800 text-xs font-medium dark:text-white">{{general}}</h4>
											</a>
										</li>
										<li id="5" class="hover:bg-muted-100 dark:hover:bg-muted-700 flex w-full items-center gap-2 rounded-lg px-3 py-2 font-sans disabled:cursor-not-allowed disabled:opacity-70">
											<a href="#">
												<p class="text-muted-500 dark:text-muted-400 text-xs">Step 5: </p>
												<h4 class="text-muted-800 text-xs font-medium dark:text-white">{{database}}</h4>
											</a>
										</li>
										<li id="6" class="hover:bg-muted-100 dark:hover:bg-muted-700 flex w-full items-center gap-2 rounded-lg px-3 py-2 font-sans disabled:cursor-not-allowed disabled:opacity-70">
											<a href="#">
												<p class="text-muted-500 dark:text-muted-400 text-xs">Step 6: </p>
												<h4 class="text-muted-800 text-xs font-medium dark:text-white">{{realms}}</h4>
											</a>
										</li>
										<li id="7" class="hover:bg-muted-100 dark:hover:bg-muted-700 flex w-full items-center gap-2 rounded-lg px-3 py-2 font-sans disabled:cursor-not-allowed disabled:opacity-70">
											<a href="#">
												<p class="text-muted-500 dark:text-muted-400 text-xs">Step 7: </p>
												<h4 class="text-muted-800 text-xs font-medium dark:text-white">{{complete}}</h4>
											</a>
										</li>
									</div>
								</ul>
							</div>
						</div>
                        <div class="flex items-center justify-end gap-4">
                            <label for="mode" class="nui-focus relative block h-9 w-9 shrink-0 overflow-hidden rounded-full transition-all duration-300 focus-visible:outline-2 dark:ring-offset-muted-900">
                                <input type="checkbox" id="mode" class="absolute start-0 top-0 z-[2] h-full w-full cursor-pointer opacity-0">
                                <span class="bg-white dark:bg-muted-800  border border-muted-300 dark:border-muted-700 relative block h-9 w-9 rounded-full">
                                    <svg id="sun" viewbox="0 0 24 24" class="pointer-events-none absolute start-1/2 top-1/2 block h-5 w-5 text-yellow-400 transition-all duration-300 translate-x-[-50%] opacity-0 rtl:translate-x-[50%] translate-y-[-150%]">
                                        <g fill="currentColor" stroke="currentColor" class="stroke-2"><circle cx="12" cy="12" r="5"></circle><path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path></g>
                                    </svg>
                                    <svg id="moon" viewbox="0 0 24 24" class="pointer-events-none absolute start-1/2 top-1/2 block h-5 w-5 text-yellow-400 transition-all duration-300 translate-x-[-45%] opacity-100 rtl:translate-x-[45%] -translate-y-1/2">
                                        <path fill="currentColor" stroke="currentColor" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" class="stroke-2"></path>
                                    </svg>
                                </span>
                            </label>
                        </div>
						<div class="absolute inset-x-0 bottom-0 z-10 w-full">
							<div id="progressbar" aria-valuenow="14.285714285714285" aria-valuemax="100" class="nui-progress nui-progress-xs nui-progress-default nui-progress-primary nui-progress-full">
								<div class="nui-progress-bar" style="width: 0;"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="dark:bg-muted-900 flex flex-col items-center justify-between bg-white py-20">
					<div class="mx-auto w-full max-w-7xl">
						<div class="grid gap-8 sm:grid-cols-12">
							<div class="col-span-12">
								<div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md mt-10 mb-10">
									<aside class="flex items-center justify-center py-8 mx-auto w-full max-w-md">
										<section class="box big step">
											<div class="flex flex-col py-2">
												<img src="<?= base_url() . $INSTALL_PATH ?>images/fusion.svg">
												<div class="mx-auto mt-4">
													<div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md shadow-muted-300/30 dark:shadow-muted-800/30 shadow-xl p-6 mt-4">
														<div class="mx-auto mb-4 max-w-xs text-center">
															<p class="font-heading text-xxs font-medium leading-normal text-white"> {{language}}</p>
														</div>
														<div class="relative h-[calc(100%_-_64px)] w-full px-10">
															<div class="grid grid-cols-4 py-6">
																<div class="relative my-4 flex items-center justify-center px-3">
																	<div class="relative">
																		<input type="radio" id="language_selection_en" class="peer absolute start-0 top-0 z-20 h-full w-full cursor-pointer opacity-0" onclick="setLanguage('en')">
																		<div class="border-muted-200 peer-checked:border-primary-500 dark:border-muted-600 flex h-14 w-14 items-center justify-center rounded-full border-2 shadow-lg transition-all duration-300"><img class="h-10 w-10 rounded-full" src="<?= base_url() ?>application/images/flags2/en.svg" alt="flag icon"></div>
																		<div class="bg-primary-500 dark:border-muted-800 absolute -end-1 -top-1 hidden h-7 w-7 items-center justify-center rounded-full border-4 border-white text-white peer-checked:flex">
																			<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-3 w-3" width="1em" height="1em" viewBox="0 0 24 24">
																				<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"></path>
																			</svg>
																		</div>
																	</div>
																</div>
																<div class="relative my-4 flex items-center justify-center px-3">
																	<div class="relative">
																		<input type="radio" id="language_selection_fa" class="peer absolute start-0 top-0 z-20 h-full w-full cursor-pointer opacity-0" onclick="setLanguage('fa')">
																		<div class="border-muted-200 peer-checked:border-primary-500 dark:border-muted-600 flex h-14 w-14 items-center justify-center rounded-full border-2 shadow-lg transition-all duration-300"><img class="h-10 w-10 rounded-full" src="<?= base_url() ?>application/images/flags2/ir.svg" alt="flag icon"></div>
																		<div class="bg-primary-500 dark:border-muted-800 absolute -end-1 -top-1 hidden h-7 w-7 items-center justify-center rounded-full border-4 border-white text-white peer-checked:flex">
																			<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-3 w-3" width="1em" height="1em" viewBox="0 0 24 24">
																				<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"></path>
																			</svg>
																		</div>
																	</div>
																</div>
																<div class="relative my-4 flex items-center justify-center px-3">
																	<div class="relative">
																		<input type="radio" id="language_selection_pt-BR" class="peer absolute start-0 top-0 z-20 h-full w-full cursor-pointer opacity-0" onclick="setLanguage('pt-BR')">
																		<div class="border-muted-200 peer-checked:border-primary-500 dark:border-muted-600 flex h-14 w-14 items-center justify-center rounded-full border-2 shadow-lg transition-all duration-300"><img class="h-10 w-10 rounded-full" src="<?= base_url() ?>application/images/flags2/br.svg" alt="flag icon"></div>
																		<div class="bg-primary-500 dark:border-muted-800 absolute -end-1 -top-1 hidden h-7 w-7 items-center justify-center rounded-full border-4 border-white text-white peer-checked:flex">
																			<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-3 w-3" width="1em" height="1em" viewBox="0 0 24 24">
																				<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"></path>
																			</svg>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="installer_navigation mt-6 flex items-center justify-between gap-2">
														<button type="button" class="next is-button rounded bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500 w-full">{{next}}</button>
													</div>
												</div>
											</div>
										</section>
										<section class="box big step" style="display:none;">
											<div class="flex flex-col py-2">
												<img src="<?= base_url() . $INSTALL_PATH ?>images/fusion.svg">
												<div class="mx-auto mt-4">
													<div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md shadow-muted-300/30 dark:shadow-muted-800/30 shadow-xl p-6 mt-4">
														<div class="mx-auto mb-4 max-w-xs text-center">
															<p class="font-heading text-xxs font-medium leading-normal text-white"> {{welcome}}</p>
														</div>
														<p class="font-alt text-base font-normal leading-normal text-muted-500 dark:text-muted-400"> <b>{{dear_customer}}</b>, {{fusion_info}} </p>
													</div>
													<div class="installer_navigation mt-6 flex items-center justify-between gap-2">
														<button type="button" class="m-0 next is-button rounded bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500 w-full">{{start_installer}}</button>
													</div>
												</div>
											</div>
										</section>

										<section class="box big step" data-validation="requirements" style="display:none;">
											<h2 class="text-white">{{server_requirements}} <span style="color:red;display:inline;padding:0px;">({{important}})</span></h2>

											<span class="flex flex-col py-2">

											<div class="introduction text-muted-500">
												<h3 class="font-heading text-xl font-light leading-tight text-muted-800 dark:text-white">{{what_need}}</h3>

												<div class="folder-permissions">
													<h4 class="font-heading text-xl font-light leading-tight text-muted-800 dark:text-white">{{folder_permissions}}</h4>
													<div style="font-weight:bold;margin:10px 0;" id="config_folder">&bull; /application/config/ {{needs_writable}} ({{see}} <a href="http://en.wikipedia.org/wiki/Chmod" target="_blank">chmod</a>)</div>

													<div style="font-weight:bold;margin:10px 0;" id="modules_folder">&bull; /application/modules/ {{is_writable}}</div>

													<div style="font-weight:bold;margin:10px 0;" id="cache_folder">&bull; /writable/cache/</div>

													<div style="font-weight:bold;margin:10px 0;" id="backups_folder">&bull; /writable/backups/</div>

													<div style="font-weight:bold;margin:10px 0;" id="logs_folder">&bull; /writable/logs/</div>

													<div style="font-weight:bold;margin:10px 0;" id="uploads_folder">&bull; /writable/uploads/</div>
												</div>

												<div class="php-version">
													<h4 class="font-heading text-xl font-light leading-tight text-muted-800 dark:text-white">{{php_version}}</h4>
													{{minimum_required_php}}: <span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">8.3.0</span> <span class="check-result"></span>
												</div>

												<div class="php-extensions">
													<h4 class="font-heading text-xl font-light leading-tight text-muted-800 dark:text-white">{{php_extensions}}</h4>

													<b>{{extensions_required_php}}:</b><br>
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">php_mysqli</span>,
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">php_curl</span>,
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">php_openssl</span>,
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">php_soap</span>,
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">php_gd</span>,
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">php_gmp</span>,
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">php_mbstring</span>,
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">php_intl</span>,
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">php_json</span>,
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">php_mcrypt</span>,
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">php_xml</span>,
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">php_zip</span>

													<span class="check-result" style="display:none"></span>
													<div id="php-extensions-missing" style="display:none;color:red;margin-top:15px">
														<b>{{extensions_required}}:</b>
														<span class="extensions"></span>
													</div>

													<div class="how_to_box">
														<div class="title bg-primary-500 dark:bg-primary-500">{{enable_extensions}}</div>
														<div class="content">
															Go into your PHP directory and find the <code>php.ini</code> file. Mine was located in <code>C:\xampp\php\</code>. Open the file with a text editor and search (CTRL+F) for one of the modules you need to enable. To enable them, simply remove the <code>;</code> character in front of the line.<br />Save the file and restart your webserver to apply the changes.<br /><br />

															<img src="<?= base_url() . $INSTALL_PATH ?>images/php.jpg" style="border:1px solid #ccc" />
														</div>
													</div>
												</div>

												<div class="apache-modules">
													<h4 class="font-heading text-xl font-light leading-tight text-muted-800 dark:text-white">{{apache_modules}}</h4>

													<b>{{recommend_apache}}<br><br>
													{{apache_required}}:</b> <br>
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">mod_rewrite</span>,
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">mod_headers</span>,
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">mod_expires</span>,
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">mod_deflate</span>
													<span class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 h-7 w-auto items-center justify-center rounded-full text-xs p-1">mod_filter</span>

													<span class="check-result" style="display:none"></span>
													<div id="apache-modules-missing" style="display:none;color:#e18f00;margin-top:15px">
														<b>{{modules_required}}:</b>
														<span class="modules"></span>
													</div>

													<div class="how_to_box">
														<div class="title bg-primary-500 dark:bg-primary-500">{{enable_modules}}</div>
														<div class="content">
															Go into your Apache directory and find the <code>httpd.conf</code> file. Mine was located in <code>C:\xampp\apache\conf\</code>. Open the file with a text editor and search <code>CTRL+F</code> for one of the modules you need to enable. To enable them, simply remove the <code>#</code> character in front of the line.<br />Save the file and restart your webserver to apply the changes.<br /><br />
															<img src="<?= base_url() . $INSTALL_PATH ?>images/apache.jpg" style="border:1px solid #ccc" />
														</div>
													</div>
												</div>
											</div>
										</span>

											<div class="installer_navigation mt-6 flex items-center justify-between gap-2">
												<button type="button" class="prev is-button rounded is-button-default w-full">{{previous_step}}</button>
												<button type="button" class="next is-button rounded bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500 w-full">{{next_step}}</button>
											</div>
										</section>

										<section class="box big step" style="display:none;">
											<form id="form-general-settings" class="mx-auto min-w-lg max-w-lg space-y-12 py-8">
												<fieldset class="relative">
													<div class="mb-6"><p class="font-heading text-base font-medium leading-none text-white">{{general_settings}}</p><p class="font-sans text-xs font-normal leading-normal text-muted-400">{{general_detail}}</p></div>
													<div class="grid grid-cols-12 gap-4">
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" id="title" data-tip="{{website_title}}" placeholder="{{website_title}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M221.66 90.34L192 120l-56-56l29.66-29.66a8 8 0 0 1 11.31 0L221.66 79a8 8 0 0 1 0 11.34Z" opacity=".2"></path><path d="m227.31 73.37l-44.68-44.69a16 16 0 0 0-22.63 0L36.69 152A15.86 15.86 0 0 0 32 163.31V208a16 16 0 0 0 16 16h44.69a15.86 15.86 0 0 0 11.31-4.69L227.31 96a16 16 0 0 0 0-22.63ZM51.31 160L136 75.31L152.69 92L68 176.68ZM48 179.31L76.69 208H48Zm48 25.38L79.31 188L164 103.31L180.69 120Zm96-96L147.31 64l24-24L216 84.68Z"></path></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" id="server_name" data-tip="{{server_name}}" placeholder="{{server_name}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M176 112L74.34 213.66a8 8 0 0 1-11.31 0L42.34 193a8 8 0 0 1 0-11.31L144 80Z" opacity=".2"></path><path d="M248 152a8 8 0 0 1-8 8h-16v16a8 8 0 0 1-16 0v-16h-16a8 8 0 0 1 0-16h16v-16a8 8 0 0 1 16 0v16h16a8 8 0 0 1 8 8ZM56 72h16v16a8 8 0 0 0 16 0V72h16a8 8 0 0 0 0-16H88V40a8 8 0 0 0-16 0v16H56a8 8 0 0 0 0 16Zm128 120h-8v-8a8 8 0 0 0-16 0v8h-8a8 8 0 0 0 0 16h8v8a8 8 0 0 0 16 0v-8h8a8 8 0 0 0 0-16Zm35.31-112L80 219.31a16 16 0 0 1-22.62 0l-20.7-20.68a16 16 0 0 1 0-22.63L176 36.69a16 16 0 0 1 22.63 0l20.68 20.68a16 16 0 0 1 0 22.63Zm-54.63 32L144 91.31l-96 96L68.68 208ZM208 68.69L187.31 48l-32 32L176 100.69Z"></path></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" id="realmlist" data-tip="{{realmlist}}" placeholder="{{realmlist}}: logon.myserver.com" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="m96 240l16-80l-64-24L160 16l-16 80l64 24Z" opacity=".2"></path><path d="M215.79 118.17a8 8 0 0 0-5-5.66L153.18 90.9l14.66-73.33a8 8 0 0 0-13.69-7l-112 120a8 8 0 0 0 3 13l57.63 21.61l-14.62 73.25a8 8 0 0 0 13.69 7l112-120a8 8 0 0 0 1.94-7.26ZM109.37 214l10.47-52.38a8 8 0 0 0-5-9.06L62 132.71l84.62-90.66l-10.46 52.38a8 8 0 0 0 5 9.06l52.8 19.8Z"></path></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" id="description" data-tip="{{description_tip}}" placeholder="{{description}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M224 56v144a8 8 0 0 1-8 8H40a8 8 0 0 1-8-8V56a8 8 0 0 1 8-8h176a8 8 0 0 1 8 8Z" opacity=".2"></path><path d="M216 40H40a16 16 0 0 0-16 16v144a16 16 0 0 0 16 16h176a16 16 0 0 0 16-16V56a16 16 0 0 0-16-16Zm0 160H40V56h176v144ZM184 96a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Zm0 32a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Zm0 32a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Z"></path></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" id="keywords" data-tip="{{keywords_tip}}" placeholder="{{keywords}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M168 96v112a8 8 0 0 1-8 8H48a8 8 0 0 1-8-8V96a8 8 0 0 1 8-8h112a8 8 0 0 1 8 8Z" opacity=".2"></path><path d="M64 216a8 8 0 0 1-8 8h-8a16 16 0 0 1-16-16v-8a8 8 0 0 1 16 0v8h8a8 8 0 0 1 8 8Zm48-8H96a8 8 0 0 0 0 16h16a8 8 0 0 0 0-16Zm-72-40a8 8 0 0 0 8-8v-16a8 8 0 0 0-16 0v16a8 8 0 0 0 8 8Zm128 24a8 8 0 0 0-8 8v8h-8a8 8 0 0 0 0 16h8a16 16 0 0 0 16-16v-8a8 8 0 0 0-8-8Zm0-80a8 8 0 0 0 8-8v-8a16 16 0 0 0-16-16h-8a8 8 0 0 0 0 16h8v8a8 8 0 0 0 8 8ZM56 80h-8a16 16 0 0 0-16 16v8a8 8 0 0 0 16 0v-8h8a8 8 0 0 0 0-16Zm152-48H96a16 16 0 0 0-16 16v40a4.44 4.44 0 0 0 0 .55A8 8 0 0 0 88 96h24a8 8 0 0 0 0-16H96V48h112v112h-32v-16a8 8 0 0 0-16 0v24a8 8 0 0 0 8 8h40a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16Z"></path></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="password" id="security_code" data-tip="{{admin_security_code}}" placeholder="{{admin_security_code}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl"/>
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-[1.15rem] w-[1.15rem]" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M224 128a96 96 0 1 1-96-96a96 96 0 0 1 96 96Z" opacity=".2"/><path d="M72 128a134.63 134.63 0 0 1-14.16 60.47a8 8 0 1 1-14.32-7.12A118.8 118.8 0 0 0 56 128a71.73 71.73 0 0 1 27-56.2a8 8 0 1 1 10 12.49A55.76 55.76 0 0 0 72 128Zm56-8a8 8 0 0 0-8 8a184.12 184.12 0 0 1-23 89.1a8 8 0 0 0 14 7.76A200.19 200.19 0 0 0 136 128a8 8 0 0 0-8-8Zm0-32a40 40 0 0 0-40 40a8 8 0 0 0 16 0a24 24 0 0 1 48 0a214.09 214.09 0 0 1-20.51 92a8 8 0 1 0 14.51 6.83A230 230 0 0 0 168 128a40 40 0 0 0-40-40Zm0-64A104.11 104.11 0 0 0 24 128a87.76 87.76 0 0 1-5 29.33a8 8 0 0 0 15.09 5.33A103.9 103.9 0 0 0 40 128a88 88 0 0 1 176 0a282.24 282.24 0 0 1-5.29 54.45a8 8 0 0 0 6.3 9.4a8.22 8.22 0 0 0 1.55.15a8 8 0 0 0 7.84-6.45A298.37 298.37 0 0 0 232 128A104.12 104.12 0 0 0 128 24ZM94.4 152.17a8 8 0 0 0-9.4 6.25a151 151 0 0 1-17.21 45.44a8 8 0 0 0 13.86 8a166.67 166.67 0 0 0 19-50.25a8 8 0 0 0-6.25-9.44ZM128 56a72.85 72.85 0 0 0-9 .56a8 8 0 0 0 2 15.87A56.08 56.08 0 0 1 184 128a252.12 252.12 0 0 1-1.92 31a8 8 0 0 0 6.92 9a8.39 8.39 0 0 0 1 .06a8 8 0 0 0 7.92-7a266.48 266.48 0 0 0 2-33A72.08 72.08 0 0 0 128 56Zm57.93 128.25a8 8 0 0 0-9.75 5.75c-1.46 5.69-3.15 11.4-5 17a8 8 0 0 0 5 10.13a7.88 7.88 0 0 0 2.55.42a8 8 0 0 0 7.58-5.46c2-5.92 3.79-12 5.35-18.05a8 8 0 0 0-5.72-9.78Z"/></g></svg>
																</div>
															</div>
														</div>
													</div>
												</fieldset>
												<fieldset class="relative">
													<div class="mb-6"><p class="font-heading text-base font-medium leading-none text-white">{{max_expansion}}</p><p class="font-sans text-xs font-normal leading-normal text-muted-400">{{max_expansion_detail}}</p></div>
													<div class="grid grid-cols-12 gap-4">
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<select id="max_expansion" data-tip="Max expansion" required class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer/input relative w-full border bg-white pe-12 ps-4 font-sans text-sm leading-5 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 rounded-xl">
																	<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="10">The War Within</option>
																	<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="9">Dragonflight/Wotlk Classic</option>
																	<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="8">Shadowlands</option>
																	<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="7">Battle for Azeroth</option>
																	<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="6">Legion</option>
																	<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="5">Warlords of Draenor</option>
																	<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="4">Mists Of Pandaria</option>
																	<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="3">Cataclysm</option>
																	<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="2">Wrath of the Lich King</option>
																	<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="1">The Burning Crusade</option>
																	<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="0">No expansion allowed</option>
																</select>
															</div>
														</div>
													</div>
												</fieldset>
												<fieldset class="relative">
													<div class="mb-6"><p class="font-heading text-base font-medium leading-none text-white">{{google_analytics}}</p><p class="font-sans text-xs font-normal leading-normal text-muted-400"><a href="http://analytics.google.com" target="_blank">{{google_analytics}}</a> {{google_analytics_detail}}</p></div>
													<div class="grid grid-cols-12 gap-4">
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" id="analytics" data-tip="{{google_analytics_web_id}} : XX-YYYYYYYY-Z" placeholder="{{google_analytics_web_id}}: XX-YYYYYYYY-Z"  class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><path fill="currentColor" d="M224 128a8 8 0 0 1-8 8h-88a8 8 0 0 1 0-16h88a8 8 0 0 1 8 8Zm-96-56h88a8 8 0 0 0 0-16h-88a8 8 0 0 0 0 16Zm88 112h-88a8 8 0 0 0 0 16h88a8 8 0 0 0 0-16ZM82.34 42.34L56 68.69L45.66 58.34a8 8 0 0 0-11.32 11.32l16 16a8 8 0 0 0 11.32 0l32-32a8 8 0 0 0-11.32-11.32Zm0 64L56 132.69l-10.34-10.35a8 8 0 0 0-11.32 11.32l16 16a8 8 0 0 0 11.32 0l32-32a8 8 0 0 0-11.32-11.32Zm0 64L56 196.69l-10.34-10.35a8 8 0 0 0-11.32 11.32l16 16a8 8 0 0 0 11.32 0l32-32a8 8 0 0 0-11.32-11.32Z"></path></svg>
																</div>
															</div>
														</div>
													</div>
												</fieldset>
												<fieldset class="relative">
													<div class="mb-6"><p class="font-heading text-base font-medium leading-none text-white">{{captcha}}</p><p class="font-sans text-xs font-normal leading-normal text-muted-400">{{enable}} <a href="http://www.google.com/recaptcha/admin" target="_blank">{{google_captcha}}</a> ({{optional}})</p></div>
													<div class="grid grid-cols-12 gap-4">
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<select id="captcha" data-tip="{{enable}} {{captcha}}" onChange="if(this.value == 'recaptcha' || this.value == 'recaptcha3'){ $('#captcha_site_keys').fadeIn(150); } else { $('#captcha_site_keys').fadeOut(150); };if(this.value == 'recaptcha' || this.value == 'recaptcha3'){ $('#captcha_secret_keys').fadeIn(150); } else { $('#captcha_secret_keys').fadeOut(150); }" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer/input relative w-full border bg-white pe-12 ps-4 font-sans text-sm leading-5 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 rounded-xl">
																	<option value="recaptcha3">{{google_captcha3}}</option>
																	<option value="recaptcha">{{google_captcha}}</option>
																	<option value="inbuilt">{{image_captcha}}</option>
																	<option value="disabled" selected>{{disable}}</option>
																</select>
															</div>
														</div>
														<div id="captcha_site_keys" style="display:none" class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" id="site_key" data-tip="{{site_key_detail}}" placeholder="{{site_key}} (?)" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M216 96v112a8 8 0 0 1-8 8H48a8 8 0 0 1-8-8V96a8 8 0 0 1 8-8h160a8 8 0 0 1 8 8Z" opacity=".2"></path><path d="M208 80h-32V56a48 48 0 0 0-96 0v24H48a16 16 0 0 0-16 16v112a16 16 0 0 0 16 16h160a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16ZM96 56a32 32 0 0 1 64 0v24H96Zm112 152H48V96h160v112Zm-68-56a12 12 0 1 1-12-12a12 12 0 0 1 12 12Z"></path></g></svg>
																</div>
															</div>
														</div>
														<div id="captcha_secret_keys" style="display:none" class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" id="secret_key" data-tip="{{secret_key_detail}}" placeholder="{{secret_key}} (?)" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M216 96v112a8 8 0 0 1-8 8H48a8 8 0 0 1-8-8V96a8 8 0 0 1 8-8h160a8 8 0 0 1 8 8Z" opacity=".2"></path><path d="M208 80h-32V56a48 48 0 0 0-96 0v24H48a16 16 0 0 0-16 16v112a16 16 0 0 0 16 16h160a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16ZM96 56a32 32 0 0 1 64 0v24H96Zm112 152H48V96h160v112Zm-68-56a12 12 0 1 1-12-12a12 12 0 0 1 12 12Z"></path></g></svg>
																</div>
															</div>
														</div>
													</div>
												</fieldset>
												<fieldset class="relative">
													<div class="mb-6"><p class="font-heading text-base font-medium leading-none text-white">{{cdn}}</p><p class="font-sans text-xs font-normal leading-normal text-muted-400">{{cdn_detail}}</p></div>
													<div class="grid grid-cols-12 gap-4">
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<select id="cdn" onChange="if(this.value == '1'){ $('#cdn_link_box').fadeIn(150); } else { $('#cdn_link_box').fadeOut(150); }" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer/input relative w-full border bg-white pe-12 ps-4 font-sans text-sm leading-5 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 rounded-xl">
																	<option value="1">{{yes}}</option>
																	<option value="0" selected>{{no}}</option>
																</select>
															</div>
														</div>
                                                        <div id="cdn_link_box" style="display:none" class="col-span-12">
                                                            <div class="group/nui-input relative">
                                                                <input type="text" id="cdn_link" data-tip="{{cdn}}" placeholder="{{cdn}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" />
                                                                <div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="800px" class="icon h-5 w-5" height="800px" viewBox="0 -11.18 69.999 69.999"><path d="m -134.73689,547.80281 c -2.83803,-0.4798 -5.15501,-1.6594 -7.31738,-3.7253 -3.76731,-3.5993 -5.21055,-9.2617 -3.61132,-14.1686 1.23516,-3.7898 3.86037,-6.7734 7.45394,-8.4714 0.86135,-0.407 0.86567,-0.4119 0.78299,-0.8931 -0.4327,-2.5179 -0.37212,-4.237 0.21737,-6.1689 0.39133,-1.2826 1.37956,-3.1052 2.21812,-4.0911 2.40512,-2.8276 5.40718,-4.2284 9.02591,-4.2116 3.22111,0.015 5.7174,1.0412 8.18677,3.3657 l 0.69859,0.6576 0.33189,-0.7174 c 1.45499,-3.1451 4.72382,-6.3603 7.9933,-7.862 1.48383,-0.6816 3.8113,-1.3734 3.8113,-1.1328 0,0.022 -1.82658,4.9217 -4.05908,10.8884 -2.32461,6.2129 -4.0419,10.9955 -4.01888,11.1924 l 0.0402,0.3438 3.77844,0.069 c 2.07814,0.038 3.85573,0.1188 3.95019,0.1799 0.0945,0.061 0.17174,0.2311 0.17174,0.3776 0,0.1466 -1.49028,3.899 -3.31173,8.3388 -4.012,9.7793 -3.86655,9.4133 -3.71867,9.3557 0.1436,-0.056 22.076195,-25.0491 22.387355,-25.5114 0.18499,-0.2748 0.18796,-0.3388 0.0207,-0.4457 -0.11411,-0.073 -1.995,-0.088 -4.52672,-0.036 -4.46253,0.092 -4.94286,0.049 -4.94286,-0.4435 0,-0.2596 6.72529,-11.601 6.87925,-11.601 0.19777,0 1.67318,1.2939 2.60561,2.2851 2.14577,2.281 3.63651,5.3049 4.1827,8.4842 0.2618,1.524 0.26247,4.0676 0.001,5.5123 -0.24762,1.3705 -0.25029,1.5801 -0.0201,1.5801 0.35775,0 2.91888,1.3453 3.73191,1.9603 2.47741,1.8739 4.36131,4.6628 5.17272,7.6575 0.27541,1.0165 0.31563,1.4797 0.31022,3.5724 -0.006,2.2031 -0.0372,2.508 -0.37638,3.641 -1.4756,4.9295 -5.04791,8.4424 -9.96785,9.8019 l -1.32161,0.3652 -22.808045,0.022 c -19.05187,0.018 -22.99644,-0.01 -23.95208,-0.1713 z" fill="currentColor" transform="translate(146.31 -500.335)"/>
                                                                </div>
                                                            </div>
                                                        </div>
													</div>
												</fieldset>
											</form>

											<div class="installer_navigation mt-6 flex items-center justify-between gap-2">
												<button type="button" class="prev is-button rounded is-button-default w-full">{{previous_step}}</button>
												<button type="button" class="next is-button rounded bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500 w-full">{{next_step}}</button>
											</div>
										</section>

										<section class="box big step" data-validation="database" style="display:none;">
											<h3 class="font-heading text-xl font-light leading-tight text-muted-800 dark:text-white">{{database_settings}}</h3>

											<form class="mx-auto min-w-lg max-w-lg space-y-12 py-8">
												<fieldset class="relative">
													<div class="mb-6"><p class="font-heading text-base font-medium leading-none text-white">{{website_database}}</p><p class="font-sans text-xs font-normal leading-normal text-muted-400">{{website_database_detail}}</p></div>
													<div class="grid grid-cols-12 gap-4">
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" id="cms_hostname" data-tip="{{hostname}}" placeholder="{{hostname}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M224 56v144a8 8 0 0 1-8 8H40a8 8 0 0 1-8-8V56a8 8 0 0 1 8-8h176a8 8 0 0 1 8 8Z" opacity=".2"></path><path d="M216 40H40a16 16 0 0 0-16 16v144a16 16 0 0 0 16 16h176a16 16 0 0 0 16-16V56a16 16 0 0 0-16-16Zm0 160H40V56h176v144ZM184 96a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Zm0 32a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Zm0 32a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Z"></path></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" id="cms_username" data-tip="{{username}}" placeholder="{{username}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M168 144a40 40 0 1 1-40-40a40 40 0 0 1 40 40ZM64 56a32 32 0 1 0 32 32a32 32 0 0 0-32-32Zm128 0a32 32 0 1 0 32 32a32 32 0 0 0-32-32Z" opacity=".2"></path><path d="M244.8 150.4a8 8 0 0 1-11.2-1.6A51.6 51.6 0 0 0 192 128a8 8 0 0 1 0-16a24 24 0 1 0-23.24-30a8 8 0 1 1-15.5-4A40 40 0 1 1 219 117.51a67.94 67.94 0 0 1 27.43 21.68a8 8 0 0 1-1.63 11.21ZM190.92 212a8 8 0 1 1-13.85 8a57 57 0 0 0-98.15 0a8 8 0 1 1-13.84-8a72.06 72.06 0 0 1 33.74-29.92a48 48 0 1 1 58.36 0A72.06 72.06 0 0 1 190.92 212ZM128 176a32 32 0 1 0-32-32a32 32 0 0 0 32 32Zm-56-56a8 8 0 0 0-8-8a24 24 0 1 1 23.24-30a8 8 0 1 0 15.5-4A40 40 0 1 0 37 117.51a67.94 67.94 0 0 0-27.4 21.68a8 8 0 1 0 12.8 9.61A51.6 51.6 0 0 1 64 128a8 8 0 0 0 8-8Z"></path></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="password" id="cms_password" data-tip="{{password}}" placeholder="{{password}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-[1.15rem] w-[1.15rem]" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M224 128a96 96 0 1 1-96-96a96 96 0 0 1 96 96Z" opacity=".2"/><path d="M72 128a134.63 134.63 0 0 1-14.16 60.47a8 8 0 1 1-14.32-7.12A118.8 118.8 0 0 0 56 128a71.73 71.73 0 0 1 27-56.2a8 8 0 1 1 10 12.49A55.76 55.76 0 0 0 72 128Zm56-8a8 8 0 0 0-8 8a184.12 184.12 0 0 1-23 89.1a8 8 0 0 0 14 7.76A200.19 200.19 0 0 0 136 128a8 8 0 0 0-8-8Zm0-32a40 40 0 0 0-40 40a8 8 0 0 0 16 0a24 24 0 0 1 48 0a214.09 214.09 0 0 1-20.51 92a8 8 0 1 0 14.51 6.83A230 230 0 0 0 168 128a40 40 0 0 0-40-40Zm0-64A104.11 104.11 0 0 0 24 128a87.76 87.76 0 0 1-5 29.33a8 8 0 0 0 15.09 5.33A103.9 103.9 0 0 0 40 128a88 88 0 0 1 176 0a282.24 282.24 0 0 1-5.29 54.45a8 8 0 0 0 6.3 9.4a8.22 8.22 0 0 0 1.55.15a8 8 0 0 0 7.84-6.45A298.37 298.37 0 0 0 232 128A104.12 104.12 0 0 0 128 24ZM94.4 152.17a8 8 0 0 0-9.4 6.25a151 151 0 0 1-17.21 45.44a8 8 0 0 0 13.86 8a166.67 166.67 0 0 0 19-50.25a8 8 0 0 0-6.25-9.44ZM128 56a72.85 72.85 0 0 0-9 .56a8 8 0 0 0 2 15.87A56.08 56.08 0 0 1 184 128a252.12 252.12 0 0 1-1.92 31a8 8 0 0 0 6.92 9a8.39 8.39 0 0 0 1 .06a8 8 0 0 0 7.92-7a266.48 266.48 0 0 0 2-33A72.08 72.08 0 0 0 128 56Zm57.93 128.25a8 8 0 0 0-9.75 5.75c-1.46 5.69-3.15 11.4-5 17a8 8 0 0 0 5 10.13a7.88 7.88 0 0 0 2.55.42a8 8 0 0 0 7.58-5.46c2-5.92 3.79-12 5.35-18.05a8 8 0 0 0-5.72-9.78Z"/></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" id="cms_database" data-tip="{{database_name}}" placeholder="{{database_name}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />															<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M88 104v96H32v-96Z" opacity=".2"></path><path d="M224 48H32a8 8 0 0 0-8 8v136a16 16 0 0 0 16 16h176a16 16 0 0 0 16-16V56a8 8 0 0 0-8-8ZM40 112h40v32H40Zm56 0h120v32H96Zm120-48v32H40V64ZM40 160h40v32H40Zm176 32H96v-32h120v32Z"></path></g></svg>
															</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="number" id="cms_port" data-tip="{{port}}" placeholder="{{port}}: 3306" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />															<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon text-muted-400 h-5 w-5 transition-transform duration-300" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></g></svg>
															</div>
															</div>
														</div>
													</div>
												</fieldset>

												<br />
												<fieldset class="relative">
													<div class="mb-6"><p class="font-heading text-base font-medium leading-none text-white">{{auth_database}}</p><p class="font-sans text-xs font-normal leading-normal text-muted-400">{{auth_database_detail}}</p></div>
													<div class="grid grid-cols-12 gap-4">
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" id="realmd_hostname" data-tip="{{hostname}}" placeholder="{{hostname}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M224 56v144a8 8 0 0 1-8 8H40a8 8 0 0 1-8-8V56a8 8 0 0 1 8-8h176a8 8 0 0 1 8 8Z" opacity=".2"></path><path d="M216 40H40a16 16 0 0 0-16 16v144a16 16 0 0 0 16 16h176a16 16 0 0 0 16-16V56a16 16 0 0 0-16-16Zm0 160H40V56h176v144ZM184 96a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Zm0 32a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Zm0 32a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Z"></path></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" id="realmd_username" data-tip="{{username}}" placeholder="{{username}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M168 144a40 40 0 1 1-40-40a40 40 0 0 1 40 40ZM64 56a32 32 0 1 0 32 32a32 32 0 0 0-32-32Zm128 0a32 32 0 1 0 32 32a32 32 0 0 0-32-32Z" opacity=".2"></path><path d="M244.8 150.4a8 8 0 0 1-11.2-1.6A51.6 51.6 0 0 0 192 128a8 8 0 0 1 0-16a24 24 0 1 0-23.24-30a8 8 0 1 1-15.5-4A40 40 0 1 1 219 117.51a67.94 67.94 0 0 1 27.43 21.68a8 8 0 0 1-1.63 11.21ZM190.92 212a8 8 0 1 1-13.85 8a57 57 0 0 0-98.15 0a8 8 0 1 1-13.84-8a72.06 72.06 0 0 1 33.74-29.92a48 48 0 1 1 58.36 0A72.06 72.06 0 0 1 190.92 212ZM128 176a32 32 0 1 0-32-32a32 32 0 0 0 32 32Zm-56-56a8 8 0 0 0-8-8a24 24 0 1 1 23.24-30a8 8 0 1 0 15.5-4A40 40 0 1 0 37 117.51a67.94 67.94 0 0 0-27.4 21.68a8 8 0 1 0 12.8 9.61A51.6 51.6 0 0 1 64 128a8 8 0 0 0 8-8Z"></path></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="password" id="realmd_password" data-tip="{{password}}" placeholder="{{password}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-[1.15rem] w-[1.15rem]" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M224 128a96 96 0 1 1-96-96a96 96 0 0 1 96 96Z" opacity=".2"/><path d="M72 128a134.63 134.63 0 0 1-14.16 60.47a8 8 0 1 1-14.32-7.12A118.8 118.8 0 0 0 56 128a71.73 71.73 0 0 1 27-56.2a8 8 0 1 1 10 12.49A55.76 55.76 0 0 0 72 128Zm56-8a8 8 0 0 0-8 8a184.12 184.12 0 0 1-23 89.1a8 8 0 0 0 14 7.76A200.19 200.19 0 0 0 136 128a8 8 0 0 0-8-8Zm0-32a40 40 0 0 0-40 40a8 8 0 0 0 16 0a24 24 0 0 1 48 0a214.09 214.09 0 0 1-20.51 92a8 8 0 1 0 14.51 6.83A230 230 0 0 0 168 128a40 40 0 0 0-40-40Zm0-64A104.11 104.11 0 0 0 24 128a87.76 87.76 0 0 1-5 29.33a8 8 0 0 0 15.09 5.33A103.9 103.9 0 0 0 40 128a88 88 0 0 1 176 0a282.24 282.24 0 0 1-5.29 54.45a8 8 0 0 0 6.3 9.4a8.22 8.22 0 0 0 1.55.15a8 8 0 0 0 7.84-6.45A298.37 298.37 0 0 0 232 128A104.12 104.12 0 0 0 128 24ZM94.4 152.17a8 8 0 0 0-9.4 6.25a151 151 0 0 1-17.21 45.44a8 8 0 0 0 13.86 8a166.67 166.67 0 0 0 19-50.25a8 8 0 0 0-6.25-9.44ZM128 56a72.85 72.85 0 0 0-9 .56a8 8 0 0 0 2 15.87A56.08 56.08 0 0 1 184 128a252.12 252.12 0 0 1-1.92 31a8 8 0 0 0 6.92 9a8.39 8.39 0 0 0 1 .06a8 8 0 0 0 7.92-7a266.48 266.48 0 0 0 2-33A72.08 72.08 0 0 0 128 56Zm57.93 128.25a8 8 0 0 0-9.75 5.75c-1.46 5.69-3.15 11.4-5 17a8 8 0 0 0 5 10.13a7.88 7.88 0 0 0 2.55.42a8 8 0 0 0 7.58-5.46c2-5.92 3.79-12 5.35-18.05a8 8 0 0 0-5.72-9.78Z"/></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" id="realmd_database" data-tip="{{database_name}}" placeholder="{{database_name}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />															<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M88 104v96H32v-96Z" opacity=".2"></path><path d="M224 48H32a8 8 0 0 0-8 8v136a16 16 0 0 0 16 16h176a16 16 0 0 0 16-16V56a8 8 0 0 0-8-8ZM40 112h40v32H40Zm56 0h120v32H96Zm120-48v32H40V64ZM40 160h40v32H40Zm176 32H96v-32h120v32Z"></path></g></svg>
															</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="number" id="realmd_port" data-tip="{{port}}" placeholder="{{port}}: 3306" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />															<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon text-muted-400 h-5 w-5 transition-transform duration-300" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></g></svg>
															</div>
															</div>
														</div>
													</div>
												</fieldset>

												<br />
												<fieldset class="relative">
													<div class="mb-6"><p class="font-heading text-base font-medium leading-none text-white">{{auth_config}}</p><p class="font-sans text-xs font-normal leading-normal text-muted-400">{{auth_config_detail}}</p></div>
													<div class="grid grid-cols-12 gap-4">
														<div class="col-span-12">
															<p class="font-sans text-s font-normal leading-normal text-muted-400">{{account_encryption}}</p>
															<p class="font-sans text-xs font-normal leading-normal text-muted-500">{{account_encryption_detail}}</p>
															<div class="group/nui-input relative">
																<select id="realmd_account_encryption" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer/input relative w-full border bg-white pe-12 ps-4 font-sans text-sm leading-5 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 rounded-xl">
																	<option selected disabled hidden>{{account_encryption}}</option>
																	<option value="SRP6">SRP6</option>
																	<option value="SPH">SPH</option>
																	<option value="SRP">SRP</option>
																</select>
															</div>
														</div>
														<div class="col-span-12">
															<p class="font-sans text-s font-normal leading-normal text-muted-400">{{rbac}}</p>
															<p class="font-sans text-xs font-normal leading-normal text-muted-500">{{rbac_detail}}</p>
															<div class="group/nui-input relative">
																<select id="realmd_rbac" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer/input relative w-full border bg-white pe-12 ps-4 font-sans text-sm leading-5 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 rounded-xl">
																	<option selected disabled hidden>{{rbac}}</option>
																	<option value="false">{{no}}</option>
																	<option value="true">{{yes}}</option>
																</select>
															</div>
														</div>
														<div class="col-span-12">
															<p class="font-sans text-s font-normal leading-normal text-muted-400">{{battle_net}}</p>
															<p class="font-sans text-xs font-normal leading-normal text-muted-500">{{battle_net_detail}}</p>
															<div class="group/nui-input relative">
																<select onchange="console.log($('[battle_net_encryption]')[this.value == 'true' ? 'show' : 'hide']())" id="realmd_battle_net" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer/input relative w-full border bg-white pe-12 ps-4 font-sans text-sm leading-5 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 rounded-xl">
																	<option selected disabled hidden>{{battle_net}}</option>
																	<option value="false">{{no}}</option>
																	<option value="true">{{yes}}</option>
																</select>
															</div>
														</div>
														<div class="col-span-12" style="display: none;" battle_net_encryption>
															<p class="font-sans text-s font-normal leading-normal text-muted-400">{{battle_net_encryption}}</p>
															<p class="font-sans text-xs font-normal leading-normal text-muted-500">{{battle_net_encryption_detail}}</p>
															<div class="group/nui-input relative">
																<select id="realmd_battle_net_encryption" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer/input relative w-full border bg-white pe-12 ps-4 font-sans text-sm leading-5 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 rounded-xl">
																	<option selected disabled hidden>{{battle_net_encryption}}</option>
																	<option value="SRP6_V2">SRP6 V2</option>
																	<option value="SRP6_V1">SRP6 V1</option>
																	<option value="SPH">SPH</option>
																</select>
															</div>
														</div>
														<div class="col-span-12">
															<p class="font-sans text-s font-normal leading-normal text-muted-400">{{totp_secret}}</p>
															<p class="font-sans text-xs font-normal leading-normal text-muted-500">{{totp_secret_detail}}</p>
															<div class="group/nui-input relative">
																<select onchange="console.log($('[totp_secret_name]')[this.value == 'true' ? 'show' : 'hide']())" id="realmd_totp_secret" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer/input relative w-full border bg-white pe-12 ps-4 font-sans text-sm leading-5 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 rounded-xl">
																	<option selected disabled hidden>{{totp_secret}}</option>
																	<option value="false">{{no}}</option>
																	<option value="true">{{yes}}</option>
																</select>
															</div>
														</div>
														<div class="col-span-12" style="display: none;" totp_secret_name>
															<p class="font-sans text-s font-normal leading-normal text-muted-400">{{totp_secret_name}}</p>
															<p class="font-sans text-xs font-normal leading-normal text-muted-500">{{totp_secret_name_detail}}</p>
															<div class="group/nui-input relative">
																<select id="realmd_totp_secret_name" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer/input relative w-full border bg-white pe-12 ps-4 font-sans text-sm leading-5 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 rounded-xl">
																	<option selected disabled hidden>{{totp_secret_name}}</option>
																	<option value="token_key">token_key</option>
																	<option value="totp_secret">totp_secret</option>
																</select>
															</div>
														</div>
													</div>
												</fieldset>
											</form>

											<div class="installer_navigation mt-6 flex items-center justify-between gap-2">
												<button type="button" class="prev is-button rounded is-button-default w-full">{{previous_step}}</button>
												<button type="button" class="next is-button rounded bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500 w-full">{{next_step}}</button>
											</div>
										</section>

										<section class="box big step" data-validation="realms" style="display:none;">
											<h3 class="font-heading text-xl font-light leading-tight text-muted-800 dark:text-white">{{realms}}</h3>

											<span class="font-sans text-xs font-normal leading-normal text-muted-400">{{realms_detail}}</span>

											<div class="realmAdd">
												<button type="button" onClick="Ajax.Realms.addRealm();" class="is-button rounded bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500 w-full">{{add_realm}}</button>
											</div>

											<div id="realm_field"></div>

											<div id="loader" style="display:none;">
												<form class="mx-auto min-w-lg max-w-lg space-y-12 py-8">
													<fieldset class="relative">
														<div class="mb-6"><p class="font-heading text-base font-medium leading-none text-white">{{emulator}}</p><p class="font-sans text-xs font-normal leading-normal text-muted-400">{{emulator_detail}}</p></div>
														<div class="grid grid-cols-12 gap-4">
															<div class="col-span-12">
																<div class="group/nui-input relative">
																	<select id="emulator" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer/input relative w-full border bg-white pe-12 ps-4 font-sans text-sm leading-5 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 rounded-xl">
																		<option disabled="disabled">{{loading}}...</option>
																	</select>
																</div>
															</div>
														</div>
													</fieldset>
													<fieldset class="relative">
														<div class="mb-6"><p class="font-heading text-base font-medium leading-none text-white">{{realm_settings}}</p><p class="font-sans text-xs font-normal leading-normal text-muted-400">{{realm_settings_detail}}</p></div>
														<div class="grid grid-cols-12 gap-4">
															<div class="col-span-12">
																<div class="group/nui-input relative">
																	<input type="text" id="realmName" data-tip="{{realm_name}}" placeholder="{{realm_name}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																	<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																		<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M221.66 90.34L192 120l-56-56l29.66-29.66a8 8 0 0 1 11.31 0L221.66 79a8 8 0 0 1 0 11.34Z" opacity=".2"></path><path d="m227.31 73.37l-44.68-44.69a16 16 0 0 0-22.63 0L36.69 152A15.86 15.86 0 0 0 32 163.31V208a16 16 0 0 0 16 16h44.69a15.86 15.86 0 0 0 11.31-4.69L227.31 96a16 16 0 0 0 0-22.63ZM51.31 160L136 75.31L152.69 92L68 176.68ZM48 179.31L76.69 208H48Zm48 25.38L79.31 188L164 103.31L180.69 120Zm96-96L147.31 64l24-24L216 84.68Z"></path></g></svg>
																	</div>
																</div>
															</div>
															<div class="col-span-12">
																<p class="font-sans text-xs font-normal leading-normal text-muted-400">{{cap}}</p>
																<div class="group/nui-input relative">
																	<input type="number" id="cap" data-tip="{{cap}}" placeholder="{{cap}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required value="100" />
																	<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																		<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M176 112L74.34 213.66a8 8 0 0 1-11.31 0L42.34 193a8 8 0 0 1 0-11.31L144 80Z" opacity=".2"></path><path d="M248 152a8 8 0 0 1-8 8h-16v16a8 8 0 0 1-16 0v-16h-16a8 8 0 0 1 0-16h16v-16a8 8 0 0 1 16 0v16h16a8 8 0 0 1 8 8ZM56 72h16v16a8 8 0 0 0 16 0V72h16a8 8 0 0 0 0-16H88V40a8 8 0 0 0-16 0v16H56a8 8 0 0 0 0 16Zm128 120h-8v-8a8 8 0 0 0-16 0v8h-8a8 8 0 0 0 0 16h8v8a8 8 0 0 0 16 0v-8h8a8 8 0 0 0 0-16Zm35.31-112L80 219.31a16 16 0 0 1-22.62 0l-20.7-20.68a16 16 0 0 1 0-22.63L176 36.69a16 16 0 0 1 22.63 0l20.68 20.68a16 16 0 0 1 0 22.63Zm-54.63 32L144 91.31l-96 96L68.68 208ZM208 68.69L187.31 48l-32 32L176 100.69Z"></path></g></svg>
																	</div>
																</div>
															</div>
															<div class="col-span-12">
																<p class="font-sans text-xs font-normal leading-normal text-muted-400">{{realm_expansion}}</p>
																<div class="grid grid-cols-12 gap-4">
																	<div class="col-span-12">
																		<div class="group/nui-input relative">
																			<select id="realm_expansion" data-tip="{{realm_expansion_detail}}" required class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer/input relative w-full border bg-white pe-12 ps-4 font-sans text-sm leading-5 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 rounded-xl">
																				<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="10">The War Within</option>
																				<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="9">Dragonflight/Wotlk Classic</option>
																				<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="8">Shadowlands</option>
																				<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="7">Battle for Azeroth</option>
																				<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="6">Legion</option>
																				<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="5">Warlords of Draenor</option>
																				<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="4">Mists Of Pandaria</option>
																				<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="3">Cataclysm</option>
																				<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="2">Wrath of the Lich King</option>
																				<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="1">The Burning Crusade</option>
																				<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="0">Vanilla</option>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-span-12">
																<div class="group/nui-input relative">
																	<input type="text" id="port" data-tip="{{realm_port}}" placeholder="{{realm_port}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																	<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																		<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon text-muted-400 h-5 w-5 transition-transform duration-300" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></g></svg>
																	</div>
																</div>
															</div>
														</div>
													</fieldset>

													<fieldset class="relative">
														<div class="mb-6"><p class="font-heading text-base font-medium leading-none text-white">{{realm_database}}</p><p class="font-sans text-xs font-normal leading-normal text-muted-400">{{realm_database_detail}}</p></div>
														<div class="grid grid-cols-12 gap-4">
															<div class="col-span-12">
																<div class="group/nui-input relative">
																	<input type="text" id="hostname" data-tip="{{hostname}}" placeholder="{{hostname}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																	<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																		<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M224 56v144a8 8 0 0 1-8 8H40a8 8 0 0 1-8-8V56a8 8 0 0 1 8-8h176a8 8 0 0 1 8 8Z" opacity=".2"></path><path d="M216 40H40a16 16 0 0 0-16 16v144a16 16 0 0 0 16 16h176a16 16 0 0 0 16-16V56a16 16 0 0 0-16-16Zm0 160H40V56h176v144ZM184 96a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Zm0 32a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Zm0 32a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Z"></path></g></svg>
																	</div>
																</div>
															</div>
															<div class="col-span-12">
																<div class="group/nui-input relative">
																	<input type="text" id="username" data-tip="{{database_username}}" placeholder="{{database_username}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																	<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																		<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M168 144a40 40 0 1 1-40-40a40 40 0 0 1 40 40ZM64 56a32 32 0 1 0 32 32a32 32 0 0 0-32-32Zm128 0a32 32 0 1 0 32 32a32 32 0 0 0-32-32Z" opacity=".2"></path><path d="M244.8 150.4a8 8 0 0 1-11.2-1.6A51.6 51.6 0 0 0 192 128a8 8 0 0 1 0-16a24 24 0 1 0-23.24-30a8 8 0 1 1-15.5-4A40 40 0 1 1 219 117.51a67.94 67.94 0 0 1 27.43 21.68a8 8 0 0 1-1.63 11.21ZM190.92 212a8 8 0 1 1-13.85 8a57 57 0 0 0-98.15 0a8 8 0 1 1-13.84-8a72.06 72.06 0 0 1 33.74-29.92a48 48 0 1 1 58.36 0A72.06 72.06 0 0 1 190.92 212ZM128 176a32 32 0 1 0-32-32a32 32 0 0 0 32 32Zm-56-56a8 8 0 0 0-8-8a24 24 0 1 1 23.24-30a8 8 0 1 0 15.5-4A40 40 0 1 0 37 117.51a67.94 67.94 0 0 0-27.4 21.68a8 8 0 1 0 12.8 9.61A51.6 51.6 0 0 1 64 128a8 8 0 0 0 8-8Z"></path></g></svg>
																	</div>
																</div>
															</div>
															<div class="col-span-12">
																<div class="group/nui-input relative">
																	<input type="password" id="password" data-tip="{{database_password}}" placeholder="{{database_password}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																	<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																		<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-[1.15rem] w-[1.15rem]" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M224 128a96 96 0 1 1-96-96a96 96 0 0 1 96 96Z" opacity=".2"/><path d="M72 128a134.63 134.63 0 0 1-14.16 60.47a8 8 0 1 1-14.32-7.12A118.8 118.8 0 0 0 56 128a71.73 71.73 0 0 1 27-56.2a8 8 0 1 1 10 12.49A55.76 55.76 0 0 0 72 128Zm56-8a8 8 0 0 0-8 8a184.12 184.12 0 0 1-23 89.1a8 8 0 0 0 14 7.76A200.19 200.19 0 0 0 136 128a8 8 0 0 0-8-8Zm0-32a40 40 0 0 0-40 40a8 8 0 0 0 16 0a24 24 0 0 1 48 0a214.09 214.09 0 0 1-20.51 92a8 8 0 1 0 14.51 6.83A230 230 0 0 0 168 128a40 40 0 0 0-40-40Zm0-64A104.11 104.11 0 0 0 24 128a87.76 87.76 0 0 1-5 29.33a8 8 0 0 0 15.09 5.33A103.9 103.9 0 0 0 40 128a88 88 0 0 1 176 0a282.24 282.24 0 0 1-5.29 54.45a8 8 0 0 0 6.3 9.4a8.22 8.22 0 0 0 1.55.15a8 8 0 0 0 7.84-6.45A298.37 298.37 0 0 0 232 128A104.12 104.12 0 0 0 128 24ZM94.4 152.17a8 8 0 0 0-9.4 6.25a151 151 0 0 1-17.21 45.44a8 8 0 0 0 13.86 8a166.67 166.67 0 0 0 19-50.25a8 8 0 0 0-6.25-9.44ZM128 56a72.85 72.85 0 0 0-9 .56a8 8 0 0 0 2 15.87A56.08 56.08 0 0 1 184 128a252.12 252.12 0 0 1-1.92 31a8 8 0 0 0 6.92 9a8.39 8.39 0 0 0 1 .06a8 8 0 0 0 7.92-7a266.48 266.48 0 0 0 2-33A72.08 72.08 0 0 0 128 56Zm57.93 128.25a8 8 0 0 0-9.75 5.75c-1.46 5.69-3.15 11.4-5 17a8 8 0 0 0 5 10.13a7.88 7.88 0 0 0 2.55.42a8 8 0 0 0 7.58-5.46c2-5.92 3.79-12 5.35-18.05a8 8 0 0 0-5.72-9.78Z"/></g></svg>
																	</div>
																</div>
															</div>
															<div class="col-span-12">
																<div class="group/nui-input relative">
																	<input type="number" id="db_port" data-tip="{{database_port}}" placeholder="{{database_port}}: 3306" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />															<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon text-muted-400 h-5 w-5 transition-transform duration-300" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></g></svg>
																</div>
																</div>
															</div>
															<div class="col-span-12">
																<div class="group/nui-input relative">
																	<input type="text" id="characters" data-tip="{{database_characters}}" placeholder="{{database_characters}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />															<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M88 104v96H32v-96Z" opacity=".2"></path><path d="M224 48H32a8 8 0 0 0-8 8v136a16 16 0 0 0 16 16h176a16 16 0 0 0 16-16V56a8 8 0 0 0-8-8ZM40 112h40v32H40Zm56 0h120v32H96Zm120-48v32H40V64ZM40 160h40v32H40Zm176 32H96v-32h120v32Z"></path></g></svg>
																</div>
																</div>
															</div>
															<div class="col-span-12">
																<div class="group/nui-input relative">
																	<input type="text" id="world" data-tip="{{database_world}}" placeholder="{{database_world}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />															<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M88 104v96H32v-96Z" opacity=".2"></path><path d="M224 48H32a8 8 0 0 0-8 8v136a16 16 0 0 0 16 16h176a16 16 0 0 0 16-16V56a8 8 0 0 0-8-8ZM40 112h40v32H40Zm56 0h120v32H96Zm120-48v32H40V64ZM40 160h40v32H40Zm176 32H96v-32h120v32Z"></path></g></svg>
																</div>
																</div>
															</div>
														</div>
													</fieldset>

													<fieldset class="relative">
														<div class="mb-6"><p class="font-heading text-base font-medium leading-none text-white">{{console_settings}}</p><p class="font-sans text-xs font-normal leading-normal text-muted-400">{{console_settings_detail_1}}<br />{{console_settings_detail_2}}</p></div>
														<div class="grid grid-cols-12 gap-4">
															<div class="col-span-12">
																<div class="group/nui-input relative">
																	<input type="text" id="console_username" data-tip="{{console_username}}" placeholder="{{console_username}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																	<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																		<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-4 w-4" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M192 96a64 64 0 1 1-64-64a64 64 0 0 1 64 64Z" opacity=".2"></path><path d="M230.92 212c-15.23-26.33-38.7-45.21-66.09-54.16a72 72 0 1 0-73.66 0c-27.39 8.94-50.86 27.82-66.09 54.16a8 8 0 1 0 13.85 8c18.84-32.56 52.14-52 89.07-52s70.23 19.44 89.07 52a8 8 0 1 0 13.85-8ZM72 96a56 56 0 1 1 56 56a56.06 56.06 0 0 1-56-56Z"></path></g></svg>
																	</div>
																</div>
															</div>
															<div class="col-span-12">
																<div class="group/nui-input relative">
																	<input type="text" id="console_password" data-tip="{{console_password}}" placeholder="{{console_password}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																	<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																		<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-[1.15rem] w-[1.15rem]" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M224 128a96 96 0 1 1-96-96a96 96 0 0 1 96 96Z" opacity=".2"/><path d="M72 128a134.63 134.63 0 0 1-14.16 60.47a8 8 0 1 1-14.32-7.12A118.8 118.8 0 0 0 56 128a71.73 71.73 0 0 1 27-56.2a8 8 0 1 1 10 12.49A55.76 55.76 0 0 0 72 128Zm56-8a8 8 0 0 0-8 8a184.12 184.12 0 0 1-23 89.1a8 8 0 0 0 14 7.76A200.19 200.19 0 0 0 136 128a8 8 0 0 0-8-8Zm0-32a40 40 0 0 0-40 40a8 8 0 0 0 16 0a24 24 0 0 1 48 0a214.09 214.09 0 0 1-20.51 92a8 8 0 1 0 14.51 6.83A230 230 0 0 0 168 128a40 40 0 0 0-40-40Zm0-64A104.11 104.11 0 0 0 24 128a87.76 87.76 0 0 1-5 29.33a8 8 0 0 0 15.09 5.33A103.9 103.9 0 0 0 40 128a88 88 0 0 1 176 0a282.24 282.24 0 0 1-5.29 54.45a8 8 0 0 0 6.3 9.4a8.22 8.22 0 0 0 1.55.15a8 8 0 0 0 7.84-6.45A298.37 298.37 0 0 0 232 128A104.12 104.12 0 0 0 128 24ZM94.4 152.17a8 8 0 0 0-9.4 6.25a151 151 0 0 1-17.21 45.44a8 8 0 0 0 13.86 8a166.67 166.67 0 0 0 19-50.25a8 8 0 0 0-6.25-9.44ZM128 56a72.85 72.85 0 0 0-9 .56a8 8 0 0 0 2 15.87A56.08 56.08 0 0 1 184 128a252.12 252.12 0 0 1-1.92 31a8 8 0 0 0 6.92 9a8.39 8.39 0 0 0 1 .06a8 8 0 0 0 7.92-7a266.48 266.48 0 0 0 2-33A72.08 72.08 0 0 0 128 56Zm57.93 128.25a8 8 0 0 0-9.75 5.75c-1.46 5.69-3.15 11.4-5 17a8 8 0 0 0 5 10.13a7.88 7.88 0 0 0 2.55.42a8 8 0 0 0 7.58-5.46c2-5.92 3.79-12 5.35-18.05a8 8 0 0 0-5.72-9.78Z"/></g></svg>
																	</div>
																</div>
															</div>
															<div class="col-span-12">
																<div class="group/nui-input relative">
																	<input type="number" id="console_port" data-tip="{{console_port}}" placeholder="{{console_port}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																	<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																		<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon text-muted-400 h-5 w-5 transition-transform duration-300" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></g></svg>
																	</div>
																</div>
															</div>
														</div>
													</fieldset>
												</form>
											</div>

											<div style="border-top:1px solid #ccc;margin-bottom:5px;"></div>

											<div class="installer_navigation mt-6 flex items-center justify-between gap-2">
												<button type="button" class="prev is-button rounded is-button-default w-full">{{previous_step}}</button>
												<button type="button" class="next is-button rounded bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500 w-full">{{next_step}}</button>
											</div>
										</section>

										<section class="box big step" style="display:none;">
											<h2 class="text-white"> {{installing}}</h2>
											<span class="text-white" id="install"></span>
											<div id="install_after_actions" class="mt-6 flex items-center justify-between gap-2 text-nowrap" style="display:none">
												<a href="<?= base_url('install/upgrade') ?>" class="m-0 is-button rounded bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500 w-full">Upgrade</a>
												<span class="text-muted-500 dark:text-muted-400">OR</span>
												<a href="<?= base_url() ?>" class="m-0 is-button rounded bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500 w-full">Go to website</a>
											</div>
										</section>
									</aside>
								</div>
							</div>
						</div>
					</div>
					<div class="text-center font-sans text-sm font-normal leading-normal text-muted-400">
						<a href="https://github.com/FusionWowCMS/FusionCMS" target="_blank">{{github}}</a> -
						<a href="https://github.com/FusionWowCMS/Modules" target="_blank">{{modules}}</a> -
						<a href="https://github.com/FusionWowCMS/Themes" target="_blank">{{themes}}</a> -
						<a href="https://github.com/FusionWowCMS/Themes/issues" target="_blank">{{support}}</a>
						<p>
                            © <?= date('Y') ?> FusionCMS. {{copyright}}
						</p>
					</div>
				</div>
			</div>
		</div>
        <script>
            Language.init();

			const userLang = localStorage.getItem('language') == null ? 'en' : localStorage.getItem('language');
			document.getElementById('language_selection_' + userLang).checked = true;

            if (userLang == 'fa')
                document.getElementsByTagName('body')[0].style.direction = "rtl";

            function setLanguage(lang) {
                localStorage.setItem('language', lang);
				location.reload();
            }
        </script>
    </body>
</html>
