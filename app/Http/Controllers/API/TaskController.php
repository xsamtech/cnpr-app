<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use App\Models\History;
use App\Models\Notification;
use App\Models\Status;
use App\Models\Task;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\Task as ResourcesTask;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesTask::collection($tasks), __('notifications.find_all_tasks_success'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
        $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();
        // Get inputs
        $inputs = [
            'task_title' => $request->task_title,
            'task_content' => $request->task_content,
            'deadline' => $request->deadline,
            'performed_at' => $request->performed_at,
            'percentage_completed' => $request->percentage_completed,
            'user_id' => $request->user_id,
            'department_id' => $request->department_id
        ];

        // Validate required fields
        if ($inputs['task_title'] == null OR $inputs['task_title'] == ' ') {
            return $this->handleError($inputs['task_title'], __('validation.required'), 400);
        }

        if ($inputs['task_content'] == null OR $inputs['task_content'] == ' ') {
            return $this->handleError($inputs['task_content'], __('validation.required'), 400);
        }

        if ($inputs['deadline'] == null OR $inputs['deadline'] == ' ') {
            return $this->handleError($inputs['deadline'], __('validation.required'), 400);
        }

        if ($inputs['department_id'] == null AND $inputs['user_id'] == null) {
            return $this->handleError(__('validation.custom.owner.required'), 400);
        }

        if ($inputs['department_id'] == ' ' AND $inputs['user_id'] == null) {
            return $this->handleError(__('validation.custom.owner.required'), 400);
        }

        if ($inputs['department_id'] == null AND $inputs['user_id'] == ' ') {
            return $this->handleError(__('validation.custom.owner.required'), 400);
        }

        if ($inputs['department_id'] == ' ' AND $inputs['user_id'] == ' ') {
            return $this->handleError(__('validation.custom.owner.required'), 400);
        }

        $task = Task::create($inputs);

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        if ($inputs['user_id'] != null) {
            Notification::create([
                'notification_url' => '/tasks/' . $task->id,
                'notification_content' => __('notifications.departement_received_task'),
                'icon' => 'bi bi-stickies',
                'color' => 'primary',
                'status_id' => $status_unread->id,
                'user_id' => $task->user_id
            ]);
        }

        if ($inputs['department_id'] != null) {
            $departmet_chief = User::where([['department_id', $task->department_id], ['is_department_chief', 1]])->first();

            Notification::create([
                'notification_url' => '/tasks/' . $task->id,
                'notification_content' => __('notifications.departement_received_task'),
                'icon' => 'bi bi-stickies',
                'color' => 'primary',
                'status_id' => $status_unread->id,
                'user_id' => $departmet_chief->id
            ]);
        }

        return $this->handleResponse(new ResourcesTask($task), __('notifications.create_task_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);

        if (is_null($task)) {
            return $this->handleError(__('notifications.find_task_404'));
        }

        return $this->handleResponse(new ResourcesTask($task), __('notifications.find_task_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
        $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'task_title' => $request->task_title,
            'task_content' => $request->task_content,
            'deadline' => $request->deadline,
            'performed_at' => $request->performed_at,
            'percentage_completed' => $request->percentage_completed,
            'user_id' => $request->user_id,
            'department_id' => $request->department_id
        ];
        $current_task = Task::find($inputs['id']);

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        if ($current_task->user_id != null) {
            if ($current_task->user_id == $inputs['user_id']) {
                Notification::create([
                    'notification_url' => '/tasks/' . $task->id,
                    'notification_content' => __('notifications.your_task_changed'),
                    'icon' => 'bi bi-stickies',
                    'color' => 'primary',
                    'status_id' => $status_unread->id,
                    'user_id' => $current_task->user_id
                ]);
            }

            if ($current_task->user_id != $inputs['user_id']) {
                $new_owner_task = User::find($inputs['user_id']);

                Notification::create([
                    'notification_url' => '/tasks/' . $task->id,
                    'notification_content' => __('notifications.you_received_task'),
                    'icon' => 'bi bi-stickies',
                    'color' => 'primary',
                    'status_id' => $status_unread->id,
                    'user_id' => $new_owner_task->id
                ]);
                Notification::create([
                    'notification_url' => '/tasks',
                    'notification_content' => __('notifications.task_named') . strtoupper($current_task->task_title) . __('notifications.is_withdrawn_from_you_feminine'),
                    'icon' => 'bi bi-stickies',
                    'color' => 'primary',
                    'status_id' => $status_unread->id,
                    'user_id' => $current_task->user_id
                ]);
            }
        }

        if ($current_task->department_id != null) {
            if ($current_task->department_id == $inputs['department_id']) {
                $departmet_chief = User::where([['department_id', $current_task->department_id], ['is_department_chief', 1]])->first();

                Notification::create([
                    'notification_url' => '/tasks/' . $task->id,
                    'notification_content' => __('notifications.your_task_changed'),
                    'icon' => 'bi bi-stickies',
                    'color' => 'primary',
                    'status_id' => $status_unread->id,
                    'user_id' => $departmet_chief->id
                ]);
            }

            if ($current_task->department_id != $inputs['department_id']) {
                $new_departmet_chief = User::where([['department_id', $inputs['department_id']], ['is_department_chief', 1]])->first();

                Notification::create([
                    'notification_url' => '/tasks/' . $task->id,
                    'notification_content' => __('notifications.you_received_task'),
                    'icon' => 'bi bi-stickies',
                    'color' => 'primary',
                    'status_id' => $status_unread->id,
                    'user_id' => $new_departmet_chief->id
                ]);

                $former_departmet_chief = User::where([['department_id', $current_task->department_id], ['is_department_chief', 1]])->first();

                Notification::create([
                    'notification_url' => '/tasks',
                    'notification_content' => __('notifications.task_named') . strtoupper($current_task->task_title) . __('notifications.is_withdrawn_from_you_feminine'),
                    'icon' => 'bi bi-stickies',
                    'color' => 'primary',
                    'status_id' => $status_unread->id,
                    'user_id' => $former_departmet_chief->user_id
                ]);
            }
        }

        if ($inputs['task_title'] != null) {
            $task->update([
                'task_title' => $request->task_title,
                'updated_at' => now()
            ]);
        }

        if ($inputs['task_content'] != null) {
            $task->update([
                'task_content' => $request->task_content,
                'updated_at' => now()
            ]);
        }

        if ($inputs['deadline'] != null) {
            $task->update([
                'deadline' => $request->deadline,
                'updated_at' => now()
            ]);
        }

        if ($inputs['performed_at'] != null) {
            $task->update([
                'performed_at' => $request->performed_at,
                'updated_at' => now()
            ]);
        }

        if ($inputs['percentage_completed'] != null) {
            $task->update([
                'percentage_completed' => $request->percentage_completed,
                'updated_at' => now()
            ]);
        }

        if ($inputs['user_id'] != null) {
            $task->update([
                'user_id' => $request->user_id,
                'updated_at' => now()
            ]);
        }

        if ($inputs['department_id'] != null) {
            $task->update([
                'department_id' => $request->department_id,
                'updated_at' => now()
            ]);
        }

        return $this->handleResponse(new ResourcesTask($task), __('notifications.update_task_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        $tasks = Task::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesTask::collection($tasks), __('notifications.delete_task_success'));
    }

    // ==================================== CUSTOM METHODS ====================================
    /**
     * Search tasks having approximately a title or content.
     *
     * @param  string $data
     * @param  int $visitor_id
     * @return \Illuminate\Http\Response
     */
    public function search($data, $visitor_id)
    {
        $tasks = Task::where('task_title', 'LIKE', '%' . $data . '%')->orWhere('task_content', 'LIKE', '%' . $data . '%')->orderByDesc('created_at')->get();

        if (is_null($tasks)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $search_history_type = Type::where([['type_name', 'Historique de recherche'], ['group_id', $history_type_group->id]])->first();

        History::create([
            'history_content' => $data,
            'history_url' => '/search/task/?query=' . $data,
            'type_id' => $search_history_type->id,
            'user_id' => $visitor_id,
        ]);

        return $this->handleResponse(ResourcesTask::collection($tasks), __('notifications.find_all_tasks_success'));
    }

    /**
     * Find all tasks belonging to user
     *
     * @param  int $user_id
     * @return \Illuminate\Http\Response
     */
    public function findByUser($user_id)
    {
        $tasks = Task::where('user_id', $user_id)->orderByDesc('created_at')->get();

        if (is_null($tasks)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesTask::collection($tasks), __('notifications.find_all_tasks_success'));    
    }

    /**
     * Find all tasks belonging to department
     *
     * @param  int $department_id
     * @return \Illuminate\Http\Response
     */
    public function findByDepartment($department_id)
    {
        $tasks = Task::where('department_id', $department_id)->orderByDesc('created_at')->get();

        if (is_null($tasks)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        return $this->handleResponse(ResourcesTask::collection($tasks), __('notifications.find_all_tasks_success'));    
    }
}
