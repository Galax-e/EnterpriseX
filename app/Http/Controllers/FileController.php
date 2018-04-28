<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    //
    public function add_file()
    {
        $uploaded_images = array();
        foreach($_FILES['upload_images']['name'] as $key=>$val)
        {
            $upload_dir = "files/";
            $upload_file = $upload_dir.time().$_FILES['upload_images']['name'][$key];
            if(move_uploaded_file($_FILES['upload_images']['tmp_name'][$key],$upload_file))
            {
                $upload = new Document;
                $upload->teamid = Input::get('team_id');
                $upload->file_name = Input::get('file_name');
                $upload->file = time().$_FILES['upload_images']['name'][$key];
                $upload->uploaded_by = Auth::user()->id;
                $upload->save();
                
                $activity = new Activity;
                $activity->teamid = Input::get('teamid');
                $activity->title = 'Added new file';
                $activity->comment = Auth::user()->name.' Added <b>'.Input::get('file_name').'</b> file';
                $activity->status = 'Added';
                $activity->activity_by = Auth::user()->id;
                $activity->save();
            }
        }
        return redirect()->back();
    }
}
