
                        <div class="grid grid-cols-12 gap-4">
                            <div class="ltablet:col-span-9 col-span-12 lg:col-span-9">
								<div class="bg-primary-700 rounded-xl px-6 py-12 mb-6">
									<div class="flex w-full flex-col items-center gap-y-4 sm:flex-row">
										<div class="flex flex-1 flex-col px-4">
											<div class="relative inline-flex shrink-0 items-center justify-center outline-none h-16 w-16 rounded-full border-primary-200/50 ring-primary-200/50 ring-offset-primary-600 mb-3 border ring-2 ring-offset-4">
												<div class="flex h-full w-full items-center justify-center overflow-hidden text-center transition-all duration-300 rounded-full">
													<img src="{$avatar}" class="max-h-full max-w-full object-cover shadow-sm dark:border-transparent h-16 w-16">
												</div>
											</div>
											<h2 class="font-heading text-3xl font-bold leading-none ltablet:!text-2xl text-white"><span>Welcome back, {$nickname}.</span></h2>
										</div>
										<div class="flex h-full flex-1 flex-col px-4 sm:px-6">
											<h2 class="font-heading text-base font-semibold leading-tight mb-1 text-white"><span>Shortcuts</span></h2>
											<p class="font-alt text-xs font-normal leading-tight mb-3"><span class="text-white"> Frequently used shortcuts: </span></p>
											<div class="mt-auto flex gap-2">
												<div class="relative inline-flex shrink-0 items-center justify-center outline-none h-10 w-10 nui-mask nui-mask-blob">
												    <a href="{$url}changelog/admin" data-toggle="tooltip" data-placement="top" title="ChangeLog">
														<div class="flex h-full w-full items-center justify-center overflow-hidden text-center transition-all duration-300">
															<i class="fs-4 fa-duotone fa-list-ul"></i>
														</div>
													</a>
												</div>
												<div class="relative inline-flex shrink-0 items-center justify-center outline-none h-10 w-10 nui-mask nui-mask-blob">
												    <a href="{$url}admin/cachemanager" data-toggle="tooltip" data-placement="top" title="Manage cache">
														<div class="flex h-full w-full items-center justify-center overflow-hidden text-center transition-all duration-300">
															<i class="fs-4 fa-duotone fa-box-archive"></i>
														</div>
													</a>
												</div>
												<div class="relative inline-flex shrink-0 items-center justify-center outline-none h-10 w-10 nui-mask nui-mask-blob">
												    <a href="{$url}page/admin" data-toggle="tooltip" data-placement="top" title="Custom pages">
														<div class="flex h-full w-full items-center justify-center overflow-hidden text-center transition-all duration-300">
															<i class="fs-4 fa-duotone fa-window"></i>
														</div>
													</a>
												</div>
												<div class="relative inline-flex shrink-0 items-center justify-center outline-none h-10 w-10 nui-mask nui-mask-blob">
												    <a href="{$url}admin/modules" data-toggle="tooltip" data-placement="top" title="Modules">
														<div class="flex h-full w-full items-center justify-center overflow-hidden text-center transition-all duration-300">
															<i class="fs-4 fa-duotone fa-sitemap"></i>
														</div>
													</a>
												</div>
											</div>
										</div>
										<div class="border-primary-300/60 flex h-full flex-1 flex-col px-4 sm:border-l sm:px-6">
											<h2 class="font-heading text-base font-semibold leading-tight mb-1 text-white"><span>Articles</span></h2>
											<p class="font-alt text-xs font-normal leading-tight mb-3"><span class="text-white"> Submit a new article to your users. </span></p>
											<div class="mt-auto"><a href="{$url}news/admin" type="button" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right is-button rounded is-button-default w-full"><span>News articles</span></a></div>
										</div>
									</div>
								</div>
                                {if $latestVersion}
                                    <div class="grid grid-cols-12 gap-4">
                                        <div class="col-span-12 md:col-span-12">
                                            <div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-xl p-6 mb-3 alert">
                                                <div class="mb-4 flex items-center justify-between">
                                                    <h3 class="font-heading text-sm font-semibold leading-tight text-muted-800 dark:text-white"><span>{lang('important', 'dashboard')} !</span><span class="badge bg-danger mx-2">{lang('new', 'dashboard')}</span></h3>
                                                    <div class="relative">
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon text-muted-400 h-4 w-4" width="1em" height="1em" viewBox="0 0 24 24">
                                                        	<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9m4.3 13a1.94 1.94 0 0 0 3.4 0"></path>
                                                        </svg>
                                                        <div class="absolute -end-0.5 top-0.5"><span class="relative flex h-2 w-2"><span class="bg-primary-400 absolute inline-flex h-full w-full animate-ping rounded-full opacity-75"></span><span class="bg-primary-500 relative inline-flex h-2 w-2 rounded-full"></span></span></div>
                                                    </div>
                                                </div>
                                                <p class="font-alt text-xs font-normal leading-normal leading-normal"><span class="text-muted-400">{lang('update_available', 'dashboard')}<br>{lang('update_download', 'dashboard')} <a href="{$url}admin/updater" class="alert-link">{lang('here', 'dashboard')}</a></span></p>
                                            </div>
                                        </div>
								    </div>
		                       {/if}
                                {if $isOldTheme}
                                    <div class="grid grid-cols-12 gap-4">
                                        <div class="col-span-12 md:col-span-12">
                                            <div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-xl p-6 mb-3 alert">
                                                <div class="mb-4 flex items-center justify-between">
                                                    <h3 class="font-heading text-sm font-semibold leading-tight text-muted-800 dark:text-white"><span>{lang('important', 'dashboard')} !</span><span class="badge bg-danger mx-2">{lang('new', 'dashboard')}</span></h3>
                                                    <div class="relative">
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon text-muted-400 h-4 w-4" width="1em" height="1em" viewBox="0 0 24 24">
                                                        	<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9m4.3 13a1.94 1.94 0 0 0 3.4 0"></path>
                                                        </svg>
                                                        <div class="absolute -end-0.5 top-0.5"><span class="relative flex h-2 w-2"><span class="bg-primary-400 absolute inline-flex h-full w-full animate-ping rounded-full opacity-75"></span><span class="bg-primary-500 relative inline-flex h-2 w-2 rounded-full"></span></span></div>
                                                    </div>
                                                </div>
                                                <p class="font-alt text-xs font-normal leading-normal leading-normal"><span class="text-muted-400">{lang('theme_old', 'dashboard')}<br>{lang('theme_old_detail', 'dashboard')}</span></p>
                                            </div>
                                        </div>
								    </div>
		                       {/if}
                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-12 md:col-span-4">
                                        <div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-4">

                                            <div class="mb-1 flex items-center justify-between">
                                                <h5 class="font-heading text-sm font-medium leading-tight text-muted-500 dark:text-muted-400">
                                                    <span>Income this month</span>
                                                </h5>
                                                <div class="relative inline-flex shrink-0 items-center justify-center h-8 w-8 rounded-full bg-success-100 text-success-500 dark:bg-success-500/20 dark:text-success-400 dark:border-success-500 dark:border-2">

                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256" data-v-cd102a71>
                                                        <g fill="currentColor">
                                                            <path d="M240 104L128 224L80 104l48-64h56Z" opacity=".2"/>
                                                            <path d="m246 98.73l-56-64a8 8 0 0 0-6-2.73H72a8 8 0 0 0-6 2.73l-56 64a8 8 0 0 0 .17 10.73l112 120a8 8 0 0 0 11.7 0l112-120a8 8 0 0 0 .13-10.73ZM222.37 96H180l-36-48h36.37ZM74.58 112l30.13 75.33L34.41 112Zm89.6 0L128 202.46L91.82 112ZM96 96l32-42.67L160 96Zm85.42 16h40.17l-70.3 75.33ZM75.63 48H112L76 96H33.63Z"/>
                                                        </g>
                                                    </svg>

                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <h4 class="font-heading text-3xl font-bold leading-tight text-muted-800 dark:text-white">
                                                    <span>{$income.this}</span>
                                                </h4>
                                            </div>
                                            <div class="{if $income.growth >= 0}text-success-500{else}text-danger-500{/if} flex items-center gap-1 font-sans text-sm">
                                                <span>{$income.growth}%</span>
                                                {if $income.growth >= 0}
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 24 24" data-v-cd102a71>
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="m22 7l-8.5 8.5l-5-5L2 17"/>
                                                        <path d="M16 7h6v6"/>
                                                    </g>
                                                </svg>
												{else}
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256" data-v-cd102a71>
                                                        <g fill="currentColor">
                                                            <path d="m94.81 192l-29.45 22.24a8 8 0 0 1-12.81-4.51L40.19 154.1a8 8 0 0 1 1.66-6.86l30.31-36.33C71 134.25 76.7 161.43 94.81 192Zm119.34-44.76l-30.31-36.33c1.21 23.34-4.54 50.52-22.65 81.09l29.45 22.24a8 8 0 0 0 12.81-4.51l12.36-55.63a8 8 0 0 0-1.66-6.86Z" opacity=".2"/>
                                                            <path d="M152 224a8 8 0 0 1-8 8h-32a8 8 0 0 1 0-16h32a8 8 0 0 1 8 8Zm-24-112a12 12 0 1 0-12-12a12 12 0 0 0 12 12Zm95.62 43.83l-12.36 55.63a16 16 0 0 1-25.51 9.11L158.51 200h-61l-27.26 20.57a16 16 0 0 1-25.51-9.11l-12.36-55.63a16.09 16.09 0 0 1 3.32-13.71l28.56-34.26a123.07 123.07 0 0 1 8.57-36.67c12.9-32.34 36-52.63 45.37-59.85a16 16 0 0 1 19.6 0c9.34 7.22 32.47 27.51 45.37 59.85a123.07 123.07 0 0 1 8.57 36.67l28.56 34.26a16.09 16.09 0 0 1 3.32 13.71ZM99.43 184h57.14c21.12-37.54 25.07-73.48 11.74-106.88C156.55 47.64 134.49 29 128 24c-6.51 5-28.57 23.64-40.33 53.12c-13.31 33.4-9.36 69.34 11.76 106.88Zm-15 5.85q-16.15-29.35-19.6-57.69L48 152.36L60.36 208l.18-.13ZM208 152.36l-16.83-20.2q-3.42 28.28-19.56 57.69l23.85 18l.18.13Z"/>
                                                        </g>
                                                    </svg>
												{/if}
                                                <span class="text-muted-400 text-xs">since last month</span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-span-12 md:col-span-4">
                                        <div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-4">

                                            <div class="mb-1 flex items-center justify-between">
                                                <h5 class="font-heading text-sm font-medium leading-tight text-muted-500 dark:text-muted-400">
                                                    <span>Votes this month</span>
                                                </h5>
                                                <div class="relative inline-flex shrink-0 items-center justify-center h-8 w-8 rounded-full bg-yellow-100 text-yellow-500 dark:border-2 dark:border-yellow-500 dark:bg-yellow-500/20 dark:text-yellow-400">

                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256" data-v-cd102a71>
                                                        <g fill="currentColor">
                                                            <path d="m94.81 192l-29.45 22.24a8 8 0 0 1-12.81-4.51L40.19 154.1a8 8 0 0 1 1.66-6.86l30.31-36.33C71 134.25 76.7 161.43 94.81 192Zm119.34-44.76l-30.31-36.33c1.21 23.34-4.54 50.52-22.65 81.09l29.45 22.24a8 8 0 0 0 12.81-4.51l12.36-55.63a8 8 0 0 0-1.66-6.86Z" opacity=".2"/>
                                                            <path d="M152 224a8 8 0 0 1-8 8h-32a8 8 0 0 1 0-16h32a8 8 0 0 1 8 8Zm-24-112a12 12 0 1 0-12-12a12 12 0 0 0 12 12Zm95.62 43.83l-12.36 55.63a16 16 0 0 1-25.51 9.11L158.51 200h-61l-27.26 20.57a16 16 0 0 1-25.51-9.11l-12.36-55.63a16.09 16.09 0 0 1 3.32-13.71l28.56-34.26a123.07 123.07 0 0 1 8.57-36.67c12.9-32.34 36-52.63 45.37-59.85a16 16 0 0 1 19.6 0c9.34 7.22 32.47 27.51 45.37 59.85a123.07 123.07 0 0 1 8.57 36.67l28.56 34.26a16.09 16.09 0 0 1 3.32 13.71ZM99.43 184h57.14c21.12-37.54 25.07-73.48 11.74-106.88C156.55 47.64 134.49 29 128 24c-6.51 5-28.57 23.64-40.33 53.12c-13.31 33.4-9.36 69.34 11.76 106.88Zm-15 5.85q-16.15-29.35-19.6-57.69L48 152.36L60.36 208l.18-.13ZM208 152.36l-16.83-20.2q-3.42 28.28-19.56 57.69l23.85 18l.18.13Z"/>
                                                        </g>
                                                    </svg>

                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <h4 class="font-heading text-3xl font-bold leading-tight text-muted-800 dark:text-white">
                                                    <span>{$votes.this}</span>
                                                </h4>
                                            </div>
                                            <div class="{if $votes.growth >= 0}text-success-500{else}text-danger-500{/if} flex items-center gap-1 font-sans text-sm">
                                                <span>{$votes.growth}%</span>
                                                {if $votes.growth >= 0}
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 24 24" data-v-cd102a71>
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="m22 7l-8.5 8.5l-5-5L2 17"/>
                                                        <path d="M16 7h6v6"/>
                                                    </g>
                                                </svg>
												{else}
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256" data-v-cd102a71>
                                                        <g fill="currentColor">
                                                            <path d="m94.81 192l-29.45 22.24a8 8 0 0 1-12.81-4.51L40.19 154.1a8 8 0 0 1 1.66-6.86l30.31-36.33C71 134.25 76.7 161.43 94.81 192Zm119.34-44.76l-30.31-36.33c1.21 23.34-4.54 50.52-22.65 81.09l29.45 22.24a8 8 0 0 0 12.81-4.51l12.36-55.63a8 8 0 0 0-1.66-6.86Z" opacity=".2"/>
                                                            <path d="M152 224a8 8 0 0 1-8 8h-32a8 8 0 0 1 0-16h32a8 8 0 0 1 8 8Zm-24-112a12 12 0 1 0-12-12a12 12 0 0 0 12 12Zm95.62 43.83l-12.36 55.63a16 16 0 0 1-25.51 9.11L158.51 200h-61l-27.26 20.57a16 16 0 0 1-25.51-9.11l-12.36-55.63a16.09 16.09 0 0 1 3.32-13.71l28.56-34.26a123.07 123.07 0 0 1 8.57-36.67c12.9-32.34 36-52.63 45.37-59.85a16 16 0 0 1 19.6 0c9.34 7.22 32.47 27.51 45.37 59.85a123.07 123.07 0 0 1 8.57 36.67l28.56 34.26a16.09 16.09 0 0 1 3.32 13.71ZM99.43 184h57.14c21.12-37.54 25.07-73.48 11.74-106.88C156.55 47.64 134.49 29 128 24c-6.51 5-28.57 23.64-40.33 53.12c-13.31 33.4-9.36 69.34 11.76 106.88Zm-15 5.85q-16.15-29.35-19.6-57.69L48 152.36L60.36 208l.18-.13ZM208 152.36l-16.83-20.2q-3.42 28.28-19.56 57.69l23.85 18l.18.13Z"/>
                                                        </g>
                                                    </svg>
												{/if}
                                                <span class="text-muted-400 text-xs">since last month</span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-span-12 md:col-span-4">
                                        <div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-4">

                                            <div class="mb-1 flex items-center justify-between">
                                                <h5 class="font-heading text-sm font-medium leading-tight text-muted-500 dark:text-muted-400">
                                                    <span>Registrations this month</span>
                                                </h5>
                                                <div class="relative inline-flex shrink-0 items-center justify-center h-8 w-8 rounded-full bg-primary-100 text-primary-500 dark:bg-primary-500/20 dark:text-primary-400 dark:border-primary-500 dark:border-2">

                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256" data-v-cd102a71>
                                                        <g fill="currentColor">
                                                            <path d="M136 69.09v101.82l-93.76 28.76A8 8 0 0 1 32 192V48a8 8 0 0 1 10.24-7.67Z" opacity=".2"/>
                                                            <path d="m220.54 86.66l-176.06-54A16 16 0 0 0 24 48v144a16 16 0 0 0 16 16a16 16 0 0 0 4.52-.65L128 181.73V192a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-29.9l28.54-8.75A16.09 16.09 0 0 0 232 138v-36a16.09 16.09 0 0 0-11.46-15.34ZM128 165l-88 27V48l88 27Zm48 27h-32v-15.18l32-9.82Zm40-54h-.11L144 160.08V79.92l71.89 22h.11v36Z"/>
                                                        </g>
                                                    </svg>

                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <h4 class="font-heading text-3xl font-bold leading-tight text-muted-800 dark:text-white">
                                                    <span>{$signups.month}</span>
                                                </h4>
                                            </div>
                                            <div class="text-success-500 flex items-center gap-1 font-sans text-sm">
                                                <span>{$signups.growth}%</span>
                                                {if $signups.growth >= 0}
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 24 24" data-v-cd102a71>
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="m22 7l-8.5 8.5l-5-5L2 17"/>
                                                        <path d="M16 7h6v6"/>
                                                    </g>
                                                </svg>
												{else}
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256" data-v-cd102a71>
                                                        <g fill="currentColor">
                                                            <path d="m94.81 192l-29.45 22.24a8 8 0 0 1-12.81-4.51L40.19 154.1a8 8 0 0 1 1.66-6.86l30.31-36.33C71 134.25 76.7 161.43 94.81 192Zm119.34-44.76l-30.31-36.33c1.21 23.34-4.54 50.52-22.65 81.09l29.45 22.24a8 8 0 0 0 12.81-4.51l12.36-55.63a8 8 0 0 0-1.66-6.86Z" opacity=".2"/>
                                                            <path d="M152 224a8 8 0 0 1-8 8h-32a8 8 0 0 1 0-16h32a8 8 0 0 1 8 8Zm-24-112a12 12 0 1 0-12-12a12 12 0 0 0 12 12Zm95.62 43.83l-12.36 55.63a16 16 0 0 1-25.51 9.11L158.51 200h-61l-27.26 20.57a16 16 0 0 1-25.51-9.11l-12.36-55.63a16.09 16.09 0 0 1 3.32-13.71l28.56-34.26a123.07 123.07 0 0 1 8.57-36.67c12.9-32.34 36-52.63 45.37-59.85a16 16 0 0 1 19.6 0c9.34 7.22 32.47 27.51 45.37 59.85a123.07 123.07 0 0 1 8.57 36.67l28.56 34.26a16.09 16.09 0 0 1 3.32 13.71ZM99.43 184h57.14c21.12-37.54 25.07-73.48 11.74-106.88C156.55 47.64 134.49 29 128 24c-6.51 5-28.57 23.64-40.33 53.12c-13.31 33.4-9.36 69.34 11.76 106.88Zm-15 5.85q-16.15-29.35-19.6-57.69L48 152.36L60.36 208l.18-.13ZM208 152.36l-16.83-20.2q-3.42 28.28-19.56 57.69l23.85 18l.18.13Z"/>
                                                        </g>
                                                    </svg>
												{/if}
                                                <span class="text-muted-400 text-xs">since last month</span>
                                            </div>

                                        </div>
                                    </div>
									{if $graphMonthly}
                                    <div class="col-span-12 md:col-span-12">
                                        <div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-6" id="graphSelectorWrapper">
                                            <div class="flex gap-8">
                                                <div>
                                                    <span class="text-muted-400 font-sans text-xs">Unique this month</span>
                                                    <p class="text-primary-500 font-sans text-lg font-medium"> {$unique.month} </p>
                                                </div>
                                                <div>
                                                    <span class="text-muted-400 font-sans text-xs">Views today</span>
                                                    <p class="text-muted-800 dark:text-muted-100 font-sans text-lg font-medium"> {$views.today} </p>
                                                </div>
                                                <div>
                                                    <span class="text-muted-400 font-sans text-xs">Views this month</span>
                                                    <p class="text-muted-800 dark:text-muted-100 font-sans text-lg font-medium"> {$views.month} </p>
                                                </div>
                                            </div>
                                            <h2>
                                                Visitors:
                                                <small class="float-end">
                                                    <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="graphSelector">
                                                        <option value="Monthly">Monthly</option>
                                                        <option value="Daily" selected>Daily</option>
                                                    </select>
                                                </small>
                                            </h2>

                                            <div id="visitorsSelectorItems" class="chart-data-selector-items mt-3">
                                                <div class="chart chart-sm chart-hidden" data-graph-rel="Monthly" id="graphMonthly" style="height: 200px;"></div>
                                                <div class="chart chart-sm chart-active" data-graph-rel="Daily" id="graphDaily" style="height: 200px;"></div>
                                            </div>
                                        </div>
<script>
    (function($) {
    'use strict';
    $('#graphSelector').themePluginMultiSelect().on('change', function() {
        var rel = $(this).val();
        $('#visitorsSelectorItems .chart').removeClass('chart-active').addClass('chart-hidden');
        $('#visitorsSelectorItems .chart[data-graph-rel="' + rel + '"]').addClass('chart-active').removeClass('chart-hidden');
    });
    $('#graphSelector').trigger('change');
    $('#graphSelectorWrapper').addClass('ready');
}).apply(this, [jQuery]);

    const thisYearMonthlyData = [
        {foreach from=$graphMonthly[0] item=data key=key}
        {if isset($data["month"])}
        {foreach from=$data["month"] item=month key=keyMonth}
        {$month},
        {/foreach}
        {else}
        {$month},
        {/if}
        {/foreach}];
    const lastYearMonthData = [
        {foreach from=$graphMonthly[1] item=data key=key}
        {if isset($data["month"])}
        {foreach from=$data["month"] item=month key=keyMonth}
        {$month},
        {/foreach}
        {else}
        {$month},
        {/if}
        {/foreach}];
    const options = {
        series: [{
            name: 'Views of this year',
            data: thisYearMonthlyData
        },{
            name: 'Views of last year',
            data: lastYearMonthData
        }],
        chart: {
            height: 350,
            type: 'area'
        },
        yaxis: {
            min: 0,
            floating: false,
            decimalsInFloat: false,
            tickAmount: 6,
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
        },
        legend: {
            position: 'top'
        }
    };

    const thisMonthDailyData = [
        {foreach from=$graphDaily[0]  item=day key=key}
        [{$key}, {$day}],
        {/foreach}];
    const lastMonthDailyData = [
        {foreach from=$graphDaily[1]  item=day key=key}
        [{$key}, {$day}],
        {/foreach}];
    const twoMonthAgoDailyData = [
        {foreach from=$graphDaily[2]  item=day key=key}
        [{$key}, {$day}],
        {/foreach}];
    const chart = new ApexCharts(document.querySelector("#graphMonthly"), options);
    chart.render();

    const options2 = {
        series: [{
            name: 'Views of this month',
            data: thisMonthDailyData
        },{
            name: 'Views of last month',
            data: lastMonthDailyData
        },{
            name: 'Views of two month ago',
            data: twoMonthAgoDailyData
        }],
        colors: ['#8b5cf6', '#0ea5e9', '#14b8a6'],
        chart: {
            height: 350,
            type: 'area'
        },
        yaxis: {
            min: 0,
            type: 'numeric'
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        legend: {
            position: 'top'
        }
    };

    const chart2 = new ApexCharts(document.querySelector("#graphDaily"), options2);
    chart2.render();

</script>
                                    </div>
									{/if}
                                    <div id="soapcheck" class="col-span-12 md:col-span-12">
                                    </div>
                                </div>

                            </div>
                            <div class="ltablet:col-span-3 col-span-12 lg:col-span-3">
                                <div class="ptablet:grid-cols-2 ltablet:flex ltablet:flex-col grid gap-4 lg:flex lg:flex-col">
                                    <div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-6">

                                        <div class="flex h-full flex-col">
                                            <div class="mb-4 flex items-center">
                                                <div class="flex-1">
                                                    <h3 class="font-heading text-base font-medium text-muted-800 dark:text-white">
                                                        <span>{$nickname}</span>
                                                    </h3>
                                                    <p class="font-alt text-base font-normal leading-none">
                                                        <span class="text-primary-500 text-xs">{$email}</span>
                                                    </p>
                                                    <p class="font-alt text-base font-normal leading-none">
                                                        <span class="text-muted-400 text-xs">{foreach from=$groups item=group} <span {if $group.color}style="color:{$group.color}"{/if}>{$group.name}</span> {/foreach}</span>
                                                    </p>
                                                </div>
                                                <div class="flex-1 shrink-0">
                                                    <div class="w-12 mx-auto">
                                                        <div class="relative inline-flex shrink-0 items-center justify-center outline-none h-12 w-12 rounded-full">
                                                            <div class="rounded-full flex h-full w-full items-center justify-center overflow-hidden text-center transition-all duration-300">
                                                                <img src="{$avatar}" class="h-12 w-12 max-h-full max-w-full object-cover shadow-sm dark:border-transparent">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4 space-y-2 font-sans">
                                                <div class="flex items-end gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon text-primary-500 h-4 w-4" style="" width="1em" height="1em" viewBox="0 0 256 256" data-v-cd102a71>
                                                        <g fill="currentColor">
                                                            <path d="M128 24a80 80 0 0 0-80 80c0 72 80 128 80 128s80-56 80-128a80 80 0 0 0-80-80Zm0 112a32 32 0 1 1 32-32a32 32 0 0 1-32 32Z" opacity=".2"/>
                                                            <path d="M128 64a40 40 0 1 0 40 40a40 40 0 0 0-40-40Zm0 64a24 24 0 1 1 24-24a24 24 0 0 1-24 24Zm0-112a88.1 88.1 0 0 0-88 88c0 31.4 14.51 64.68 42 96.25a254.19 254.19 0 0 0 41.45 38.3a8 8 0 0 0 9.18 0a254.19 254.19 0 0 0 41.37-38.3c27.45-31.57 42-64.85 42-96.25a88.1 88.1 0 0 0-88-88Zm0 206c-16.53-13-72-60.75-72-118a72 72 0 0 1 144 0c0 57.23-55.47 105-72 118Z"/>
                                                        </g>
                                                    </svg>
                                                    <span class="text-muted-400 text-xs">{$location}</span>
                                                </div>
                                                <div class="flex items-end gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon text-primary-500 h-4 w-4" style="" width="1em" height="1em" viewBox="0 0 256 256" data-v-cd102a71>
                                                        <g fill="currentColor">
                                                            <path d="M223.94 174.08A48.33 48.33 0 0 1 176 216A136 136 0 0 1 40 80a48.33 48.33 0 0 1 41.92-47.94a8 8 0 0 1 8.3 4.8l21.13 47.2a8 8 0 0 1-.66 7.53L89.32 117a7.93 7.93 0 0 0-.54 7.81c8.27 16.93 25.77 34.22 42.75 42.41a7.92 7.92 0 0 0 7.83-.59l25-21.3a8 8 0 0 1 7.59-.69l47.16 21.13a8 8 0 0 1 4.83 8.31Z" opacity=".2"/>
                                                            <path d="m222.37 158.46l-47.11-21.11l-.13-.06a16 16 0 0 0-15.17 1.4a8.12 8.12 0 0 0-.75.56L134.87 160c-15.42-7.49-31.34-23.29-38.83-38.51l20.78-24.71c.2-.25.39-.5.57-.77a16 16 0 0 0 1.32-15.06v-.12L97.54 33.64a16 16 0 0 0-16.62-9.52A56.26 56.26 0 0 0 32 80c0 79.4 64.6 144 144 144a56.26 56.26 0 0 0 55.88-48.92a16 16 0 0 0-9.51-16.62ZM176 208A128.14 128.14 0 0 1 48 80a40.2 40.2 0 0 1 34.87-40a.61.61 0 0 0 0 .12l21 47l-20.67 24.74a6.13 6.13 0 0 0-.57.77a16 16 0 0 0-1 15.7c9.06 18.53 27.73 37.06 46.46 46.11a16 16 0 0 0 15.75-1.14a8.44 8.44 0 0 0 .74-.56L168.89 152l47 21.05h.11A40.21 40.21 0 0 1 176 208Z"/>
                                                        </g>
                                                    </svg>
                                                    <span class="text-muted-400 text-xs">{$register_date}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-6">
                                        <div>
                                            <div class="mb-4 flex items-center justify-between">
                                                <h3 class="font-heading text-sm font-semibold leading-tight text-muted-800 dark:text-white">
                                                    <span>System information</span>
                                                </h3>
                                            </div>
                                            <div>
                                                <ul class="space-y-3">
                                                    <li>
                                                        <a class="router-link-active router-link-exact-active group flex items-center justify-between">
                                                            <p class="font-alt text-sm font-normal leading-normal leading-normal">
                                                                <span class="text-muted-500 dark:text-muted-400 group-hover:text-primary-500 transition-colors duration-300"> PHP version </span>
                                                            </p>
                                                            <div class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 flex h-7 w-auto items-center justify-center rounded-full text-xs p-2"><span>{$php_version}</span></div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="router-link-active router-link-exact-active group flex items-center justify-between">
                                                            <p class="font-alt text-sm font-normal leading-normal leading-normal">
                                                                <span class="text-muted-500 dark:text-muted-400 group-hover:text-primary-500 transition-colors duration-300"> CodeIgniter version </span>
                                                            </p>
                                                            <div class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 flex h-7 w-auto items-center justify-center rounded-full text-xs p-2"><span>{$ci_version}</span></div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="router-link-active router-link-exact-active group flex items-center justify-between">
                                                            <p class="font-alt text-sm font-normal leading-normal leading-normal">
                                                                <span class="text-muted-500 dark:text-muted-400 group-hover:text-primary-500 transition-colors duration-300"> Smarty version </span>
                                                            </p>
                                                            <div class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 flex h-7 w-auto items-center justify-center rounded-full text-xs p-2"><span>{$smarty_version}</span></div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="router-link-active router-link-exact-active group flex items-center justify-between">
                                                            <p class="font-alt text-sm font-normal leading-normal leading-normal">
                                                                <span class="text-muted-500 dark:text-muted-400 group-hover:text-primary-500 transition-colors duration-300"> CMS version </span>
                                                            </p>
                                                            <div class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 flex h-7 w-auto items-center justify-center rounded-full text-xs p-2"><span>{$version}</span></div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="router-link-active router-link-exact-active group flex items-center justify-between">
                                                            <p class="font-alt text-sm font-normal leading-normal leading-normal">
                                                                <span class="text-muted-500 dark:text-muted-400 group-hover:text-primary-500 transition-colors duration-300"> OS </span>
                                                            </p>
                                                            <div class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 flex h-7 w-auto items-center justify-center rounded-full text-xs p-2"><span>{$os}</span></div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="router-link-active router-link-exact-active group flex items-center justify-between">
                                                            <p class="font-alt text-sm font-normal leading-normal leading-normal">
                                                                <span class="text-muted-500 dark:text-muted-400 group-hover:text-primary-500 transition-colors duration-300"> PHP SAPI </span>
                                                            </p>
                                                            <div class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 flex h-7 w-auto items-center justify-center rounded-full text-xs p-2"><span>{$php_sapi}</span></div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="router-link-active router-link-exact-active group flex items-center justify-between">
                                                            <p class="font-alt text-sm font-normal leading-normal leading-normal">
                                                                <span class="text-muted-500 dark:text-muted-400 group-hover:text-primary-500 transition-colors duration-300"> Server Software </span>
                                                            </p>
                                                            <div class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 flex h-7 w-auto items-center justify-center rounded-full text-xs p-2"><span>{$server_software}</span></div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="router-link-active router-link-exact-active group flex items-center justify-between">
                                                            <p class="font-alt text-sm font-normal leading-normal leading-normal">
                                                                <span class="text-muted-500 dark:text-muted-400 group-hover:text-primary-500 transition-colors duration-300"> Page speed </span>
                                                            </p>
                                                            <div class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 flex h-7 w-auto items-center justify-center rounded-full text-xs p-2"><span>{$benchmark}</span></div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="router-link-active router-link-exact-active group flex items-center justify-between">
                                                            <p class="font-alt text-sm font-normal leading-normal leading-normal">
                                                                <span class="text-muted-500 dark:text-muted-400 group-hover:text-primary-500 transition-colors duration-300"> Memory usage </span>
                                                            </p>
                                                            <div class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 flex h-7 w-auto items-center justify-center rounded-full text-xs p-2"><span>{$memory_usage}</span></div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-6">
                                        <div>
                                            <div class="mb-4 flex items-center justify-between">
                                                <h3 class="font-heading text-sm font-semibold leading-tight text-muted-800 dark:text-white">
                                                    <span>Theme information</span>
                                                </h3>
                                            </div>
                                            <div>
                                                <ul class="space-y-3">
                                                    <li>
                                                        <a class="router-link-active router-link-exact-active group flex items-center justify-between">
                                                            <p class="font-alt text-sm font-normal leading-normal leading-normal">
                                                                <span class="text-muted-500 dark:text-muted-400 group-hover:text-primary-500 transition-colors duration-300"> Name </span>
                                                            </p>
                                                            <div class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 flex h-7 w-auto items-center justify-center rounded-full text-xs p-2"><span>{$theme.name}</span></div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="router-link-active router-link-exact-active group flex items-center justify-between">
                                                            <p class="font-alt text-sm font-normal leading-normal leading-normal">
                                                                <span class="text-muted-500 dark:text-muted-400 group-hover:text-primary-500 transition-colors duration-300"> Author </span>
                                                            </p>
                                                            <div class="bg-muted-200 dark:bg-muted-700 text-muted-500 dark:text-muted-200 flex h-7 w-auto items-center justify-center rounded-full text-xs p-2"><span>{$theme.author}</span></div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        {if hasPermission("changeTheme")}
                                                            <a href="{$url}admin/theme" class="router-link-active router-link-exact-active bg-muted-100 hover:bg-muted-200 dark:bg-muted-700 dark:hover:bg-muted-900 text-primary-500 rounded-lg px-4 py-2 font-sans text-sm font-medium underline-offset-4 transition-colors duration-300 hover:underline">Change theme</a>
                                                        {/if}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
									{if !$realm_status}
                                        <div id="realms-container" class="ptablet:grid-cols-2 ltablet:flex ltablet:flex-col grid gap-2 lg:flex lg:flex-col">
                                            <div id="realms-loading" class="flex justify-center items-center p-4 w-full text-muted-500 dark:text-muted-400 text-sm">
                                                <i class="fa-solid fa-spinner-third fa-spin fa-2xl"></i>
                                            </div>
                                            <script>
                                                document.addEventListener("DOMContentLoaded", function () {
                                                    fetch(Config.URL + "admin/realmstatus")
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            const container = document.getElementById('realms-container');
                                                            const loader = document.getElementById('realms-loading');
                                                            if (loader) loader.remove();
                                                            data.realms.forEach(realm => {
                                                                const card = document.createElement('div');
                                                                card.className = "border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-6 mb-3";

                                                                card.innerHTML = `
                                                                        <div class="mb-10 flex items-center justify-between">
                                                                            <h3 class="font-heading text-base font-semibold leading-tight text-muted-800 dark:text-white">
                                                                                <span>Realm: ${ realm.name }</span>
                                                                            </h3>
                                                                        </div>
                                                                        <div class="mb-6">
                                                                            <div>
                                                                                <div class="semi-donut text-muted-500 dark:text-muted-400 m-2" style="--percentage : ${ realm.percentage };">
                                                                                    <span>${ realm.is_online ? 'Online' : 'Offline'}</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mt-auto">
                                                                            <div class="border-muted-200 dark:border-muted-700 flex w-full border-t pt-4 text-center">
                                                                                <div class="border-muted-200 dark:border-muted-700 flex-1 border-r px-2">
                                                                                    <span class="text-muted-400 font-sans text-xs"> Total players online </span>
                                                                                    <p class="text-muted-800 dark:text-muted-100 font-sans text-lg font-medium"> ${ realm.online_players } </p>
                                                                                </div>
                                                                                <div class="flex-1 px-2">
                                                                                    <span class="text-muted-400 font-sans text-xs"> Uptime </span>
                                                                                    <p class="text-muted-800 dark:text-muted-100 font-sans text-lg font-medium"> ${ realm.uptime } </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                `;
                                                                container.appendChild(card);
                                                            });
                                                        })
                                                        .catch(error => {
                                                            console.error('Error loading realms:', error);
                                                        });
                                                });
                                            </script>
                                        </div>
									{/if}
                                </div>
                            </div>
                        </div>

<script type="text/javascript">
    var checkSoap = {
        check: function() {
            $.get(Config.URL + "admin/checkSoap", function(data) {
                try {
                    if(data.includes("Something")) {
                        $("#soapcheck").html('<div class="relative"><div class="nui-card nui-card-curved nui-card-white p-6"><div class="flex w-full flex-col gap-4 sm:flex-row"><svg data-v-26e5b7b0="" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="icon h-10 w-10 shrink-0" width="1em" height="1em" viewBox="0 0 256 256"><defs><linearGradient id="iconifyVue0" x1="99.687%" x2="39.836%" y1="15.801%" y2="97.438%"><stop offset="0%" stop-color="#0052CC"></stop><stop offset="92.3%" stop-color="#2684FF"></stop></linearGradient></defs><path fill="url(#iconifyVue0)" d="M75.793 117.95c-3.82-4.08-9.77-3.85-12.367 1.342L.791 244.565a7.488 7.488 0 0 0 6.697 10.838h87.228a7.22 7.22 0 0 0 6.699-4.14c18.808-38.89 7.413-98.018-25.622-133.314Z"></path><path fill="#2681FF" d="M121.756 4.011c-35.033 55.505-32.721 116.979-9.646 163.13l42.06 84.121a7.488 7.488 0 0 0 6.697 4.14h87.227a7.488 7.488 0 0 0 6.697-10.838S137.445 9.837 134.493 3.964c-2.64-5.258-9.344-5.33-12.737.047Z"></path></svg><div><h4 class="nui-heading nui-heading-md nui-weight-semibold nui-lead-tight after:text-muted-800 mb-4 dark:text-white"><span class="text-danger-500">Soap Checker</span></h4><p class="nui-paragraph nui-paragraph-sm nui-weight-normal nui-lead-normal"><span class="text-danger-500 line-clamp-4"><strong>Oh no!</strong><br/> Looks like a realm has a soap problem!</span></p><div class="flex items-center justify-between pt-4"><div class="flex gap-2"><a href="'+ Config.URL +'admin/checkSoap" class="router-link-active router-link-exact-active bg-muted-100 hover:bg-muted-200 dark:bg-muted-700 dark:hover:bg-muted-900 text-primary-500 rounded-lg px-4 py-2 font-sans text-sm font-medium underline-offset-4 transition-colors duration-300 hover:underline"> Details </a></div></div></div></div></div></div>');
                    }
                } catch(e) {
                    console.log(e);
                }
            });
        }
    }

    checkSoap.check();
</script>
