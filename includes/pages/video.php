<section class="p-5" style="width: 82vw;">
    <?php 
        if (!isset($_GET["id"])) {
            echo "Video neextistuje";
        } else {
            if (isset($_GET["s"]) && isset($_GET["e"])) {
                // Video is series
                $series_data = get_series_data($_GET["id"], $_GET["s"], $_GET["e"]);
                $title_data = $series_data[(int)$_GET["e"]-1];
                $url_data = "video_id=" . $_GET["id"] . "&s=" . $_GET["s"] . "&e=" . $_GET["e"] . "&tmdb=1";
                echo("<div class='row'>");
                if(isset($_GET["ads"]))
                    echo('<iframe allowfullscreen="" class="col video-player" src="includes/php/player.php?'.$url_data.'"></iframe>');
                else
                    echo('<iframe allowfullscreen="" sandbox="allow-forms allow-pointer-lock allow-same-origin allow-scripts allow-top-navigation" class="col video-player" src="includes/php/player.php?'.$url_data.'"></iframe>');
                echo("<section class='col-4 p-5 mt-5 h-100'>");
                echo("<h2>".$title_data["name"]."</h2>");
                echo("<div class = 'row'><span class='col'>S" .$title_data["season_number"]. "E" . $title_data["episode_number"] . "</span>");
                echo("<span class='col text-end' id='video-runtime'>".$title_data["runtime"]." minutes</span></div>");
                echo("<p id='overview-text-p'>".$title_data["overview"]."</p>");


                if (isset($_SESSION["user"])) {
                    # If logged get watched history
                    $user_id = $_SESSION["user"]["user_id"];
                    $tmdb_id = $_GET["id"];
                    $season = $_GET["s"];
                    $episode = $_GET["e"];
                    echo("<script>GetWatchedTime($user_id, $tmdb_id, $season, $episode);</script>");
                }  
                
                echo('<a href="#" class="video-params"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16"><path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/></svg>&nbsp; &nbsp;Add to favourites</a><br/>');
                echo('<a href="#" class="video-params"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/></svg>&nbsp; &nbsp;Didn\'t finish?</a><br/>');
                if (isset($_SESSION["user"])) {
                    # If logged save to watched history
                    $user_id = $_SESSION["user"]["user_id"];
                    $tmdb_id = $_GET["id"];
                    $season = $_GET["s"];
                    $episode = $_GET["e"];
                    echo("<script>AddToWatched($user_id, $tmdb_id, $season, $episode);</script>");
                    echo('<a href="http://'.$_SERVER['HTTP_HOST'].'/includes/php/add_to_watched.php?user_id='.$user_id.'&tmdb_id='.$tmdb_id.'&s='.$season.'&e='.$episode.'&return=1" class="video-params"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-check" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/></svg>&nbsp; &nbsp;Add to watched</a>');
                }    

                echo("<div class='d-flex justify-content-between mt-4'>");

                $last_episode = (int)$_GET["e"]-1;
                $last_season = (int)$_GET["s"];
                $next_episode = (int)$_GET["e"]+1;
                $next_season = (int)$_GET["s"];
                // Determining last/next episodes
                if ($_GET["e"] == "1" && $_GET["s"] == "1") {
                    $last_season = 1;
                    $last_episode = 1;
                } else if ($_GET["e"] == "1" && $_GET["s"] != "1") {
                    $last_episode = count(get_series_data($_GET["id"], $_GET["s"], "1"));
                    $last_season = (int)$_GET["s"]-1;
                } else if ((int)$_GET["e"] == count($series_data)) {
                    if (get_series_data($_GET["id"], (int)$_GET["s"]+1, $_GET["e"]) == "") {
                        $next_episode = $_GET["e"];
                        $next_season = $_GET["s"];
                    } else {
                        $next_episode = 1;
                        $next_season = (int)$_GET["s"]+1;
                    }
                }

                echo('<a href=http://'.$_SERVER['HTTP_HOST'].'/?p=video&id=' . $_GET["id"] . "&s=" . $last_season . "&e=" . $last_episode . '";"><img src="./img/left-arrow.png" alt="Next" style="height: 25px;cursor: pointer;"/></a>');
                echo('<a href="http://'.$_SERVER['HTTP_HOST'].'/?p=video&id=' . $_GET["id"] . "&s=" . $next_season . "&e=" . $next_episode . '";"><img src="./img/right-arrow.png" alt="Next" style="height: 25px;cursor: pointer;"/></a>');
                echo("</div>");
                echo("</section>");
                echo("</div>");   


                if (isset($_SESSION["user"])) {
                    # If logged save to watched history
                    $user_id = $_SESSION["user"]["user_id"];
                    $tmdb_id = $_GET["id"];
                    $season = $_GET["s"];
                    $episode = $_GET["e"];
                    echo("<script>AddToWatched($user_id, $tmdb_id, $season, $episode);</script>");
                }     
                        
            } else {
                // Video is movie
                $title_data = get_title_data($_GET["id"], "movie");
                $url_data = "video_id=" . $_GET["id"] . "&tmdb=1";

                echo("<div class='row'>");
                if(isset($_GET["ads"]))
                    echo('<iframe allowfullscreen="" class="col video-player" src="includes/php/player.php?'.$url_data.'"></iframe>');            
                else
                    echo('<iframe allowfullscreen="" sandbox="allow-forms allow-pointer-lock allow-same-origin allow-scripts allow-top-navigation" class="col video-player" src="includes/php/player.php?'.$url_data.'"></iframe>');
                                
                echo("<section class='col-4 p-5 mt-5 h-100'>");
                echo("<h2>".$title_data["title"]."</h2>");
                echo("<div class = 'row'><span class='col'>" . explode("-", $title_data["release_date"])[0] . '</span>');
                echo("<span class='col text-end' id='video-runtime'>".$title_data["runtime"]." minutes</span></div>");
                echo("<p id='overview-text-p' style='margin-block: 5px;'>".$title_data["overview"]."</p><div>");

                if (isset($_SESSION["user"])) {
                    # If logged save to watched history
                    $user_id = $_SESSION["user"]["user_id"];
                    $tmdb_id = $_GET["id"];
                    echo("<script>GetWatchedTime($user_id, $tmdb_id, '', '');</script>");
                }  
                
                foreach ($title_data["genres"] as $genre) {
                    if (is_array($genre)) {
                        foreach ($genre as $g) {
                            echo(get_genre_from_id($g)." ");
                        }
                    } else {
                        echo(get_genre_from_id($genre)." ");
                    }
                }                
                echo("</div></br>");                
                echo('<a href="#" class="video-params"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16"><path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/></svg>&nbsp; &nbsp;Add to favourites</a><br/>');
                echo('<a href="#" class="video-params"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/></svg>&nbsp; &nbsp;Didn\'t finish?</a><br/>');
                

                if (isset($_SESSION["user"])) {
                    # If logged save to watched history
                    $user_id = $_SESSION["user"]["user_id"];
                    $tmdb_id = $_GET["id"];
                    echo("<script>AddToWatched($user_id, $tmdb_id, '', '');</script>");
                    echo('<a href="http://'.$_SERVER['HTTP_HOST'].'/includes/php/add_to_watched.php?user_id='.$user_id.'&tmdb_id='.$tmdb_id.'&return=1" class="video-params"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-check" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/></svg>&nbsp; &nbsp;Add to watched</a>');
                }                
                echo("</section>");
                echo("</div>");
            }
        }
    ?>
    <section class="py-5">     
        <?php
            if (isset($_GET["id"])) {
                if (isset($_GET["s"]) && isset($_GET["e"])) {
                    # This is series
                    echo('<div class="dropdown mb-3">');
                    echo('<a class="dropdown-toggle text-white text-decoration-none h2" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">');
                    echo('Season '. htmlentities($_GET["s"]));
                    echo('</a>');
                    echo('<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuLink">');

                    $watched_episodes = [];
                    $watching_episodes = [];
                    if (isset($_SESSION["user"])) {
                        $conn = get_conn();
                        $query = "SELECT episode FROM watched_series WHERE user_id=? AND season=? AND tmdb_id=?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("iii", $_SESSION["user"]["user_id"], $_GET["s"], $_GET["id"]);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            array_push($watched_episodes, $row["episode"]);
                        }

                        $query = "SELECT episode FROM watching_series WHERE user_id=? AND season=? AND tmdb_id=?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("iii", $_SESSION["user"]["user_id"], $_GET["s"], $_GET["id"]);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            array_push($watching_episodes, $row["episode"]);
                        }                        
                    }

                    $seasons = get_title_data($_GET["id"], "tv")["seasons"];
                    $season_number = 1;
                    foreach ($seasons as $season) {
                        if ($season["name"] == "Specials")
                            continue;
                        echo('<li><a class="dropdown-item" href="http://'.$_SERVER['HTTP_HOST'].'/?p=video&id='. $_GET["id"] .'&s='. $season_number .'&e=1">'.$season["name"].'</a></li>');
                        $season_number += 1;
                    }
                    echo('</ul>');
                    echo('</div>');   
                    
                    $episode_number = 1;
                    foreach ($series_data as $episode) {
                        $btnMark = "";
                        if ($episode_number == $_GET["e"]) {
                            $btnMark = "active-episode-btn ";
                        } 
                        if (in_array($episode_number, $watched_episodes)) {
                            $btnMark = $btnMark."watched-btn";
                        } else if (in_array($episode_number, $watching_episodes)) {
                            $btnMark = $btnMark."watching-btn";
                        }
                        echo('<a href="http://'.$_SERVER['HTTP_HOST'].'/?p=video&id='. $_GET["id"] .'&s='. $_GET["s"] .'&e='.$episode_number.'" class="episode-button"><button class="btn '.$btnMark.' btn-dark"><b>E' . $episode_number . ": </b>" . $episode["name"] . '</button><a/>');
                        $episode_number += 1;
                    }
                } else {
                    echo('<h2>Similar movies</h2>');

                    echo('<section class="row" style="margin: 0; padding: 0;">');
                        echo('<section class="video-block d-flex col overflow-hidden justify-content-left p-3 mb-4">');
                            $similar = get_similar_movies($_GET["id"]);
                            foreach ($similar as $title) {
                                show_title($title);
                            }                    
                        echo('</section>');
                        echo('<div class="row col-1" style="height: 80px; margin-top: 4.0rem">');
                            echo('<img class="arrow" src="./img/left-arrow.png" alt="Next" onclick="ScrollVideos(this);"/>');
                            echo('<img class="arrow" src="./img/right-arrow.png" alt="Next" onclick="ScrollVideos(this);"/>');
                        echo('</div');
                    echo('</section>');
                }
            }
        ?>
    </section>
</section>
