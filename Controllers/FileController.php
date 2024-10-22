<?php 

require_once './autoload/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
class FileController extends Controller {

    // Allowed mime types 
    protected $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    public function __construct() {

    }

    public function import() {

        if (isset($_FILES['file'])) {
            if ($_FILES['file']['error'] > 0)
                echo "Upload lỗi rồi!";
            else {

                $uploaddir = 'upload/';
                // if (!is_dir($uploaddir) && !mkdir($uploaddir)){
                // die("Error creating folder $uploaddir");
                // }

                // move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . $_FILES['file']['name']);
                $rs = $this->readFile($uploaddir . $_FILES['file']['name']);
                // echo json_encode($rs);
                // var_dump($rs);
                echo $this->returnSuccess($rs);
            }
        }
    }

    public function readFile($file) {
        $reader = new Reader(); 
        $spreadsheet = $reader->load($file); 
        $worksheet = $spreadsheet->getActiveSheet();  
        $worksheet_arr = $worksheet->toArray();

        $result = [];
        
        foreach ($worksheet_arr as $row) {
            $cell = [];
            foreach ($row as $cellValue) {
                // Do something with the cell data here.
                if (!$cellValue) continue;
                $cell[] = $cellValue;
            }
            $result[] = $cell;
        }

        return $result;
    }
}