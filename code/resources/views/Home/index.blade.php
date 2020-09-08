<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!--Fontawesome fonts link start-->
		<link href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" rel="stylesheet">
	<!--Fontawesome fonts link end-->
	<style type="text/css">
		body{
			background-color: #f9faf5;
		}
		.header 
		{
		    position: relative;
		    z-index: 100;
		}
		.header_v2 
		{
		    margin: 0 auto;
		    padding: 10px 0 13px;
		    width: 970px;
		    border-bottom: 1px solid #d4d4d4;
		}
		header
		{
			display: block;
		}
		.g-row_inline
		{
			white-space: nowrap;
		}
		.page-width-inner 
		{
		    width: 720px;
		    margin: 0 auto;
		}
		.g-row_inline .g-col 
		{
		    float: none;
		    display: inline-block;
		    vertical-align: middle;
		    white-space: normal;
		    width: 74.5%;
		}
		.nav-top-2 
		{
		    font-family: Open Sans,Arial,sans-serif;
		    margin-top: 4px;
		}
		.right 
		{
		    text-align: right;
		}
		.header a 
		{
		    text-decoration: none;
		}
		.nav-top-2__item 
		{
		    display: inline-block;
		    margin: 0 25px;
		    color: #333;
		    font-size: 16px;
		    text-decoration: none;
		    border-bottom: 2px solid transparent;
		}
		.g-row_inline .g-col 
		{
		    float: none;
		    display: inline-block;
		    vertical-align: middle;
		    white-space: normal;
		}
		.g-col.c3 
		{
		    width: 23.5%;
		}
		.g-col:first-child 
		{
		    margin-left: 0;
		}
		.header_v2 .logo 
		{
		    display: block;
		    margin-left: 10px;
		    font-size: 30px;
		    font-family: cursive;
		    opacity: 0.9;
		}
		.main
		{
			margin: 0 auto;
		    padding: 10px 0 13px;
		    width: 970px;
		    position: relative;
		    z-index: 100;
		    background-color: #ffffff;
		}
		.content
		{
		    margin: auto;
		    text-align: center;
		    padding: 20px 50px 20px 50px;
		}
		.search-box
		{
			padding-left: 50px;
		    padding-right: 50px;
		    overflow: hidden;
		    text-align: center;
		}
		.inputbox
		{
			border: 2px solid #000000;
		    height: 50px;
		    /*width: 60%;*/
		    padding: 0 220px 0 16px;
		    margin: 0;
		    font-family: Roboto,sans-serif;
		    font-size: .875rem;color: #242424;
		    background: #fff;
		    border-radius: 0;
		    outline: none;
		    font-size: 15px;
		    display: block;
		    float: left;
		    box-sizing: border-box;
		    resize: none;
		    box-shadow: 0 1px 0 0 #e9e9e9;
		    vertical-align: baseline;
		    outline-offset: -2px;
		    line-height: normal;
		}
		.inputbutton
		{
			padding: 16px 20px 16px 20px;
		    font-size: 15px;
		    font-family: sans-serif;
		    outline: none;
		    background:linear-gradient(90deg, #7441c0 0%,#a972e0 100%);
		    border: none;
		    color: #ffffff;
		    font-weight: 790;
		    float: left;
		    margin-left: 5px;
		}
		.search-results
		{
			text-align: center;
    		padding: 0 50px 0 50px;
    		overflow: hidden;
    		margin-top: 30px; 
    		/*display: none;*/
		}
		.form-fields
		{
			padding: 3px 8px 3px 8px;
			font-size: 17px;
			font-family: sans-serif;
			font-weight: 500;
			    padding: 10px 15px 10px 15px;
    color: #444242;
    font-size: 1.1rem;
    font-weight: 700;
    border: 2px solid #7441c0;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
		}
		.v-title
		{
			font-family: sans-serif;
			white-space: pre-line;
			max-width: 280px;
			font-weight: 500;
			font-size: 18px;
			padding-bottom:10px;
		}
		.v-runtime
		{
			font-family: sans-serif;
			white-space: pre-line;
			max-width: 280px;
			font-weight: 500;
			font-size: 18px;
			margin-bottom:0px;
			display: inline;
			padding-right: 35px;
		}
	</style>
</head>
<body>

    <header class="header header_v2">
    	<div class="page-width-inner g-row_inline">

	      	<div class="header__left g-col c3">
	        	<span class="menu-btn menu-btn_v2"></span>
	        		<a name="logo" class="logo">V-Downlink</a>
	      	</div>
	      	<div id="nav_top" class="g-col c9">
	          	<div class="nav-top-2 right">
	          		<a href="/myDownloads" class="nav-top-2__item">My Downloads</a>
		            <a href="/help" class="nav-top-2__item">Help</a>          
	        	</div>
        	</div>

        </div>
  	</header>

  	<div class="main">
  		<div class="content" style="border-left: 1px solid #d4d4d4;border-right: 1px solid #d4d4d4;height: 500px;">
  			<div class="search-info" style="font-family: sans-serif;">
  				<h1>Lorem Ipsum</h1>
  			</div>

  			<div class="search-box">

  				<!-- Search Form Start -->
					<form action="/search" method="post" id="search-form" style="overflow: hidden;display: inline-block;">
						@csrf
						<input type="text" name="link" id="link" placeholder="Enter Video Link Here" class="inputbox">
						<input type="submit" value="Search" class="inputbutton">
					</form>
				<!-- Search Form Ends -->

  			</div>

  			<div class="search-results" id="download-box" style="display: none;">
  				
  				<!-- Search Results Start -->
					<form action="/download" method="post" id="download-form" style="display: inline-block;overflow: hidden;padding: 15px 0 15px 0;border-bottom: 1px solid #d4d4d4;">
						@csrf

						<div style="float: left;">
						<img height='120' width='200' id="thumbnail"></div>

						<div style="float: left;padding: 0px 10px 0px 10px;">
							<p class="v-title" id="v-title">knds wknsc sdksndc dlsnmdc lsdnslnc</p>
							<p id="runtime" class="v-runtime">sbj</p>

							<select name="quality" id="select-tag" class="form-fields">
								<option>360p</option>
								<option>720p</option>
							</select>

							<input type="hidden" name="title" id="title">
							<input type="submit" value="Download" class="form-fields" style=" 
		    background:linear-gradient(90deg, #7441c0 0%,#a972e0 100%);
    outline: none;
    border: none;
    color: white;
    font-size: 1.25rem;
    padding: 10px 15px 10px 15px;
    font-family: sans-serif;
    font-weight: 600;"> 
						</div>
						<!-- <p id="title"></p><br> -->
						
						
					</form>
				<!-- Search Results Ends -->

  			</div>


  		</div>
  	</div>	

	<script type="text/javascript">

		function check()
		{
			window.location=document.getElementById('select-tag').value;
		}

		$("#search-form").submit(function(e){
			e.preventDefault();
			console.log('hey');

		  $.ajax({
		  	url: "/search",
		  	method: 'post', 
		  	data: {
		        "_token": "{{ csrf_token() }}",
		        "link": document.getElementById('link').value
			},
		  	success: function(result){

		  		var data = JSON.parse(result);  console.log(data);

		  		var selectTag = document.getElementById('select-tag');

				selectTag.innerHTML='';

		  		for(var key in data.qualities)
		  		{	
		  			// for key use 'key' for value use data.qualities[key] and this is foreach loop in javascript // console.log(key+'=>'+data.qualities[key]);

		  			var option = document.createElement("option");

					option.text = key;

					option.value = data.qualities[key];

					selectTag.add(option);
				}

				document.getElementById('title').value=data.title;
				document.getElementById('v-title').innerHTML=data.title;
				document.getElementById('runtime').innerHTML=data.runtime;
				document.getElementById('thumbnail').setAttribute('src',data.thumbnail);

				// $('download-box').fadeIn('slow');
				// $("#download-box").show('fade','slow');
		  		document.getElementById('download-box').style.display='block';

		  			// old code
				    // 	$.each(data,function(){
				    // 		$.each(this,function(key,val){
				    // 			// console.log(key,val);
				    // 			var option = document.createElement("option");

								// option.text = key;
								// option.value = val;
								// selectTag.add(option);
				    // 		});
				    // 	});
		  	}
		  });
		});


		// $("#download-form").submit(function(e){
		// 	e.preventDefault();
		// 	console.log('hey');

		//   $.ajax({
		//   	url: "/download",
		//   	method: 'post', 
		//   	data: {
		//         "_token": "{{ csrf_token() }}",
		//         "dLink": document.getElementById('select-tag').value
		// 	},
		//   	success: function(result){
		//   		console.log(result);
		//   		// // work in progress
		//   		// var data = JSON.parse(result); // console.log(data);

		//   		// var selectTag = document.getElementById('select-tag');

		//     // 	$.each(data,function(){
		//     // 		$.each(this,function(key,val){
		//     // 			// console.log(key,val);
		//     // 			var option = document.createElement("option");

		// 				// option.text = key;
		// 				// option.value = val;
		// 				// selectTag.add(option);
		//     // 		});
		//     // 	});

		//     // 	document.getElementById('download-box').style.display='block';

		//     // 	// work in progress_______
		//   	}
		//   });

		// });

	</script>
</body>
</html>