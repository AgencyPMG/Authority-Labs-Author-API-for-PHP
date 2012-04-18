<?PHP


require_once('AuthorityLabsAuthor.php');

$a = new AuthorityLabsAuthor();
$accountInfo = $a->getAccountLimit(1337);
print_r($accountInfo);

$domainCount = $accountInfo['watched-domains-count'];
$keywordCount = $accountInfo['watched-keywords-count'];

$domains = $a->getListOfDomains(array(), 1);
$keywords = $a->getListOfKeywords(13371, array(), 1);
$a->debugMode = true;

$ranks = $a->getHistoricalRankForKeyword(12341234, 1234123, '2011-01-01', '2012-12-12');


print_r($domains);



?>