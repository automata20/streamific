
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color:#152427">
	  <a class="navbar-brand" href="/plex/home.php">PLEX</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item active">
	        <a class="nav-link" href="/plex/home.php?id=<?php echo $_SESSION['id']?>">Home <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="/plex/videos_grid.php?type=movies">Movies</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="/plex/videos_grid.php?type=tvseries">TV Shows</a>
	      </li>
	      <!-- <li class="nav-item">
	        <a class="nav-link" href="/plex/videos_grid.php?type=documentary">Docu</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="/plex/videos_grid.php?type=anime">Anime</a>
	      </li> -->
	      <li class="nav-item dropdown">
	        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          Genre
	        </a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	          <a class="dropdown-item" href="/plex/genre_grid.php?genre=Action">Action</a>
	          <a class="dropdown-item" href="/plex/genre_grid.php?genre=Adventure">Adventure</a>
	          <a class="dropdown-item" href="/plex/genre_grid.php?genre=Comedy">Comedy</a>
	          <a class="dropdown-item" href="/plex/genre_grid.php?genre=Crime">Crime</a>
	          <a class="dropdown-item" href="/plex/genre_grid.php?genre=Drama">Drama</a>
	          <a class="dropdown-item" href="/plex/genre_grid.php?genre=Family">Family</a>
	          <a class="dropdown-item" href="/plex/genre_grid.php?genre=Fantasy">Fantasy</a>
	          <a class="dropdown-item" href="/plex/genre_grid.php?genre=History">History</a>
	          <a class="dropdown-item" href="/plex/genre_grid.php?genre=Horror">Horror</a>
	          <a class="dropdown-item" href="/plex/genre_grid.php?genre=Romance">Romance</a>
	          <a class="dropdown-item" href="/plex/genre_grid.php?genre=SciFi">Sci-Fi</a>
	          <a class="dropdown-item" href="/plex/genre_grid.php?genre=Thriller">Thriller</a>
	          <a class="dropdown-item" href="/plex/genre_grid.php?genre=War">war</a>

	        </div>
	      </li>
	    </ul>
	    <form class="form-inline my-2 my-lg-0 mr-md-4 search-box">
	      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" style="background-color:transparent; color: white;" name="search"> 
	      <!-- border: none; border-bottom: 2px solid white; -->
	      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="display: none;"><i class="fa fa-search"></i></button>
	    </form>
	   
	    <ul class="navbar-nav mr-sm-2">
	      <li class="nav-item dropdown">
	        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          <?php echo $_SESSION['name'];?>
	        </a>
	        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
	          <a class="dropdown-item" href=/plex/watchlist.php?id=<?php echo $_SESSION['id'];?>&&name=<?php echo $_SESSION['name'];?>>My watchlist</a>
	          <a class="dropdown-item" href=/plex/account.php?id=<?php echo $_SESSION["id"];?>>Account & Settings</a>
	          <a class="dropdown-item" href="#">Help?</a>
	          <form action="logout.php" method="POST">
					<button class="dropdown-item"  type="submit" name="submitlogout"  class="btn btn-warning logout">logout </button>
			</form>
	        </div>
	      </li>
	    </ul>
	  </div>
	</nav>
	<div class="result-container " style="color: black;
    height: auto;
    width: 17.5%;
    z-index: 1050;
    position: fixed;
    margin-top: 50px;
    border: 2px solid;
    margin-left: 71%;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
    padding: 10px 10px 10px 10px;
    background-color: white;
    display: none;
    border-color: white;
    ">
	    <!-- <div style="background-color: red; height: 100%; width: 100%;">
	    	
	    </div> -->
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.search-box input[name="search"]').on("keyup", function(){
		        // var inputVal = $(this).val();
		        // var resultDropdown = $(this).siblings(".result");
		        // if(inputVal.length){
		        //     $.get("api/fetch_search.php", {term: inputVal}).done(function(data){
		        //         resultDropdown.html(data);
		        //     });
		        // } else{
		        //     resultDropdown.empty();
		        // }
		        // $('.result-container').css('display','block');
		        var searchtext=$(this).val();
		        $.ajax({
		        	url:'api/search.php',
		        	type:'post',
		        	data:{
		        		search:searchtext
		        	},
		        	success:function(response){
		        		response=JSON.parse(response);
		        		console.log(response);
		        		if (response.status==true) {
		        			$('.result-container').css('display','block');
		        			var result='';
		        			$.each(response.list,function(i,v){
		        				result+=`<a class="result-link row" href="detail.php?id=${response.list[i]['id']}&&name=${response.list[i]['title']}"><img  class="img-responsive img-fluid col-sm-5" src="images/posters/${response.list[i].thumb_poster}"><li class="result-list col-sm-7" >${response.list[i].title}</li></a>`;
		        			})
		        			$('.result-container').html(result);
		        		}else{
		        			$('.result-container').html("");
		        			$('.result-container').css('display','none');
		        		}
		        	}

		        })
		        
		    });

		    $('search-box').submit(function(e){
		    	e.preventDefault();

		    })
		    
		    // // Set search input value on click of result item
		    // $(document).on("click", ".result p", function(){
		    //     $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
		    //     $(this).parent(".result").empty();
		    // });

			var id="<?php echo $_SESSION['id']?>"
			$('.logout').click(function(){
				$.ajax({
					url:'api/logout.php',
					type:'post',
					data:{
						id:id
					},
					success:function(response){
						response=JSON.parse(response);
						window.location.href=response.url;
					}
				})
			})
		})
	</script>