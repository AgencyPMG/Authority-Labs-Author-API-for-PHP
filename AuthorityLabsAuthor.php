<?php

/**
 * Authority Labs Author API client interface.
 *
 * @category Services
 * @package  Authority Labs Partner API PHP Library
 * @author   PMG, Chris Alvares <seo@pmg.co>
 * @license  http://creativecommons.org/licenses/MIT/ MIT
 * @link     https://github.com/AgencyPMG/Authority-Labs-Author-API-for-PHP
 * More documentation can be found at https://docs.google.com/View?id=dfjjgtqz_34f4kkw6jk
 */
 

class AuthorityLabsAuthor
{
	protected $apikey = 'XXXXXXXXXXXXXXXXXX';
	protected $password = '***********';
	protected $subdomain = 'mysubdomain'; 


	public function __construct($apikey=null, $password=null, $subdomain=null)
	{
		if($apikey != null) $this->apikey = $apikey;
		if($password != null) $this->password = $password;
		if($subdomain != null) $this->subdomain = $subdomain;
		
	}

	/**
	* Get keyword and domain limit data for your account
	* @param string $account_id The Authority Labs AccountID
	*/
	public function getAccountLimit($account_id)
	{
		return $this->getAuthorityLabsData('/accounts/' . $account_id . '/limits.xml');
	}

	/**
	Add a new domain to your account
	* @param string $domain_name Name of Domain
	* @param string $locale A combination of language/country_code
	*/
	public function createDomain($domain_name, $locale=null)
	{
		$params = array('domain_name'=>$domain_name);
		if($locale != null) $params['locale'] = $locale;
		
		return $this->getAuthorityLabsData('/watched_domains.xml', 'POST', $params);
	}
	
	/**
	* To delete a domain
	* @param string $domain_id ID of the domain
	*/
	public function deleteDomain($domain_id)
	{
		return $this->getAuthorityLabsData('/watched_domains/' . $domain_id . '.xml', 'DELETE');
	}
	
	/**
	* Add multiple keywords
	* @param string $domain_id ID of the domain
	* @param array $keywords An array of keywords to add to the domain
	*/
	public function createMultipleKeywords($domain_id, $keywords)
	{
		return $this->getAuthorityLabsData('/watched_domains/' . $domain_id . '/watched_keywords.xml', 
											'POST', 
											array('keyword_name'=> implode('\r\n', $keywords)));
		
	}
	
	
	/**
	* Same call as @see creativeMultipleKeywords, except with only one keyword
	* @param string $domain_id ID of the domain
	* @param string $keyword A keyword to add to the domain
	* */
	public function createKeyword($domain_id, $keyword)
	{
		return $this->createMultipleKeywords($domain_id, array($keyword));
	}
	
	/**
	* To delete a single keyword
	* @param string $domain_id ID of the domain
	* @param string $keyword_id ID of the keyword
	*/
	public function deleteKeyword($domain_id, $keyword_id)
	{
		return $this->getAuthorityLabsData('/watched_domains/' . $domain_id . '/watched_keywords/' . $keywordid . '.xml',
											'DELETE');
	}
	
	
	/**
	* Available Attributes:
	* 	id
	* 	account-id
	* 	domain-id
	* 	domain-name
	* 	created-at
	* 	updated-at
	* 	watched-keywords-count
	* 	locale
	* 	syncing-group-id
	* 
	* @param array $searchParams A search parameter dictionary
	* @param number $page the page list, the pages come in at 50 per query
	*/
	public function getListOfDomains($searchParams=array(), $page=1)
	{
		$url = '/watched_domains.xml?version=2010&page=' . $page;
		
		foreach($searchParams as $key=>$value)
		{
			$url .= '&'. urlencode($key) . '=' . urlencode($value);
		}
		
		return $this->getAuthorityLabsData($url);
	}
	
	/**
	* To get all watched domains tied to a URL
	* @param string $url URL to look at
	*/
	public function getListOfDomainsByURL($url)
	{
		return $this->getAuthorityLabsData('/watched_domains/get_watched_domains_by_url.xml?url=' . urlencode($url));
	}
	
	/**
	* To get rank averages for a watched domain
	* @param string $domain_id ID of the domain
	*/
	public function getDomainRankAverages($domain_id)
	{
		return $this->getAuthorityLabsData('/watched_domains/' . $domain_id . '/rank_averages.xml');
	}
	
	/**
	* To get a the name and suggested keywords for your watched domains,
	* @param string $domain_id ID of the domain
	*/
	public function getDomain($domain_id)
	{
		return $this->getAuthorityLabsData('/domains/' . $domain_id . '.xml');
	}
	/**
	* To get a list of your watched keywords for a watched domain
	* @see getListOfDomains for searchParameters
	* @param string $domain_id ID of the domain
	* @param array $searchParams a dictionary of search parameters
	* @param number $page a number for pagenation, each query returns a maximum of 50
	*/
	public function getListOfKeywords($domain_id, $searchParams=array(), $page=1)
	{
		$url = '/watched_domains/'.$domain_id.'/watched_keywords.xml?version=2010&page=' . $page;
		
		foreach($searchParams as $key=>$value)
		{
			$url .= '&'.urlencode($key) . '=' . urlencode($value);
		}
		
		return $this->getAuthorityLabsData($url);
	}
	
	/**
	* To get a the name for your watched keywords
	* @param string $keyword_id ID of the keyword
	*/
	public function getKeyword($keyword_id)
	{
		return $this->getAuthorityLabsData('/keywords/' . $keyword_id . '.xml');
	}
	
	/**
	* To get a keyword and it's current rank in each engine
	* @param string $domain_id ID of the domain
	* @param string $keyword_id ID of the keyword
	*/
	public function getCurrentRankForKeyword($domain_id, $keyword_id)
	{
		return $this->getAuthorityLabsData('/watched_domains/' . $domain_id . '/watched_keywords/' . $keyword_id . '/current_rankings.xml');
	}
	
	/**
	* To get a list of all domainless keywords
	* @param string $domain_id ID of the domain
	* @param string $keyword_id ID of the keyword
	* @param date $startdate start date in YYYY-MM-DD format
	* @param date $enddate end date in YYYY-MM-DD format
	*/
	public function getHistoricalRankForKeyword($domain_id, $keyword_id, $startdate, $enddate)
	{
		return $this->getAuthorityLabsData("/watched_domains/$domain_id/watched_keywords/$keyword_id/historical_rankings.xml?start_date=$startdate&end_date=$enddate");
	}
	
	/**
	* To get a keyword's previous rank results in each engine
	* @param string $domain_id ID of the domain
	* @param string $keyword_id ID of the keyword
	*/
	public function getAllRankResultsForKeyword($domain_id, $keyword_id)
	{
		return $this->getAuthorityLabsData("/watched_domains/$domain_id/watched_keywords/$keyword_id/current_full_rankings.xml");
	}
	
	/**
	To get the number of indexed pages in each search engine
	@param string $domain_id ID of the domain
	*/
	public function getIndexedPageCount($domain_id)
	{
		return $this->getAuthorityLabsData("/watched_domains/$domain_id/domain_indices/domain_index_counts.xml");
	}
	
	/**
	* To get the top 100 indexed pages in each search engine for a domain or page
	* @param string $domain_id ID of the domain
	* @param string $engine name of the Search Engine {google|bing|yahoo}
	*/
	public function getTopIndexedPages($domain_id, $engine='google')
	{
		return $this->getAuthorityLabsData("/watched_domains/watched_domain_id/domain_indices.xml?engine=$engine");
	}
	
	protected function buildBaseURL()
	{
		return 'http://' . urlencode($this->apikey) . ':' . urlencode($this->password) . '@' . $this->subdomain . '.authoritylabs.com';
	}
	
	protected function getAuthorityLabsData($path, $method='GET', $params=array())
	{
		$url = $this->buildBaseURL() . $path;
		
		$encoded = "";
		foreach($params as $key=>$value)
		    $encoded .= "$key=".urlencode($value)."&";
		$encoded = substr($encoded, 0, -1);
		
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		// curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
		switch(strtoupper($method))
		{
		    case "GET":
		        curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
		        break;
		    case "POST":
		        curl_setopt($curl, CURLOPT_POST, TRUE);
		        curl_setopt($curl, CURLOPT_POSTFIELDS, $encoded);
		        break;
		    case "PUT":
		        curl_setopt($curl, CURLOPT_POSTFIELDS, $encoded);
		        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
		        file_put_contents($tmpfile = tempnam("/tmp", "put_"), $encoded);
		        curl_setopt($curl, CURLOPT_INFILE, $fp = fopen($tmpfile, 'r'));
		        curl_setopt($curl, CURLOPT_INFILESIZE, filesize($tmpfile));
		        break;
		    case "DELETE":
		        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		        break;
		    default:
		       return "Unknown method $method";
		        break;
		}
		$result = curl_exec($curl);
		
		if(isset($fp)) fclose($fp);
		if(isset($tmpfile)) unlink($tmpfile);
		
		// do the request. If FALSE, then an exception occurred    
		if($result === false)
		{
			throw new AuthorityLabsAuthorException("AuthorityLabsAuthor failed with error " . curl_error($curl));
			return;
		}
		
		return $this->parseOutput($result);

	}
	
	protected function parseOutput($output)
	{
		return json_decode(json_encode(simplexml_load_string($output)), true);
	}


}

class AuthorityLabsAuthorException extends Exception
{

}