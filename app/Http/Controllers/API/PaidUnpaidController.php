<?php

namespace App\Http\Controllers\API;

use App\Models\PaidUnpaid;
use Illuminate\Http\Request;
use App\Http\Resources\PaidUnpaid as ResourcesPaidUnpaid;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class PaidUnpaidController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paid_unpaids = PaidUnpaid::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesPaidUnpaid::collection($paid_unpaids), __('notifications.find_all_paid_unpaids_success'));
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
            'month_year' => $request->month_year,
            'is_paid' => !empty($request->is_paid) ? $request->is_paid : 0,
            'user_id' => $request->user_id
        ];

        // Validate required fields
        if ($inputs['user_id'] == null OR $inputs['user_id'] == ' ') {
            return $this->handleError($inputs['user_id'], __('validation.required'), 400);
        }

        $paid_unpaid = PaidUnpaid::create($inputs);

        return $this->handleResponse(new ResourcesPaidUnpaid($paid_unpaid), __('notifications.create_paid_unpaid_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paid_unpaid = PaidUnpaid::find($id);

        if (is_null($paid_unpaid)) {
            return $this->handleError(__('notifications.find_paid_unpaid_404'));
        }

        return $this->handleResponse(new ResourcesPaidUnpaid($paid_unpaid), __('notifications.find_paid_unpaid_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaidUnpaid  $paid_unpaid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaidUnpaid $paid_unpaid)
    {
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'month_year' => $request->month_year,
            'is_paid' => $request->is_paid,
            'user_id' => $request->user_id,
            'updated_at' => now()
        ];

        if ($inputs['month_year'] != null) {
            $paid_unpaid->update([
                'month_year' => $request->month_year,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['is_paid'] != null) {
            $paid_unpaid->update([
                'is_paid' => $request->is_paid,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['user_id'] != null) {
            $paid_unpaid->update([
                'user_id' => $request->user_id,
                'updated_at' => now(),
            ]);
        }

        return $this->handleResponse(new ResourcesPaidUnpaid($paid_unpaid), __('notifications.update_paid_unpaid_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaidUnpaid  $paid_unpaid
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaidUnpaid $paid_unpaid)
    {
        $paid_unpaid->delete();

        $paid_unpaids = PaidUnpaid::all();

        return $this->handleResponse(ResourcesPaidUnpaid::collection($paid_unpaids), __('notifications.delete_paid_unpaid_success'));
    }

    // ==================================== CUSTOM METHODS ====================================
    /**
     * Search employee payment of a specific month of the year.
     *
     * @param  int $user_id
     * @param  string $month_year
     * @return \Illuminate\Http\Response
     */
    public function findByUserMonthYear($user_id, $month_year)
    {
        $paid_unpaid = PaidUnpaid::where([['user_id', $user_id], ['month_year', $month_year]])->first();

        if (is_null($paid_unpaid)) {
            return $this->handleResponse(null, __('notifications.find_presence_absence_404'));
        }

        return $this->handleResponse(new ResourcesPaidUnpaid($paid_unpaid), __('notifications.find_paid_unpaid_success'));
    }

    /**
     * Search employee payments of a specific year.
     *
     * @param  int $user_id
     * @param  string $year
     * @return \Illuminate\Http\Response
     */
    public function findByUserYear($user_id, $year)
    {
        $paid_unpaids = PaidUnpaid::where([['user_id', $user_id], ['month_year', 'LIKE', '%-' . $year]])->get();

        if (is_null($paid_unpaids)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPaidUnpaid::collection($paid_unpaids), __('notifications.find_all_paid_unpaids_success'));
    }

    /**
     * Search all employees payments of a specific mont/year.
     *
     * @param  int $branch_id
     * @param  string $month_year
     * @return \Illuminate\Http\Response
     */
    public function findByBranchMonthYear($branch_id, $month_year)
    {
        $paid_unpaids = PaidUnpaid::whereHas('user', function ($query) use ($branch_id) {
                                        $query->whereHas('branches', function ($query) use ($branch_id) {
                                            $query->where('branches.id', $branch_id);
                                        })->whereHas('roles', function ($query) {
                                            $query->where('roles.role_name', 'Employé');
                                        });
                                    })->where('paid_unpaids.month_year', $month_year)->get();

        if (is_null($paid_unpaids)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPaidUnpaid::collection($paid_unpaids), __('notifications.find_all_paid_unpaids_success'));
    }

    /**
     * Search all employees payments of a specific year.
     *
     * @param  int $branch_id
     * @param  string $year
     * @return \Illuminate\Http\Response
     */
    public function findByBranchYear($branch_id, $year)
    {
        $paid_unpaids = PaidUnpaid::whereHas('user', function ($query) use ($branch_id) {
                                        $query->whereHas('branches', function ($query) use ($branch_id) {
                                            $query->where('branches.id', $branch_id);
                                        })->whereHas('roles', function ($query) {
                                            $query->where('roles.role_name', 'Employé');
                                        });
                                    })->where('paid_unpaids.month_year', 'LIKE', '%-' . $year)->get();

        if (is_null($paid_unpaids)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPaidUnpaid::collection($paid_unpaids), __('notifications.find_all_paid_unpaids_success'));
    }

    /**
     * Search all employees payments of a specific mont/year.
     *
     * @param  int $branch_id
     * @param  string $month_year
     * @param  string $status_name
     * @return \Illuminate\Http\Response
     */
    public function findByBranchMonthYearStatus($branch_id, $month_year, $status_name)
    {
        $paid_unpaids = PaidUnpaid::whereHas('user', function ($query) use ($branch_id, $status_name) {
                                        $query->whereHas('branches', function ($query) use ($branch_id) {
                                            $query->where('branches.id', $branch_id);
                                        })->whereHas('roles', function ($query) {
                                            $query->where('roles.role_name', 'Employé');
                                        })->whereHas('status', function ($query) use ($status_name) {
                                            $query->where('statuses.status_name', $status_name);
                                        });
                                    })->where('paid_unpaids.month_year', $month_year)->get();

        if (is_null($paid_unpaids)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPaidUnpaid::collection($paid_unpaids), __('notifications.find_all_paid_unpaids_success'));
    }

    /**
     * Search all employees payments of a specific year.
     *
     * @param  int $branch_id
     * @param  string $year
     * @param  string $status_name
     * @return \Illuminate\Http\Response
     */
    public function findByBranchYearStatus($branch_id, $year, $status_name)
    {
        $paid_unpaids = PaidUnpaid::whereHas('user', function ($query) use ($branch_id, $status_name) {
                                        $query->whereHas('branches', function ($query) use ($branch_id) {
                                            $query->where('branches.id', $branch_id);
                                        })->whereHas('roles', function ($query) {
                                            $query->where('roles.role_name', 'Employé');
                                        })->whereHas('status', function ($query) use ($status_name) {
                                            $query->where('statuses.status_name', $status_name);
                                        });
                                    })->where('paid_unpaids.month_year', 'LIKE', '%-' . $year)->get();

        if (is_null($paid_unpaids)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPaidUnpaid::collection($paid_unpaids), __('notifications.find_all_paid_unpaids_success'));
    }

    /**
     * Search all paid/unpaid employees of a specific mont/year.
     *
     * @param  int $branch_id
     * @param  int $is_paid
     * @param  string $month_year
     * @return \Illuminate\Http\Response
     */
    public function findByBranchIsPaidMonthYear($branch_id, $is_paid, $month_year)
    {
        $paid_unpaids = PaidUnpaid::whereHas('user', function ($query) use ($branch_id) {
                                        $query->whereHas('branches', function ($query) use ($branch_id) {
                                            $query->where('branches.id', $branch_id);
                                        })->whereHas('roles', function ($query) {
                                            $query->where('roles.role_name', 'Employé');
                                        });
                                    })->where([['paid_unpaids.is_paid', $is_paid], ['paid_unpaids.month_year', $month_year]])->get();

        if (is_null($paid_unpaids)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPaidUnpaid::collection($paid_unpaids), __('notifications.find_all_paid_unpaids_success'));
    }

    /**
     * Search all paid/unpaid employees of a specific year.
     *
     * @param  int $branch_id
     * @param  int $is_paid
     * @param  string $year
     * @return \Illuminate\Http\Response
     */
    public function findByBranchIsPaidYear($branch_id, $is_paid, $year)
    {
        $paid_unpaids = PaidUnpaid::whereHas('user', function ($query) use ($branch_id) {
                                        $query->whereHas('branches', function ($query) use ($branch_id) {
                                            $query->where('branches.id', $branch_id);
                                        })->whereHas('roles', function ($query) {
                                            $query->where('roles.role_name', 'Employé');
                                        });
                                    })->where([['paid_unpaids.is_paid', $is_paid], ['paid_unpaids.month_year', 'LIKE', '%-' . $year]])->get();

        if (is_null($paid_unpaids)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPaidUnpaid::collection($paid_unpaids), __('notifications.find_all_paid_unpaids_success'));
    }

    /**
     * Search all paid/unpaid employees of a specific mont/year.
     *
     * @param  int $branch_id
     * @param  int $is_paid
     * @param  string $month_year
     * @param  string $status_name
     * @return \Illuminate\Http\Response
     */
    public function findByBranchIsPaidMonthYearStatus($branch_id, $is_paid, $month_year, $status_name)
    {
        $paid_unpaids = PaidUnpaid::whereHas('user', function ($query) use ($branch_id, $status_name) {
                                        $query->whereHas('branches', function ($query) use ($branch_id) {
                                            $query->where('branches.id', $branch_id);
                                        })->whereHas('roles', function ($query) {
                                            $query->where('roles.role_name', 'Employé');
                                        })->whereHas('status', function ($query) use ($status_name) {
                                            $query->where('statuses.status_name', $status_name);
                                        });
                                    })->where([['paid_unpaids.is_paid', $is_paid], ['paid_unpaids.month_year', $month_year]])->get();

        if (is_null($paid_unpaids)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPaidUnpaid::collection($paid_unpaids), __('notifications.find_all_paid_unpaids_success'));
    }

    /**
     * Search all paid/unpaid employees of a specific year.
     *
     * @param  int $branch_id
     * @param  int $is_paid
     * @param  string $year
     * @return \Illuminate\Http\Response
     */
    public function findByBranchIsPaidYearStatus($branch_id, $is_paid, $year, $status_name)
    {
        $paid_unpaids = PaidUnpaid::whereHas('user', function ($query) use ($branch_id, $status_name) {
                                        $query->whereHas('branches', function ($query) use ($branch_id) {
                                            $query->where('branches.id', $branch_id);
                                        })->whereHas('roles', function ($query) {
                                            $query->where('roles.role_name', 'Employé');
                                        })->whereHas('status', function ($query) use ($status_name) {
                                            $query->where('statuses.status_name', $status_name);
                                        });
                                    })->where([['paid_unpaids.is_paid', $is_paid], ['paid_unpaids.month_year', 'LIKE', '%-' . $year]])->get();

        if (is_null($paid_unpaids)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPaidUnpaid::collection($paid_unpaids), __('notifications.find_all_paid_unpaids_success'));
    }

    /**
     * Switch between employee payment.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function switchIs($id)
    {
        $paid_unpaid = PaidUnpaid::find($id);

        if ($paid_unpaid->is_paid == 0) {
            $paid_unpaid->update([
                'is_paid' => 1,
                'updated_at' => now()
            ]);

        } else {
            $paid_unpaid->update([
                'is_paid' => 0,
                'updated_at' => now()
            ]);
        }

        return $this->handleResponse(new ResourcesPaidUnpaid($paid_unpaid), __('notifications.update_paid_unpaid_success'));
    }
}
