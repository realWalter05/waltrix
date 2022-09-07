<section class="p-5 shadow-lg flex" style="width: 18vw; margin:0; background-color: rgb(32,32,37);">
<section style="position: fixed; width: 18vw;">
<a href="/" style="width: 80%;" class="d-flex pb-2 mb-3 border-bottom display-5 text-white text-decoration-none">Waltrix</a>
<ul class="list-unstyled py-2 px-4 d-flex flex-column" style="font-size: 1.1em">
    <li class="mb-1">Watch now</li>
    <li class="mb-1">Best movies</li> 	
    <li class="mb-1">IMDB top</li>
    <li class="mb-1">Continue</li> 	 					  
    <li class="mb-1">Re-watch</li> 	 					  
    <input id="searcher" type="text" placeholder="Searcher..." class="form-control mb-1"/>
    <div id="videos-overview">        
        
    </div>
</ul>
<div class="p-3 d-flex" style="font-size: 1.15em;">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
    </svg>
        <?php
            if (isset($_SESSION['user'])) {
                // User logged
                echo('<a href="index.php?p=account" class="text-decoration-none text-white">');
                echo($_SESSION["user"]['username'].'</a>');
            } else {
                echo('<a href="index.php?p=register" class="text-decoration-none text-white">');
                echo('Register/Login</a>');
            }
        ?>
</div>
</section>
</section>