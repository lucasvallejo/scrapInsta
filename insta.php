<?php
	require('phpQuery/phpQuery.php');
	header('Content-type: text/html; charset=UTF-8');
	header('Access-Control-Allow-Origin: *');
?>

<!DOCTYPE html>
<html>
<head>
	<title>WIDTGET COMENTARIOS</title>

<link href="http://flatfull.com/themes/basik/assets/css/site.min.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;500&display=swap" rel="stylesheet">


	<style type="text/css">
		
		html,body,*{
			font-family: 'Montserrat', sans-serif;
			font-size: 13px;
		}

		.thead{
			background-color: #355a7f;
    		color: #fff;
		}

		.thead{
			padding: 10px;
		}

		.theadc {
		    background-color: #f9f9fa;
		    color: #0b2946;
		}

		.theadc{
			padding: 10px;
		}


		.imagen img{
			border:3px solid red;
		}

		.existe{
			background-color: red;
			color:#fff;
		}

		.noexiste{
			background-color: #bbdcbb;
			
		}
	</style>

</head>
<body>



    

    

<?php

function filtro($palabra)
{
	$status = false;

	if (preg_match('/Pedid/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Orde/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Estafa/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Plata/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Devu/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Mal/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Cali/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Estaf/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Contes/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Atenci/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Pesim/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Mail/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Consum/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Defens/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Correo/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/No/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/odio/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/Forr/i', $palabra)) {
		$status = true;
	}

	if (preg_match('/responde/i', $palabra)) {
		$status = true;
	}

	return $status;
}

function getcomment($link, $imagen, $texto, $like, $comentarios, $tienda)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $link);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$body = curl_exec($ch);
	curl_close($ch);

	$content = phpQuery::newDocument($body);

	$dato3 = ['<script type="text/javascript">', '</script>', 'window._sharedData =', ';'];
	$dato4   = ["", "", "", ""];

	$feed = str_replace($dato3, $dato4, pq($content)->find('script:eq(3)'));

	if (preg_match('/application/', $feed)) {
		$feed = str_replace($dato3, $dato4, pq($content)->find('script:eq(4)'));
	}

	$estado = json_decode($feed, true);

	$estado = $estado['entry_data']['PostPage'][0]['graphql']['shortcode_media']['edge_media_to_parent_comment']['edges'];

	echo "
		<table width='100%' class='table table-theme table-row v-middle' data-plugin='bootstrapTable'>
			<thead>
		        <tr>

				<th width='5%'>POSTEO</th>

				<th width='85%'>TEXTO</th>

				<th width='5%'>LIKES</th>

				<th width='5%'>COMENTARIOS</th>
				
				</tr>
			</thead>

		<tr>


			<td class='imagen' valign='middle'><img width='50px' src='" . $imagen . "'></td>

			<td>" . $texto . "</td>

			<td>" . $like . "</td>

			<td>" . $comentarios . "</td>


		</tr>


";

	if ($comentarios > 0) {
		echo "<tr>
		<td  colspan='4'>";

		echo "<table width='100%' class='table table-theme table-row v-middle'>

		<thead>
			<tr class='theadc'>

				<th width='20%'>USUARIO</th>

				<th width='60%'>COMENTARIO</th>

				<th width='20%'>ACCION</th>
			</tr>
		</thead>
			";

		for ($i = 0; $i < count($estado); $i++) { 
						

				

			if (filtro($estado[$i]['node']['text'])) {
				$clase = "bg-danger";
			} else {
				$clase = "";
			}

			echo "


				<tr>


				<td><a href='https://www.instagram.com/" . $estado[$i]['node']['owner']['username'] . "/' target='_blank'>" . $estado[$i]['node']['owner']['username'] . "</a></td>

				<td><span class='" . $clase . "'>" . $estado[$i]['node']['text'] . "</span></td>

				<td><a href='" . $link . "' target='_blank'>Responder</a></td>

				




				</tr>";



		}

		echo "</table>";
	}

	echo "</td>

		</tr>

		</table>";
}

$tienda = $_GET['insta'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/" . $tienda . "/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$body = curl_exec($ch);
curl_close($ch);

$content = phpQuery::newDocument($body);

$dato3 = ['<script type="text/javascript">', '</script>', 'window._sharedData =', ';'];
$dato4   = ["", "", "", ""];

$feed = str_replace($dato3, $dato4, pq($content)->find('script:eq(4)'));

    

    ////////////////////////////////////////////////////////

$array_profile = json_decode($feed, true);

	

$posteos = $array_profile['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];

	

for ($i = 0; $i < count($posteos); $i++) {
	getcomment(
		"https://www.instagram.com/p/" . $posteos[$i]['node']['shortcode'] . "/",
		$posteos[$i]['node']['thumbnail_src'],
		$posteos[$i]['node']['edge_media_to_caption']['edges'][0]['node']['text'],
		$posteos[$i]['node']['edge_liked_by']['count'],
		$posteos[$i]['node']['edge_media_to_comment']['count'],
		$tienda
	);
}

?>


</body>
</html>