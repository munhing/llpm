<?php

use Illuminate\Support\Facades\Log;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use LLPM\Containers\DailyContainerDaysCalculation;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CalculateContainerDaysCommand extends ScheduledCommand {

	protected $dailyContainerDaysCalculation;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'llpm:calculate-container-days';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Recalculate days and charges for active containers in the port';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(DailyContainerDaysCalculation $dailyContainerDaysCalculation)
	{
		$this->dailyContainerDaysCalculation = $dailyContainerDaysCalculation;

		parent::__construct();
	}


	/**
	 * When a command should run
	 *
	 * @param Scheduler $scheduler
	 * @return \Indatus\Dispatcher\Scheduling\Schedulable
	 */
	public function schedule(Schedulable $scheduler)
	{
		// return $scheduler->everyMinutes(10);
		// return $scheduler->daily();
        return [
            // run daily at 12am
            $scheduler->daily(),

            // run daily at 1pm
            App::make(get_class($scheduler))
                ->daily()
                ->hours(13)
        ];		
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		Log::info('Calculate container days');
		$this->dailyContainerDaysCalculation->fire();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			// array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			// array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
