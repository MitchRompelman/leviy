<?php

namespace App\Console\Commands;
use Storage;

use Illuminate\Console\Command;

class SchemeCommand extends Command
{
    // Last day and first day
    public $firstWorkDay = 0;
    public $lastWorkDay = 0; 

    // Csv Headers
    public $csvHeader = [
        'date',
        'activities',
        'time',
    ];

    // Time activities
    public $timeVacuuming = "00:21";
    public $timeVacuumingAndFridge = "01:11";
    public $timeCleanWindows = "00:35";

    // Csv output
    public $csvOutput = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SchemeCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the clean scheme.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Standards
        $date = $this->getdate();
        $year = $this->getYear();
        $days = $this->getMonthDays($date);
        // Date month
        $firstMonth = $this->getNextMonth('1');
        $secondMonth = $this->getNextMonth('2');
        $thirdMonth = $this->getNextMonth('3');
        // Date year month day
        $firstDate = $this->getNextDate('1');
        $secondDate = $this->getNextDate('2');
        $thirdDate = $this->getNextDate('3');
        // Check years
        if($this->getMonth() + 1 > 12) {
            $year = $year + 1;
        } 
        // First next month
        $this->checkList($firstDate, $firstMonth, $year);
        // Second next month
        $this->checkList($secondDate, $secondMonth, $year);
        // Third next month
        $this->checkList($thirdDate, $thirdMonth, $year); 
        // Generate csv
        $output = implode(",", $this->csvHeader);
        foreach ($this->csvOutput as $row) {
            $output .= "\n" . implode(",", array($row[0], $row[1], $row[2])); // append each row
        }
        // Add content to private storage csv
        Storage::disk('csv')->put('scheme.csv', rtrim($output, "\n"));
        $this->info('Csv generated, please login to download.');
    }

    public function checkList($date, $month, $year) {
        $format = date(''.$year.'-'.$month.'-');
        $days = $this->getMonthDays($date);
        for($start=1; $start<=$days; $start++)
        {
            $tmp_format = $format.$start;
            $date = date('Y M D d', $time = strtotime($tmp_format));
            // Vacuuming and fridge
            $this->VacuumingAndFridge($date, $start);
            // Vacuuming
            $this->vacuuming($date);
            // Clean windows
            $this->cleanWindows($date, $start, $days, $format);
        }
    }

    // Vacuuming and fridge
    public function VacuumingAndFridge($date, $start) {
        $message = 'Vacuuming and cleaning fridge';
        if($start == 1 ) {
            if(strpos($date, 'Sat')) {
                $this->firstWorkDay = $start + 2;
            }
            else if(strpos($date, 'Sun')) {
                $this->firstWorkDay = $start + 1;
            }
            else {
                $this->firstWorkDay = $start; 
            }
        }
        if($start == $this->firstWorkDay) {
            $this->csvOutput[] = [$date, $message, $this->timeVacuumingAndFridge];
        }
    }

    // Vacuuming
    public function Vacuuming($date) {
        $message = 'Vacuuming';
        if( strpos($date, 'Tue') || strpos($date, 'Thu') )
        {
            $this->csvOutput[] = [$date, $message, $this->timeVacuuming];
        }
    }

    // Clean windows
    public function cleanWindows($date, $start, $days, $format) {
        $message = 'Clean windows';
        if($start == $days) {
            if(strpos($date, 'Sat')) {
                $this->lastWorkDay = $start - 1;
                $tmp_format_lastday = $format.$this->lastWorkDay;
                $lastday = date('Y M D d', $time = strtotime($tmp_format_lastday));
                $this->csvOutput[] = [$lastday, $message, $this->timeCleanWindows];
            }
            else if(strpos($date, 'Sun')) {
                $this->lastWorkDay = $start - 2;
                $tmp_format_lastday = $format.$this->lastWorkDay;
                $lastday = date('Y M D d', $time = strtotime($tmp_format_lastday));
                $this->csvOutput[] = [$lastday, $message, $this->timeCleanWindows];
            } else {
                $this->csvOutput[] = [$date, $message, $this->timeCleanWindows];
            }
        }
    }

    public function getDate() {
        return date('Y-m-d');
    }

    public function getYear() {
        return date('Y');
    }

    public function getMonth() {
        return date('m');
    }

    public function getMonthDays($date) {
        return date("t", strtotime($date));
    }

    public function getNextMonth($month) {
        return date("m", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+".$month." month" ) );
    }

    public function getNextDate($month) {
        return date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+".$month." months" ) );
    }
}
