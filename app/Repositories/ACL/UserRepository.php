<?php

namespace App\Repositories\ACL;

use App\Models\User;
use App\Repositories\AbstractRepository;
use \Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;

class UserRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * update user profile
     *
     * @param  Request $request
     * @return string
     */
    public function updateProfile($request)
    {
        $params = $request->all();

        if (isset($params['image'])) {
            $params['image'] = $this->storeImage($request);
        }

        return $this->update($params, Auth::id());
    }

    /**
     * save upload image user to local storage
     *
     * @param  Request $request
     * @return string
     */
    private function storeImage($request)
    {
        return $request->file('image')->store('public/avatars');
    }
}
