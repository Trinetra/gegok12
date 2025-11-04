<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\WithHeadingRow;  
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Models\LibraryCard;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\TeacherProfile;



 
class LibraryCardImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
  {
    $school_id = Auth::user()->school_id;
    $user = null;

    
    if (!empty($row['registration_number'])) {
        $user = User::where('registration_number', $row['registration_number'])
                    ->where('usergroup_id', 6)
                    ->first();
    }

   
    if (!$user && !empty($row['employee_id'])) {
        $user = User::whereIn('usergroup_id', [5, 8, 10, 11, 13])
                    ->whereHas('teacherprofile', function ($q) use ($row) {
                        $q->where('employee_id', $row['employee_id']);
                    })
                    ->first();
    }

    
    if (!$user) {
        return null;
    }

    if (LibraryCard::where('user_id', $user->id)->exists()) {
        return null;
    }

    return new LibraryCard([
        'school_id'       => $school_id,
        'user_id'         => $user->id,
        'library_card_no' => $row['card_number'],
        'book_limit'      => $row['book_limit'],
        'expiry_date'     => date('Y-m-d H:i:s', strtotime($row['expiry_date'])),
        'status'          => '1',
    ]);
 }


}


         



         


