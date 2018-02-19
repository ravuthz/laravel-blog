<?php

namespace App\Traits;

trait HtmlPageTrait {
    private $pageTitle;
    private $siteTitle;

    /**
     * @return mixed
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * @param mixed $pageTitle
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;
    }

    /**
     * @return mixed
     */
    public function getSiteTitle()
    {
        return $this->siteTitle;
    }

    /**
     * @param mixed $siteTitle
     */
    public function setSiteTitle($siteTitle)
    {
        $this->siteTitle = $siteTitle;
    }


}