<?php
session_name('plex');
session_start();
if (!isset($_SESSION['id'])) {
	header("location:index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PLEX-HOME</title>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="js/js.js"></script>
	<script src="js/ajax.js"></script>
	<link href="css/style.css" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="">
	<?php include"./common/header.php";?>
	<section class="">
   		<div class="container-fluid">
   			<br><br><br>
			<div class="heading" style="border-bottom: 2px solid; border-color: #050c2b;">
	   			<h4 class="genrestitle"></h4>
	   		</div>
	   		<br> 
	   		<div class="row" id="genrelist">
	   			
	   		</div>
	   	</div>   		
   </section>
<script type="text/javascript">
	$(document).ready(function(){
		var genre="<?php echo $_GET['genre'];?>";
		loadbygenre();
		function loadbygenre(){
			$.ajax({
				url: "api/fetch_by_genre.php",
				type:"post",
				data: {
					genre:genre
				},
				success:function(msg){
					var data=JSON.parse(msg);
					console.log(data);
					if (data.status==true) {
						if (data.list.length !=0 ) {
						    $('.genrestitle').append(data.genre+' Total results: ' +data.videos_count);
							var watchingcards="";
							$.each(data.list,function(i,v){
								watchingcards+=`<div class="col-lg-2 col-md-2 col-sm-2">
								   				<div class="card">
								   					<a href="display.php?id=`+data.list[i]['id']+`&&name=`+data.list[i]['title']+`" class="infohover" id=`+data.list[i]['id']+`>
								   						<img class="card-img-top" src="`+data.list[i]['poster']+`" alt="Card image cap">
								   					</a>
								   				</div>
								   			</div>`;
								   			// var id ='#'+data.list[i].id;
								   			// console.log(id);
							});
							$('#genrelist').append(watchingcards);
						}else{
							$('.genrestitle').append('No results: 0');
							$('#genrelist').append(`<div class="col-lg-12"> <img class="empty-image" src="cactus.png" alt="Card image cap"> </div>`);
						}
					}else{
						$('.genrestitle').append('No results: 0');
						$('#genrelist').html(`<div class="col-lg-12"><h1>THERE IS NO SUCH GENRE EXIST!</h1></div>`);
					}

				},
				complete:function(msg){

					$('.infohover').mouseenter(function() {
					   var i = '.infohover';
					   var id=$(this).attr('id');
					   loaddynamicpopover('fds',id,i)

					});

				}
			});
					
		}
		function loaddynamicpopover(het,id,classname){
			var contentinfo=""
			$.ajax({
				url: "api/newexp.php",
				type:"post",
				data: {
					genre:'Crime',
					id:id,
				},
				success:function(response){
					var data=JSON.parse(response);
					if (data.status==true) {
						$.each(data.list, function(i,v){
							console.log(data.list[i].isadded);
							genres=data.list[i].genres.split(',');
							var genresStrarray=[];
							$.each(genres, function(i,v){
								genresStrarray[i]=`<a style="color: black;" href=/plex/genre_grid.php?genre=`+genres[i]+`>`+genres[i]+`</a>`;
							});
							data.list[i].genres=genresStrarray.join(',');

							var contentbutton="";

							if (data.list[i].isadded=="Y") {
								console.log("remove button");
								contentbutton=`<div class="col-sm-6">
			                			
											<button type="submit" class="btn btn-primary watchlist" data-action="remove" id="${data.list[i].id}"><i class="fa fa-minus"></i></button>
				                		</div>`;
							}else if(data.list[i].isadded=="N"){
								console.log("add button");
								contentbutton=`<div class="col-sm-6">
			                			
											<button type="submit" class="btn btn-primary watchlist" data-action="add" id="${data.list[i].id}"><i class="fa fa-plus"></i></button>
				                		</div>`
							}else{
								console.log("error")		
							}
							contentinfo+=`
								<h6>${data.list[i].title}</h6>
								<div>
				                <p>
				                <span>${data.list[i].duration} min</span>
				                <span>${data.list[i].year}</span>
				                <span class="badge badge-secondary">${data.list[i].rated}+</span>
				                </p>
				                <p>${data.list[i].type}</p>
				                <p>Genres: ${data.list[i].genres}</p>
				                <p>${data.list[i].description}</p>
				                <div class="container">
				                	<div class="row">
				                		<div class="col-sm-6">
				                			<a href=display.php?id=${data.list[i]['id']}&&name=${data.list[i]['title']}>
												<button class="btn btn-primary"><i class="fa fa-play"></i></button>
											</a>
				                		</div>
				                		${contentbutton}
				                	</div>
				                </div>
				                </div>
							`;
							
						})
						$('#'+id).popover({
				            html:true,
				            content:contentinfo,
				            trigger:"manual"
				        }).on('mouseenter', function () {
						    var _this = this;
						    $(this).popover('show');
						    $('.popover').on('mouseleave', function () {
						        $(_this).popover('hide');
						    });
						}).on('mouseleave', function () {
						    var _this = this;
						    setTimeout(function () {
						        if (!$('.popover:hover').length) {
						            $(_this).popover('hide');
						        }
						    }, 300);
						});

						// $('body').popover({
						//     selector: '#'+id,
						//     trigger: 'hover',
						//     html: true,
						//     content: contentinfo
						// });
					}else{
						console.log("no response");
					}
					
				}
			})


			
		}
		$(document).on('click', '.watchlist', function(e){
				e.preventDefault();
				var videos_id=parseInt($(this).attr('id'));
				$.ajax({
					url:"api/addtowatchlist.php",
					type:'post',
					data:{
						user_id:1,
						videos_id:videos_id,
					},
					success:function(response){
						response=JSON.parse(response);
						if (response.status==true) {
							alert(response.msg);
						}else{
							alert(response.msg);
						}
					},
					complete:function(response){

					}
				});
				
			})
		
		
	});
</script>	
</body>

</html>
