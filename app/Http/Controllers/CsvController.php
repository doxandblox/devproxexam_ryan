<?php
namespace App\Http\Controllers;

ini_set('max_execution_time', 0);

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\CsvImport;
use App\Helpers\CsvHelper;
use Redirect;
  
class CsvController extends BaseController
{

	public function index() {
		return view('csv');
	}
	public function csvEntries() {
		$csvEntries = CSVImport::get()->take(100);
		foreach ($csvEntries as $e) {
			$e->date_of_birth = (date('d/m/Y', strtotime(str_replace('/', '-', $e->date_of_birth))));
		}
		return view('csv-entries', compact('csvEntries'));
	}
	public function buildCSV(Request $request) {

		//Initialize a counter and variables for use in ouputting file
		$randomIndexEndRange = 20;
		$csvOutputArr = [];
		$checkSumArr = [];
		$n = (!empty($request->get('nrRows'))) ? $request->get('nrRows') : 1000000;

		//Initialize utilized arrays
		$namesArr = \App\Models\CsvImport::factory()->names($randomIndexEndRange);
		$surnamesArr = \App\Models\CsvImport::factory()->surnames($randomIndexEndRange);
		//Instantiate Helper
		$cs = new CsvHelper();
		//Lets start with the headers
		array_push($csvOutputArr, ["id", "name", "surname", "initials", "age", "date_of_birth"]);
		$checkSumArr[md5("id,name,surname,initials,age,date_of_birth")] = md5("id,name,surname,initials,age,date_of_birth");

		//Lets begin building the rows
		for ($i = 0; $i < $n; $i++) {
			$arr = $cs->row($i, $namesArr[rand(0, $randomIndexEndRange)], $surnamesArr[rand(0, $randomIndexEndRange)]);
			//We want unique values, but to check back against the file as its being built up
			//will be expensive and timeous, we can build a checksum
			$checkSumArrKey = md5($arr[1].$arr[2].$arr[3].$arr[4].$arr[5]);
			//Check if the given checksum exists
			if (!isset($checkSumArr[$checkSumArrKey])) {
				//The key has identified the row as a unique entry, commit and iterate
				array_push($csvOutputArr, $arr);
				$checkSumArr[$checkSumArrKey] = $checkSumArrKey;
			} else {
				//Force a new iteration thereby generating a new entry, which will recieve the same treatment
				$i--;
			}
		}

		//Finally lets write the file
		$filename = 'output/output.csv';
		$f = fopen($filename, 'w+');
		// write each row at a time to a file
		foreach ($csvOutputArr as $row) {
			fputcsv($f, $row);
		}
		// close the file
		fclose($f);
		return Redirect::back();
	}
	public function processCSV(Request $request) {

		$cs = new CsvHelper();
		if (!empty($request->files)) {
			$file = $request->file('csvFile');
			if ($file == null) {
				return Redirect::back()->withInput()->withErrors(['msg' => 'Must upload CSV File']);
			}
			$type = $file->getClientOriginalExtension();
			$real_path = $file->getRealPath();
			$name = $file->getClientOriginalName();

			if ($type <> 'csv') {
				return Redirect::back()->withInput()->withErrors(['msg' => 'File type must be CSV']);
			}
			$data = $cs->csvToArray(public_path().'/output/'.$name);
			if (!is_array($data)) {
				return Redirect::back()->withInput()->withErrors(['msg' => 'The conversion process has failed']);
			}

			//Lets check if theres anything to validate against,
			//depending on size of table, count(*) might be excessive to accomplish this

			if (CsvImport::take(1)->get()->first() != null) {
				foreach ($data as $d) {
					$csvImportDataDB = CsvImport::where("name", $d["name"])->
												  where("surname", $d["surname"])->
												  where("age",$d["age"])->
												  where("date_of_birth",date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $d["date_of_birth"]))))
					->first();
					
					$msg = "Duplicate entry found " . $d["name"] ." ". $d["surname"] . ' ~ Age : ' . $d["age"] . " ~ DOB : " . $d["date_of_birth"];
					return Redirect::back()->withInput()->withErrors(['msg' => $msg]);
				}
			}
		

		#Fluent
		\DB::transaction(function() use ($request, $data) {
			//We will house the csv data iteration within the transaction
			$bz = 10000;
			$iterator = \count($data) / $bz;
			$dc = \count($data);
			//Will will use this index, to manage our batches.
			$spliceIdx = 0;

			if ($iterator < 1) {
				//We have less than 100, as such we can process the entire batch
				$iterator = 1;
				$spliceIdx = \count($data);
			}

			for ($x = 0; $x < $iterator; $x++) {
				$arr = array_splice($data, 0, $bz, []);
				//Process it for insert
				for ($j = 0; $j < count($arr); $j++) {
					unset($arr[$j]["id"]);
					$arr[$j]["date_of_birth"] = \Carbon\Carbon::createFromDate(date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $arr[$j]["date_of_birth"]))))->toDateTimeString();
				}
				//Carry out the final movement
				#Eloquent
				CSVImport::insert($arr);
			}

		});
		return redirect('/csv-entries');
	} else {
		return Redirect::back()->withInput()->withErrors(['msg' => 'Must upload CSV File']);
	}
}
public function removeCSV() {
	if (\file_exists('output/output.csv')) {
		unlink('output/output.csv');
	}
	return Redirect::back();
}


}
