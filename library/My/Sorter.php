<?php

class My_Sorter
{
	private $baseURL;
	private $sortParam;
	private $sortDirect;
	private $pageParams;
	
	public function __construct($baseURL, $sortParam, $sortDirect, $pageParams=array()) {
		$this->baseURL = $baseURL;
		$this->sortParam = $sortParam;
		$this->sortDirect = $sortDirect;
		$this->pageParams = $pageParams;
	}
	
	public function getSortURL($sortParam) {
		$pageParams = $this->pageParams;
		$pageParams['order']  = $sortParam;
		$pageParams['direct'] = (($this->sortParam == $sortParam) && ($this->sortDirect == 'asc')) ? 'desc' : 'asc';
		
		$sortURLParams = '';
		foreach ($pageParams as $sortParam=>$sortValue) {
			$urlString = '';
			
			if (!is_array($sortValue)) {
				$urlString = $sortParam . '=' . urlencode($sortValue);
			} else {
				$c=0;
				foreach ($sortValue as $value) {
					$c++;
					$urlString .= $sortParam . '[]=' . urlencode($value) . (count($sortValue) != $c ? '&' : '');
				}
			}

			$sortURLParams .= ($sortURLParams ? '&amp;' : '') . $urlString;
		}
		
		return $this->baseURL . ($sortURLParams ? '?' : '') . $sortURLParams;
	}
	
	public function isSortDirect($sortParam) {
		return ($this->sortParam == $sortParam);
	}
	
	public function getSortDirect($sortParam) {
		return ($this->sortParam == $sortParam) ? $this->sortDirect : 'asc';
	}
}