{if $show_slider && is_array($slider) && (($isHomePage && $CI->config->item('slider_home')) || !$CI->config->item('slider_home'))}
	<!-- Slider.Start -->
	<section class="section section-slider" slider="{if $CI->config->item('slider')}{if $CI->config->item('slider_home')}homepage{else}always{/if}{else}hidden{/if}">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider" class="slider">
						{foreach from=$slider key=key item=slide}
							{* Default image *}
							{if $slide.image == $image_path}
								{$slide.image = 'slide-01.jpg'}
							{/if}

							{* Build caption *}
							{capture assign=caption}
								{if $slide.header || $slide.body || $slide.footer}
									{strip}

									<div class='slider-caption'>
										{if $slide.header}<span class='caption-header'>{$slide.header}</span>{/if}
										{if $slide.body}<span class='caption-body'>{$slide.body}</span>{/if}
										{if $slide.footer}<span class='caption-footer'>{$slide.footer}</span>{/if}
									</div>

									{/strip}
								{/if}
							{/capture}

							<img width="1296" height="391" alt="{if $slide.header}{$slide.header} {/if}{if $slide.body}{$slide.body} {/if}{if $slide.footer}{$slide.footer}{/if}" src="{$slider_image_path}{basename($slide.image)}" title="{$caption}" {if !$slide@first}style="display:none"{/if} />
						{/foreach}
					</div>
				</div>

				<div class="col-sm-12">
					<div class="simple_border type-1"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- Slider.End -->
{/if}