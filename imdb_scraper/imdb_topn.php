<?php

require 'vendor/autoload.php';
require_once('includes/simple_html_dom.php');
ini_set('memory_limit', '256M');

$url = "http://www.imdb.com/chart/top";

if ($argc > 1) {
	if (!is_numeric($argv[1]) || $argv[1] > 250) {
		echo "Please enter a number less than 250 as the first argument.";
	}
	else {
		$result = list_of_movies($url, $argv[1]);
		foreach ($result as $num => $movie) {
			echo ++$num . ") " . $movie->innertext . "\n";
		}
		if ($argc > 2 && $argc < 10) {
			$name = "";
			foreach ($argv as $argument) {
				if ($argument == $argv[0] || $argument == $argv[1])
					continue;
				else {
					if (!ctype_alpha($argument)) {
						echo "Please enter a valid name as the second argument.";
						exit();
					}
					else
						$name .= " " . $argument;
				}
			}
			$second = has_actor($result, trim($name));
		}	
	}
}

else 
	echo "Invalid number of arguments.";

function list_of_movies($url, $n) {
	$movie_urls = [];
	$html = file_get_html($url);
	for ($i = 0; $i < $n; $i++) {
		$td = $html->find('td[class="titleColumn"]', $i);
		$movie_urls[$i] = $td->find('a', 0);
	}
	return $movie_urls;
}

function has_actor($movie_urls, $actor) {
	global $client;
	$rank = 1;
	$no_movies = 1;
	echo "\nMovies " . $actor . " played in: \n";
	foreach ($movie_urls as $movie_url) {
		$title_string = preg_match('/\/title\/([a-zA-Z0-9]+)\//', $movie_url->href, $movie_title);
		$base = "http://www.imdb.com/title/". $movie_title[1] . "/fullcredits?ref_=tt_cl_sm";

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_HEADER, FALSE);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($curl, CURLOPT_URL, $base);
		curl_setopt($curl, CURLOPT_REFERER, $base);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$str = curl_exec($curl);
		curl_close($curl);

		$html_base = new simple_html_dom();
		$html_base->load($str);
		foreach ($html_base->find('span[class="itemprop"]') as $span) {
			$cast_member = $span->innertext;	
			if ($cast_member == $actor) {
				$no_movies = 0;
				echo $rank . ") " . $movie_url->innertext . "\n";
			}			
		}
		$rank++;
	}
	if ($no_movies) 
		echo $actor . " hasn't played in any of the Top " . --$rank . " movies.";
}

?>