<!DOCTYPE html>
<html>

	<!--
		Global announcement message
	-->

	<head>
		<title>{$title}</title>
		<style type="text/css">
			body {
				background-color:#141414;
				padding:0px;
				margin:0px;
				text-align:center;
				color:#ffffff;
				line-height:1.5;
			}

			@font-face {
				font-family: 'MuseoSans';
				src: url('application/fonts/MuseoSans_500-webfont.eot');
				src: url('application/fonts/MuseoSans_500-webfont.eot?#iefix') format('embedded-opentype'),
					url('application/fonts/MuseoSans_500-webfont.woff') format('woff'),
					url('application/fonts/MuseoSans_500-webfont.ttf') format('truetype'),
					url('application/fonts/MuseoSans_500-webfont.svg#MuseoSans500') format('svg');
				font-weight: normal;
				font-style: normal;
			}

			@font-face {
				font-family: 'MuseoSlab';
				src: url('application/fonts/Museo_Slab_500-webfont.eot');
				src: url('application/fonts/Museo_Slab_500-webfont.eot?#iefix') format('embedded-opentype'),
					url('application/fonts/Museo_Slab_500-webfont.woff') format('woff'),
					url('application/fonts/Museo_Slab_500-webfont.ttf') format('truetype'),
					url('application/fonts/Museo_Slab_500-webfont.svg#Museo_Slab500') format('svg');
				font-weight: normal;
				font-style: normal;
			}

			h1 {
				margin:0px;
				padding:0px;
				margin-bottom:50px;
				font-family:'MuseoSlab', Arial, Sans-serif;
				font-size:{$size}px;
				font-weight:normal;
				margin-top:200px;
				text-shadow:1px 0px 0px #666, 2px 1px 0px #666, 3px 2px 0px #666, 4px 3px 0px #000;
			}

			p {
				display:block;
				margin-left:auto;
				margin-right:auto;
				width:550px;
				font-size:20px;
				font-family:'MuseoSans', Arial, Sans-serif;
				color:#666;
				text-shadow:1px 1px 0px #000;
			}
		</style>
	</head>

	<body>
		<h1>{$headline}</h1>
		<p>{$message}</p>
	</body>
</html>