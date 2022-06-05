<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Log;

class UserRepository extends BaseRepository
{
    protected $model;

    /**
     * Repository constructor.
     *
     * @param  User $model;
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }    

    public function getDatatableList()
    {
        return Datatables::of(self::prepareForDatatable()->get()->makeHidden(['id']))
            ->addIndexColumn()
            ->setRowId(function ($data) {
                return $data->uuid;
            })
            ->addColumn('new_image', function($data) {

                if ($data->image){
                    return '<img src=" '.$data->image.' " alt="-" height="200px" style="max-width:200px" class="imgProfile">';
                }
                return "-";
            })
            ->setRowClass(function ($data) {
                return "clickRow";
            })
            ->rawColumns(['new_image'])    
            ->make(true);
    }

    private function prepareForDatatable()
    {
        return $this->model->query();
    }
}