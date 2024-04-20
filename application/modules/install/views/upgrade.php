<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Upgrade - FusionCMS</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" href="<?= $INSTALL_PATH ?>images/favicon.png" />
		<link rel="stylesheet" href="<?= $css ?>" />

		<script src="//cdnjs.cloudflare.com/ajax/libs/Kraken/3.8.2/js/html5.min.js"></script>
		<script src="<?= base_url() ?>node_modules/jquery/dist/jquery.min.js"></script>
		<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

		<script src="<?= $INSTALL_PATH ?>js/lang.js"></script>
		<script src="<?= $INSTALL_PATH ?>js/ui.js"></script>
		<script src="<?= $INSTALL_PATH ?>js/upgrade.js"></script>
		<script src="<?= $INSTALL_PATH ?>js/memory.js"></script>
		<script>
		    const Config = {
		        url: '<?= base_url() ?>'
		    };

			$(document).ready(function()
			{
				UI.initialize();
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
							<img class="border-muted-200 dark:border-muted-700 flex w-56 items-center justify-center border-r pe-6" src="<?= $INSTALL_PATH ?>images/fusion.svg" alt="FusionCMS">
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
												<h4 class="text-muted-800 text-xs font-medium dark:text-white">Migrate</h4>
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
												<img src="<?= $INSTALL_PATH ?>images/fusion.svg">
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

										<section class="box big step" style="display: none;">
											<h3 class="font-heading text-xl font-light leading-tight text-muted-800 dark:text-white">Migrate</h3>

											<form name="migrate" onSubmit="upgrade.install(this); return false;" class="mx-auto min-w-lg max-w-lg space-y-12 py-8" data-baseURL="<?= base_url() ?>">
												<fieldset class="relative">
													<div class="mb-6"><p class="font-heading text-base font-medium leading-none text-white">CMS name</p><p class="font-sans text-xs font-normal leading-normal text-muted-400">Select your previously installed CMS to upgrade</p></div>
													<div class="grid grid-cols-12 gap-4">
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<select name="cms" data-tip="CMS" required class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer/input relative w-full border bg-white pe-12 ps-4 font-sans text-sm leading-5 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 rounded-xl">
																	<?php foreach($statements as $cms => $data) { ?>
																		<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="<?= $cms ?>"><?= $data['info']['name'] ?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
													</div>

													<div class="my-6"><p class="font-heading text-base font-medium leading-none text-white">Table name</p><p class="font-sans text-xs font-normal leading-normal text-muted-400">Select table to migrate</p></div>
													<div class="grid grid-cols-12 gap-4">
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<?php $first = true; foreach($statements as $cms => $data) { ?>
																	<select name="table" data-tip="Table" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer/input relative w-full border bg-white pe-12 ps-4 font-sans text-sm leading-5 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 rounded-xl" required <?= $cms ?> <?= (!$first) ? 'style="display: none;" disabled' : '' ?>>
																		<?php foreach($data['queries'] as $key => $val) { ?>
																			<option class="relative flex cursor-pointer select-none items-center px-3 py-2 rounded" value="<?= $key ?>"><?= $val['select']['table'] ?></option>
																		<?php } ?>
																	</select>
																<?php $first = false; } ?>
															</div>
														</div>
													</div>

													<div class="my-6"><p class="font-heading text-base font-medium leading-none text-white">{{website_database}}</p><p class="font-sans text-xs font-normal leading-normal text-muted-400">{{website_database_detail}}</p></div>
													<div class="grid grid-cols-12 gap-4">
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" name="db_hostname" data-tip="{{hostname}}" placeholder="{{hostname}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M224 56v144a8 8 0 0 1-8 8H40a8 8 0 0 1-8-8V56a8 8 0 0 1 8-8h176a8 8 0 0 1 8 8Z" opacity=".2"></path><path d="M216 40H40a16 16 0 0 0-16 16v144a16 16 0 0 0 16 16h176a16 16 0 0 0 16-16V56a16 16 0 0 0-16-16Zm0 160H40V56h176v144ZM184 96a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Zm0 32a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Zm0 32a8 8 0 0 1-8 8H80a8 8 0 0 1 0-16h96a8 8 0 0 1 8 8Z"></path></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" name="db_username" data-tip="{{username}}" placeholder="{{username}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M168 144a40 40 0 1 1-40-40a40 40 0 0 1 40 40ZM64 56a32 32 0 1 0 32 32a32 32 0 0 0-32-32Zm128 0a32 32 0 1 0 32 32a32 32 0 0 0-32-32Z" opacity=".2"></path><path d="M244.8 150.4a8 8 0 0 1-11.2-1.6A51.6 51.6 0 0 0 192 128a8 8 0 0 1 0-16a24 24 0 1 0-23.24-30a8 8 0 1 1-15.5-4A40 40 0 1 1 219 117.51a67.94 67.94 0 0 1 27.43 21.68a8 8 0 0 1-1.63 11.21ZM190.92 212a8 8 0 1 1-13.85 8a57 57 0 0 0-98.15 0a8 8 0 1 1-13.84-8a72.06 72.06 0 0 1 33.74-29.92a48 48 0 1 1 58.36 0A72.06 72.06 0 0 1 190.92 212ZM128 176a32 32 0 1 0-32-32a32 32 0 0 0 32 32Zm-56-56a8 8 0 0 0-8-8a24 24 0 1 1 23.24-30a8 8 0 1 0 15.5-4A40 40 0 1 0 37 117.51a67.94 67.94 0 0 0-27.4 21.68a8 8 0 1 0 12.8 9.61A51.6 51.6 0 0 1 64 128a8 8 0 0 0 8-8Z"></path></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="password" name="db_password" data-tip="{{password}}" placeholder="{{password}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-[1.15rem] w-[1.15rem]" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M224 128a96 96 0 1 1-96-96a96 96 0 0 1 96 96Z" opacity=".2"/><path d="M72 128a134.63 134.63 0 0 1-14.16 60.47a8 8 0 1 1-14.32-7.12A118.8 118.8 0 0 0 56 128a71.73 71.73 0 0 1 27-56.2a8 8 0 1 1 10 12.49A55.76 55.76 0 0 0 72 128Zm56-8a8 8 0 0 0-8 8a184.12 184.12 0 0 1-23 89.1a8 8 0 0 0 14 7.76A200.19 200.19 0 0 0 136 128a8 8 0 0 0-8-8Zm0-32a40 40 0 0 0-40 40a8 8 0 0 0 16 0a24 24 0 0 1 48 0a214.09 214.09 0 0 1-20.51 92a8 8 0 1 0 14.51 6.83A230 230 0 0 0 168 128a40 40 0 0 0-40-40Zm0-64A104.11 104.11 0 0 0 24 128a87.76 87.76 0 0 1-5 29.33a8 8 0 0 0 15.09 5.33A103.9 103.9 0 0 0 40 128a88 88 0 0 1 176 0a282.24 282.24 0 0 1-5.29 54.45a8 8 0 0 0 6.3 9.4a8.22 8.22 0 0 0 1.55.15a8 8 0 0 0 7.84-6.45A298.37 298.37 0 0 0 232 128A104.12 104.12 0 0 0 128 24ZM94.4 152.17a8 8 0 0 0-9.4 6.25a151 151 0 0 1-17.21 45.44a8 8 0 0 0 13.86 8a166.67 166.67 0 0 0 19-50.25a8 8 0 0 0-6.25-9.44ZM128 56a72.85 72.85 0 0 0-9 .56a8 8 0 0 0 2 15.87A56.08 56.08 0 0 1 184 128a252.12 252.12 0 0 1-1.92 31a8 8 0 0 0 6.92 9a8.39 8.39 0 0 0 1 .06a8 8 0 0 0 7.92-7a266.48 266.48 0 0 0 2-33A72.08 72.08 0 0 0 128 56Zm57.93 128.25a8 8 0 0 0-9.75 5.75c-1.46 5.69-3.15 11.4-5 17a8 8 0 0 0 5 10.13a7.88 7.88 0 0 0 2.55.42a8 8 0 0 0 7.58-5.46c2-5.92 3.79-12 5.35-18.05a8 8 0 0 0-5.72-9.78Z"/></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="text" name="db_database" data-tip="{{database_name}}" placeholder="{{database_name}}" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256"><g fill="currentColor"><path d="M88 104v96H32v-96Z" opacity=".2"></path><path d="M224 48H32a8 8 0 0 0-8 8v136a16 16 0 0 0 16 16h176a16 16 0 0 0 16-16V56a8 8 0 0 0-8-8ZM40 112h40v32H40Zm56 0h120v32H96Zm120-48v32H40V64ZM40 160h40v32H40Zm176 32H96v-32h120v32Z"></path></g></svg>
																</div>
															</div>
														</div>
														<div class="col-span-12">
															<div class="group/nui-input relative">
																<input type="number" name="db_port" data-tip="{{port}}" placeholder="{{port}}: 3306" class="nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl" required />
																<div class="h-10 w-10 text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75">
																	<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon text-muted-400 h-5 w-5 transition-transform duration-300" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></g></svg>
																</div>
															</div>
														</div>
													</div>
												</fieldset>

												<div class="installer_navigation mt-6 flex items-center justify-between gap-2">
													<button type="button" class="prev is-button rounded is-button-default w-full">{{previous_step}}</button>
													<button type="submit" class="is-button rounded bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500 w-full">Migrate!</button>
												</div>

												<div class="font-sans text-xs font-normal leading-normal text-muted-400" migrate_logs></div>
											</form>
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
							{{copyright}}
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
