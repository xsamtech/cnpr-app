<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use App\Models\Notification;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Notification as ResourcesNotification;

/**
 * @author Xanders
 * @see https://www.xsam-tech.com
 */
class NotificationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesNotification::collection($notifications), __('notifications.find_all_notifications_success'));
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
            'notification_url' => $request->notification_url,
            'notification_content' => $request->notification_content,
            'icon' => $request->icon,
            'color' => $request->color,
            'status_id' => $status_unread->id,
            'user_id' => $request->user_id
        ];

        $validator = Validator::make($inputs, [
            'notification_url' => ['required'],
            'notification_content' => ['required'],
            'status_id' => ['required'],
            'user_id' => ['required']
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());       
        }

        $notification = Notification::create($inputs);

        return $this->handleResponse(new ResourcesNotification($notification), __('notifications.create_notification_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = Notification::find($id);

        if (is_null($notification)) {
            return $this->handleError(__('notifications.find_notification_404'));
        }

        return $this->handleResponse(new ResourcesNotification($notification), __('notifications.find_notification_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'notification_url' => $request->notification_url,
            'notification_content' => $request->notification_content,
            'icon' => $request->icon,
            'color' => $request->color,
            'status_id' => $request->status_id,
            'user_id' => $request->user_id,
            'updated_at' => now()
        ];

        $validator = Validator::make($inputs, [
            'notification_url' => ['required'],
            'notification_content' => ['required'],
            'status_id' => ['required'],
            'user_id' => ['required']
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());       
        }

        $notification->update($inputs);

        return $this->handleResponse(new ResourcesNotification($notification), __('notifications.update_notification_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        $notifications = Notification::all();

        return $this->handleResponse(ResourcesNotification::collection($notifications), __('notifications.delete_notification_success'));
    }

    // ==================================== CUSTOM METHODS ====================================
    /**
     * Select all user notifications.
     *
     * @param  $user_id
     * @return \Illuminate\Http\Response
     */
    public function selectByUser($user_id)
    {
        $notifications = Notification::where('user_id', $user_id)->orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesNotification::collection($notifications), __('notifications.find_all_notifications_success'));
    }

    /**
     * Select all user unread notifications.
     *
     * @param  $user_id
     * @return \Illuminate\Http\Response
     */
    public function selectUnreadByUser($user_id)
    {
        $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
        $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();
        $notifications = Notification::where([['user_id', $user_id], ['status_id', $status_unread->id]])->orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesNotification::collection($notifications), __('notifications.find_all_notifications_success'));
    }

    /**
     * Switch between notification statuses.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function switchStatus($id)
    {
        $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
        $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();
        $status_read = Status::where([['status_name', 'Lue'], ['group_id', $notif_status_group->id]])->first();
        $notification = Notification::find($id);

        // update "status_id" column
        if ($notification->status_id == $status_unread->id) {
            $notification->update([
                'status_id' => $status_read->id,
                'updated_at' => now()
            ]);

        } else {
            $notification->update([
                'status_id' => $status_unread->id,
                'updated_at' => now()
            ]);
        }

        return $this->handleResponse(new ResourcesNotification($notification), __('notifications.find_notification_success'));
    }

    /**
     * Set user notifications status to "Lue".
     *
     * @param  $user_id
     * @return \Illuminate\Http\Response
     */
    public function markAllRead($user_id)
    {
        $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
        $status_read = Status::where([['status_name', 'Lue'], ['group_id', $notif_status_group->id]])->first();
        $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();
        $notifications = Notification::where([['user_id', $user_id], ['status_id', $status_unread->id]])->get();

        foreach ($notifications as $notification):
            // update "status_id"
            $notification->update([
                'status_id' => $status_read->id,
                'updated_at' => now()
            ]);
        endforeach;

        return $this->handleResponse(new ResourcesNotification($notification), __('notifications.find_notification_success'));
    }
}
