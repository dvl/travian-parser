<?php

/**
 * @author dvl <contato@xdvl.info>
 * @version 0.1
 * @package Travian End Game Parser
 */

error_reporting(E_ALL);

require_once 'simple_html_dom.php';
require_once 'Snoopy.class.php'; 

class Parser { 

	private $cookie;
	private $server;
	private $pages = array(
		'jogadores' => array('id' => 0, 'idsub' => 0),
		'atacantes' => array('id' => 0, 'idsub' => 1),
		'defensores' => array('id' => 0, 'idsub' => 2),
		'aliancas' => array('id' => 1, 'idsub' => 0),
		'aldeias' => array('id' => 2, 'idsub' => 0),
		'herois' => array('id' => 3, 'idsub' => 0),
		'ww' => array('id' => 6, 'idsub' => 0),
	);
	private $message;
	private $ranks = array();

	public function __construct($server) { 
		$this->snoopy = new Snoopy;
		$this->server = $server;

		$this->html = new simple_html_dom();
	}

	public function login($login, $password) {
		if ($this->snoopy->submit($this->server.'dorf1.php', array('name' => $login, 'password' => $password, 'w' => '1920%3A1080', 'login' => microtime()))) { 
			preg_match('/^Set-Cookie: T3E=(.*?);/sm', $this->snoopy->headers[8], $c);
			$this->cookie = $c[1];
		}
		else {
			echo "error fetching login: ".$this->snoopy->error;
		}
	}

	public function populate() { 
		foreach ($this->pages as $key => $page) {
			$this->ranks[$key] = $this->fetch($page['id'], $page['idsub']);
		}
	}

	public function fetch($id, $idsub = 0) { 
		$this->snoopy->cookies["T3E"] = $this->cookie;

		if($this->snoopy->fetch($this->server.'statistiken.php?id='.$id.'&idSub='.$idsub)) {

			$this->html->load($this->snoopy->results);

			$players = array(); // Javascript feels

			foreach($this->html->find('table tbody tr') as $line) {
				if (count($players) <= 20) { // Controle...
					$item[0] = $line->find('td', 0)->plaintext;
					$item[1] = $line->find('td', 1)->plaintext;
					$item[2] = $line->find('td', 2)->plaintext;
					$item[3] = $line->find('td', 3)->plaintext;
					if ($line->find('td', 4)) // Para o rank de aldeias ou WW que possuem uma coluna a mais
						$item[4] = $line->find('td', 4)->plaintext;
					$players[] = $item;
				}
			}
			return $players;
		}
		else {
			echo "error fetching top 10: ".$this->snoopy->error;
		}
	}

	public function fetch_msg() { 
		$this->snoopy->cookies["T3E"] = $this->cookie;
		if($this->snoopy->fetch($this->server.'dorf2.php?a=26&c=9414ec')) {
			$this->html->load($this->snoopy->results);

			preg_match('/\<p\>(.*?)\<\/p\>/sm', $this->html->find('div#sysmsg', 0)->outertext, $m);

			return $m[1]; 
		} 
		else {
			echo "error fetching end message: ".$this->snoopy->error;
		}
	}

	public function build_html($template, $infos) {
		$content = file_get_contents($template);

		preg_match_all("{%([0-9A-Za-z_]+)%}", $content, $output);

		foreach ($output[1] as $old) { 
			$n = explode("_", $old);
			$new = $this->ranks[$n[0]][$n[1]][$n[2]];
			$content = str_replace("%".$old."%", $new, $content);
		}

		$msg = str_replace('<img src="http://img.travian.org/temp/ww100.gif"   style="float:right;">','',$this->fetch_msg());

		$DateTime = new DateTime($infos['inicio']);

		$diff = $DateTime->diff(new DateTime($infos['fim']));

		$infos_old = array('$servidor$','$duracao$','$inicio$','$fim$','$msg$');
		$infos_new = array($infos['titulo'],$diff->days,$infos['inicio'],$infos['fim'],$msg);
		$content = str_replace($infos_old,$infos_new,$content);

		return $content;
	}
}