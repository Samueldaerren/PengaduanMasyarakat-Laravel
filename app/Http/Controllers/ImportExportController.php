<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Exports\ExportUsers;
use Maatwebsite\Excel\Facades\Excel;
class ImportExportController extends Controller
{
     public function importExport()
    {
       return view('staff.import');
    }
    public function export() 
    {
        return Excel::download(new ExportUsers, 'users.xlsx');
    }
}