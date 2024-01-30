<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\ExamModel;

class UpdateExamStatus extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'CodeIgniter';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'update:exam-status';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Update exam status in the application.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'update:exam-status';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        // Panggil model atau service untuk memperbarui status ujian
        $examModel = new ExamModel();
        $examModel->checkAndUpdateExamStatus();

        CLI::write('Exam status updated successfully!', 'green');
    }
}
