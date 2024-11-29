<?php

namespace App\Http\Controllers\API;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Resources\File as ResourcesFile;

/**
 * @author Xanders
 * @see https://www.xsam-tech.com
 */
class FileController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesFile::collection($files), __('notifications.find_all_files_success'));
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
            'file_name' => $request->file_name,
            'file_url' => $request->file_url,
            'type_id' => $request->type_id,
            'message_id' => $request->message_id
        ];
        // Select all files to check unique constraint
        $files = File::all();

        // Validate required fields
        if ($inputs['type_id'] == null OR $inputs['type_id'] == ' ') {
            return $this->handleError($inputs['type_id'], __('validation.required'), 400);
        }

        if ($inputs['file_url'] == null OR $inputs['file_url'] == ' ') {
            return $this->handleError($inputs['file_url'], __('validation.required'), 400);
        }

        // Check if file URL already exists
        foreach ($files as $another_file):
            if ($another_file->file_url == $inputs['file_url']) {
                return $this->handleError($inputs['file_url'], __('validation.custom.file_url.exists'), 400);
            }
        endforeach;

        $file = File::create($inputs);

        return $this->handleResponse(new ResourcesFile($file), __('notifications.create_file_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = File::find($id);

        if (is_null($file)) {
            return $this->handleError(__('notifications.find_file_404'));
        }

        return $this->handleResponse(new ResourcesFile($file), __('notifications.find_file_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'file_name' => $request->file_name,
            'file_url' => $request->file_url,
            'type_id' => $request->type_id,
            'message_id' => $request->message_id
        ];
        // Select all files and specific file to check unique constraint
        $files = File::all();
        $current_file = File::find($inputs['id']);

        if ($inputs['type_id'] == null OR $inputs['type_id'] == ' ') {
            return $this->handleError($inputs['type_id'], __('validation.required'), 400);
        }

        if ($inputs['file_url'] == null OR $inputs['file_url'] == ' ') {
            return $this->handleError($inputs['file_url'], __('validation.required'), 400);
        }

        foreach ($files as $another_file):
            if ($current_file->file_url != $inputs['file_url']) {
                if ($another_file->file_url == $inputs['file_url']) {
                    return $this->handleError($inputs['file_url'], __('validation.custom.file_url.exists'), 400);
                }
            }
        endforeach;

        if ($inputs['file_name'] != null) {
            $file->update([
                'file_name' => $request->file_name,
                'updated_at' => now()
            ]);
        }

        if ($inputs['file_url'] != null) {
            $file->update([
                'file_url' => $request->file_url,
                'updated_at' => now()
            ]);
        }

        return $this->handleResponse(new ResourcesFile($file), __('notifications.update_file_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $file->delete();

        $files = File::all();

        return $this->handleResponse(ResourcesFile::collection($files), __('notifications.delete_file_success'));
    }
}
