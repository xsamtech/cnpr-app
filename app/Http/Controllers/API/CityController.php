<?php

namespace App\Http\Controllers\API;

use App\Models\City;
use App\Models\Group;
use App\Models\History;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Resources\City as ResourcesCity;

/**
 * @author Xanders
 * @see https://www.xsam-tech.com
 */
class CityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesCity::collection($cities), __('notifications.find_all_cities_success'));
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
            'city_name' => $request->city_name,
            'province_id' => $request->province_id
        ];
        // Select all province cities to check unique constraint
        $cities = City::where('province_id', $inputs['province_id'])->get();

        // Validate required fields
        if ($inputs['city_name'] == null OR $inputs['city_name'] == ' ') {
            return $this->handleError($inputs['city_name'], __('validation.required'), 400);
        }

        if ($inputs['province_id'] == null OR $inputs['province_id'] == ' ') {
            return $this->handleError($inputs['province_id'], __('validation.required'), 400);
        }

        // Check if city name already exists
        foreach ($cities as $another_city):
            if ($another_city->city_name == $inputs['city_name']) {
                return $this->handleError($inputs['city_name'], __('validation.custom.city_name.exists'), 400);
            }
        endforeach;

        $city = City::create($inputs);

        return $this->handleResponse(new ResourcesCity($city), __('notifications.create_city_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::find($id);

        if (is_null($city)) {
            return $this->handleError(__('notifications.find_city_404'));
        }

        return $this->handleResponse(new ResourcesCity($city), __('notifications.find_city_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'city_name' => $request->city_name,
            'province_id' => $request->province_id
        ];
        // Select all province cities and specific city to check unique constraint
        $cities = City::where('province_id', $inputs['province_id'])->get();
        $current_city = City::find($inputs['id']);

        if ($inputs['city_name'] != null) {
            foreach ($cities as $another_city):
                if ($current_city->city_name != $inputs['city_name']) {
                    if ($another_city->city_name == $inputs['city_name']) {
                        return $this->handleError($inputs['city_name'], __('validation.custom.city_name.exists'), 400);
                    }
                }
            endforeach;

            $city->update([
                'city_name' => $request->city_name,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['province_id'] != null) {
            $city->update([
                'province_id' => $request->province_id,
                'updated_at' => now(),
            ]);
        }

        return $this->handleResponse(new ResourcesCity($city), __('notifications.update_city_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();

        $cities = City::all();

        return $this->handleResponse(ResourcesCity::collection($cities), __('notifications.delete_city_success'));
    }

    // ==================================== CUSTOM METHODS ====================================
    /**
     * Search a city by its name.
     *
     * @param  string $data
     * @param  int $visitor_id
     * @return \Illuminate\Http\Response
     */
    public function search($data, $visitor_id)
    {
        $cities = City::where('city_name', 'LIKE', '%' . $data . '%')->get();

        if (is_null($cities)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $search_history_type = Type::where([['type_name', 'Historique de recherche'], ['group_id', $history_type_group->id]])->first();

        History::create([
            'history_content' => $data,
            'history_url' => '/search/city/?query=' . $data,
            'type_id' => $search_history_type->id,
            'user_id' => $visitor_id,
        ]);

        return $this->handleResponse(ResourcesCity::collection($cities), __('notifications.find_all_cities_success'));
    }

    /**
     * Find all cities by province.
     *
     * @param  int $province_id
     * @return \Illuminate\Http\Response
     */
    public function findByProvince($province_id)
    {
        $cities = City::where('province_id', $province_id)->get();

        if (is_null($cities)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesCity::collection($cities), __('notifications.find_all_cities_success'));
    }
}
