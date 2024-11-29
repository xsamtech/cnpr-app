<?php

namespace App\Http\Controllers\API;

use App\Models\Branch;
use App\Models\Department;
use App\Models\File;
use App\Models\Group;
use App\Models\History;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Role;
use App\Models\Status;
use App\Models\Type;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Message as ResourcesMessage;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class MessageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.find_all_messages_success'));
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
            'message_subject' => $request->message_subject,
            'message_content' => $request->message_content,
            'answered_for' => $request->answered_for,
            'readers_stack' => $request->readers_stack,
            'deleters_stack' => $request->deleters_stack,
            'type_id' => $request->type_id,
            'status_id' => $request->status_id,
            'user_id' => $request->user_id,
            'addressee_role_id' => $request->addressee_role_id,
            'addressee_branch_id' => $request->addressee_branch_id,
            'addressee_department_id' => $request->addressee_department_id,
            'addressee_user_id' => $request->addressee_user_id
        ];

        // Validate required fields
        if ($inputs['message_content'] == null OR $inputs['message_content'] == ' ') {
            return $this->handleError($inputs['message_content'], __('validation.required'), 400);
        }

        if ($inputs['type_id'] == null OR $inputs['type_id'] == ' ') {
            return $this->handleError($inputs['type_id'], __('validation.required'), 400);
        }

        if ($inputs['user_id'] == null OR $inputs['user_id'] == ' ') {
            return $this->handleError($inputs['user_id'], __('validation.required'), 400);
        }

        $message = Message::create($inputs);

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $message_type_group = Group::where('group_name', 'Type de message')->first();
        $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();
        $activities_history_type = Type::where([['type_name', 'Historique des activités'], ['group_id', $history_type_group->id]])->first();
        // Some data to send righteous history or notification
        $ordinary_message_type = Type::where([['type_name', 'Message ordinaire'], ['group_id', $message_type_group->id]])->first();
        $communique_type = Type::where([['type_name', 'Communiqué'], ['group_id', $message_type_group->id]])->first();
        $report_type = Type::where([['type_name', 'Rapport'], ['group_id', $message_type_group->id]])->first();
        $complaint_type = Type::where([['type_name', 'Plainte'], ['group_id', $message_type_group->id]])->first();
        $justification_type = Type::where([['type_name', 'Justification'], ['group_id', $message_type_group->id]])->first();
        $current_message_type = Type::find($inputs['type_id']);
        $message_sender = User::find($inputs['user_id']);

        if ($inputs['answered_for'] != null) {
            $originating_message = Message::find($inputs['answered_for']);
            $originating_message_sender = User::find($originating_message->user_id);

            History::create([
                'history_content' => ($message->type_id == $ordinary_message_type->id OR $message->type_id == $communique_type->id OR $message->type_id == $report_type->id ? __('notifications.you_answered_masculine') : __('notifications.you_answered_feminine')) . strtolower($current_message_type->type_name),
                'history_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                'icon' => 'bi bi-envelope',
                'color' => 'success',
                'type_id' => $activities_history_type->id,
                'user_id' => $message_sender->id,
            ]);

            if ($message->type_id != $ordinary_message_type->id AND $message->type_id != $justification_type->id) {
                if (inArrayR('Administrateur', $originating_message_sender->roles, 'role_name')) {
                    Notification::create([
                        'notification_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                        'notification_content' => $message_sender->firstname . ' ' . $message_sender->lastname . ($message->type_id == $ordinary_message_type->id OR $message->type_id == $communique_type->id OR $message->type_id == $report_type->id ? __('notifications.answered_masculine') : __('notifications.answered_feminine')) . strtolower($current_message_type->type_name),
                        'icon' => 'bi bi-envelope',
                        'color' => 'success',
                        'status_id' => $status_unread->id,
                        'user_id' => $originating_message->user_id,
                    ]);

                } else {
                    if (inArrayR('Administrateur', $message_sender->roles, 'role_name') AND !inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Employé', $message_sender->roles, 'role_name')) {
                        Notification::create([
                            'notification_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                            'notification_content' => ($message->type_id == $ordinary_message_type->id OR $message->type_id == $communique_type->id OR $message->type_id == $report_type->id ? __('notifications.admin_answered_masculine') : __('notifications.admin_answered_feminine')) . strtolower($current_message_type->type_name),
                            'icon' => 'bi bi-envelope',
                            'color' => 'success',
                            'status_id' => $status_unread->id,
                            'user_id' => $originating_message->user_id,
                        ]);
                    }

                    if (inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Administrateur', $message_sender->roles, 'role_name') AND !inArrayR('Employé', $message_sender->roles, 'role_name')) {
                        Notification::create([
                            'notification_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                            'notification_content' => ($message->type_id == $ordinary_message_type->id OR $message->type_id == $communique_type->id OR $message->type_id == $report_type->id ? __('notifications.manager_answered_masculine') : __('notifications.manager_answered_feminine')) . strtolower($current_message_type->type_name),
                            'icon' => 'bi bi-envelope',
                            'color' => 'success',
                            'status_id' => $status_unread->id,
                            'user_id' => $originating_message->user_id,
                        ]);
                    }

                    if (inArrayR('Employé', $message_sender->roles, 'role_name') AND !inArrayR('Administrateur', $message_sender->roles, 'role_name') AND !inArrayR('Manager', $message_sender->roles, 'role_name')) {
                        Notification::create([
                            'notification_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                            'notification_content' => $message_sender->firstname . ' ' . $message_sender->lastname . ($message->type_id == $ordinary_message_type->id OR $message->type_id == $communique_type->id OR $message->type_id == $report_type->id ? __('notifications.answered_masculine') : __('notifications.answered_feminine')) . strtolower($current_message_type->type_name),
                            'icon' => 'bi bi-envelope',
                            'color' => 'success',
                            'status_id' => $status_unread->id,
                            'user_id' => $originating_message->user_id,
                        ]);
                    }
                }
            }

        } else {
            History::create([
                'history_content' => __('notifications.you_sent') . ($message->type_id == $ordinary_message_type->id OR $message->type_id == $communique_type->id OR $message->type_id == $report_type->id ? __('miscellaneous.a_masculine') : __('miscellaneous.a_feminine')) . strtolower($current_message_type->type_name),
                'history_url' => '/messages/' . $message->id,
                'icon' => 'bi bi-envelope',
                'color' => 'success',
                'type_id' => $activities_history_type->id,
                'user_id' => $message_sender->id,
            ]);

            if ($message->type_id != $ordinary_message_type->id AND $message->type_id != $justification_type->id) {
                if ($inputs['addressee_role_id'] != null) {
                    $addressee_role = Role::find($inputs['addressee_role_id']);

                    // If addressee role name is "Administrateur", just send notification to all users having that role
                    if ($addressee_role->role_name == 'Administrateur') {
                        $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                        $query->where('id', $addressee_role->id);
                                                    })->get();

                        foreach ($addressees as $addressee) {
                            Notification::create([
                                'notification_url' => '/messages/' . $message->id,
                                'notification_content' => $message_sender->firstname . ' ' . $message_sender->lastname . __('notifications.sent') . ($message->type_id == $complaint_type->id ? __('miscellaneous.a_feminine') : __('miscellaneous.a_masculine')) . strtolower($current_message_type->type_name),
                                'icon' => 'bi bi-envelope',
                                'color' => 'success',
                                'status_id' => $status_unread->id,
                                'user_id' => $addressee->id,
                            ]);
                        }
                    }

                    // If addressee role name is "Manager", send notification to all users having that role 
                    // and belonging to the same branch that the sender.
                    if ($addressee_role->role_name == 'Manager') {
                        if (inArrayR('Administrateur', $message_sender->roles, 'role_name') AND !inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Employé', $message_sender->roles, 'role_name')) {
                            $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                            $query->where('id', $addressee_role->id);
                                                        })->get();

                            foreach ($addressees as $addressee) {
                                Notification::create([
                                    'notification_url' => '/messages/' . $message->id,
                                    'notification_content' => __('miscellaneous.admin_sent_message'),
                                    'icon' => 'bi bi-envelope',
                                    'color' => 'success',
                                    'status_id' => $status_unread->id,
                                    'user_id' => $addressee->id,
                                ]);
                            }

                        }

                        if (inArrayR('Employé', $message_sender->roles, 'role_name') AND !inArrayR('Manager', $message_sender->roles, 'role_name')) {
                            foreach ($message_sender->branches as $branch) {
                                $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                                $query->where('id', $addressee_role->id);
                                                            })
                                                    ->whereHas('branches', function ($query) use ($branch) {
                                                                $query->where('id', $branch->id);
                                                            })->get();

                                foreach ($addressees as $addressee) {
                                    Notification::create([
                                        'notification_url' => '/messages/' . $message->id,
                                        'notification_content' => $message_sender->firstname . ' ' . $message_sender->lastname . __('notifications.sent') . ($message->type_id == $report_type->id ? __('miscellaneous.a_masculine') : __('miscellaneous.a_feminine')) . strtolower($current_message_type->type_name),
                                        'icon' => 'bi bi-envelope',
                                        'color' => 'success',
                                        'status_id' => $status_unread->id,
                                        'user_id' => $addressee->id,
                                    ]);
                                }
                            }
                        }
                    }

                    // If addressee role name is "Employé", send notification to all users having that role 
                    // and belonging to the same branch that the sender.
                    if ($addressee_role->role_name == 'Employé') {
                        if (inArrayR('Administrateur', $message_sender->roles, 'role_name') AND !inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Employé', $message_sender->roles, 'role_name')) {
                            $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                            $query->where('id', $addressee_role->id);
                                                        })->get();

                            foreach ($addressees as $addressee) {
                                Notification::create([
                                    'notification_url' => '/messages/' . $message->id,
                                    'notification_content' => __('notifications.admin_sent_message'),
                                    'icon' => 'bi bi-envelope',
                                    'color' => 'success',
                                    'status_id' => $status_unread->id,
                                    'user_id' => $addressee->id,
                                ]);
                            }
                        }

                        if (inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Administrateur', $message_sender->roles, 'role_name') AND !inArrayR('Employé', $message_sender->roles, 'role_name')) {
                            foreach ($message_sender->branches as $branch) {
                                $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                                $query->where('id', $addressee_role->id);
                                                            })
                                                    ->whereHas('branches', function ($query) use ($branch) {
                                                                $query->where('id', $branch->id);
                                                            })->get();

                                foreach ($addressees as $addressee) {
                                    Notification::create([
                                        'notification_url' => '/messages/' . $message->id,
                                        'notification_content' => __('notifications.manager_sent') . ($message->type_id == $communique_type->id ? __('miscellaneous.a_masculine') : __('miscellaneous.a_feminine')) . strtolower($current_message_type->type_name),
                                        'icon' => 'bi bi-envelope',
                                        'color' => 'success',
                                        'status_id' => $status_unread->id,
                                        'user_id' => $addressee->id,
                                    ]);
                                }
                            }
                        }
                    }
                }

                if ($inputs['addressee_branch_id'] != null) {
                    $addressee_branch = Branch::find($inputs['addressee_branch_id']);

                    if (is_null($addressee_branch)) {
                        return $this->handleError(__('notifications.find_branch_404'));
                    }

                    $addressees = User::whereHas('branches', function ($query) use ($addressee_branch) {
                                                    $query->where('id', $addressee_branch->id);
                                                })->get();

                    if (inArrayR('Administrateur', $message_sender->roles, 'role_name') AND !inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Employé', $message_sender->roles, 'role_name')) {
                        foreach ($addressees as $addressee) {
                            Notification::create([
                                'notification_url' => '/messages/' . $message->id,
                                'notification_content' => __('notifications.admin_sent_message'),
                                'icon' => 'bi bi-envelope',
                                'color' => 'success',
                                'status_id' => $status_unread->id,
                                'user_id' => $addressee->id,
                            ]);
                        }
                    }

                    if (inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Administrateur', $message_sender->roles, 'role_name') AND !inArrayR('Employé', $message_sender->roles, 'role_name')) {
                        foreach ($addressees as $addressee) {
                            Notification::create([
                                'notification_url' => '/messages/' . $message->id,
                                'notification_content' => __('notifications.manager_sent') . ($message->type_id == $communique_type->id ? __('miscellaneous.a_masculine') : __('miscellaneous.a_feminine')) . strtolower($current_message_type->type_name),
                                'icon' => 'bi bi-envelope',
                                'color' => 'success',
                                'status_id' => $status_unread->id,
                                'user_id' => $addressee->id,
                            ]);
                        }
                    }
                }

                if ($inputs['addressee_department_id'] != null) {
                    $addressee_department = Department::find($inputs['addressee_department_id']);

                    if (is_null($addressee_department)) {
                        return $this->handleError(__('notifications.find_department_404'));
                    }

                    $addressees = User::where('department_id', $addressee_department->id)->get();

                    if (inArrayR('Administrateur', $message_sender->roles, 'role_name') AND !inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Employé', $message_sender->roles, 'role_name')) {
                        foreach ($addressees as $addressee) {
                            Notification::create([
                                'notification_url' => '/messages/' . $message->id,
                                'notification_content' => __('notifications.admin_sent_message'),
                                'icon' => 'bi bi-envelope',
                                'color' => 'success',
                                'status_id' => $status_unread->id,
                                'user_id' => $addressee->id,
                            ]);
                        }
                    }

                    if (inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Administrateur', $message_sender->roles, 'role_name') AND !inArrayR('Employé', $message_sender->roles, 'role_name')) {
                        foreach ($addressees as $addressee) {
                            Notification::create([
                                'notification_url' => '/messages/' . $message->id,
                                'notification_content' => __('notifications.manager_sent') . ($message->type_id == $communique_type->id ? __('miscellaneous.a_masculine') : __('miscellaneous.a_feminine')) . strtolower($current_message_type->type_name),
                                'icon' => 'bi bi-envelope',
                                'color' => 'success',
                                'status_id' => $status_unread->id,
                                'user_id' => $addressee->id,
                            ]);
                        }
                    }
                }
            }
        }

        return $this->handleResponse(new ResourcesMessage($message), __('notifications.create_message_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = Message::find($id);

        if (is_null($message)) {
            return $this->handleError(__('notifications.find_message_404'));
        }

        return $this->handleResponse(new ResourcesMessage($message), __('notifications.find_message_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'message_subject' => $request->message_subject,
            'message_content' => $request->message_content,
            'answered_for' => $request->answered_for,
            'readers_stack' => $request->readers_stack,
            'deleters_stack' => $request->deleters_stack,
            'type_id' => $request->type_id,
            'status_id' => $request->status_id,
            'user_id' => $request->user_id,
            'addressee_role_id' => $request->addressee_role_id,
            'addressee_branch_id' => $request->addressee_branch_id,
            'addressee_department_id' => $request->addressee_department_id,
            'addressee_user_id' => $request->addressee_user_id
        ];

        if ($inputs['message_subject'] != null) {
            $message->update([
                'message_subject' => $request->message_subject,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['message_content'] != null) {
            $message->update([
                'message_content' => $request->message_content,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['readers_stack'] != null) {
            $message->update([
                'readers_stack' => $request->readers_stack,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['deleters_stack'] != null) {
            $message->update([
                'deleters_stack' => $request->deleters_stack,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['type_id'] != null) {
            $message->update([
                'type_id' => $request->type_id,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['status_id'] != null) {
            $message->update([
                'status_id' => $request->status_id,
                'updated_at' => now(),
            ]);
        }

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $message_type_group = Group::where('group_name', 'Type de message')->first();
        $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();
        $activities_history_type = Type::where([['type_name', 'Historique des activités'], ['group_id', $history_type_group->id]])->first();
        // Some data to send righteous history or notification
        $ordinary_message_type = Type::where([['type_name', 'Message ordinaire'], ['group_id', $message_type_group->id]])->first();
        $communique_type = Type::where([['type_name', 'Communiqué'], ['group_id', $message_type_group->id]])->first();
        $report_type = Type::where([['type_name', 'Rapport'], ['group_id', $message_type_group->id]])->first();
        $complaint_type = Type::where([['type_name', 'Plainte'], ['group_id', $message_type_group->id]])->first();
        $current_message_type = Type::find($inputs['type_id']);
        $message_sender = User::find($inputs['user_id']);

        History::create([
            'history_content' => __('notifications.you_changed') . ($message->type_id == $ordinary_message_type->id OR $message->type_id == $communique_type->id OR $message->type_id == $report_type->id ? __('miscellaneous.a_masculine') : __('miscellaneous.a_feminine')) . strtolower($current_message_type->type_name),
            'history_url' => '/messages/' . $message->id,
            'icon' => 'bi bi-envelope',
            'color' => 'success',
            'type_id' => $activities_history_type->id,
            'user_id' => $message_sender->id,
        ]);

        if ($inputs['answered_for'] != null) {
            $message->update([
                'answered_for' => $request->answered_for,
                'updated_at' => now(),
            ]);

            if ($message->type_id != $ordinary_message_type->id) {
                $originating_message = Message::find($inputs['answered_for']);
                $originating_message_sender = User::find($originating_message->user_id);

                if ($originating_message_sender->addressee_role_id != null) {
                    $addressee_role = Role::find($originating_message_sender->addressee_role_id);

                    if ($addressee_role->role_name == 'Administrateur') {
                        $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                        $query->where('id', $addressee_role->id);
                                                    })->get();

                        foreach ($addressees as $addressee) {
                            Notification::create([
                                'notification_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                                'notification_content' => $message_sender->firstname . ' ' . $message_sender->lastname . __('notifications.changed_answer'),
                                'icon' => 'bi bi-envelope',
                                'color' => 'success',
                                'status_id' => $status_unread->id,
                                'user_id' => $addressee->user_id,
                            ]);
                        }
                    }

                    if ($addressee_role->role_name == 'Manager') {
                        if (inArrayR('Administrateur', $message_sender->roles, 'role_name') AND !inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Employé', $message_sender->roles, 'role_name')) {
                            $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                            $query->where('id', $addressee_role->id);
                                                        })->get();

                            foreach ($addressees as $addressee) {
                                Notification::create([
                                    'notification_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                                    'notification_content' => __('notifications.admin_changed_answer'),
                                    'icon' => 'bi bi-envelope',
                                    'color' => 'success',
                                    'status_id' => $status_unread->id,
                                    'user_id' => $addressee->user_id,
                                ]);
                            }
                        }

                        if (inArrayR('Employé', $message_sender->roles, 'role_name') AND !inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Administrateur', $message_sender->roles, 'role_name')) {
                            foreach ($message_sender->branches as $branch) {
                                $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                                $query->where('id', $addressee_role->id);
                                                            })
                                                    ->whereHas('branches', function ($query) use ($branch) {
                                                                $query->where('id', $branch->id);
                                                            })->get();

                                foreach ($addressees as $addressee) {
                                    Notification::create([
                                        'notification_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                                        'notification_content' => $message_sender->firstname . ' ' . $message_sender->lastname . __('notifications.changed_answer'),
                                        'icon' => 'bi bi-envelope',
                                        'color' => 'success',
                                        'status_id' => $status_unread->id,
                                        'user_id' => $addressee->user_id,
                                    ]);
                                }
                            }
                        }
                    }

                    if ($addressee_role->role_name == 'Employé') {
                        if (inArrayR('Administrateur', $message_sender->roles, 'role_name') AND !inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Employé', $message_sender->roles, 'role_name')) {
                            $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                            $query->where('id', $addressee_role->id);
                                                        })->get();

                            foreach ($addressees as $addressee) {
                                Notification::create([
                                    'notification_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                                    'notification_content' => __('notifications.admin_changed_answer'),
                                    'icon' => 'bi bi-envelope',
                                    'color' => 'success',
                                    'status_id' => $status_unread->id,
                                    'user_id' => $addressee->user_id,
                                ]);
                            }
                        }

                        if (inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Employé', $message_sender->roles, 'role_name') AND !inArrayR('Administrateur', $message_sender->roles, 'role_name')) {
                            foreach ($message_sender->branches as $branch) {
                                $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                                $query->where('id', $addressee_role->id);
                                                            })
                                                    ->whereHas('branches', function ($query) use ($branch) {
                                                                $query->where('id', $branch->id);
                                                            })->get();

                                foreach ($addressees as $addressee) {
                                    Notification::create([
                                        'notification_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                                        'notification_content' => __('notifications.manager_changed_answer'),
                                        'icon' => 'bi bi-envelope',
                                        'color' => 'success',
                                        'status_id' => $status_unread->id,
                                        'user_id' => $addressee->user_id,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($inputs['answered_for'] == null) {
            if ($message->type_id != $ordinary_message_type->id) {
                $originating_message = Message::find($inputs['answered_for']);
                $originating_message_sender = User::find($originating_message->user_id);

                if ($originating_message_sender->addressee_role_id != null) {
                    $addressee_role = Role::find($originating_message_sender->addressee_role_id);

                    if ($addressee_role->role_name == 'Administrateur') {
                        $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                        $query->where('id', $addressee_role->id);
                                                    })->get();

                        foreach ($addressees as $addressee) {
                            Notification::create([
                                'notification_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                                'notification_content' => $message_sender->firstname . ' ' . $message_sender->lastname . __('notifications.changed') . ($message->type_id == $complaint_type->id ? __('miscellaneous.a_feminine') : __('miscellaneous.a_masculine')) . strtolower($current_message_type->type_name),
                                'icon' => 'bi bi-envelope',
                                'color' => 'success',
                                'status_id' => $status_unread->id,
                                'user_id' => $addressee->user_id,
                            ]);
                        }
                    }

                    if ($addressee_role->role_name == 'Manager') {
                        if (inArrayR('Administrateur', $message_sender->roles, 'role_name') AND !inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Employé', $message_sender->roles, 'role_name')) {
                            $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                            $query->where('id', $addressee_role->id);
                                                        })->get();

                            foreach ($addressees as $addressee) {
                                Notification::create([
                                    'notification_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                                    'notification_content' => __('notifications.admin_changed_message'),
                                    'icon' => 'bi bi-envelope',
                                    'color' => 'success',
                                    'status_id' => $status_unread->id,
                                    'user_id' => $addressee->user_id,
                                ]);
                            }
                        }

                        if (inArrayR('Employé', $message_sender->roles, 'role_name') AND !inArrayR('Manager', $message_sender->roles, 'role_name') AND !inArrayR('Administrateur', $message_sender->roles, 'role_name')) {
                            foreach ($message_sender->branches as $branch) {
                                $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                                $query->where('id', $addressee_role->id);
                                                            })
                                                    ->whereHas('branches', function ($query) use ($branch) {
                                                                $query->where('id', $branch->id);
                                                            })->get();

                                foreach ($addressees as $addressee) {
                                    Notification::create([
                                        'notification_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                                        'notification_content' => $message_sender->firstname . ' ' . $message_sender->lastname . __('notifications.changed') . ($message->type_id == $ordinary_message_type->id OR $message->type_id == $communique_type->id OR $message->type_id == $report_type->id ? __('miscellaneous.a_masculine') : __('miscellaneous.a_feminine')) . strtolower($current_message_type->type_name),
                                        'icon' => 'bi bi-envelope',
                                        'color' => 'success',
                                        'status_id' => $status_unread->id,
                                        'user_id' => $addressee->user_id,
                                    ]);
                                }
                            }
                        }
                    }

                    if ($addressee_role->role_name == 'Employé') {
                        if (inArrayR('Administrateur', $message_sender->roles, 'role_name')) {
                            $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                            $query->where('id', $addressee_role->id);
                                                        })->get();

                            foreach ($addressees as $addressee) {
                                Notification::create([
                                    'notification_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                                    'notification_content' => __('notifications.admin_changed_answer'),
                                    'icon' => 'bi bi-envelope',
                                    'color' => 'success',
                                    'status_id' => $status_unread->id,
                                    'user_id' => $addressee->user_id,
                                ]);
                            }
                        }

                        if (inArrayR('Manager', $message_sender->roles, 'role_name')) {
                            foreach ($message_sender->branches as $branch) {
                                $addressees = User::whereHas('roles', function ($query) use ($addressee_role) {
                                                                $query->where('id', $addressee_role->id);
                                                            })
                                                    ->whereHas('branches', function ($query) use ($branch) {
                                                                $query->where('id', $branch->id);
                                                            })->get();

                                foreach ($addressees as $addressee) {
                                    Notification::create([
                                        'notification_url' => '/messages/' . $originating_message->id . '?answer_id=' . $message->id,
                                        'notification_content' => __('notifications.manager_changed_answer'),
                                        'icon' => 'bi bi-envelope',
                                        'color' => 'success',
                                        'status_id' => $status_unread->id,
                                        'user_id' => $addressee->user_id,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }

        return $this->handleResponse(new ResourcesMessage($message), __('notifications.update_message_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();

        $messages = Message::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.delete_message_success'));
    }

    // ==================================== CUSTOM METHODS ====================================
    /**
     * Search a message by its content.
     *
     * @param  string $data
     * @param  int $visitor_id
     * @param  string $type_name
     * @return \Illuminate\Http\Response
     */
    public function search($data, $visitor_id, $type_name)
    {
        $type = Type::where('type_name', $type_name)->first();

        if (is_null($type)) {
            return $this->handleError(__('notifications.find_type_404'));
        }

        $messages = Message::where([['message_content', 'LIKE', '%' . $data . '%'], ['type_id', $type->id]])->get();

        if (is_null($messages)) {
            return $this->handleResponse(null, __('miscellaneous.empty_list'));
        }

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $search_history_type = Type::where([['type_name', 'Historique de recherche'], ['group_id', $history_type_group->id]])->first();

        History::create([
            'history_content' => $data,
            'history_url' => '/search/message/?type_name=' . $type_name . '&query=' . $data,
            'type_id' => $search_history_type->id,
            'user_id' => $visitor_id,
        ]);

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.find_all_messages_success'));
    }

    /**
     * GET: Display all user received messages.
     *
     * @param  string $type_name
     * @param  int $user_id
     * @return \Illuminate\Http\Response
     */
    public function chatUser($type_name, $addressee_user_id)
    {
        $type = Type::where('type_name', $type_name)->first();

        if (is_null($type)) {
            return $this->handleError(__('notifications.find_type_404'));
        }

        $messages = Message::where([['type_id', $type->id], ['addressee_user_id', $addressee_user_id]])->get();

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.find_all_messages_success'));
    }

    /**
     * GET: Display all role received messages.
     *
     * @param  string $type_name
     * @param  string $addressee_role_name
     * @return \Illuminate\Http\Response
     */
    public function chatRole($type_name, $addressee_role_name)
    {
        $type = Type::where('type_name', $type_name)->first();
        $role = Role::where('role_name', $addressee_role_name)->first();

        if (is_null($type)) {
            return $this->handleError(__('notifications.find_type_404'));
        }

        if (is_null($role)) {
            return $this->handleError(__('notifications.find_role_404'));
        }

        $messages = Message::where([['type_id', $type->id], ['addressee_role_id', $role->id]])->get();

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.find_all_messages_success'));
    }

    /**
     * GET: Display all branch received messages.
     *
     * @param  string $type_name
     * @param  string $addressee_branch_id
     * @return \Illuminate\Http\Response
     */
    public function chatBranch($type_name, $addressee_branch_id)
    {
        $type = Type::where('type_name', $type_name)->first();
        $branch = Branch::find($addressee_branch_id);

        if (is_null($type)) {
            return $this->handleError(__('notifications.find_type_404'));
        }

        if (is_null($branch)) {
            return $this->handleError(__('notifications.find_branch_404'));
        }

        $messages = Message::where([['type_id', $type->id], ['addressee_branch_id', $branch->id]])->get();

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.find_all_messages_success'));
    }

    /**
     * GET: Display all department received messages.
     *
     * @param  string $type_name
     * @param  string $addressee_department_id
     * @return \Illuminate\Http\Response
     */
    public function chatDepartment($type_name, $addressee_department_id)
    {
        $type = Type::where('type_name', $type_name)->first();
        $department = Department::find($addressee_department_id);

        if (is_null($type)) {
            return $this->handleError(__('notifications.find_type_404'));
        }

        if (is_null($department)) {
            return $this->handleError(__('notifications.find_department_404'));
        }

        $messages = Message::where([['type_id', $type->id], ['addressee_department_id', $department->id]])->get();

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.find_all_messages_success'));
    }

    /**
     * GET: Display all messages answered for a specific message.
     *
     * @param  $message_id
     * @return \Illuminate\Http\Response
     */
    public function answers($message_id)
    {
        $messages = Message::where('answered_for', $message_id)->get();

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.find_all_messages_success'));
    }

    /**
     * Switch between notification statuses.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function switchStatus($id)
    {
        $message_status_group = Group::where('group_name', 'Etat du message')->first();
        $status_read = Status::where([['status_name', 'Lu'], ['group_id', $message_status_group->id]])->first();
        $status_unread = Status::where([['status_name', 'Non lu'], ['group_id', $message_status_group->id]])->first();
        $message = Message::find($id);

        // update "status_id" column
        if ($message->status_id == $status_unread->id) {
            $message->update([
                'status_id' => $status_read->id,
                'updated_at' => now()
            ]);

        } else {
            $message->update([
                'status_id' => $status_unread->id,
                'updated_at' => now()
            ]);
        }

        return $this->handleResponse(new ResourcesMessage($message), __('notifications.find_message_success'));
    }

    /**
     * GET: Display all messages answered for a specific message.
     *
     * @param  $message_id
     * @return \Illuminate\Http\Response
     */
    public function markAllRead($message_id)
    {
        $message_status_group = Group::where('group_name', 'Etat du message')->first();
        $status_read = Status::where([['status_name', 'Lu'], ['group_id', $message_status_group->id]])->first();
        $status_unread = Status::where([['status_name', 'Non lu'], ['group_id', $message_status_group->id]])->first();
        $messages = Message::where([['answered_for', $message_id], ['status_id', $status_unread->id]])->get();

        foreach ($messages as $message) {
            // update "status_id"
            $message->update([
                'status_id' => $status_read->id,
                'updated_at' => now()
            ]);
        }

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.find_all_messages_success'));
    }

    /**
     * Upload message documents in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadDoc(Request $request, $id)
    {
        $inputs = [
            'file_name' => $request->file_name,
            'message_id' => $request->message_id,
            'document' => $request->file('document'),
            'extension' => $request->file('document')->extension()
        ];
        // Validate file mime type
        $validator = Validator::make($inputs, [
            'document' => 'required|mimes:txt,pdf,doc,docx,xls,xlsx,ppt,pptx,pps,ppsx'
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());       
        }

        // Current message
		$message = Message::find($id);

        if (is_null($message)) {
            return $this->handleError(__('notifications.find_message_404'));
        }

        // Create file name
		$file_name = 'documents/messages/' . $inputs['message_id'] . '/' . Str::random(50) . '.' . $inputs['extension'];

		// Upload file
		Storage::url(Storage::disk('public')->put($file_name, $inputs['audio']));

		// Find type by name to get its ID
        $file_type_group = Group::where('group_name', 'Type de fichier')->first();
		$document_type = Type::where([['type_name', 'Document'], ['group_id', $file_type_group->id]])->first();

        File::create([
            'file_content' => $inputs['file_name'],
            'file_url' => '/' . $file_name,
            'type_id' => $document_type->id,
            'message_id' => $message->id
        ]);

        return $this->handleResponse(new ResourcesMessage($message), __('notifications.update_message_success'));
    }

    /**
     * Upload message audio in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadAudio(Request $request, $id)
    {
        $inputs = [
            'file_name' => $request->file_name,
            'message_id' => $request->message_id,
            'audio' => $request->file('audio'),
            'extension' => $request->file('audio')->extension()
        ];
        // Validate file mime type
        $validator = Validator::make($inputs, [
            'audio' => 'required|mimes:mp3,wav,m4a,mid,midi,oga,opus,weba,aac'
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());       
        }

        // Current message
		$message = Message::find($id);

        if (is_null($message)) {
            return $this->handleError(__('notifications.find_message_404'));
        }

        // Create file name
		$file_name = 'audios/messages/' . $inputs['message_id'] . '/' . Str::random(50) . '.' . $inputs['extension'];

		// Upload file
		Storage::url(Storage::disk('public')->put($file_name, $inputs['audio']));

		// Find type by name to get its ID
        $file_type_group = Group::where('group_name', 'Type de fichier')->first();
		$audio_type = Type::where([['type_name', 'Audio'], ['group_id', $file_type_group->id]])->first();

        File::create([
            'file_content' => $inputs['file_name'],
            'file_url' => '/' . $file_name,
            'type_id' => $audio_type->id,
            'message_id' => $message->id
        ]);

        return $this->handleResponse(new ResourcesMessage($message), __('notifications.update_message_success'));
    }

    /**
     * Upload message video in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadVideo(Request $request, $id)
    {
        $inputs = [
            'file_name' => $request->file_name,
            'message_id' => $request->message_id,
            'video' => $request->file('video'),
            'extension' => $request->file('video')->extension()
        ];
        // Validate file mime type
        $validator = Validator::make($inputs, [
            'video' => 'required|mimes:avi,mp4,mpeg,ogg,ts,webm,3gp,3g2'
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());       
        }

        // Current message
		$message = Message::find($id);

        if (is_null($message)) {
            return $this->handleError(__('notifications.find_message_404'));
        }

        // Create file name
		$file_name = 'images/messages/' . $inputs['message_id'] . '/' . Str::random(50) . '.' . $inputs['extension'];

		// Upload file
		Storage::url(Storage::disk('public')->put($file_name, $inputs['video']));

		// Find type by name to get its ID
        $file_type_group = Group::where('group_name', 'Type de fichier')->first();
		$video_type = Type::where([['type_name', 'Vidéo'], ['group_id', $file_type_group->id]])->first();

        File::create([
            'file_content' => $inputs['file_name'],
            'file_url' => '/' . $file_name,
            'type_id' => $video_type->id,
            'message_id' => $message->id
        ]);

        return $this->handleResponse(new ResourcesMessage($message), __('notifications.update_message_success'));
    }

    /**
     * Update message picture in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadImage(Request $request, $id)
    {
        $inputs = [
            'file_name' => $request->file_name,
            'message_id' => $request->entity_id,
            'image_64' => $request->base64image
        ];
        $replace = substr($inputs['image_64'], 0, strpos($inputs['image_64'], ',') + 1);
        // Find substring from replace here eg: data:image/png;base64,
        $image = str_replace($replace, '', $inputs['image_64']);
        $image = str_replace(' ', '+', $image);
        // Current message
		$message = Message::find($id);

        if (is_null($message)) {
            return $this->handleError(__('notifications.find_message_404'));
        }

		// Create file URL
		$file_name = 'images/messages/' . $inputs['message_id'] . '/' . Str::random(50) . '.png';

		// Upload file
		Storage::url(Storage::disk('public')->put($file_name, base64_decode($image)));

		// Find type by name to get its ID
        $file_type_group = Group::where('group_name', 'Type de fichier')->first();
		$photo_type = Type::where([['type_name', 'Photo'], ['group_id', $file_type_group->id]])->first();

        File::create([
            'file_content' => $inputs['file_name'],
            'file_url' => '/' . $file_name,
            'type_id' => $photo_type->id,
            'message_id' => $message->id
        ]);

        return $this->handleResponse(new ResourcesMessage($message), __('notifications.update_message_success'));
	}
}
