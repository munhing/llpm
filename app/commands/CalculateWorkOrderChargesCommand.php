<?php

use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use LLPM\WorkOrders\DailyWorkOrderChargesCalculation;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CalculateWorkOrderChargesCommand extends ScheduledCommand {
	protected $dailyWorkOrderChargesCalculation;


	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'llpm:calculate-workorder-charges';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'This is a cron to recalculate workorder charges daily after the cron: calculate-container-days is ran. This cron will be set to run pass midnight.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(DailyWorkOrderChargesCalculation $dailyWorkOrderChargesCalculation)
	{
		$this->dailyWorkOrderChargesCalculation = $dailyWorkOrderChargesCalculation;

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
		return $scheduler->daily()->hours(0)->minutes(30);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		Log::info('Calculate workorder charges');
		$this->dailyWorkOrderChargesCalculation->fire();
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
