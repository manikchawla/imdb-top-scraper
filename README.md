# imdb-top-scraper
A PHP script which scrapes IMDB for top rated movies and searches if an actor has played in them.

The script takes the number of IMDB top rated movies and the name of the actor as arguments and then displays the number of movies and the movies actor has played in.

Example: php imdb_topn.php 10 Brad Pitt

P.S. - The script takes ~25 mins for checking an actor's name in all 250 top rated movies.

Notes:

1. This script does not use Goutte which is an amazing library that uses Symphony components for scraping in PHP because somehow I couldn't get Goutte to work with all IMDB web pages. 
It worked flawlessly for reddit and other websites.

2. It makes use of the Simple HTML DOM Parser library for parsing the DOM and accesing elements and their attributes.

3. In has_actor function file_get_html() resulted in a lot of failed requests so I have used curl in its place.

4. .php_ini has been manually overridden for this script as the script was getting out of memory in some cases when the html object was too large.

5. value of constant MAX_FILE_SIZE has been changed in simple_html_dom.php to accomodate for larger HTML strings.

6. There is still plenty of scope for improvement. Feel free to fork it or do whatever you want with it. 
