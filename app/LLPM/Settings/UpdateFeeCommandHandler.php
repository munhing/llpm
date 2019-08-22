<?php 

namespace LLPM\Settings;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\FeeRepository;
use Fee;

class UpdateFeeCommandHandler implements CommandHandler {

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
        
    	$rates = [];
        $effective_date = '';

        if($command->fee_type == 'haulage' || $command->fee_type == 'lifting') {
            //convert rates to array and then json
        	$rates['20E'] = (int)$command->e20;
        	$rates['20L'] = (int)$command->l20;
        	$rates['40E'] = (int)$command->e40;
            $rates['40L'] = (int)$command->l40;
            $effective_date = $command->effective_date1;

        } else {
            $rates['20'] = (int)$command->s20;
            $rates['40'] = (int)$command->s40;           
            $effective_date = $command->effective_date2;
        }

        $fee = json_encode($rates);

        $feeSetting = Fee::edit(
            $command->fee_id,
            $fee,
            convertToMySQLDate($effective_date)
        );

        $this->feeRepository->save($feeSetting);

        // $this->dispatchEventsFor($portUser);

        return $feeSetting;   	
    }

}