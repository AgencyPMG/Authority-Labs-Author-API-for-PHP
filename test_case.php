<?PHP


require_once('AuthorityLabsAuthor.php');

$a = new AuthorityLabsAuthor();
print_r($a->getAccountLimit(1337));




?>