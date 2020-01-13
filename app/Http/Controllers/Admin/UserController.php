<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ACL\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth:admin');

        $this->userRepository = $userRepository;
    }

    /**
     * show profile current user
     *
     * @param  Request $request
     * @return view
     */
    public function showProfile(Request $request)
    {
        $user = Auth::user();

        return view('admin.user.profile', compact('user'));
    }

    /**
     * handle update profile current user
     *
     * @param  Request $request
     * @return view
     */
    public function updateProfile(Request $request)
    {
        $user = $this->userRepository->updateProfile($request);

        $redirect = redirect()->route('admin.user.profile.view');

        return $user
            ? $redirect->withSuccess('Update profile success')
            : $redirect->withError('Update profile fail');
    }
}
