Authority Labs Account API for PHP

API Access
Contact sales@authoritylabs.com for Account API Access

How to use
Documentation can be found inside: documentation/db_AuthorityLabsAuthor.html

After acquiring an API key from Authority labs, fill in the information inside the AuthorityLabsAuthor.php file

protected $apikey = 'XXXXXXXXXXXXXXXXXX';
protected $password = '***********';
protected $subdomain = 'mysubdomain'; 

If you have multiple Authority Labs accounts, you may also ass in the information into the constructor of the class

$al = new AuthorityLabsAuthor($apikey, $password, $subdomain)



Sample Use

require_once('AuthorityLabsAuthor.php');

$a = new AuthorityLabsAuthor();

//get a list of domains
$domains = $a->getListOfDomains());
print_r($domains);

Authority Labs Author API client interface.

package  Authority Labs Partner API PHP Library
author   PMG, Chris Alvares <chris.alvares@pmg.co>, http://pmg.co
license  http://creativecommons.org/licenses/MIT/ MIT
link     https://github.com/kressaty/Authority-Labs-Partner-API-PHP-Library (pending)
More documentation can be found at https://docs.google.com/View?id=dfjjgtqz_34f4kkw6jk

