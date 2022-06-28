<?php
namespace App\Http\Controllers;

ini_set('max_execution_time', 0);

use Illuminate\Http\Request;
use App\Models\CsvImport;
use Redirect;
use Illuminate\Routing\Controller as BaseController;

class CsvController extends BaseController
{

    public $namesArr = [];
    public $surnamesArr = [];

    public function index(){
        return view('csv');
    }

     public function csvEntries(){
        $csvEntries = CSVImport::get()->take(100);
        return view('csv-entries', compact('csvEntries'));
    }

    public function buildCSV(Request $request){

        //Initialize a counter and variables for use in ouputting file
        $csvOutputArr = [];
        $n = $request->get('nrRows');
        if ($n == ''){
            $n = 100000;
        }
        //Initialize utilized arrays
        $this->initNamesArr();
        $this->initSurnamesArr();

        //Lets start with the headers
        $arr = [];
        array_push($arr,"id");
        array_push($arr,"name");
        array_push($arr,"surname");
        array_push($arr,"initials");
        array_push($arr,"age");
        array_push($arr,"date_of_birth");
        array_push($csvOutputArr,$arr);

        for($i=0; $i<$n; $i++){
            //Massage the data a little
            $nameIdx = rand(0,19);
            $surnameIdx = rand(0,19);
            $age = rand(18,75);
            $dob = date('Y/m/d',strtotime("-$age years",strtotime(date('Y/m/d'))));


            //Prepare out inner array
            $arr = [];
            //Push into "CSV Builder" array
            array_push($arr,$i);
            array_push($arr,$this->namesArr[$nameIdx]);
            array_push($arr,$this->surnamesArr[$surnameIdx]);
            array_push($arr,substr($this->namesArr[$nameIdx],0,1).substr($this->surnamesArr[$surnameIdx],0,1));

            array_push($arr,$age);
            array_push($arr,date('d/m/Y',strtotime($dob)));
            array_push($csvOutputArr,$arr);
        }

        $filename = 'output/output.csv';

        // open csv file for writing
        $f = fopen($filename, 'w+');

        if ($f === false) {
        	die('Error opening the file ' . $filename);
        }

        // write each row at a time to a file
        foreach ($csvOutputArr as $row) {
        	fputcsv($f, $row);
        }

        // close the file
        fclose($f);
        return Redirect::back();
    }

    public function processCSV(Request $request){

        if (!empty($request->files)) {
            $file = $request->file('csvFile');
            $type = $file->getClientOriginalExtension();
            $real_path = $file->getRealPath();
            $name = $file->getClientOriginalName();

            if ($type <> 'csv') {
                return Redirect::back()->withInput()->withErrors(['msg' => 'File type must be CSV']);
            }
            $data = $this->csvToArray(public_path().'/output/'.$name);
            foreach($data as $d){
             unset($d["id"]);
             CsvImport::insert($d);
            }
            return redirect('/csv-entries');
        } else {
            return Redirect::back()->withInput()->withErrors(['msg' => 'Must upload CSV File']);
        }
    }

    private function initNamesArr(){
            $this->namesArr = [
                0=>'John',
                1=>'Mary',
                2=>'Henro',
                3=>'Mannie',
                4=>'Stefan',
                5=>'Michelle',
                6=>'Jane',
                7=>'Lucy',
                8=>'Daisy',
                9=>'Cindy',
                10=>'Mellisa',
                11=>'Michael',
                12=>'Tristan',
                13=>'Kyle',
                14=>'James',
                15=>'Ken',
                16=>'Jonothan',
                17=>'Melinda',
                18=>'Annatjie',
                19=>'Joan'
            ];
    }

    private function initSurnamesArr(){
        $this->surnamesArr = [
                0=>'Mason',
                1=>'Holdsworth',
                2=>'Strider',
                3=>'Walker',
                4=>'Watson',
                5=>'Griffon',
                6=>'Simpson',
                7=>'Englebrecht',
                8=>'Montre',
                9=>'Callisi',
                10=>'Mather',
                11=>'Farraday',
                12=>'Tesla',
                13=>'Johnston',
                14=>'Webb',
                15=>'Copperfield',
                16=>'Malthorpe',
                17=>'Smith',
                18=>'Tuffin',
                19=>'Vanidestine'
        ];
    }

    public function removeCSV(){
        if(\file_exists('output/output.csv')){
            unlink('output/output.csv');
        }
        return Redirect::back();
    }

    function csvToArray($filename = '', $delimiter = ',') {
    if (!file_exists($filename) || !is_readable($filename))
        return false;

    $header = null;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== false)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
        {
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
