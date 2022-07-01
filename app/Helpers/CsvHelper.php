<?php 

namespace App\Helpers;

class CsvHelper {
	public function header($headerArr){
		if (!is_array($headerArr))
			throw new \ErrorException('Headers of CSV File must be passed as standard array format');
		
		$arr = [];
		foreach($headerArr as $h){
			array_push($arr, $h);			
		}	
		return $arr;	
	}
	
	public function row($id, $name, $surname){

        //Massage the data a little
        $age = rand(5,95);
        $dob = date('Y/m/d',strtotime("-".rand(5,2022)." years",strtotime(date('Y/m/d'))));

        //Prepare out inner array
        $row = [];
        //Push into "CSV Builder" array
        array_push($row,$id);
        array_push($row,$name);
        array_push($row,$surname);
        array_push($row,substr($name,0,1).substr($surname,0,1));
        array_push($row,$age);
        array_push($row,date('d/m/Y',strtotime($dob)));
        
        return $row;

    }
    
    public function csvToArray($filename = '', $delimiter = ',') {
		if (!file_exists($filename) || !is_readable($filename))
			return false;

		$header = null;
		$data = array();
		if (($handle = fopen($filename, 'r')) !== false) {
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
				if (!$header)
					$header = $row;
				else
					$data[] = array_combine($header, $row);
			}
			fclose($handle);
		}

		return $data;
	}


}