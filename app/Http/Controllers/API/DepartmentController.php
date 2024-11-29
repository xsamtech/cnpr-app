<?php

namespace App\Http\Controllers\API;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Resources\Department as ResourcesDepartment;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class DepartmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();

        return $this->handleResponse(ResourcesDepartment::collection($departments), __('notifications.find_all_departments_success'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get inputs
        $inputs = [
            'department_name' => $request->department_name,
            'department_description' => $request->department_description,
            'belongs_to' => $request->belongs_to
        ];
        // Select all departments to check unique constraint
        $departments = Department::all();

        // Validate required fields
        if ($inputs['department_name'] == null OR $inputs['department_name'] == ' ') {
            return $this->handleError($inputs['department_name'], __('validation.required'), 400);
        }

        // Check if department name already exists
        foreach ($departments as $another_department):
            if ($another_department->department_name == $inputs['department_name'] && $another_department->belongs_to == $inputs['belongs_to']) {
                return $this->handleError($inputs['department_name'], __('validation.custom.department_name.exists'), 400);
            }
        endforeach;

        $department = Department::create($inputs);

        return $this->handleResponse(new ResourcesDepartment($department), __('notifications.create_department_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $department = Department::find($id);

        if (is_null($department)) {
            return $this->handleError(__('notifications.find_department_404'));
        }

        return $this->handleResponse(new ResourcesDepartment($department), __('notifications.find_department_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'department_name' => $request->department_name,
            'department_description' => $request->department_description,
            'belongs_to' => $request->belongs_to
        ];
        // Select all departments and specific department to check unique constraint
        $departments = Department::all();
        $current_department = Department::find($inputs['id']);

        if ($inputs['department_name'] != null) {
            foreach ($departments as $another_department):
                if ($current_department->department_name != $inputs['department_name']) {
                    if ($another_department->department_name == $inputs['department_name'] && $another_department->belongs_to == $inputs['belongs_to']) {
                        return $this->handleError($inputs['department_name'], __('validation.custom.department_name.exists'), 400);
                    }
                }
            endforeach;

            $department->update([
                'department_name' => $request->department_name,
                'updated_at' => now()
            ]);
        }

        if ($inputs['department_description'] != null) {
            $department->update([
                'department_description' => $request->department_description,
                'updated_at' => now()
            ]);
        }

        if ($inputs['belongs_to'] != null) {
            $department->update([
                'belongs_to' => $request->belongs_to,
                'updated_at' => now()
            ]);
        }

        return $this->handleResponse(new ResourcesDepartment($department), __('notifications.update_department_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();

        $departments = Department::all();

        return $this->handleResponse(ResourcesDepartment::collection($departments), __('notifications.delete_department_success'));
    }

    // ==================================== CUSTOM METHODS ====================================
    /**
     * Find all departments belonging to a specific department.
     *
     * @param  int $belongs_to
     * @return \Illuminate\Http\Response
     */
    public function findByBelongsTo($belongs_to)
    {
        $departments = Department::where('belongs_to', $belongs_to)->get();

        if (is_null($departments)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesDepartment::collection($departments), __('notifications.find_all_departments_success'));
    }
}
