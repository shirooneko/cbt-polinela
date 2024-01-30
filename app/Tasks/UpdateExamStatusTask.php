<?php

namespace App\Tasks;

use App\Models\ExamModel;

class UpdateExamStatusTask
{
    public function handle()
    {
        log_message('info', 'UpdateExamStatusTask started');
        $examModel = new ExamModel();
        $examModel->checkAndUpdateExamStatus();
        log_message('info', 'UpdateExamStatusTask completed');
    }
}
