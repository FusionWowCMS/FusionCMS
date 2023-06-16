<div class="container">
	<div class="row">

	<div class="col-lg-4 py-5 pe-lg-5">
		<div class="w-100 text-center mb-5">
			<div class="user-avatar">
				<img src="{$avatar}" alt="avatar" class="rounded-circle">
				<div class="blend"></div>
			</div>			
		</div>

		<div class="section-header">{lang("profile_nav", "profile")}</div>
		<div class="section-body">

			<div class="list-group mb-3">
				<a href="javascript:void(0);" class="list-group-item list-group-item-action active" data-bs-toggle="tab" data-bs-target="#nav-overview" type="button" role="tab" aria-controls="nav-overview" aria-selected="true">Overview</a>
				<!--<a href="javascript:void(0);" class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#nav-forum-posts" type="button" role="tab" aria-controls="nav-forum-posts" aria-selected="false">Forum Posts</a>
				<a href="javascript:void(0);" class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#nav-bugtracker-posts" type="button" role="tab" aria-controls="nav-bugtracker-posts" aria-selected="false">Bugtracker Posts</a>-->
			</div>

			<!--<div class="btn-group w-100" role="group">
				<button type="button" class="btn btn-primary text-light">Edit</button>
				<button type="button" class="btn btn-danger text-light">Ban</button>
			</div>-->
		</div>
	</div>

	<div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">
		<div class="tab-content" id="nav-tabContent">
			<div class="tab-pane fade show active" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab">
				<div class="section-header">Profile <span>Overview</span></div>
				<div class="section-body">
					<table class="table table-borderless table-responsive user-table">
						<tr>
							<td><div class="user-table-icon"><i class="fas fa-user"></i></div> {lang("nickname", "profile")}</td>
							<td>{$username}</td>
						</tr>
						
						<tr><td class="pb-3"></td></tr>
						
						<tr>
							<td><div class="user-table-icon"><i class="fa-solid fa-user-lock"></i></div> {lang("account_status", "profile")}</td>
							<td colspan="2">{$status}</td>
						</tr>
						<tr>
							<td><div class="user-table-icon"><i class="fa-solid fa-calendar"></i></div> {lang("member_since", "profile")}</td>
							<td colspan="2">{$register_date}</td>
						</tr>
						<tr>
							<td><div class="user-table-icon"><i class="fa-solid fa-user-shield"></i></div> {lang("account_rank", "profile")}</td>
							<td colspan="2">{foreach from=$groups item=group} <span {if $group.color}style="color:{$group.color}"{/if}>{$group.name}</span> {/foreach}</td>
						</tr>
						
						<tr><td class="pb-3"></td></tr>
						
						<tr>
							<td><div class="user-table-icon"><i class="fa-solid fa-location-dot"></i></div> {lang("location", "profile")}</td>
							<td>{$location}</td>
						</tr>

						<tr><td class="pb-3"></td></tr>
						
						<!--<tr>
							<td><div class="user-table-icon"><i class="fa-solid fa-pen-to-square"></i></div> {lang("forum_posts", "profile")}</td>
							<td>0</td>
						</tr>
						<tr>
							<td><div class="user-table-icon"><i class="fa-solid fa-square-pen"></i></div> {lang("forum_threads", "profile")}</td>
							<td>0</td>
						</tr>-->
					</table>
				</div>

				{$characters}
			</div>

			<div class="tab-pane fade" id="nav-forum-posts" role="tabpanel" aria-labelledby="nav-forum-posts-tab">
				{for $i = 0; $i<10; $i++}
					<div class="card mb-3">
						<div class="row no-gutters">
							<div class="col-auto position-relative">
								<div class="card-block p-3">
									<a href="javascript:void(0);" class="card-title d-block h4 text-truncate">Forum Ipsum {$i}</a>
									<h6 class="card-subtitle mb-4">
										<div class="d-flex">
										
											<div class="user me-3">
												<i class="fas fa-user"></i>
												<a href="{$url}profile/1">Admin</a>
											</div>
										
											<div class="time me-3">
												<i class="fas fa-clock"></i>
												<a href="javascript:void(0);">DateTIme</a>
											</div>
									
											<div class="tags me-3">
												<i class="fa-solid fa-tag"></i>
												<a href="{$url}/tags">Tag</a>
											</div>

											<div class="comments">
												<i class="fas fa-comments"></i>
												<a href="javascript:void(0)">0</a>
											</div>
											
										</div>
									</h6>
									<div class="card-text">
										Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea t...

										<p class="text-end"><a href="{$url}news/1" class="btn btn-xs btn-dark text-1 text-uppercase">Read More</a></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				{/for}
			</div>

			<div class="tab-pane fade" id="nav-bugtracker-posts" role="tabpanel" aria-labelledby="nav-bugtracker-posts-tab">
				Bugtracker
			</div>
		</div>
	</div>

	</div>
</div>