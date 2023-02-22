<section id="main">
	<section style="width: 100%;  position:relative; margin:0; padding: 3rem 0 0 3rem; box-sizing: border-box;">

		<h2>Best movies of all times</h2>
		<section class="row" style="margin: 0; padding: 0;">
			<section class="video-block d-flex col justify-content-left p-3 mb-4">
				<?php
					$titles = get_top_movies();
					foreach ($titles as $title) {
						show_title($title);
					}
				?>
			</section>					
		</section>						
	</section>
</section>
<script>CheckMobile();</script>