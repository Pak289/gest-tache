<?php


class stm_Task
{
    private $id;
    private $title;
    private $wording;
    private $localisation;

    private $priority_id;
    private $state_id;
    private $company_id;
    private $ug_id;
    private $site_id;
    private $project_id;

    /*
     *   Pour les tableaux, uniquement trois valeurs par valeur : [0] => id; [1] => nom; [2] => prenom;
     */

    private $user_assign;
    private $observ_assign;
    private $days;

    private $type; // Bool : true => type recurrent; false => type simple;

    private $sDate;
    private $eDate;

    public function __construct()
    {
        $this->user_assign = array();
        $this->observ_assign = array();
        $this->days = array();

        $this->type = false;
    }

    public function __destruct()
    {

    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_id($id): void
    {
        $this->id = $id;
    }

    public function get_title()
    {
        return $this->title;
    }

    public function set_title($title): void
    {
        $this->title = $title;
    }

    public function get_wording()
    {
        return $this->wording;
    }

    public function set_wording($wording): void
    {
        $this->wording = $wording;
    }

    public function get_localisation()
    {
        return $this->localisation;
    }

    public function set_localisation($localisation): void
    {
        $this->localisation = $localisation;
    }

    public function get_priority_id()
    {
        return $this->priority_id;
    }

    public function set_priority_id($priority_id): void
    {
        $this->priority_id = $priority_id;
    }

    public function get_state_id()
    {
        return $this->state_id;
    }

    public function set_state_id($state_id): void
    {
        $this->state_id = $state_id;
    }

    public function get_company_id()
    {
        return $this->company_id;
    }

    public function set_company_id($company_id): void
    {
        $this->company_id = $company_id;
    }

    public function get_ug_id()
    {
        return $this->ug_id;
    }

    public function set_ug_id($ug_ig): void
    {
        $this->ug_id = $ug_ig;
    }

    public function get_site_id()
    {
        return $this->site_id;
    }

    public function set_site_id($site_id): void
    {
        $this->site_id = $site_id;
    }

    public function get_project_id()
    {
        return $this->project_id;
    }

    public function set_project_id($project_id): void
    {
        $this->project_id = $project_id;
    }

    public function get_user_assign(): array
    {
        return $this->user_assign;
    }

    public function get_observ_assign(): array
    {
        return $this->observ_assign;
    }

    public function get_days(): array
    {
        return $this->days;
    }

    public function get_type(): bool
    {
        return $this->type;
    }

    public function set_type(bool $type)
    {
        $this->type = $type;
    }

    public function get_sDate()
    {
        return $this->sDate;
    }

    public function set_sDate($sDate)
    {
        $this->sDate = $sDate;
    }

    public function get_eDate()
    {
        return $this->eDate;
    }

    public function set_eDate($eDate)
    {
        $this->eDate = $eDate;
    }

    public function add_user_simple_assign($user_assign): void
    {
        array_push($this->user_assign, $user_assign);
    }

    public function add_user_assign($database, $user_assign): void
    {
        $stmt = $database->prepare("SELECT id,name,firstname FROM USERS WHERE id = :id");
        $stmt->execute(array(
            ':id' => $user_assign
        ));

        $stmt = $stmt->fetchAll();

        $user_assign = array(
            $stmt[0][0],
            $stmt[0][1],
            $stmt[0][2]
        );

        array_push($this->user_assign, $user_assign);
    }

    public function add_observ_simple_assign($observ_assign): void
    {
        array_push($this->observ_assign, $observ_assign);
    }

    public function add_observ_assign($database, $observ_assign): void
    {
        $stmt = $database->prepare("SELECT id,name,firstname FROM USERS WHERE id = :id");
        $stmt->execute(array(
            ':id' => $observ_assign
        ));

        $stmt = $stmt->fetchAll();

        $observ_assign = array(
            $stmt[0][0],
            $stmt[0][1],
            $stmt[0][2]
        );

        array_push($this->observ_assign, $observ_assign);
    }

    public function add_simple_days($day_assign): void
    {
        array_push($this->days, $day_assign);
    }

    public function add_days($database, $day_assign): void
    {
        $stmt = $database->prepare("SELECT id,wording FROM DAY_DAYS WHERE id = :id");
        $stmt->execute(array(
            ':id' => $day_assign
        ));

        $stmt = $stmt->fetchAll();

        $day_assign = array(
            $stmt[0][0],
            $stmt[0][1]
        );

        array_push($this->days, $day_assign);
    }

    public function rm_user_assign(int $id): void
    {
        array_splice($this->user_assign, $id, 1);
    }

    public function rm_observ_assign(int $id): void
    {
        array_splice($this->observ_assign, $id, 1);
    }

    public function rm_days(int $id): void
    {
        array_splice($this->days, $id, 1);
    }


    public function sendTask($database)
    {

        $stmt = $database->prepare("INSERT INTO TASKS VALUES (NULL,:title,:wording,:localisation,:priority,:state,:company,:site,:project,NULL)");

        $stmt->execute(array(
            ':title' => $this->get_title(),
            ':wording' => $this->get_wording(),
            ':localisation' => $this->get_localisation(),
            ':priority' => $this->get_priority_id(),
            ':state' => $this->get_state_id(),
            ':company' => $this->get_company_id(),
            ':site' => $this->get_site_id(),
            ':project' => $this->get_project_id()
        ));

        $this->set_id($database->lastInsertId());

        if ($this->get_user_assign()[0] != null) {
            $stmt = $database->prepare("INSERT INTO WORK VALUES (NULL,:user,:task)");

            foreach ($this->get_user_assign() as $user)
                $stmt->execute(array(
                    ':user' => $user[0],
                    ':task' => $this->get_id()
                ));
        }

        if ($this->get_observ_assign()[0] != null) {
            $stmt = $database->prepare("INSERT INTO OBS VALUES (NULL,:user,:task)");

            foreach ($this->get_observ_assign() as $user)
                $stmt->execute(array(
                    ':user' => $user[0],
                    ':task' => $this->get_id()
                ));
        }

        if ($this->get_type() === false) {
            $stmt = $database->prepare("INSERT INTO SIMPLE VALUES (:id,STR_TO_DATE(:sDate,'%d/%m/%Y'))");

            $stmt->execute(array(
                ':id' => $this->get_id(),
                ':sDate' => $this->get_sDate()
            ));
        } else {
            $stmt = $database->prepare("INSERT INTO RECURRENT VALUES (:id,STR_TO_DATE(:sDate,'%d/%m/%Y'),STR_TO_DATE(:eDate,'%d/%m/%Y'))");

            $stmt->execute(array(
                ':id' => $this->get_id(),
                ':sDate' => $this->get_sDate(),
                ':eDate' => $this->get_eDate()
            ));

            $stmt = $database->prepare("INSERT INTO RECURRENT_DAYS VALUES (NULL,:id,:day)");

            foreach ($this->get_days() as $day)
                $stmt->execute(array(
                    ':id' => $this->get_id(),
                    ':day' => $day[0]
                ));
        }
    }

    public function archiveTask($database) {
        $stmt = $database->prepare("UPDATE TASKS SET visibility = true WHERE id = :task_id");
        $stmt->execute(array(
            'task_id' => $this->get_id()
        ));
    }

    public function removeTask($database)
    {

        $stmt = $database->prepare("DELETE FROM OBS WHERE task_id = :task_id");
        $stmt->execute(array(
            ':task_id' => $this->get_id()
        ));

        $stmt = $database->prepare("DELETE FROM WORK WHERE task_id = :task_id");
        $stmt->execute(array(
            ':task_id' => $this->get_id()
        ));

        $stmt = $database->prepare("DELETE FROM DATING WHERE task_id = :id");
        $stmt->execute(array(
            ':id' => $this->get_id()
        ));

        $stmt = $database->prepare("DELETE FROM SIMPLE WHERE id = :id");
        $stmt->execute(array(
            ':id' => $this->get_id()
        ));

        $stmt = $database->prepare("DELETE FROM RECURRENT_DAYS WHERE recurrent_id = :id");
        $stmt->execute(array(
            ':id' => $this->get_id()
        ));

        $stmt = $database->prepare("DELETE FROM RECURRENT WHERE id = :id");
        $stmt->execute(array(
            ':id' => $this->get_id()
        ));

        $stmt = $database->prepare("DELETE FROM TASKS WHERE id = :id");
        $stmt->execute(array(
            ':id' => $this->get_id()
        ));
    }

    public function postMessage($database, $lastCommentary, $user)
    {
        $stmt = $database->prepare("INSERT INTO DATING VALUES (NULL,:task_id,:user,:commentary_id,:date,NULL)");

        date_default_timezone_set('Europe/Paris');
        $date = date('Y-m-d H:i:s', time());

        $stmt->execute(array(
            ':task_id' => $this->get_id(),
            ':user' => $user->getId(),
            ':commentary_id' => $lastCommentary,
            ':date' => $date
        ));
    }

    public function modifyStatePriority($database) {
        $stmt = $database->prepare("UPDATE TASKS SET localisation = :localisation, company_id = :company_id, state_id = :state_id, priority_id = :priority_id  WHERE id = :id");
        $stmt->execute(array(
            ':localisation' => $this->get_localisation(),
            ':company_id' => $this->get_company_id(),
            ':state_id' => $this->get_state_id(),
            ':priority_id' => $this->get_priority_id(),
            ':id' => $this->get_id()
        ));
    }
}

class stm_Task_Herite extends stm_Task
{
    public function __construct($database, $task, $id = null)
    {
        parent::__construct();

        $this->set_id($task[0]);
        $this->set_title($task[1]);
        $this->set_wording($task[2]);
        $this->set_localisation($task[3]);
        $this->set_priority_id($task[4]);
        $this->set_state_id($task[5]);
        $this->set_company_id($task[6]);
        $this->set_site_id($task[7]);
        if(isset($id))
            $this->set_project_id($id);
        else {
            $stmt = $database->prepare("SELECT project_id FROM TASKS WHERE id = :id;");
            $stmt->execute(array(
                ':id' => $this->get_id()
            ));
            $stmt = $stmt->fetchAll();
            
            $this->set_project_id($stmt[0][0]);
        }


        $stmt = $database->prepare("SELECT DISTINCT U.id,U.name,U.firstname,U.ini FROM USERS U, WORK W, TASKS T WHERE U.id = W.user_id AND :id = W.task_id");
        $stmt->execute(array(
            ':id' => $this->get_id()
        ));
        $stmt = $stmt->fetchAll();

        foreach ($stmt as $user) {
            $user_assign = array(
                $user[0],
                $user[1],
                $user[2],
                $user[3]
            );

            $this->add_user_simple_assign($user_assign);
        }

        $stmt = $database->prepare("SELECT DISTINCT U.id,U.name,U.firstname,U.ini FROM USERS U, OBS O, TASKS T WHERE U.id = O.user_id AND :id = O.task_id");
        $stmt->execute(array(
            ':id' => $this->get_id()
        ));
        $stmt = $stmt->fetchAll();

        foreach ($stmt as $user) {
            $user_assign = array(
                $user[0],
                $user[1],
                $user[2],
                $user[3]
            );

            $this->add_observ_simple_assign($user_assign);
        }

        $stmt = $database->prepare("SELECT * FROM SIMPLE WHERE id = :id");
        $stmt->execute(array(
            ':id' => $this->get_id()
        ));

        $stmt = $stmt->fetchAll(PDO::FETCH_BOTH);

        if (count($stmt) > 0)
            $this->set_sDate($stmt[0][1]);
        else {
            $this->set_type(true);

            $stmt = $database->prepare("SELECT * FROM RECURRENT WHERE id = :id");
            $stmt->execute(array(
                ':id' => $this->get_id()
            ));

            $stmt = $stmt->fetchAll(PDO::FETCH_BOTH);

            $this->set_sDate($stmt[0][1]);
            $this->set_eDate($stmt[0][2]);

            $stmt = $database->prepare("SELECT * FROM RECURRENT_DAYS WHERE recurrent_id = :id");
            $stmt->execute(array(
                ':id' => $this->get_id()
            ));

            $stmt = $stmt->fetchAll(PDO::FETCH_BOTH);

            foreach ($stmt as $day) {
                $statement = $database->prepare("SELECT * FROM DAY_DAYS WHERE id = :id");
                $statement->execute(array(
                    ':id' => $day[2]
                ));

                $days = $statement->fetchAll(PDO::FETCH_BOTH);
                $assign = array(
                    $days[0],
                    $days[1]);

                $this->add_simple_days($days);
            }
        }

        if($this->get_project_id() != null) {
            $stmt = $database->prepare("SELECT ug_id FROM PROJECTS WHERE id = :id");
            $stmt->execute(array(
                ':id' => $this->get_project_id()
            ));

            $stmt = $stmt->fetchAll(PDO::FETCH_BOTH);

            $this->set_ug_id($stmt[0][0]);
        }
    }


    public
    function get_priority($database, $id)
    {
        $stmt = $database->prepare("SELECT wording FROM PRIORITY WHERE id = :id");
        $stmt->execute(array(
            ':id' => $id
        ));

        return $stmt->fetchAll(PDO::FETCH_BOTH)[0];
    }

    public
    function get_state($database, $id)
    {
        $stmt = $database->prepare("SELECT wording FROM STATES WHERE id = :id");
        $stmt->execute(array(
            ':id' => $id
        ));

        return $stmt->fetchAll(PDO::FETCH_BOTH)[0];
    }

    public
    function get_company($database, $id)
    {
        $stmt = $database->prepare("SELECT name FROM COMPANY WHERE id = :id");
        $stmt->execute(array(
            ':id' => $id
        ));

        return $stmt->fetchAll(PDO::FETCH_BOTH)[0];
    }

    public
    function get_site($database, $id)
    {
        $stmt = $database->prepare("SELECT name FROM SITES WHERE id = :id");
        $stmt->execute(array(
            ':id' => $id
        ));

        return $stmt->fetchAll(PDO::FETCH_BOTH)[0];
    }
}
