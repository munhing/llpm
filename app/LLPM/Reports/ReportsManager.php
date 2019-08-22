<?php 

namespace LLPM\Reports;

use Illuminate\Support\Collection;
use Carbon\Carbon;

use LLPM\Repositories\ContainerConfirmationRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\CargoRepository;
use LLPM\Repositories\VesselScheduleRepository;
use LLPM\Repositories\CargoItemRepository;

class ReportsManager
{
    protected $containerConfirmationRepository;
    protected $containerRepository;
    protected $cargoRepository;
    protected $vesselScheduleRepository;
    protected $cargoItemRepository;
    protected $array_month;

	function __construct(
        ContainerConfirmationRepository $containerConfirmationRepository,
        ContainerRepository $containerRepository,
        CargoRepository $cargoRepository,
        VesselScheduleRepository $vesselScheduleRepository,
        CargoItemRepository $cargoItemRepository
    )
    {
        $this->containerConfirmationRepository = $containerConfirmationRepository;
        $this->containerRepository = $containerRepository;
        $this->cargoRepository = $cargoRepository;
        $this->vesselScheduleRepository = $vesselScheduleRepository;
        $this->cargoItemRepository = $cargoItemRepository;
    }

    /*
    |--------------------------------------------------------------------------
    | Repositories
    |--------------------------------------------------------------------------
     */
    
    public function getAllImportExport($year)
    {
        return $this->containerConfirmationRepository->getAllImportExport($year);
    }

    public function getTotalContainersTransferToCY3($year)
    {
        return $this->containerConfirmationRepository->getTotalContainersTransferToCY3($year);
    }

    public function getTotalContainersTransferToCY1($year)
    {
        return $this->containerConfirmationRepository->getTotalContainersTransferToCY1($year);
    }

    public function getTotalContainerActive()
    {
        return $this->containerRepository->getTotalActive();
    }

    public function getCargoImportLooseMtByYear($year)
    {
        return $this->cargoRepository->getTotalImportLooseMtByYear($year);
    }
    
    public function getCargoExportLooseMtByYear($year)
    {
        return $this->cargoRepository->getTotalExportLooseMtByYear($year);
    }

    public function getCargoImportContainerizedMtByYear($year)
    {
        return $this->cargoRepository->getTotalImportContainerizedMtByYear($year);
    }

    public function getCargoExportContainerizedMtByYear($year)
    {
        return $this->cargoRepository->getTotalExportContainerizedMtByYear($year);
    }

    public function getCargoImportByYear($year)
    {
        return $this->cargoRepository->getImportByYear($year);
    }

    public function getCargoExportByYear($year)
    {
        return $this->cargoRepository->getExportByYear($year);
    }

    public function getVesselCountByYear($year)
    {
        return $this->vesselScheduleRepository->getVesselCountByYear($year);
    }
    
    public function getCargoOriginByYear($year)
    {
        return $this->cargoRepository->getOriginByYear($year);
    }

    public function getCargoDestinationByYear($year)
    {
        return $this->cargoRepository->getDestinationByYear($year);
    }

    public function getTopVesselByYear($year, $limit = 20)
    {
        return $this->vesselScheduleRepository->getTopVesselByYear($year, $limit);
    }    

    public function getTopAgentByYear($year, $limit = 20)
    {
        return $this->vesselScheduleRepository->getTopAgentByYear($year, $limit);
    }

    public function getTopImportCargoItemByYear($year, $limit = 100)
    {
        return $this->cargoItemRepository->getTopImportCargoItemByYear($year, $limit);
    }

    public function getTopExportCargoItemByYear($year, $limit = 100)
    {
        return $this->cargoItemRepository->getTopExportCargoItemByYear($year, $limit);
    }

    public function getImportCargoListByConsigneeAndYear($consignee_id, $year)
    {
        return $this->cargoRepository->getImportCargoListByConsigneeAndYear($consignee_id, $year);
    }

    public function getExportCargoListByConsignorAndYear($consignor_id, $year)
    {
        return $this->cargoRepository->getExportCargoListByConsignorAndYear($consignor_id, $year);
    }

    public function getTopConsigneeByYear($year, $limit = 100)
    {
        return $this->cargoRepository->getTopConsigneeByYear($year, $limit);
    }    

    public function getTopConsignorByYear($year, $limit = 100)
    {
        return $this->cargoRepository->getTopConsignorByYear($year, $limit);
    }   
    /*
    |--------------------------------------------------------------------------
    | Helper Functions
    |--------------------------------------------------------------------------
     */    
    
    public function getYear($input)
    {
        if($input != '') {
            $year = $input;
        } else {
            $year = Carbon::now()->format('Y');
        }

        return $year;
    }

    public function getMonth($number)
    {
        $month = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec'
        ];

        return $month[$number];
    }

    public function getMonthList($teus)
    {
        $this->array_month = [];
  
        return $teus->map(function($row) {
            $month = $this->getMonth($row->c_month);
            if(!in_array($month, $this->array_month)) {
                array_push($this->array_month, $month);
                return $month;
            }
        })->filter(function($row){
            if($row) {
              return $row;  
            }
        })->flatten();
    }

    public function filterTeusBySize($teus, $size) 
    {
        return $teus->filter(function($row) use ($size) {
            if ($row->size == $size) {
                return true;    
            }
        });
    }

    public function getTeusCountBySize($teus, $size)
    {
        $col = new Collection;
        foreach($teus as $row) {
            if($row->size == $size) {
                if($col->has($row->c_month)) {
                    $col[$row->c_month] += $row->container_count;
                } else {
                    $col->put($row->c_month, $row->container_count);
                }
            }
        }

        return $col->flatten();
    }

    public function getTeusByType($teus, $type)
    {
        $col = new Collection;

        foreach($teus as $row) {
            if($row->movement == $type && $row->size == 20 ) {
                if($col->has($row->c_month)) {
                    $col[$row->c_month] += $row->container_count;
                } else {
                    $col->put($row->c_month, $row->container_count);
                }
            }
            if($row->movement == $type && $row->size == 40 ) {
                if($col->has($row->c_month)) {
                    $col[$row->c_month] += (2 * $row->container_count);
                } else {
                    $col->put($row->c_month, (2 * $row->container_count));
                }
            }            
        }

        return $col->flatten();
    }

    public function getTotalTeus($teus)
    {
        $collection = new Collection;

        foreach($teus as $data) {
            // dd($data->toArray());
            if($data->size == 20) {
                if(isset($collection[$data->c_month])) {
                    $collection[$data->c_month] += $data->container_count;
                } else {
                    $collection[$data->c_month] = $data->container_count;
                }
            }

            if($data->size == 40) {
                if(isset($collection[$data->c_month])) {
                    $collection[$data->c_month] += ($data->container_count * 2);
                } else {
                    $collection[$data->c_month] = ($data->container_count * 2);
                }
            }       
        }

        // remove associative array from collection
        $c = $collection->flatten();
        // $c = $collection->map(function($row) {
        //     return $row;    
        // });
        // dd($c->toJson());
        return $c;
    }

    public function getMonthly($collection, $month_column)
    {
        return $collection->map(function($row) use ($month_column){
            return $this->getMonth($row->{$month_column});      
        });
    }

    public function convertValuesToArray($collection, $col_name)
    {
        return $collection->map(function($row) use ($col_name) {
            return $row->{$col_name};
        });
    }

    public function convertDecimalValuesToArray($collection, $col_name)
    {
        return $collection->map(function($row) use ($col_name) {
            return number_format($row->{$col_name},2,'.','');
        });
    }      

    public function convertDecimalValuesToArray2($collection, $col_name)
    {
        return $collection->map(function($row) use ($col_name) {
            return number_format($row[$col_name],2,'.','');
        });
    }  

    public function addMissingMonthsToCollection($collection)
    {
        $newCollection = new Collection();

        for($x=1; $x<=12; $x++) {

            $flag = false;

            foreach($collection as $row) {
                if ($row->monthly == $x) {
                    $newCollection->push($row);
                    $flag = true;
                }
            }

            if($flag == false) {

                $newCollection->push(['total_mt' => 0, 'monthly' => $x]);
            }
        }

        return $newCollection;
    }       
}