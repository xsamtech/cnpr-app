<?php

namespace App\Http\Controllers\API;

use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Http\Resources\Vacation as ResourcesVacation;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class VacationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vacations = Vacation::orderByDesc('updated_at')->get();

        return $this->handleResponse(ResourcesVacation::collection($vacations), __('notifications.find_all_vacations_success'));
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
            'day_month' => $request->day_month,
            'year' => $request->year,
            'vacation_description' => $request->vacation_description
        ];
        // Select all vacations to check unique constraint
        $vacations = Vacation::all();

        // Validate required fields
        if ($inputs['day_month'] == null OR $inputs['day_month'] == ' ') {
            return $this->handleError($inputs['day_month'], __('validation.required'), 400);
        }

        if ($inputs['year'] == null OR $inputs['year'] == ' ') {
            return $this->handleError($inputs['year'], __('validation.required'), 400);
        }

        // Check if vacation for the current year already exists
        foreach ($vacations as $another_vacation):
            if ($another_vacation->day_month == $inputs['day_month'] AND $another_vacation->year == $inputs['year']) {
                return $this->handleError($inputs['year'], __('validation.custom.day_month.exists'), 400);
            }
        endforeach;

        $vacation = Vacation::create($inputs);

        return $this->handleResponse(new ResourcesVacation($vacation), __('notifications.create_vacation_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vacation = Vacation::find($id);

        if (is_null($vacation)) {
            return $this->handleError(__('notifications.find_vacation_404'));
        }

        return $this->handleResponse(new ResourcesVacation($vacation), __('notifications.find_vacation_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vacation $vacation)
    {
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'day_month' => $request->day_month,
            'year' => $request->year,
            'vacation_description' => $request->vacation_description,
            'updated_at' => now()
        ];
        // Select all vacations and specific vacation to check unique constraint
        $vacations = Vacation::all();
        $current_vacation = Vacation::find($inputs['id']);

        if ($inputs['day_month'] == null OR $inputs['day_month'] == ' ') {
            return $this->handleError($inputs['day_month'], __('validation.required'), 400);
        }

        if ($inputs['year'] == null OR $inputs['year'] == ' ') {
            return $this->handleError($inputs['year'], __('validation.required'), 400);
        }

        foreach ($vacations as $another_vacation):
            if ($current_vacation->day_month != $inputs['day_month'] OR $current_vacation->year != $inputs['year']) {
                if ($another_vacation->day_month == $inputs['day_month'] AND $another_vacation->year == $inputs['year']) {
                    return $this->handleError($inputs['year'], __('validation.custom.day_month.exists'), 400);
                }
            }
        endforeach;

        $vacation->update($inputs);

        return $this->handleResponse(new ResourcesVacation($vacation), __('notifications.update_vacation_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacation $vacation)
    {
        $vacation->delete();

        $vacations = Vacation::all();

        return $this->handleResponse(ResourcesVacation::collection($vacations), __('notifications.delete_vacation_success'));
    }

    // ==================================== CUSTOM METHODS ====================================
    /**
     * Search all vacations of the specific year
     *
     * @param  string $year
     * @return \Illuminate\Http\Response
     */
    public function findByYear($year)
    {
        $vacations = Vacation::where('year', $year)->orderByDesc('created_at')->get();

        if (is_null($vacations)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesVacation::collection($vacations), __('notifications.delete_vacation_success'));
    }
}
