
function ScrollVideos(arrow) {
    let by = 1418;
    if (arrow.src.includes("left-arrow")) {
        by = by * -1;
    }
    let videos = arrow.parentElement.parentElement.firstElementChild;
    videos.scrollLeft += by;
}

$(document).ready(function(){
var timer = null;
$('#searcher').keydown(function(){
    clearTimeout(timer); 
    timer = setTimeout(function() {
        $.ajax({
            url: '/includes/php/search.php',
            type: 'get',
            data: { query: $("#searcher").val()},
            success: function(response) { 
                console.log(JSON.parse(response));
                const videos = document.getElementById("videos-overview");
                videos.innerHTML = JSON.parse(response);
            }
        });
    }, 500);
});
});

function AddToWatched(user_id, tmdb_id, season, episode) {
    var monitor = setInterval(function(){
        if(document.activeElement && document.activeElement.tagName == 'IFRAME'){
            // Video has ben clicked 
            clearInterval(monitor);
            const runtime = parseInt(document.getElementById("video-runtime").textContent.split(" ")[0]);
            
            // Get previous watching time
            let watching_time = 1;
            let previous_percentage_to_end = "a";
            if (season == "" && episode == "") {
                $.ajax({
                    url: '/includes/php/get_watched_percentage.php',
                    type: 'get',
                    data: { 
                        user_id: user_id,
                        tmdb_id: tmdb_id,                  
                    },
                    success: function(response) { 
                        previous_percentage_to_end = response;
                    }
                });         
            } else {
                $.ajax({
                    url: '/includes/php/get_watched_percentage.php',
                    type: 'get',
                    data: { 
                        user_id: user_id,
                        tmdb_id: tmdb_id,
                        s: season,
                        e: episode                    
                    },
                    success: function(response) { 
                        previous_percentage_to_end = response;
                    }
                });                 
            }      

            if (previous_percentage_to_end == "a") {
                previous_percentage_to_end = 0;
            } else {
                previous_percentage_to_end = parseInt(previous_percentage_to_end);
            }
            
            // Repeats till user stops watching
            var ajax_data = setInterval(function(){
                percentage_to_end = +previous_percentage_to_end + (watching_time / (runtime / 100));

                if (percentage_to_end > 92) {
                    // Movies series is finished
                    clearInterval(ajax_data);

                    if (season == "" && episode == "") {
                        // It is a movie
                        $.ajax({
                            url: '/includes/php/add_to_watched.php',
                            type: 'get',
                            data: { 
                                user_id: user_id,
                                tmdb_id: tmdb_id
                            },
                            success: function(response) { 
                                console.log("Added to watched movies");
                                console.log(response);
                            }
                        });                   
                    } else {
                        // It is series
                        $.ajax({
                            url: '/includes/php/add_to_watched.php',
                            type: 'get',
                            data: { 
                                user_id: user_id,
                                tmdb_id: tmdb_id,
                                s: season,
                                e: episode
                            },
                            success: function(response) { 
                                console.log("Added to watched movies");
                                console.log(response);
                            }                    
                        });                    
                    }
                } else {
                    if (season == "" && episode == "") {
                        // It is a movie
                        $.ajax({
                            url: '/includes/php/add_to_watching.php',
                            type: 'get',
                            data: { 
                                user_id: user_id,
                                tmdb_id: tmdb_id,
                                watched: percentage_to_end
                            },
                            success: function(response) { 
                                console.log("Added watched time movie");
                            }
                        });                   
                    } else {
                        // It is series
                        $.ajax({
                            url: '/includes/php/add_to_watching.php',
                            type: 'get',
                            data: { 
                                user_id: user_id,
                                tmdb_id: tmdb_id,
                                s: season,
                                e: episode,
                                watched: percentage_to_end
                            },
                            success: function(response) { 
                                console.log("Added watched time");
                            }                    
                        });                    
                    }
                }
                watching_time += 1;
            }, 60000);
        }
    }, 100);
}

function GetWatchedTime(user_id, tmdb_id, season, episode) {
    if (season == "" && episode == "") {
        $.ajax({
            url: '/includes/php/get_watched_percentage.php',
            type: 'get',
            data: { 
                user_id: user_id,
                tmdb_id: tmdb_id,                  
            },
            success: function(response) { 
                if (response) {
                    let minutes_watched = response * (parseInt(document.getElementById("video-runtime").textContent.split(" ")[0]) / 100);
                    document.getElementById("overview-text-p").innerHTML += "<div class='mt-1'><i>" + "You have already watched " + Math.round(minutes_watched*100)/100 + " minutes</i></div>";
                }
            }
        });         
    } else {
        $.ajax({
            url: '/includes/php/get_watched_percentage.php',
            type: 'get',
            data: { 
                user_id: user_id,
                tmdb_id: tmdb_id,
                s: season,
                e: episode                    
            },
            success: function(response) { 
                if (response) {
                    let minutes_watched = response * (parseInt(document.getElementById("video-runtime").textContent.split(" ")[0]) / 100);
                    document.getElementById("overview-text-p").innerHTML += "<div class='mt-1'><i>" + "You have already watched " + Math.round(minutes_watched*100)/100  + " minutes</i></div>";
                }
            }
        });                 
    }      
}

window.onload = function() {
    setTimeout(function() {
      if ( typeof(window.google_jobrunner) === "undefined" ) {
        console.log("ad blocker installed");
      } else {
        console.log("no ad blocking found.");
      }
    }, 10000);
  };