<?php 

namespace App;

class SearchData
{
    private string $searchBar = "" ;

    public function getSearchBar(): ?string
    {   
        return $this->searchBar ;
    }

    public function setSearchBar(string $searchBar): self
    {
        $this->searchBar = $searchBar;
        dump($searchBar);
        return $this;
    }   

    public function __toString()
    {
        return $this->searchBar;
    }
    
}



