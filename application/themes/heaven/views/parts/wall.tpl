{if $theme_configs.config.wall.enabled && (($theme_configs.config.wall.visibility == 'home' && $isHomePage) || ($theme_configs.config.wall.visibility == 'always'))}
	<!-- Wall.Start -->
	<section class="section section-wall" wall>
		<div class="container d-flex flex-grow-1 align-items-center justify-content-center">
			<div class="row w-100 justify-content-center">
				{if $show_slider && is_array($slider) && (($isHomePage && $CI->config->item('slider_home')) || !$CI->config->item('slider_home'))}
					<div class="col-sm-12">
						<div class="wall-slider owl-carousel owl-theme" owl-carousel="main">
							{foreach from=$slider key=key item=slide}
								{if !$slide.header || !$slide.body}{continue}{/if}

								<div class="slider-item">
									<span class="item-title">{$slide.header}</span>
									<p class="item-desc">{$slide.body}</p>
									{if $slide.link}<a href="{$slide.link}" class="btn-blue -round text-ellipsis" title="{lang('general_readMore', 'theme')}">{lang('general_readMore', 'theme')}</a>{/if}
								</div>
							{/foreach}
						</div>
					</div>
				{/if}

				{if $MY_sideboxes.status}
					<div class="col-sm-12 mt-5">
						{$MY_sideboxes.status}
					</div>
				{/if}

				<div class="col-sm-12 mt-5">
					<div class="wall-membership">
						<a href="{$url}page/connect" class="btn-big text-ellipsis" title="{lang('wall_playNow', 'theme')}"><span>{lang('wall_playNow', 'theme')}</span></a>

						<div class="membership-row mt-3">
							{if $CI->user->isOnline()}
								{sprintf(lang('wall_userOnline', 'theme'), '<a href="'|cat:$url|cat:'ucp">', '</a>')}
							{else}
								{sprintf(lang('wall_userOffline', 'theme'), '<a href="'|cat:$url|cat:'login">', '</a>')}
							{/if}
						</div>

						<div class="membership-row mt-3">
							{if $CI->user->isOnline()}
								<a href="{$url}logout" class="btn-blue -outline -noise text-ellipsis" title="{lang('btn_logout', 'theme')}">{lang('btn_logout', 'theme')}</a>
							{else}
								<a href="{$url}register" class="btn-blue -outline -noise text-ellipsis" title="{lang('btn_register', 'theme')}">{lang('btn_register', 'theme')}</a>
							{/if}
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Wall.End -->
{/if}