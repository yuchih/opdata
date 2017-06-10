<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<title>OP</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link rel="stylesheet" href="css/one-col-portfolio.css" />

</head>

<body>


	<?php include 'html/loading.html'; ?>

	<div class="container scene-content">


	    <!-- Project Three -->
        <div class="row">
            <div class="col-md-7">

            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
					  <ol class="carousel-indicators">
					    <!-- <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li> -->
					  </ol>
					  <div class="carousel-inner" role="listbox">
					    <!-- <div class="carousel-item active">
					      <img class="d-block img-fluid" src="http://placehold.it/600x300" alt="First slide">
					    </div>
					    <div class="carousel-item">
					      <img class="d-block img-fluid" src="http://placehold.it/600x300" alt="Second slide">
					    </div>
					    <div class="carousel-item">
					      <img class="d-block img-fluid" src="http://placehold.it/600x300" alt="Third slide">
					    </div> -->
					  </div>
					  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
					    <span class="sr-only">Previous</span>
					  </a>
					  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					    <span class="carousel-control-next-icon" aria-hidden="true"></span>
					    <span class="sr-only">Next</span>
					  </a>
					</div>
                    <!-- <img class="img-fluid rounded mb-3 mb-md-0" src="http://placehold.it/600x400" alt=""> -->

            </div>
            <div class="col-md-5 scene-para">
                <h3 id="scene_name">Project Three</h3>
                <p id="scene">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis, temporibus, dolores, at, praesentium ut unde repudiandae voluptatum sit ab debitis suscipit fugiat natus velit excepturi amet commodi deleniti alias possimus!</p>

            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

	<script src="js/global.js"></script>

	<script>

		$(document).ready(function(){

			loading_ajax_show();

			var data = {
				name: getParameterByName("name")
			};

            var success_back = function(data) {

                    data = JSON.parse(data);

                    if (data.success) {
                    	console.log(data.data);
                    	var data = data.data;
                    	var temp = "", temp2 = "";

                    	$( data.image ).each(function(idx, val){
                    		if(val != '' && checkURL(val+'.jpg')) {

	                    		temp += '<div class="carousel-item">'
								      +'<img class="d-block img-fluid" src="' +val+ 'jpg" alt="不好意思這張圖片掛了，請致電到台北觀光局抗議" title="' +data['name']+ '的實地照片">'
								    +'</div>';

								temp2 += '<li data-target="#carouselExampleIndicators" data-slide-to="' +idx+ '" class=""></li>';

                    		}
                    	});

						$(".carousel-inner").html( temp );
						$(".carousel-indicators").html( temp2 );
						$(".carousel-item").first().addClass('active');
						$(".carousel-indicators").first().addClass('active');

						$("#scene_name").text( data.name );
						$("#scene").text( data.scene );

// echo '旅遊類別: ' .$item['class']. "<br>"
// 				 .'景點名稱: ' .$item['name']. "<br>"
// 				 .'景點地址: ' .$item['address']. "<br>"
// 				 .'交通路線: ' .$item['path']. "<br>"
// 				 .'附近捷運站: ' .$item['station']. "<br>"
// 				 .'景點簡介: ' .$item['scene']. "<br>";

// 			foreach( $item['image'] as $value ) {

// 				if( !checkRemoteFile($value) ) {

// 					echo '<img src="'.$value. 'jpg'.'" alt="不好意思這張圖片掛了，請致電到台北觀光局抗議" title="'.$item['name'].'的實地照片" width="150px">';
// 				}

// 			}

						loading_ajax_hide();

                    } else {
                        alert(data.msg);
                        loading_ajax_hide();
                    }
            };

            var error_back = function(data) { console.log(data); };

            $.Ajax("POST", "php/readJson.php?func=getScene", data, "", success_back, error_back);

		});


	</script>

</body>
</html>