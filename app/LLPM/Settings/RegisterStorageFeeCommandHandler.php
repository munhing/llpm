<?php 

namespace LLPM\Settings;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\FeeRepository;
use Fee;

class RegisterStorageFeeCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $feeRepository;

	function __construct(FeeRepository $feeRepository)
	{
		$this->feeRepository = $feeRepository;
	}


    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {
    	// dd($command);

    	//convert rates to array and then json
    	$rates = [];
    	$rates['20'] = (int)$command->s20;
    	$rates['40'] = (int)$command->s40;

    	$fee = json_encode($rates);

		$storageFee = Fee::register(
			'storage',
            $fee,
            $command->storage_effective_date
		);

        $this->feeRepository->save($storageFee);

		// $this->dispatchEventsFor($portUser);

		return $storageFee;    	
    }

}