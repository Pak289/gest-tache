<?php
    
class stm_Group
{
    private $Id;
    private $Wording;
    private $UserPerms;
    private $GroupPerms;
    private $SitePerms;
    private $UGPerms;
    private $SubTaskPerms;
    private $TaskPerms;
    private $ProjectPerms;
    private $CompanyPerms;
    private $canWriteCommentary;

    public function __construct($Id, $Wording, $UserPerms, $GroupPerms, $SitePerms, $UGPerms, $SubTaskPerms, $TaskPerms, $ProjectPerms, $CompanyPerms, $canWriteCommentary)
    {
        $this->Id = $Id;
        $this->Wording = $Wording;
        $this->UserPerms = $UserPerms;
        $this->GroupPerms = $GroupPerms;
        $this->SitePerms = $SitePerms;
        $this->UGPerms = $UGPerms;
        $this->SubTaskPerms = $SubTaskPerms;
        $this->TaskPerms = $TaskPerms;
        $this->ProjectPerms = $ProjectPerms;
        $this->CompanyPerms = $CompanyPerms;
        $this->canWriteCommentary = $canWriteCommentary;
    }

    public function getId()
    {
        return $this->Id;
    }

    public function getWording()
    {
        return $this->Wording;
    }

    public function getUserPerms()
    {
        return $this->UserPerms;
    }

    public function getGroupPerms()
    {
        return $this->GroupPerms;
    }

    public function getSitePerms()
    {
        return $this->SitePerms;
    }

    public function getUGPerms()
    {
        return $this->UGPerms;
    }

    public function getSubTaskPerms()
    {
        return $this->SubTaskPerms;
    }

    public function getTaskPerms()
    {
        return $this->TaskPerms;
    }

    public function getProjectPerms()
    {
        return $this->ProjectPerms;
    }
    
    public function getCompanyPerms()
    {
        return $this->CompanyPerms;
    }

    public function getCanWriteCommentary()
    {
        return $this->canWriteCommentary;
    }
}
