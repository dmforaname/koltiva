<?php

namespace App\Repositories\Web;

use App\Repositories\BaseRepository;
use App\Models\User;
use App\Traits\ImageTrait;

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
}
