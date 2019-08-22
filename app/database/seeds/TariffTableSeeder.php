<?php

class TariffTableSeeder extends Seeder
{

	public function run()
	{
        Excel::load('custome_tariff_01.xls', function($reader) {

            $results = $reader->all();

            $results->each(function($sheet) {
                // var_dump($sheet->header);
                // $header = (string)$sheet->header;
                // $header = $this->getCode($sheet);
                CustomTariff::create(array(
                    'code' => $this->getCode($sheet),
                    'description' => $sheet->description,
                    'uoq' => $sheet->unit
                ));                
                // echo ($header . "\n");
            });

        });  	
	}

    public function getCode($sheet)
    {
        // header
        $prefix = '';
        $header = (string)$sheet->header;
        $len = strlen($header);
        // echo ($len . "\n");
        
        if($len < 4) {
            $zero = '0';
            for($i=0;$i<(4-$len);$i++) {
                $prefix .= $zero;
            }
        }

        $code = $prefix . $header;

        // sub
        $prefix = '';
        $sub = (string)$sheet->sub;
        $len = strlen($sub);
        // echo ($len . "\n");
        
        if($len < 2) {
            $zero = '0';
            for($i=0;$i<(2-$len);$i++) {
                $prefix .= $zero;
            }
        }

        $code .= $prefix . $sub;

        // item
        $prefix = '';
        $item = (string)$sheet->item;
        $len = strlen($item);
        // echo ($len . "\n");
        
        if($len < 3) {
            $zero = '0';
            for($i=0;$i<(3-$len);$i++) {
                $prefix .= $zero;
            }
        }

        $code .= $prefix . $item;

        return $code;
    }
}