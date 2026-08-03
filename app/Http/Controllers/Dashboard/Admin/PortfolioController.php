<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Helpers\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Admin\AdminPortfolio;

class PortfolioController extends Controller
{

    // Get Table Name From Model
    public function table()
    {
        $model =  new AdminPortfolio;
        return $model->table;
    }


    public function getPortfolio($id = null)
    {

        $id = $id == null ? adminId() : $id;

        // Select
        $select = [];
        foreach (socialMedia() as $val) {
            array_push($select, $val['name_en']);
        }

        // Portfolio
        $portfolio = DB::table($this->table())->where('admin_id', $id)->first($select);

        return  json_decode(json_encode($portfolio), true);
    }

    protected function update(Request $request, AdminPortfolio $portfolio)
    {

        // Set Rules
        foreach (socialMedia() as $val) {
            $rules[$val['name_en']] = 'nullable|url|max:255';
        }

        // Validate
        $data = $request->validate($rules);

        // Store
        $update = $portfolio->where('admin_id', adminId())->update($data);

        if ($update > 0) {
            return Response::success('Successfull Update', ['style' => 'toastr']);
        }
    }
}
