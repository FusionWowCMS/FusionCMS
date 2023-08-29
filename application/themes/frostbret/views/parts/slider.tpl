<!-- Slider Section.Start -->
<section id="section-slider" class="section section-text-slider visible" slider="homepage">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-12 ">
        <div id="slider" class="slider">
          <div class="main-slider owl-carousel fluxslider">
            {foreach from=$slider item=slide}
			<div class="surface ">
				<div class="caption">
					{if $slide.header}<span>{$slide.header}</span>{/if}
					{if $slide.body}<i>{$slide.body}</i>{/if}
					{if $slide.footer}<p>{$slide.footer}</p>{/if}
				</div>
			</div>
			{/foreach}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Slider Section.End -->