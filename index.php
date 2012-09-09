<?php
/*
 * Travian End Game Parser 
 * 
 * By: dvl <contato@xdvl.info>
 * Private software do not restribute
 * Designed to be used at travian.pt
 *
 */
?>

<html>
<head>
	<title>TRAVIAN - End Game Parser</title>
	<link rel="stylesheet" type="text/css" href="assets/style.css" />
  	<link rel="shortcut icon" type="image/x-icon" href="http://forum.travian.pt/images/travianvb4/statusicon/favicon.ico">
</head>
<body>
	<div id="content">
		<?php
			if ($_SERVER['REQUEST_METHOD'] == "POST") {

				// import_request_variables("p","_");
				$_data = $_POST['data'];	
				$_info = $_POST['info'];

				$_data['aldeias'] = str_replace(chr(13)."".chr(10),"",$_data['aldeias']);
				$_data['aldeias'] = str_replace("&#8206;","\n",$_data['aldeias']);
				/* hack pra lista de aldeias */

				foreach ($_data as $key => $value) {
					$line = explode("\n",$value);
					$i = 0;

					foreach ($line as $data) {
						$item = explode("\t",$data);

						if (preg_match("/(\d+)\./",$item[0])) {
							$x = 0;
							foreach ($item as $v) {
								$conteudo[$key][$i][$x] = $v;
								$x++;
							}
						}
						$i++;
					}
				}

				$content = file_get_contents("template.html");

				preg_match_all("{%([0-9A-Za-z_]+)%}", $content, $output);

				foreach ($output[1] as $old) {
					$n = explode("_",$old);
					$new = $conteudo[$n[0]][$n[1]][$n[2]];
					$content = str_replace("%".$old."%",$new,$content);
				}

				$duracao = floor((strtotime($_info['fim']) - strtotime($_info['inicio'])) / (60*60*24));

				$infos_old = array('$servidor$','$duracao$','$inicio$','$fim$','$hora$');
				$infos_new = array($_info['servidor'],$duracao,$_info['inicio'],$_info['fim'],$_info['hora']);
				$content = str_replace($infos_old,$infos_new,$content);

				echo "Para criar um novo post siga os passos abaixo:
					<ul>
						<li>Cole o código gerado abaixo no campo destinado a mensagem</li>
						<li>Tenha certeza de selecionar a opção <strong>HTML On - Don't convert linebreaks</strong></li>
						<li>Publique a postagem</li>
					</ul>
					<textarea rows='10' cols='128' readonly>$content</textarea>";

			}
			else {
				?>
				
				<form action="" method="post"> 
					<fieldset>
						<legend>Servidor</legend>
						<label>Titulo:</label> <input type="text" name="info[servidor]" placeholder="4º Servidor PT4" required /> <br />
						<label>Inicio em:</label> <input type="text" name="info[inicio]" width="30px" placeholder="01/01/1969" required /><br />
						<label>Termino em:</label> <input type="text" name="info[fim]" width="30px" placeholder="01/01/1970" required /> as <input type="text" name="info[hora]" placeholder="9:38pm" required /><br />
					</fieldset>

					<fieldset>
						<legend>Estatisticas</legend>
						<label>WWs:</label> <textarea rows="5" cols="80" name="data[ww]" required></textarea> <br />
						<label>Jogadores:</label> <textarea rows="5" cols="80" name="data[jogadores]" required></textarea> <br />
						<label>Ataque:</label> <textarea rows="5" cols="80" name="data[ataque]" required></textarea> <br />
						<label>Defesa:</label> <textarea rows="5" cols="80" name="data[defesa]" required></textarea> <br />
						<label>Alianças:</label> <textarea rows="5" cols="80" name="data[aliancas]" required></textarea> <br />
						<label>Aldeias:</label> <textarea rows="5" cols="80" name="data[aldeias]" required></textarea> <br />
						<label>Heróis:</label> <textarea rows="5" cols="80" name="data[herois]" required></textarea> <br />
					</fieldset>

					<fieldset align="center">
						<legend>Finalizar</legend>
						<input type="submit" value="Gerar"> <input type="reset" value="Limpar">
					</fieldset>
				</form>

				<?php				
			}
		?>
	</div>
</body>
</html>