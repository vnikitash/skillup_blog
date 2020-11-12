<?php


namespace App\Http\Controllers;

use App\Http\Requests\Blog\CreateBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {

        $users = User::with(['blogs'])->get();

        return response()->json(['users' => $users]);
    }

    public function export()
    {
        try {
            $users = User::query()->get();

            // Create new PHPExcel object
            $objPHPExcel = new \PHPExcel();

// Set document properties
            $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


// Add some data
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'ID')
                ->setCellValue('B1', 'Email')
                ->setCellValue('C1', 'CreatedAt');

            /**
             * @var int $index
             * @var User $user
             */

            foreach ($users as $index => $user) {

                //dd('A' . ($index + 2), 'B' . ($index + 2), 'C' . ($index + 2), $user->id, $user->email, $user->created_at->format("d-m-Y"));

                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . ($index + 2), (string) $user->id)
                    ->setCellValue('B' . ($index + 2), $user->email)
                    ->setCellValue('C' . ($index + 2), $user->created_at->format("d-m-Y"));
            }


// Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="01simple.xlsx"');
            header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');

        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getLine(), $e->getFile());
        }
    }

    public function show($userId): JsonResponse
    {
        /** @var User $user */
        $user = User::with(['activeBlogs'])->where('id', $userId)->firstOrFail();

        return response()->json(['user' => $user]);
    }
}