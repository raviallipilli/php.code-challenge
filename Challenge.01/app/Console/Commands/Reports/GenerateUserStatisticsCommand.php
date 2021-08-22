<?php

namespace App\Console\Commands\Reports;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Config\Database;
use League\Csv\Writer;

class GenerateUserStatisticsCommand extends Command
{
    /**
     * The default command name.
     *
     * @var string
     */
    protected static $defaultName = 'generate:users-stats';

    /**
     * Define a description, help message and the input options and arguments.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->addOption(
                'start-date',
                null,
                InputOption::VALUE_REQUIRED,
                'The start date for report'
            )
            ->addOption(
                'end-date',
                null,
                InputOption::VALUE_REQUIRED,
                'End period'
            )
            ->setDescription('Generate statistics of users\' entitlements');
    }

    /**
     * Handle installing the development environment from scratch.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $startDate = $input->getOption('start-date');
        $endDate   = $input->getOption('end-date');

        // Your code ..
        $result = null;  

        // check if the date is empty
        if(!empty($startDate) && !empty($endDate))
        {     
            // check if the date is yyyy-mm-dd format
            if ($this->validateDate($startDate, 'Y-m-d') && $this->validateDate($endDate,'Y-m-d'))
            {
                $result = Database::getReports($startDate, $endDate);
                while($row = mysqli_fetch_assoc($result)) 
                {
                    $data[] = $row;
                }
            }
            else 
            {
                echo "Invalid date format. Please enter 'yyyy-mm-dd' date format\n";
                exit;
            }
        }
        else 
        {
            if ($startDate == null)
            {
                echo "Start date is required\n";
            }
            elseif ($endDate == null)
            {
                echo "End date is required\n";
            }
            else {
                echo "Start date and End date are required\n";
            }
            exit;
        }
        
        // create the CSV into memory
        $csv = \League\Csv\Writer::createFromPath('storage/reports_'.date('Y_m_d_H_i_s_a').'.csv', 'w');

        // insert the CSV header
        $csv->insertOne(['Company', 'Basic', 'Plus', 'Premium']);

        // The PDOStatement Object implements the Traversable Interface that's why Writer::insertAll can directly insert the data into the CSV
        $csv->insertAll($data);

        // Because we are providing the filename you don't have to set the HTTP headers, Writer::output can directly set them for you The file is downloadable
       $csv->output();
    
        return (int) true;
    }

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
}
