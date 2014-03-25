<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    private $db = null;
    private $rubric = null;
    private $subject = null;
    private $user = null;
    private $userSubject = null;

    function __construct() {
        parent::__construct();
        $this->db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        Application::requireClass('Rubric');
        $this->rubric = new Rubric();
        Application::requireClass('Subject');
        $this->subject = new Subject();
        Application::requireClass('User');
        $this->user = new User();
        $this->smarty->assign('small_path', $this->user->images['small_path']);
        Application::requireClass('UserSubject');
        $this->userSubject = new UserSubject();
    }

    protected function assignSubjects () {
        $rubrics = $this->db
            ->select('r_id, title')
            ->from($this->rubric->table)
            ->orderBy('sort')
            ->limit(0, 4)
            ->fetch('r_id');

        foreach ($rubrics as &$r) {
            $r['subjects'] = array();
            $this->db = $this->db
                ->select('url, subject, r_id')
                ->from($this->subject->table)
                ->where("r_id = {$r['r_id']}")
                ->orderBy('subject')
                ->limit(0, 5)
                ->union();
        }

        $subjects = $this->db->fetch();

        foreach ($subjects as $subject) {
            $rubrics[$subject['r_id']]['subjects'][] = $subject;
        }

        $this->smarty->assign('rubrics', $rubrics);
    }

    protected function assignTeachers () {
        $teachers = $this->db
            ->select("user_pic, {$this->user->table}.u_id, fio, subject")
            ->from($this->user->table)
            ->join($this->userSubject->table, "ON {$this->userSubject->table}.u_id = {$this->user->table}.u_id")
            ->join($this->subject->table, "ON {$this->subject->table}.s_id = {$this->userSubject->table}.s_id")
            ->where('status = 1 AND i_am_teacher = 1 AND subjects > 0')
            ->groupBy("{$this->user->table}.u_id")
            ->limit(0, 7)
            ->fetch();

        if (count($teachers) < 7 && count($teachers) > 0) {
            $cnt = count($teachers);
            for ($i = 0; $i < 7 - $cnt; $i++) {
                $teachers[] = $teachers[$i];
            }
        }

        $this->smarty->assign('teachers', $teachers);
    }

    function display () {
        if (count(Router::$path) > 0) {
            throw new Exception404();
        }

        $this->assignSubjects();
        $this->assignTeachers();

        $this->smarty->assign('page', 'main');
        parent::display();
    }
}