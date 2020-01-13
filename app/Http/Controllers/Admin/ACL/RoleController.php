<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ACL\RoleRequest;
use App\Repositories\ACL\RoleRepository;
use App\Http\Requests\ACL\UpdateRoleRequest;
use App\Repositories\ACL\PermissionRepository;

/**
 * Class RoleController
 * @package App\Http\Controllers\ACL
 */
class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $repository;
    /**
     * @var PermissionRepository
     */
    protected $permissionRepository;

    /**
     * RoleController constructor.
     * @param RoleRepository $repository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(RoleRepository $repository, PermissionRepository $permissionRepository)
    {
        $this->repository = $repository;
        $this->permissionRepository = $permissionRepository;
//        $this->middleware('permission:view role', ['only' => ['index', 'show']]);
//        $this->middleware('permission:create role', ['only' => ['create', 'store']]);
//        $this->middleware('permission:edit role', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:delete role', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = $this->repository->getList($request);

        return view('acl.roles.index', compact('roles'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = $this->permissionRepository->get();

        return view('acl.roles.create', compact('permission'));
    }


    /**
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RoleRequest $request)
    {
        $role = $this->repository->create(['name' => $request->get('name')]);
        $role->syncPermissions($request->get('permission'));

        return redirect()->route('roles.index')->with('success', __('Create success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = $this->repository->find($id);
        $permissions = $this->permissionRepository->get();
        $rolePermissions = $this->permissionRepository->pluck_role_has_permissions($id);

        return view('acl.roles.show', compact('role', 'rolePermissions', 'permissions'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = $this->repository->find($id);

        $permission = $this->permissionRepository->get();
        $rolePermissions = $this->permissionRepository->pluck_role_has_permissions($id);

        return view('acl.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $role = $this->repository->find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.edit', $id)->with('success', __('Update success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (in_array($id, User::getRolesNotDelete())) {
            return redirect()->route('roles.index')->with('error', __('This role can not delete'));
        }

        $this->repository->delete($id);

        return redirect()->route('roles.index')->with('success', __('Delete success'));
    }
}
