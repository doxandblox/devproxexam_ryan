<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Redirect;
use App\Models\Student;
class StudentController extends BaseController
{
    //Initialize data and load the View
    public function index(){
        $students = Student::all();
        return view('students', compact('students'));
    }

    public function add(){
        return view('students-add');
    }

    public function edit(){
        $data['student'] = Student::findOrFail($id);
        return view('students-add');
    }
    //Store the data
    public function store(Request $request){

        $validated = $request->validate([
          'name' => 'required|max:255|regex:/^[a-zA-ZÑñ\s]+$/',
          'surname' => 'required',
          'national_id' => 'required|min:13|max:13|unique:students|regex:/^[0-9]/',
          'dob' => 'required',
        ]);

        //Just for fun, Ensure a unique name and surname for this test
        /*
        $cnt = Student::where(['name' => $request->name, 'surname' => $request->surname])->count();
        if ($cnt > 0){
            return Redirect::back()->withErrors(['msg' => 'Student Entry Exists']);
        }
        */
	
        $idExcerpt = (substr($request->national_id,0,6));
        $request->dob = \Carbon\Carbon::createFromDate(date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->dob))))->toDateTimeString();
        $dtExcerpt = (substr(str_replace('-','',$request->dob),2,6));
        
        if ($idExcerpt != $dtExcerpt){
            return Redirect::back()->withInput()->withErrors(['msg' => 'ID must match given date']);
        }

        $student = new student;
        $student->name = $request->name;
        $student->surname = $request->surname;
        $student->national_id = $request->national_id;
        //Convert the given date to ensure the required format for persistence
        $student->dob = Carbon::parse(date($request->dob));

        $student->save();
        return redirect('students')->with('status', 'Student Form Data Has Been saved to the Databse!');
    }
}
