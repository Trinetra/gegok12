<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use App\Models\StudentParentLink;
use App\Models\StudentAcademic;
use App\Models\ParentProfile;
use App\Models\StandardLink;
use App\Helpers\SiteHelper;
use App\Models\Userprofile;
use App\Models\LibraryCard;
use App\Models\School;
use App\Models\User;
use Carbon\Carbon;

class UsersStudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schools = School::where('status',1)->get();
        foreach ($schools as $school) 
        {

            $academic_year = SiteHelper::getAcademicyear($school->id);
            $classRooms= StandardLink::where([['school_id',$school->id],['academic_year_id',$academic_year->id]])->get();
            foreach ($classRooms as $classRoom) 
            {
                $studentCountPerSection = rand(10,12);

                $students = User::factory($studentCountPerSection)->create([
                    'school_id'    =>   $classRoom->school_id,
                    'usergroup_id' =>   6
                ]);

                foreach ($students as $student) 
                {
                    Userprofile::factory(1)->create([
                        'school_id'     =>  $student->school_id,
                        'user_id'       =>  $student->id,
                        'usergroup_id'  =>  $student->usergroup_id
                    ]);

                    $father = User::factory()->create([
                        'school_id'     => $student->school_id,
                        'usergroup_id'  => 7
                    ]);

                    Userprofile::factory()->create([
                        'school_id'     =>  $student->school_id,
                        'user_id'       =>  $father->id,
                        'usergroup_id'  =>  $father->usergroup_id,
                        'address'       =>  'Madurai,Tamilnadu,India',
                        'pincode'       =>  '625001',
                        'gender'        =>  'male',
                        'date_of_birth' =>  Carbon::now()->subYears(rand(25, 45))
                    ]);

                    StudentParentLink::factory()->create([
                        'school_id'  => $student->school_id,
                        'parent_id'  => $father->id,
                        'student_id' => $student->id
                    ]);

                    ParentProfile::factory()->create([
                        'school_id'  => $father->school_id,
                        'user_id'    => $father->id
                    ]);

                    $mother = User::factory()->create([
                        'school_id'     => $student->school_id,
                        'usergroup_id'  => 7
                    ]);

                    Userprofile::factory()->create([
                        'school_id'     =>  $student->school_id,
                        'user_id'       =>  $mother->id,
                        'usergroup_id'  =>  $mother->usergroup_id,
                        'address'       =>  'Madurai,Tamilnadu,India',
                        'pincode'       =>  '625001',
                        'gender'        =>  'female',
                        'date_of_birth' =>  Carbon::now()->subYears(rand(25, 40)),
                    ]);

                    StudentParentLink::factory()->create([
                        'school_id'  => $student->school_id,
                        'parent_id'  => $mother->id,
                        'student_id' => $student->id
                    ]);

                    ParentProfile::factory()->create([
                        'school_id'  => $mother->school_id,
                        'user_id'    => $mother->id
                    ]);

                    LibraryCard::factory()->create([
                        'school_id'  => $student->school_id,
                        'user_id'  => $student->id,
                    ]);

                    StudentAcademic::factory(1)->create([
                        'school_id'         =>  $student->school_id,
                        'user_id'           =>  $student->id,
                        'standardLink_id'   =>  $classRoom->id,
                        'academic_year_id'  =>  $classRoom->academic_year_id
                    ]);
                }
            }
        }
    }
}