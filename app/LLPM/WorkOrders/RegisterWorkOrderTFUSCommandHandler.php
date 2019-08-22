<?php

namespace LLPM\WorkOrders;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\CommanderTrait;

use LLPM\WorkOrders\RegisterWorkOrderCommand;
use LLPM\Confirmation\ConfirmContainerCommand;

class RegisterWorkOrderTFUSCommandHandler implements CommandHandler {

    use CommanderTrait;

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {
        // dd($command);

        $inputTF = $this->convertToArrayTF($command);
        $inputUS = $this->convertToArrayUS($command);

        // register WO TF-1-3
        $workorder = $this->execute(RegisterWorkOrderCommand::class, $inputTF);

        //Confirm TF Container with BYPASS
				$inputConfirmation = $this->convertToArrayConfirmation($command, $workorder);

				foreach($inputConfirmation as $confirmation) {
						$this->execute(ConfirmContainerCommand::class, $confirmation);
				}

        // register WO US-3
				$workorder = $this->execute(RegisterWorkOrderCommand::class, $inputUS);

				return $workorder;
    }

    function convertToArrayTF($command)
    {
        // dd('Convert');
        $array = [];
        $array['type'] = 'TF-1-3';
        $array['handler_id'] = $command->handler_id;
        $array['carrier_id'] = $command->carrier_id;

        foreach($command->containers as $cont) {
            $array['containers'][] = $cont;
        }

        // dd($array);
        return $array;
    }

    function convertToArrayUS($command)
    {
        // dd('Convert');
        $array = [];
        $array['type'] = 'US-3';
        $array['handler_id'] = $command->handler_id;
        $array['carrier_id'] = $command->carrier_id;

        foreach($command->containers as $cont) {
            $array['containers'][] = $cont;
        }

        // dd($array);
        return $array;
    }

		function convertToArrayConfirmation($command, $workorder)
		{
				$arrConfirmation = [];

				foreach($command->containers as $cont) {
						$array = [];

						$array['a_confirmation'] = '["'. $cont .',L,'. $workorder->id.',TF-1-3"]';
						$array['a_carrier'] = '["BYPASS"]';
						$array['a_lifter'] = '["FOR UST-3"]';
						$array['a_date'] = '["'. date('Y-m-d').'"]';
						$array['a_confirmed_at'] = '["'. date('H:i').'"]';
						$array['a_operator'] = '["29"]';
						$array['a_cp'] = '["CY1"]';
						$array['bypass'] = '["true"]';

						$arrConfirmation[] = $array;
				}

				return $arrConfirmation;

			/*
			public 'a_confirmation' => string '["196574,E,131079,TF-3-1"]' (length=26)
			public 'a_carrier' => string '["BYPASS"]' (length=10)
			public 'a_lifter' => string '["BYPASS"]' (length=10)
			public 'a_date' => string '["2016-12-14"]' (length=14)
			public 'a_confirmed_at' => string '["9:37"]' (length=8)
			public 'a_operator' => string '["15"]' (length=6)
			public 'a_cp' => string '["CY3"]' (length=7)
			public 'bypass' => string '["true"]' (length=8)
			*/
		}
}
