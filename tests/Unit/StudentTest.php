<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Student;
use Illuminate\Support\Facades\Artisan;

class StudentTest extends TestCase {

  private $tbl;
  private $testDate;
  //Prepare the envionment for testing
  public function setUp() : void {
    parent::setUp();
    Artisan::call('migrate:refresh --env=testing');
    Artisan::call('db:seed --env=testing');
    $this->tbl = 'students';
    $this->testDate = \Carbon\Carbon::createFromDate(date('Y-m-d H:i:s'))->toDateTimeString();
    Student::truncate();
  }

  /** @test */
  public function createStudent() {

    $studentEntry = [
      'name' => 'CyrixTestSite',
      'surname' => 'TestDescription',
      'national_id' => '77041127361862',
      'dob' => '1977/04/11',
      'updated_at'=>null,
      'created_at'=>$this->testDate
    ];

    $sid = Student::insertGetId($studentEntry);
    $this->assertDatabaseHas($this->tbl, ['id' => $sid]);

    $student = Student::find($sid);
    $student->delete();
    $this->assertDatabaseMissing($this->tbl, ['id' => $sid]);
  }


}
