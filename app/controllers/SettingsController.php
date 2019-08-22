<?php

use LLPM\Forms\HandlingFeeForm;
use LLPM\Forms\StorageFeeForm;
use LLPM\Repositories\FeeRepository;
use LLPM\Settings\RegisterFeeCommand;
use LLPM\Settings\UpdateFeeCommand;
use LLPM\Settings\RegisterHandlingFeeCommand;
use LLPM\Settings\UpdateHandlingFeeCommand;
use LLPM\Settings\RegisterStorageFeeCommand;
use LLPM\Settings\UpdateStorageFeeCommand;

class SettingsController extends \BaseController {

	protected $feeRepository;
	protected $handlingFeeForm;
	protected $storageFeeForm;

	function __construct(
		FeeRepository $feeRepository,
		HandlingFeeForm $handlingFeeForm,
		StorageFeeForm $storageFeeForm
	)
	{
		parent::__construct();
		$this->feeRepository = $feeRepository;
		$this->handlingFeeForm = $handlingFeeForm;
		$this->storageFeeForm = $storageFeeForm;
	}
	/**
	 * Display a listing of the resource.
	 * GET /settings
	 *
	 * @return Response
	 */
	public function feesIndex()
	{
		// dd('Fees Index');
		$haulageFees = $this->feeRepository->getHaulageFees();
		$liftingFees = $this->feeRepository->getLiftingFees();
		$activityFees = $this->feeRepository->getActivityFees();
		$transferFees = $this->feeRepository->getTransferFees();
		$storageFees = $this->feeRepository->getStorageFees();


		// dd($handlingFees->first()->effective_date);
		// var_dump($handlingFee);
		// var_dump($storageFee);

		return View::make('settings/fees_index', compact('haulageFees', 'liftingFees', 'activityFees', 'transferFees', 'storageFees'))->withAccess($this->access);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /settings/create
	 *
	 * @return Response
	 */
	public function feesStore()
	{
		$input = Input::all();
		// dd($input);

		// for update
		// UpdateFeeCommand
		if($input['form_action'] == 'update') {
			// dd('update');
			$this->execute(UpdateFeeCommand::class);
			Flash::success("Fee updated!");			
		} else {
			// dd('new');
			$this->execute(RegisterFeeCommand::class);
			Flash::success("New Fee was registered!");			
		}

		return Redirect::back();	
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /settings
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /settings/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /settings/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /settings/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /settings/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}