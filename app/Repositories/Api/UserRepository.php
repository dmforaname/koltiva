<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;
use App\Models\User;
use DataTables;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Log;

class UserRepository extends BaseRepository
{
    use ImageTrait;

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
        return Datatables::of(self::prepareForDatatable()->latest()->get()->makeHidden(['id']))
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
            ->addColumn('updatedAt', function($data) {

                return $data->updated_at;
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

    public function getNewParam($request,$image = null)
    {
        $params = $request->validated();

        if ($request->hasFile('image')) {

            if ($image) {

                $this->removeImage($image);
            }

            $params['image'] = $this->storeImageToStorage($request,'image');
        }

        return $params;
    }

    public function deleteImage($image): void
    {
        if ($image) {

            $this->removeImage($image);
        }
    }
}
