<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ExamModel;

class UpdateStatusExam extends BaseController
{
    protected $exam;

    public function __construct()
    {
        $this->exam = new ExamModel();
    }

    public function updateStatus()
    {
        $this->exam->checkAndUpdateExamStatus();
    }
}
