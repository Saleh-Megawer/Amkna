<?php
namespace App\Http\Controllers\Dashboard\Pages;

use App\Helpers\FileUploader;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Pages;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    /**
     * Upload Config
     */
    const PATH      = 'pages/home';
    const LARGE     = '1920*1080*70';
    const EXTENSION = 'webp';
    const HASH_NAME = false;

    /**
     * Home page row
     */
    protected $homeRow;

    public function __construct()
    {
        /**
         * Ensure home page record always exists
         */
        $this->homeRow = Pages::firstOrCreate(
            ['page' => 'home'],
            [
                'slider'            => json_encode([]),
                'header_title_desc' => json_encode([]),
            ]
        );
    }

    /**
     * Display Home Page Settings
     */
    public function index()
    {
        $headerSlider          = json_decode($this->homeRow->slider, true) ?? [];
        $headerSliderTitleDesc = json_decode($this->homeRow->header_title_desc, true) ?? [];

    //    dd($headerSliderTitleDesc);
        return view(
            'dashboard.pages.home',
            compact('headerSlider', 'headerSliderTitleDesc')
        );
    }

    /**
     * Upload Slider Attachments
     */
    public function headerSliderAttech(Request $request)
    {
        $uploadOptions = [
            'path'      => self::PATH,
            'max_width' => 1400,
            'quality'   => 80,
            'extension' => self::EXTENSION,
        ];

        $imageData = FileUploader::multiUpload('header_attech', $uploadOptions);

        $data = json_decode($this->homeRow->slider, true) ?? [];

        /**
         * Get Last Rank Safely
         */
        $lastRank  = collect($data)->max('rank');
        $loopIndex = is_null($lastRank) ? 0 : $lastRank + 1;

        foreach ($imageData as $file) {

            $id = random_int(100000, 999999999);

            $data[$id] = [
                'rank'      => $loopIndex++,
                'file_name' => $file['file_name'],
                'type'      => $file['real_mime_type'],
                'id'        => $id,
            ];
        }

        $this->homeRow->update([
            'slider' => $data,
        ]);

        return Response::success(
            'تم رفع مرفقات جديدة داخل القسم الرئيسي',
            ['reset' => true, 'style' => 'toastr']
        );
    }

    /**
     * Delete Single Slider Item
     */
    public function headerSliderDeleteSingle(Request $request)
    {
        $index = $request->slider_index;

        $sliderData = json_decode($this->homeRow->slider, true) ?? [];

        if (! isset($sliderData[$index])) {
            return back();
        }

        // Delete file physically
        FileUploader::delete(self::PATH, $sliderData[$index]['file_name']);

        unset($sliderData[$index]);

        $this->homeRow->update(['slider' => $sliderData]);

        Response::success(
            'تم حذف مرفق من داخل القسم الرئيسي',
            ['style' => 'toastr', 'json' => false]
        );

        return back();
    }

    /**
     * Move Slider Item Up
     */
    public function headerSliderRankUp(Request $request)
    {
        $old_rank = (int) $request->old_rank;

        $data = json_decode($this->homeRow->slider, true) ?? [];

        // Key by rank (as array not Collection)
        $getDataByKeyRank = collect($data)->keyBy('rank')->toArray();

        if (! isset($getDataByKeyRank[$old_rank - 1])) {
            return back();
        }

        // Swap ranks safely
        $getDataByKeyRank[$old_rank - 1]['rank'] = $old_rank;
        $getDataByKeyRank[$old_rank]['rank']     = $old_rank - 1;

        // Sort by rank
        usort($getDataByKeyRank, fn($a, $b) => $a['rank'] <=> $b['rank']);

        // Re-key by id (original structure)
        $sorted = array_column($getDataByKeyRank, null, 'id');

        $this->homeRow->update(['slider' => $sorted]);

        Response::success(
            'تم إعادة ترتيب المرفق',
            ['style' => 'toastr', 'json' => false]
        );

        return back();
    }

    /**
     * Store Header Titles & Descriptions
     */
    public function headerStoreTitleDesc(Request $request)
    {
        $data = [];

        $titles = $request->header_title ?? [];
        $descs  = $request->header_desc ?? [];
        $lang   = $request->lang ?? [];

        foreach ($titles as $i => $title) {

            $id = random_int(100000, 999999999);

            $data[$id] = [
                'lang'  => $lang[$i],
                'title' => $title,
                'desc'  => $descs[$i] ?? null,
                'id'    => $id,
            ];
        }

        $this->homeRow->update([
            'header_title_desc' => $data,
        ]);

        Response::success(
            'تم تحديث الوصف التعريفي في القسم الرئيسي',
            ['style' => 'toastr', 'json' => false]
        );

        return back();
    }
}
