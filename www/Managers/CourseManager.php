<?php
namespace Pa\Managers;

use Pa\Core\Connection\BDDInterface;
use Pa\Core\Manager;
use Pa\Core\QueryBuilder;
use Pa\Models\Courses;

class CourseManager extends Manager
{
    public function __construct()
    {
        parent::__construct(Courses::class, 'courses');
    }

    /**
     * @param $date_start
     * @param $date_end
     * @param $idPlanning
     * @param string $id_course
     * @return mixed
     * Verif que le cours qui va être crée n'empiete pas sur un autre cours
     */
    public function verifCourse($date_start, $date_end, $idPlanning, $id_course = '') {
        $qb = new QueryBuilder();
        $qb->select('c.*')
            ->from('courses', 'c')
            ->where("c.date_start BETWEEN :date_start AND :date_end OR
             c.date_end BETWEEN :date_start AND :date_end")
            ->where("idPlanning = :idPlanning");
        if ($id_course !== '') {
            $qb->where("c.id_course <> :id_course")->setParameter("id_course", $id_course);
        }
            $courses = $qb->setParameter("date_start", $date_start)
            ->setParameter("date_end", $date_end)
            ->setParameter("idPlanning", $idPlanning)
            ->getQuery()
            ->getArray();
        return $courses;
    }

    /**
     * @param $date_start
     * @param $date_end
     * @param $idPlanning
     * @return mixed
     * Vérif que le cours créé est bien compris dans les dates du planning
     */
    public function courseInsidePlanning($date_start, $date_end, $idPlanning)
    {
        $courses = (new QueryBuilder())->select('p.*')
            ->from('plannings', 'p')
            ->where(":date_start < p.date_start OR :date_start > p.date_end 
            OR :date_end < p.date_start OR :date_end > p.date_end")
            ->where("p.id_planning = :idPlanning")
            ->setParameter("date_start", $date_start)
            ->setParameter("date_end", $date_end)
            ->setParameter("idPlanning", $idPlanning)
            ->getQuery()->getArray();
        return $courses;
    }

    /**
     * @param $courseId
     * @return mixed
     * Recup l'id du planning grâce a l'id du cours
     */
    public function getPlanningId($courseId)
    {
        $planningId = (new QueryBuilder())->select('c.idPlanning')
            ->from('courses', 'c')
            ->where("c.id_course = :courseId")
            ->setParameter('courseId', $courseId)
            ->getQuery()
            ->getArray();
        return $planningId[0];
    }

    /**
     * @param $id
     * @return mixed
     * Recup les infos d'un cours
     */
    public function getInfo($id)
    {
        $course = $this->findBy(['id_course'=>$id]);
        return $course[0];
    }
}