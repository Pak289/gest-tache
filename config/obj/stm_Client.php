<?php
include_once ('stm_Group.php');

class stm_Client
{
    private $id;
    private $name;
    private $firstname;
    private $email;
    private $group_id;
    private $ug_id;
    private $group;


    public function __construct($id, $name, $firstname, $email, $group_id, $ug_id, $group)
    {
        $this->id = $id;
        $this->name = $name;
        $this->firstname = $firstname;
        $this->email = $email;
        $this->group_id = $group_id;
        $this->ug_id = $ug_id;
        $this->group = new stm_Group($group[0],$group[1],$group[2],$group[3],$group[4],$group[5],$group[6],$group[7],$group[8],$group[9],$group[10]);
    }


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getGroupId()
    {
        return $this->group_id;
    }

    public function getUgId()
    {
        return $this->ug_id;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function getGroupWording() {
        return $this->group->getWording();
    }
}
