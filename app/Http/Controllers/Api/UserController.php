<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserUpdateRequest;
use App\Http\Requests\Web\RegistrationStoreRequest;
use App\Repositories\Api\UserRepository;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Auth;

class UserController extends Controller
{
    use ApiResponser;

    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            return $this->user->getDatatableList();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegistrationStoreRequest $request)
    {
        $params = $this->user->getNewParam($request);
        $data = $this->user->create($params);

        return $this->success($data,'Successfully Store Data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->user->getByUuid($id);

        return $this->success($data,'Get User Data Success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $data = $this->user->getByUuid($id);
        $params = $this->user->getNewParam($request,$data->image);
        $data->update($params);

        return $this->success($data,'Successfully Update Data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->user->getByUuid($id);

        if (Auth::id() == $data->id) return $this->error('Cant delete login user');

        $this->user->deleteImage($data->image);
        $data->delete();
        

        return $this->success($data,'Successfully Delete Data');
    }
}
