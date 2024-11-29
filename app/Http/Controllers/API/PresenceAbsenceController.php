<?php

namespace App\Http\Controllers\API;

use App\Models\Type;
use App\Models\Group;
use App\Models\History;
use Illuminate\Http\Request;
use App\Models\PresenceAbsence;
use App\Http\Resources\PresenceAbsence as ResourcesPresenceAbsence;
use App\Models\User;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class PresenceAbsenceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $presence_absences = PresenceAbsence::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesPresenceAbsence::collection($presence_absences), __('notifications.find_all_presence_absences_success'));
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
            'daytime' => $request->daytime,
            'is_present' => !empty($request->is_present) ? $request->is_present : 0,
            'arrival_hour' => $request->arrival_hour,
            'departure_hour' => $request->departure_hour,
            'status_id' => $request->status_id,
            'user_id' => $request->user_id
        ];

        // Validate required fields
        if ($inputs['status_id'] == null OR $inputs['status_id'] == ' ') {
            return $this->handleError($inputs['status_id'], __('validation.required'), 400);
        }

        if ($inputs['user_id'] == null OR $inputs['user_id'] == ' ') {
            return $this->handleError($inputs['user_id'], __('validation.required'), 400);
        }

        $presence_absence = PresenceAbsence::create($inputs);

        return $this->handleResponse(new ResourcesPresenceAbsence($presence_absence), __('notifications.create_presence_absence_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $presence_absence = PresenceAbsence::find($id);

        if (is_null($presence_absence)) {
            return $this->handleError(__('notifications.find_presence_absence_404'));
        }

        return $this->handleResponse(new ResourcesPresenceAbsence($presence_absence), __('notifications.find_presence_absence_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PresenceAbsence  $presence_absence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PresenceAbsence $presence_absence)
    {
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $activities_history_type = Type::where([['type_name', 'Historique des activités'], ['group_id', $history_type_group->id]])->first();
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'daytime' => $request->daytime,
            'is_present' => $request->is_present,
            'arrival_hour' => $request->arrival_hour,
            'departure_hour' => $request->departure_hour,
            'status_id' => $request->status_id,
            'user_id' => $request->user_id
        ];

        if ($inputs['daytime'] != null) {
            $presence_absence->update([
                'daytime' => $request->daytime,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['is_present'] != null) {
            $presence_absence->update([
                'is_present' => $request->is_present,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['arrival_hour'] != null) {
            $presence_absence->update([
                'arrival_hour' => $request->arrival_hour,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['departure_hour'] != null) {
            $presence_absence->update([
                'departure_hour' => $request->departure_hour,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['status_id'] != null) {
            if ($request->visitor_id != null) {
                $user = User::find($inputs['user_id']);

                if (is_null($user)) {
                    return $this->handleError(__('notifications.find_user_404'));
                }

                /*
                    HISTORY AND/OR NOTIFICATION MANAGEMENT
                */
                History::create([
                    'history_content' => __('notifications.you_changed_status') . ' ' . $user->firstname . ' ' . $user->lastname,
                    'history_url' => '/employee/' . $user->id,
                    'icon' => 'bi bi-toggle-on',
                    'color' => 'warning',
                    'type_id' => $activities_history_type->id,
                    'user_id' => $request->visitor_id,
                ]);
            }

            $presence_absence->update([
                'status_id' => $request->status_id,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['user_id'] != null) {
            $presence_absence->update([
                'user_id' => $request->user_id,
                'updated_at' => now(),
            ]);
        }

        return $this->handleResponse(new ResourcesPresenceAbsence($presence_absence), __('notifications.update_presence_absence_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PresenceAbsence  $presence_absence
     * @return \Illuminate\Http\Response
     */
    public function destroy(PresenceAbsence $presence_absence)
    {
        $presence_absence->delete();

        $presence_absences = PresenceAbsence::all();

        return $this->handleResponse(ResourcesPresenceAbsence::collection($presence_absences), __('notifications.delete_presence_absence_success'));
    }

    // ==================================== CUSTOM METHODS ====================================
    /**
     * Search employee presence of a specific date.
     *
     * @param  int $user_id
     * @param  string $date
     * @return \Illuminate\Http\Response
     */
    public function findByUserDate($user_id, $date)
    {
        $presence_absence = PresenceAbsence::where('user_id', $user_id)->whereDate('daytime', '=', $date)->first();

        if (is_null($presence_absence)) {
            return $this->handleResponse(null, __('notifications.find_presence_absence_404'));
        }

        return $this->handleResponse(new ResourcesPresenceAbsence($presence_absence), __('notifications.find_presence_absence_success'));
    }

    /**
     * Search employee presences of a specific month of a specific year.
     *
     * @param  int $user_id
     * @param  string $monthYear
     * @return \Illuminate\Http\Response
     */
    public function findByUserMonthYear($user_id, $monthYear)
    {
        $presence_absences = PresenceAbsence::where('user_id', $user_id)->whereMonth('daytime', '=', explode('-', $monthYear)[0])
                                            ->whereYear('daytime', '=', explode('-', $monthYear)[1])->get();

        if (is_null($presence_absences)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPresenceAbsence::collection($presence_absences), __('notifications.find_all_presence_absences_success'));
    }

    /**
     * Search employee presences of a specific year.
     *
     * @param  int $user_id
     * @param  string $year
     * @return \Illuminate\Http\Response
     */
    public function findByUserYear($user_id, $year)
    {
        $presence_absences = PresenceAbsence::where('user_id', $user_id)->whereYear('daytime', '=', $year)->first();

        if (is_null($presence_absences)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPresenceAbsence::collection($presence_absences), __('notifications.find_all_presence_absences_success'));
    }

    /**
     * Search all employees presences of a specific date.
     *
     * @param  int $branch_id
     * @param  string $date
     * @return \Illuminate\Http\Response
     */
    public function findByBranchDate($branch_id, $date)
    {
        $presence_absences = PresenceAbsence::whereHas('user', function ($query) use ($branch_id) {
                                                $query->whereHas('branches', function ($query) use ($branch_id) {
                                                    $query->where('branches.id', $branch_id);
                                                })->whereHas('roles', function ($query) {
                                                    $query->where('roles.role_name', 'Employé');
                                                })->whereHas('status', function ($query) {
                                                    $query->where('statuses.status_name', 'Actif');
                                                });
                                            })->whereDate('presence_absences.daytime', '=', $date)->get();

        if (is_null($presence_absences)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPresenceAbsence::collection($presence_absences), __('notifications.find_all_presence_absences_success'));
    }

    /**
     * Search all employees presences of a specific month of the year.
     *
     * @param  int $branch_id
     * @param  string $monthYear
     * @return \Illuminate\Http\Response
     */
    public function findByBranchMonthYear($branch_id, $monthYear)
    {
        $presence_absences = PresenceAbsence::whereHas('user', function ($query) use ($branch_id) {
                                                    $query->whereHas('branches', function ($query) use ($branch_id) {
                                                        $query->where('branches.id', $branch_id);
                                                    })->whereHas('roles', function ($query) {
                                                        $query->where('roles.role_name', 'Employé');
                                                    })->whereHas('status', function ($query) {
                                                        $query->where('statuses.status_name', 'Actif');
                                                    });
                                                })->whereMonth('presence_absences.daytime', '=', explode('-', $monthYear)[0])
                                                    ->whereYear('presence_absences.daytime', '=', explode('-', $monthYear)[1])->get();

        if (is_null($presence_absences)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPresenceAbsence::collection($presence_absences), __('notifications.find_all_presence_absences_success'));
    }

    /**
     * Search all employees presences of a specific year.
     *
     * @param  int $branch_id
     * @param  string $year
     * @return \Illuminate\Http\Response
     */
    public function findByBranchYear($branch_id, $year)
    {
        $presence_absences = PresenceAbsence::whereHas('user', function ($query) use ($branch_id) {
                                                    $query->whereHas('branches', function ($query) use ($branch_id) {
                                                        $query->where('branches.id', $branch_id);
                                                    })->whereHas('roles', function ($query) {
                                                        $query->where('roles.role_name', 'Employé');
                                                    })->whereHas('status', function ($query) {
                                                        $query->where('statuses.status_name', 'Actif');
                                                    });
                                                })->whereYear('presence_absences.daytime', '=', $year)->get();

        if (is_null($presence_absences)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPresenceAbsence::collection($presence_absences), __('notifications.find_all_presence_absences_success'));
    }

    /**
     * Search all employees presences of a specific date and having a specific status.
     *
     * @param  int $branch_id
     * @param  int $status_id
     * @param  string $date
     * @return \Illuminate\Http\Response
     */
    public function findByBranchStatusDate($branch_id, $status_id, $date)
    {
        $presence_absences = PresenceAbsence::where('presence_absences.status_id', $status_id)
                                                ->whereHas('user', function ($query) use ($branch_id) {
                                                    $query->whereHas('branches', function ($query) use ($branch_id) {
                                                        $query->where('branches.id', $branch_id);
                                                    })->whereHas('roles', function ($query) {
                                                        $query->where('roles.role_name', 'Employé');
                                                    })->whereHas('status', function ($query) {
                                                        $query->where('statuses.status_name', 'Actif');
                                                    });
                                                })->whereDate('presence_absences.daytime', '=', $date)->get();

        if (is_null($presence_absences)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPresenceAbsence::collection($presence_absences), __('notifications.find_all_presence_absences_success'));
    }

    /**
     * Search all employees presences of a specific month of the year and having a specific status.
     *
     * @param  int $branch_id
     * @param  int $status_id
     * @param  string $monthYear
     * @return \Illuminate\Http\Response
     */
    public function findByBranchStatusMonthYear($branch_id, $status_id, $monthYear)
    {
        $presence_absences = PresenceAbsence::where('presence_absences.status_id', $status_id)
                                                ->whereHas('user', function ($query) use ($branch_id) {
                                                    $query->whereHas('branches', function ($query) use ($branch_id) {
                                                        $query->where('branches.id', $branch_id);
                                                    })->whereHas('roles', function ($query) {
                                                        $query->where('roles.role_name', 'Employé');
                                                    })->whereHas('status', function ($query) {
                                                        $query->where('statuses.status_name', 'Actif');
                                                    });
                                                })->whereMonth('presence_absences.daytime', '=', explode('-', $monthYear)[0])
                                                    ->whereYear('presence_absences.daytime', '=', explode('-', $monthYear)[1])->get();

        if (is_null($presence_absences)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPresenceAbsence::collection($presence_absences), __('notifications.find_all_presence_absences_success'));
    }

    /**
     * Search all employees presences of a specific year and having a specific status.
     *
     * @param  int $branch_id
     * @param  int $status_id
     * @param  string $year
     * @return \Illuminate\Http\Response
     */
    public function findByBranchStatusYear($branch_id, $status_id, $year)
    {
        $presence_absences = PresenceAbsence::where('presence_absences.status_id', $status_id)
                                                ->whereHas('user', function ($query) use ($branch_id) {
                                                    $query->whereHas('branches', function ($query) use ($branch_id) {
                                                        $query->where('branches.id', $branch_id);
                                                    })->whereHas('roles', function ($query) {
                                                        $query->where('roles.role_name', 'Employé');
                                                    })->whereHas('status', function ($query) {
                                                        $query->where('statuses.status_name', 'Actif');
                                                    });
                                                })->whereYear('presence_absences.daytime', '=', $year)->get();

        if (is_null($presence_absences)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPresenceAbsence::collection($presence_absences), __('notifications.find_all_presence_absences_success'));
    }

    /**
     * Search all employees presences of a specific date and having a specific status.
     *
     * @param  int $branch_id
     * @param  int $is_present
     * @param  int $status_id
     * @param  string $date
     * @return \Illuminate\Http\Response
     */
    public function findByBranchIsPresentDate($branch_id, $is_present, $status_id, $date)
    {
        $presence_absences = PresenceAbsence::where([['presence_absences.is_present', $is_present], ['presence_absences.status_id', $status_id]])
                                                ->whereHas('user', function ($query) use ($branch_id) {
                                                    $query->whereHas('branches', function ($query) use ($branch_id) {
                                                        $query->where('branches.id', $branch_id);
                                                    })->whereHas('roles', function ($query) {
                                                        $query->where('roles.role_name', 'Employé');
                                                    })->whereHas('status', function ($query) {
                                                        $query->where('statuses.status_name', 'Actif');
                                                    });
                                                })->whereDate('presence_absences.daytime', '=', $date)->get();

        if (is_null($presence_absences)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPresenceAbsence::collection($presence_absences), __('notifications.find_all_presence_absences_success'));
    }

    /**
     * Search all employees presences or absences of a specific month of the year and having a specific status.
     *
     * @param  int $branch_id
     * @param  int $is_present
     * @param  int $status_id
     * @param  string $monthYear
     * @return \Illuminate\Http\Response
     */
    public function findByBranchIsPresentMonthYear($branch_id, $is_present, $status_id, $monthYear)
    {
        $presence_absences = PresenceAbsence::where([['presence_absences.is_present', $is_present], ['presence_absences.status_id', $status_id]])
                                                ->whereHas('user', function ($query) use ($branch_id) {
                                                    $query->whereHas('branches', function ($query) use ($branch_id) {
                                                        $query->where('branches.id', $branch_id);
                                                    })->whereHas('roles', function ($query) {
                                                        $query->where('roles.role_name', 'Employé');
                                                    })->whereHas('status', function ($query) {
                                                        $query->where('statuses.status_name', 'Actif');
                                                    });
                                                })->whereMonth('presence_absences.daytime', '=', explode('-', $monthYear)[0])
                                                    ->whereYear('presence_absences.daytime', '=', explode('-', $monthYear)[1])->get();

        if (is_null($presence_absences)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPresenceAbsence::collection($presence_absences), __('notifications.find_all_presence_absences_success'));
    }

    /**
     * Search all employees presences or absences of a specific year and having a specific status.
     *
     * @param  int $branch_id
     * @param  int $is_present
     * @param  int $status_id
     * @param  string $year
     * @return \Illuminate\Http\Response
     */
    public function findByBranchIsPresentYear($branch_id, $is_present, $status_id, $year)
    {
        $presence_absences = PresenceAbsence::where([['presence_absences.is_present', $is_present], ['presence_absences.status_id', $status_id]])
                                                ->whereHas('user', function ($query) use ($branch_id) {
                                                    $query->whereHas('branches', function ($query) use ($branch_id) {
                                                        $query->where('branches.id', $branch_id);
                                                    })->whereHas('roles', function ($query) {
                                                        $query->where('roles.role_name', 'Employé');
                                                    })->whereHas('status', function ($query) {
                                                        $query->where('statuses.status_name', 'Actif');
                                                    });
                                                })->whereYear('presence_absences.daytime', '=', $year)->get();

        if (is_null($presence_absences)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesPresenceAbsence::collection($presence_absences), __('notifications.find_all_presence_absences_success'));
    }

    /**
     * Switch between employee presence.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function switchIs($id)
    {
        $presence_absence = PresenceAbsence::find($id);

        if ($presence_absence->is_present == 0) {
            $presence_absence->update([
                'is_present' => 1,
                'updated_at' => now()
            ]);

        } else {
            $presence_absence->update([
                'is_present' => 0,
                'updated_at' => now()
            ]);
        }

        return $this->handleResponse(new ResourcesPresenceAbsence($presence_absence), __('notifications.update_presence_absence_success'));
    }
}
