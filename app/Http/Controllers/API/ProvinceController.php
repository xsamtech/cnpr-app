<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use App\Models\History;
use App\Models\Province;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Resources\Province as ResourcesProvince;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class ProvinceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = Province::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesProvince::collection($provinces), __('notifications.find_all_provinces_success'));
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
            'province_name' => $request->province_name
        ];
        // Select all provinces to check unique constraint
        $provinces = Province::all();

        // Validate required fields
        if ($inputs['province_name'] == null OR $inputs['province_name'] == ' ') {
            return $this->handleError($inputs['province_name'], __('validation.required'), 400);
        }

        // Check if province name already exists
        foreach ($provinces as $another_province):
            if ($another_province->province_name == $inputs['province_name']) {
                return $this->handleError($inputs['province_name'], __('validation.custom.province_name.exists'), 400);
            }
        endforeach;

        $province = Province::create($inputs);

        return $this->handleResponse(new ResourcesProvince($province), __('notifications.create_province_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $province = Province::find($id);

        if (is_null($province)) {
            return $this->handleError(__('notifications.find_province_404'));
        }

        return $this->handleResponse(new ResourcesProvince($province), __('notifications.find_province_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Province $province)
    {
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'province_name' => $request->province_name
        ];
        // Select all provinces and specific province to check unique constraint
        $provinces = Province::all();
        $current_province = Province::find($inputs['id']);

        if ($inputs['province_name'] != null) {
            foreach ($provinces as $another_province):
                if ($current_province->province_name != $inputs['province_name']) {
                    if ($another_province->province_name == $inputs['province_name']) {
                        return $this->handleError($inputs['province_name'], __('validation.custom.province_name.exists'), 400);
                    }
                }
            endforeach;

            $province->update([
                'province_name' => $request->province_name,
                'updated_at' => now(),
            ]);
        }

        return $this->handleResponse(new ResourcesProvince($province), __('notifications.update_province_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province)
    {
        $province->delete();

        $provinces = Province::all();

        return $this->handleResponse(ResourcesProvince::collection($provinces), __('notifications.delete_province_success'));
    }

    // ==================================== CUSTOM METHODS ====================================
    /**
     * Search a province by its name.
     *
     * @param  string $data
     * @param  int $visitor_id
     * @return \Illuminate\Http\Response
     */
    public function search($data, $visitor_id)
    {
        $provinces = Province::where('province_name', 'LIKE', '%' . $data . '%')->get();

        if (is_null($provinces)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $search_history_type = Type::where([['type_name', 'Historique de recherche'], ['group_id', $history_type_group->id]])->first();

        History::create([
            'history_content' => $data,
            'history_url' => '/search/province/?query=' . $data,
            'type_id' => $search_history_type->id,
            'user_id' => $visitor_id,
        ]);

        return $this->handleResponse(ResourcesProvince::collection($provinces), __('notifications.find_all_provinces_success'));
    }
}
