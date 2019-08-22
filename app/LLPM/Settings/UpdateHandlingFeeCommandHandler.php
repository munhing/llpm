<?php 

namespace LLPM\Settings;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\FeeRepository;
use Fee;

class UpdateHandlingFeeCommandHandler implements CommandHandler {

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
    	$rates['20E'] = (int)$command->e20;
    	$rates['20L'] = (int)$command->l20;
    	$rates['40E'] = (int)$command->e40;
    	$rates['40L'] = (int)$command->l40;

        $fee = json_encode($rates);

        $handlingFee = Fee::edit(
            $command->handling_fee_id,
            $fee,
            $command->handling_effective_date
        );

        $this->feeRepository->save($handlingFee);

        // $this->dispatchEventsFor($portUser);

        return $handlingFee;   	
    }

}