<?php

namespace App\Http\Controllers\Admin\ACL;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ACL\RoleRepository;
use App\Http\Requests\ACL\PermissionRequest;
use App\Repositories\ACL\PermissionRepository;

class PermissionController extends Controller
{
    /**
     * @var PermissionRepository
     */
    protected $repository;

    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * PermissionController constructor.
     * @param PermissionRepository $repository
     * @param RoleRepository $roleRepository
     */
    public function __construct(PermissionRepository $repository, RoleRepository $roleRepository)
    {
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
        $this->middleware('permission:view permission', ['only' => ['index']]);
        $this->middleware('permission:create permission', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit permission', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete permission', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permissions = $this->repository->getList($request);

        return view('acl.permissions.index')->with('permissions', $permissions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roleRepository->get();

        return view('acl.permissions.create')->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PermissionRequest $request)
    {
        $name = $request->get('name');
        $permission = $this->repository->create(['name' => $name]);

        $roles = $request->get('roles');
        $permission->syncRoles($roles);

        return redirect()->route('permissions.index')->with('success',__('Create success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = $this->repository->find($id);
        $roles = $this->roleRepository->get();
        $permissionRoles = $this->repository->pluck_permissions_has_role($id);

        return view('acl.permissions.edit', compact('permission', 'roles', 'permissionRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        $permission = $this->repository->find($id);

        $roleRequests = $request['roles'];
        $permissionRoles = $this->roleRepository->get();

        foreach ($permissionRoles as $permissionRole) {
            if (is_array($roleRequests) && in_array($permissionRole->id, $roleRequests)) {
                if (!$permission->hasRole($permissionRole))
                    $permission->assignRole($permissionRole);
            } else {
                $permission->removeRole($permissionRole);
            }
        }

        $roleRequestOther = array_diff($roleRequests, $permissionRoles->pluck('id')->toArray());

        foreach ($roleRequestOther as $roleId) {
            $permission->assignRole($roleId);
        }

        $permission->update(['name' => $request->get('name')]);

        return redirect()->route('permissions.edit', $id)->with('success',__('Update success'));
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

        return redirect()->route('permissions.index')
            ->with('success',__('Delete success'));
    }
}
