<section style="width: 82vw; margin: 0; padding: 0;">
	<?php 
	$title = get_data_about_title(get_title_data("60059", "tv"));
	echo("<a id='cover-title' href='/index.php?p=video&id=" . $title['id'] . (($title["type"] == "tv") ? "&s=1&e=1" : "") . "'>");
	echo("<div class='title' style='width: 82vw; margin:0; padding:0; height: 30vw;'>");
	echo("<div>");
	echo('<div class="title-text text-center d-self justify-content-center align-items-center">');
	echo('<p style="margin-top: 180px; font-size: 1.2em;" class="px-4">'.$title["name"].'<br/><span style="font-size: 1em; opacity: 0.9;">'.$title["release"].'</span></p>');
	echo('<p class="genres">');
	foreach ($title["genres"] as $genre) {
		if (is_array($genre)) {
			foreach ($genre as $g) {
				echo(get_genre_from_id($g)." ");
			}
		} else {
			echo(get_genre_from_id($genre)." ");
	  } 
	}
	echo('</p>');
	echo("</div>");
	echo('<img src="https://image.tmdb.org/t/p/original/'.$title["img"]. '" style="width: 105%;"/>');
	echo "</div>";
	echo "</div>";
	echo "</a>";
	
	?>
	<section style="width: 100%;  position:relative; margin:0; padding: 3rem 0 0 3rem; box-sizing: border-box;">
		<h2><?php echo((isset($_SESSION["user"])) ? "Continue watching" : "Výběr redakce :D"); ?></h2>
		<section class="row d-flex" style="margin: 0; padding: 0;">
			<section class="video-block d-flex col overflow-hidden justify-content-left p-3 mb-4">
				<?php 
					if ($_SESSION["user"]) {
						$conn = get_conn();
						$query = "SELECT season, max(episode), tmdb_id from watching_series where (season) in (select max(season) from watching_series group by tmdb_id) AND user_id=? group by season, tmdb_id;";
						$stmt = $conn->prepare($query);
						$stmt->bind_param("i", $_SESSION["user"]["user_id"]);
						if ($stmt->execute()) {
							$result = $stmt->get_result();
							while ($row = $result->fetch_assoc()) {
								show_series_title(get_data_about_title(get_title_data($row["tmdb_id"], "tv")), $row["season"], $row["max(episode)"]);
							}
						}		

						$query = "SELECT * FROM watching_movies WHERE user_id=?";
						$stmt = $conn->prepare($query);
						$stmt->bind_param("i", $_SESSION["user"]["user_id"]);
						if ($stmt->execute()) {
							$result = $stmt->get_result();
							while ($row = $result->fetch_assoc()) {
								show_title(get_data_about_title(get_title_data($row["tmdb_id"], "movie")));
							}		
						}
					} else {
						show_title(get_data_about_title(get_title_data("456", "tv")));
						show_title(get_data_about_title(get_title_data("2288", "tv")));
						show_title(get_data_about_title(get_title_data("2710", "tv")));
						show_title(get_data_about_title(get_title_data("1100", "tv")));
						show_title(get_data_about_title(get_title_data("1434", "tv"))); 
					}
				?>
			</section>		
			<div class="row col-1" style="height: 80px; margin-top: 4.0rem">
				<img class="arrow" src="./img/left-arrow.png" alt="Next" onclick="ScrollVideos(this);"/>
				<img class="arrow" src="./img/right-arrow.png" alt="Next" onclick="ScrollVideos(this);"/>
			</div>
		</section>

		<h2>Trending</h2>
		<section class="row" style="margin: 0; padding: 0;">
			<section class="video-block d-flex col overflow-hidden justify-content-left p-3 mb-4">
				<?php
					$titles = get_trending_titles("movie");
					foreach ($titles as $title) {
						show_title($title);
					}
				?>
			</section>				
			<div class="row col-1" style="height: 80px; margin-top: 4.0rem">
				<img class="arrow" src="./img/left-arrow.png" alt="Next" onclick="ScrollVideos(this);"/>
				<img class="arrow" src="./img/right-arrow.png" alt="Next" onclick="ScrollVideos(this);"/>
			</div>			
		</section>				

		<h2>Series</h2>
		<section class="row" style="margin: 0; padding: 0;">
			<section class="video-block d-flex col overflow-hidden justify-content-left p-3 mb-4">
				<?php
					$titles = get_trending_titles("tv");
					foreach ($titles as $title) {
						show_title($title);
					}
				?>
			</section>				
			<div class="row col-1" style="height: 80px; margin-top: 4.0rem">
				<img class="arrow" src="./img/left-arrow.png" alt="Next" onclick="ScrollVideos(this);"/>
				<img class="arrow" src="./img/right-arrow.png" alt="Next" onclick="ScrollVideos(this);"/>
			</div>			
		</section>			            
	</section>
</section>

