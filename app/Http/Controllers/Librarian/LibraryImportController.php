<?php
/**
 * SPDX-License-Identifier: MIT
 * (c) 2025 GegoSoft Technologies and GegoK12 Contributors
 */
namespace App\Http\Controllers\Librarian;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\LibraryCardImport;
use App\Models\LibraryCard;
use App\Traits\LogActivity;
use League\Csv\Writer;
use App\Traits\Common;

class LibraryImportController extends Controller

{
    use LogActivity;
    use Common;

   public function index()
    {
        // dd("fgdfgf");
  
    $libiarycards = LibraryCard::paginate(10); 

    return view('library/import/listcarddeatils', ['libiarycards' => $libiarycards]);
    }



      public function create()
    {
       
      
      return view('library/import/studentscard');
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx,csv,txt',
           
                    

        ]);
    //    dd($request->file('import_file')) ;
    //    $request->file('import_file');
$test1=$request->file('import_file');
        Excel::import(new LibraryCardImport, $test1);

         return back()->with('success', 'Library card data imported successfully.');
        
    }

public function downloadFormat()
{
    
        // $filePath = public_path('uploads\sample\school.csv'); 
        // $filePath = $this->getFilePath('uploads\sample\school.csv');

        // if ($filePath) {

        //     return response()->download($filePath, 'school.csv', [
        //         'Content-Type' => 'text/csv',
        //     ]);
        // } else {
        //     return redirect()->back()->with('error', 'Sample file not found.');
        // }
       $csv = Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(['card_number','book_limit','expiry_date','registration_number']);
        $csv->insertOne([
            '23321211',
            '10',
            '31-05-2025',
            '5252525',
        ]);

        $csv->output('School Plus Add Librarycard Format'.date('_d-m-Y_H:i').'.csv');
       
        $message=('Downloaded Sample Format File Successfully');

        $ip= $this->getRequestIP();
        $this->doActivityLog(
            Auth::user(),
            Auth::user(),
            ['ip' => $ip, 'details' => $_SERVER['HTTP_USER_AGENT'] ],
            LOGNAME_DOWNLOAD_SAMPLE_FORMAT_LIBRARYCARD,
            $message
        );
    }
    


  }
