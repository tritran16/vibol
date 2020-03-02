<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Requests\ACL\UpdateUserRequest;
use App\Http\Requests\ACL\UserRequest;
use App\Repositories\ACL\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ACL\RoleRepository;
use App\Http\Requests\ACL\PermissionRequest;
use App\Repositories\ACL\PermissionRepository;

class UserController extends Controller
{
    /**
     * @var PermissionRepository
     */
    protected $repository;

    protected $roleRepository;

    /**
     * PermissionController constructor.
     * @param PermissionRepository $repository
     * @param RoleRepository $roleRepository
     */
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->repository = $userRepository;
        $this->roleRepository = $roleRepository;
//        $this->middleware('permission:view user', ['only' => ['index']]);
//        $this->middleware('permission:create user', ['only' => ['create', 'store']]);
//        $this->middleware('permission:edit user', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:delete user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->repository->getList($request);

        return view('acl.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roleRepository->get();

        return view('acl.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(UserRequest $request)
    {
        $data = $request->only(['name', 'email', 'password']);
        $user = $this->repository->create($data);

        //$user->assignRole($request->input('roles'));
        $user->assignRole([1]);
        return redirect()->route('users.index')->with('success',__('Create success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->repository->find($id);

        //$roles = $this->roleRepository->get();
        //$userRoles = $user->roles->pluck('id', 'id')->all();

        return view('acl.users.edit', compact('user', 'roles', 'userRoles'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $input = $request->only('name', 'email', 'password');
        $user = $this->repository->update($input, $id);
//        $roleRequests = $request->get('roles');
//        $userRoles = $user->roles()->get();
//
//        foreach ($userRoles as $userRole) {
//            if (is_array($roleRequests) && in_array($userRole->id, $roleRequests)) {
//                if (!$user->hasRole($userRole))
//                    $user->assignRole($userRole);
//            } else {
//                $user->removeRole($userRole);
//            }
//        }

//        $roleRequestOther = array_diff($roleRequests, $userRoles->pluck('id')->toArray());

//        foreach ($roleRequestOther as $roleId) {
//            $user->assignRole($roleId);
//        }

        return redirect()->route('users.edit', $id)->with('success', __('Update success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);

        return redirect()->route('users.index')->with('success',__('Delete success'));
    }
}
