<?php


namespace Pa\Managers;


use Pa\Core\Manager;
use Pa\Core\QueryBuilder;
use Pa\Models\Plannings;

class PlanningManager extends Manager
{
    /**
     * PlanningManager constructor.
     * Appelle le constructeur parent
     */
    public function __construct()
    {
        parent::__construct(Plannings::class, 'plannings');
    }

    /**
     * @return array
     * Recup tous les plannings et les retournes sous le format clef -> id du planning, valeur -> nom du planning
     */
    public function getPlannings()
    {
        $allPlannings = $this->findAll();
        $plannings = [];
        foreach ($allPlannings as $planning) {
            $plannings[$planning->getId()] = $planning->getName();
        }
        return $plannings;
    }

    /**
     * @return array
     * Recup tous les plannings sans faire de traitement
     */
    public function getAllPlannings()
    {
        return $this->findAll();
    }

    /**
     * @param $id
     * @return mixed
     * Recup les infos du planning
     */
    public function getPlanningInfo($id)
    {
        $planning = $this->findBy(["id_planning"=>$id]);
        return $planning[0];
    }

    /**
     * @param $name
     * @return mixed
     * Recup l'id d'un planning par son nom
     */
    public function getPlanningId($name)
    {
        $planning = $this->findBy(["name"=>$name]);
        return $planning[0]['id_planning'];
    }

    /**
     * @param $id
     * @return mixed
     * Recup l'id du role d'un planning
     */
    public function getPlanningRoleId($id)
    {
        $user = (new QueryBuilder())->select('pr.idRole')
            ->from('planning_role', 'pr')
            ->where('pr.idPlanning = :idPlanning')
            ->setParameter('idPlanning', $id)
            ->getQuery()
            ->getArray();
        return $user[0]['idRole'];
    }

    /**
     * @param $id
     * @return mixed
     * Recupère tous les cours lié a un planning
     */
    public function getAllCourses($id)
    {
        return (new QueryBuilder())->select('c.*')
            ->from('plannings', 'p')
            ->join("courses", "c", "p", "id_planning", "idPlanning")
            ->where("idPlanning = :idPlanning")
            ->setParameter("idPlanning", $id)
            ->getQuery()
            ->getArray();
    }

    public function getAllEventsInsidePlanningRange($id)
    {
        $planning = (new QueryBuilder())->select('p.date_start, p.date_end')
            ->from('plannings', 'p')
            ->where("id_planning = :id")
            ->setParameter('id', $id)
            ->getQuery()
            ->getArray();
        return (new QueryBuilder())->select('e.*')
            ->from('events', 'e')
            ->where("(e.date_start BETWEEN :date_start AND :date_end) AND
                               (e.date_end BETWEEN :date_start AND :date_end)")
            ->setParameter("date_start", $planning[0]['date_start'])
            ->setParameter("date_end", $planning[0]['date_end'])
            ->getQuery()
            ->getArray();
    }

}