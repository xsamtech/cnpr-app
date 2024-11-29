<?php

namespace App\Http\Controllers\API;

use App\Models\Type;
use App\Models\Group;
use App\Models\Branch;
use App\Models\Status;
use App\Models\History;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Resources\Branch as ResourcesBranch;
use App\Models\User;

/**
 * @author Xanders
 * @see https://www.xsam-tech.com
 */
class BranchController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesBranch::collection($branches), __('notifications.find_all_branches_success'));
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
            'branch_name' => $request->branch_name,
            'email' => $request->email,
            'phones' => $request->phones,
            'address' => $request->address,
            'p_o_box' => $request->p_o_box,
            'city_id' => $request->city_id
        ];
        // Select all branches to check unique constraint
        $branches = Branch::all();

        // Validate required fields
        if ($inputs['branch_name'] == null OR $inputs['branch_name'] == ' ') {
            return $this->handleError($inputs['branch_name'], __('validation.required'), 400);
        }

        if ($inputs['city_id'] == null OR $inputs['city_id'] == ' ') {
            return $this->handleError($inputs['city_id'], __('validation.required'), 400);
        }

        // Check if branch name already exists
        foreach ($branches as $another_branch):
            if ($another_branch->branch_name == $inputs['branch_name']) {
                return $this->handleError($inputs['branch_name'], __('validation.custom.branch_name.exists'), 400);
            }
        endforeach;

        $branch = Branch::create($inputs);

        if ($request->user_id != null) {
            $branch->users()->attach([$request->user_id]);
        }

        if ($request->users_ids != null) {
            $branch->users()->attach($request->users_ids);
        }

        return $this->handleResponse(new ResourcesBranch($branch), __('notifications.create_branch_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $branch = Branch::find($id);

        if (is_null($branch)) {
            return $this->handleError(__('notifications.find_branch_404'));
        }

        return $this->handleResponse(new ResourcesBranch($branch), __('notifications.find_branch_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'branch_name' => $request->branch_name,
            'email' => $request->email,
            'phones' => $request->phones,
            'address' => $request->address,
            'p_o_box' => $request->p_o_box,
            'city_id' => $request->city_id
        ];
        // Select all branches and specific branch to check unique constraint
        $branches = Branch::all();
        $current_branch = Branch::find($inputs['id']);

        if ($inputs['branch_name'] != null) {
            foreach ($branches as $another_branch):
                if ($current_branch->branch_name != $inputs['branch_name']) {
                    if ($another_branch->branch_name == $inputs['branch_name']) {
                        return $this->handleError($inputs['branch_name'], __('validation.custom.branch_name.exists'), 400);
                    }
                }
            endforeach;

            $branch->update([
                'branch_name' => $request->branch_name,
                'updated_at' => now()
            ]);
        }

        if ($inputs['email'] != null) {
            $branch->update([
                'email' => $request->email,
                'updated_at' => now()
            ]);
        }

        if ($inputs['phones'] != null) {
            $branch->update([
                'phones' => $request->phones,
                'updated_at' => now()
            ]);
        }

        if ($inputs['address'] != null) {
            $branch->update([
                'address' => $request->address,
                'updated_at' => now()
            ]);
        }

        if ($inputs['p_o_box'] != null) {
            $branch->update([
                'p_o_box' => $request->p_o_box,
                'updated_at' => now()
            ]);
        }

        if ($inputs['city_id'] != null) {
            $branch->update([
                'city_id' => $request->city_id,
                'updated_at' => now()
            ]);
        }

        if ($request->user_id != null) {
            $branch->users()->syncWithoutDetaching([$request->user_id]);
        }

        if ($request->users_ids != null) {
            $branch->users()->syncWithoutDetaching($request->users_ids);
        }

        return $this->handleResponse(new ResourcesBranch($branch), __('notifications.update_branch_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();

        $branches = Branch::all();

        return $this->handleResponse(ResourcesBranch::collection($branches), __('notifications.delete_branch_success'));
    }

    // ==================================== CUSTOM METHODS ====================================
    /**
     * Search a branch by its name.
     *
     * @param  string $data
     * @param  int $visitor_id
     * @return \Illuminate\Http\Response
     */
    public function search($data, $visitor_id)
    {
        $branches = Branch::where('branch_name', 'LIKE', '%' . $data . '%')->get();

        if (is_null($branches)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $search_history_type = Type::where([['type_name', 'Historique de recherche'], ['group_id', $history_type_group->id]])->first();

        History::create([
            'history_content' => $data,
            'history_url' => '/search/branch/?query=' . $data,
            'type_id' => $search_history_type->id,
            'user_id' => $visitor_id,
        ]);

        return $this->handleResponse(ResourcesBranch::collection($branches), __('notifications.find_all_branches_success'));
    }

    /**
     * Find all branches by city.
     *
     * @param  int $city_id
     * @return \Illuminate\Http\Response
     */
    public function findByCity($city_id)
    {
        $branches = Branch::where('city_id', $city_id)->get();

        if (is_null($branches)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesBranch::collection($branches), __('notifications.find_all_branches_success'));
    }

    /**
     * Update users branch.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @param  $visitor_id
     * @return \Illuminate\Http\Response
     */
    public function updateUsers(Request $request, $id, $visitor_id)
    {
        $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();
        $activities_history_type = Type::where([['type_name', 'Historique des activités'], ['group_id', $history_type_group->id]])->first();
        $branch = Branch::find($id);
        $visitor = User::find($visitor_id);

        if ($request->user_id) {
            $user = User::find($request->user_id);

            $branch->users()->syncWithoutDetaching([$request->user_id]);

            /*
                HISTORY AND/OR NOTIFICATION MANAGEMENT
            */
            History::create([
                'history_content' => __('notifications.you_placed_to_branch', ['employee_names' => $user->firstname . ' ' . $user->lastname]) . $branch->branch_name . '.',
                'history_url' => inArrayR('Administrateur', $visitor->roles, 'role_name') ? '/branch/' . $branch->id : '/employee',
                'icon' => 'bi bi-building-check',
                'color' => 'primary',
                'type_id' => $activities_history_type->id,
                'user_id' => $visitor_id,
            ]);

            Notification::create([
                'notification_url' => '/account',
                'notification_content' => __('notifications.you_are_placed_branch', ['placed' => ($user->gender == 'F' ? __('notifications.placed_feminine') : __('notifications.placed_masculine'))]) . $branch->branch_name . '.',
                'icon' => 'bi bi-building-check',
                'color' => 'primary',
                'status_id' => $status_unread->id,
                'user_id' => $user->id,
            ]);
        }

        if ($request->users_ids) {
            $branch->users()->syncWithoutDetaching($request->users_ids);

            /*
                HISTORY AND/OR NOTIFICATION MANAGEMENT
            */
            History::create([
                'history_content' => __('notifications.you_placed_nth_to_branch', ['nth' => (count($request->users_ids) > 1 ? count($request->users_ids) : __('miscellaneous.a_feminine')), 'person' => (count($request->users_ids) > 1 ? __('notifications.nth_much_person') : __('notifications.nth_one_person'))]) . $branch->branch_name . '.',
                'history_url' => inArrayR('Administrateur', $visitor->roles, 'role_name') ? '/branch/' . $branch->id : '/employee',
                'icon' => 'bi bi-building-check',
                'color' => 'primary',
                'type_id' => $activities_history_type->id,
                'user_id' => $visitor_id,
            ]);

            foreach ($request->users_ids as $usr):
                Notification::create([
                    'notification_url' => '/account',
                    'notification_content' => __('notifications.you_are_placed_branch', ['placed' => ($usr->gender == 'F' ? __('notifications.placed_feminine') : __('notifications.placed_masculine'))]) . $branch->branch_name . '.',
                    'icon' => 'bi bi-building-check',
                    'color' => 'primary',
                    'status_id' => $status_unread->id,
                    'user_id' => $usr->id,
                ]);    
            endforeach;
        }

        return $this->handleResponse(new ResourcesBranch($branch), __('notifications.update_branch_success'));
    }

    /**
     * Remove users from branch.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @param  $visitor_id
     * @return \Illuminate\Http\Response
     */
    public function removeUsers(Request $request, $id, $visitor_id)
    {
        $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();
        $activities_history_type = Type::where([['type_name', 'Historique des activités'], ['group_id', $history_type_group->id]])->first();
        $branch = Branch::find($id);
        $visitor = User::find($visitor_id);

        if ($request->user_id) {
            $user = User::find($request->user_id);

            $branch->users()->detach([$request->user_id]);

            /*
                HISTORY AND/OR NOTIFICATION MANAGEMENT
            */
            History::create([
                'history_content' => __('notifications.you_removed_to_branch', ['employee_names' => $user->firstname . ' ' . $user->lastname]) . $branch->branch_name . '.',
                'history_url' => inArrayR('Administrateur', $visitor->roles, 'role_name') ? '/branch/' . $branch->id : '/employee',
                'icon' => 'bi bi-building-check',
                'color' => 'primary',
                'type_id' => $activities_history_type->id,
                'user_id' => $visitor_id,
            ]);

            Notification::create([
                'notification_url' => '/account',
                'notification_content' => __('notifications.you_are_removed_branch', ['removed' => ($user->gender == 'F' ? __('notifications.removed_feminine') : __('notifications.removed_masculine'))]) . $branch->branch_name . '.',
                'icon' => 'bi bi-building-check',
                'color' => 'primary',
                'status_id' => $status_unread->id,
                'user_id' => $user->id,
            ]);
        }

        if ($request->users_ids) {
            $branch->users()->detach($request->users_ids);

            /*
                HISTORY AND/OR NOTIFICATION MANAGEMENT
            */
            History::create([
                'history_content' => __('notifications.you_removed_nth_to_branch', ['nth' => (count($request->users_ids) > 1 ? count($request->users_ids) : __('miscellaneous.a_feminine')), 'person' => (count($request->users_ids) > 1 ? __('notifications.nth_much_person') : __('notifications.nth_one_person'))]) . $branch->branch_name . '.',
                'history_url' => inArrayR('Administrateur', $visitor->roles, 'role_name') ? '/branch/' . $branch->id : '/employee',
                'icon' => 'bi bi-building-check',
                'color' => 'primary',
                'type_id' => $activities_history_type->id,
                'user_id' => $visitor_id,
            ]);

            foreach ($request->users_ids as $usr):
                Notification::create([
                    'notification_url' => '/account',
                    'notification_content' => __('notifications.you_are_removed_branch', ['removed' => ($usr->gender == 'F' ? __('notifications.removed_feminine') : __('notifications.removed_masculine'))]) . $branch->branch_name . '.',
                    'icon' => 'bi bi-building-check',
                    'color' => 'primary',
                    'status_id' => $status_unread->id,
                    'user_id' => $usr->id,
                ]);    
            endforeach;
        }

        return $this->handleResponse(new ResourcesBranch($branch), __('notifications.update_branch_success'));
    }
}
