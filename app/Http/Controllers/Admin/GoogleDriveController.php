<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use App\SocialNetwork;
use App\Photo;
use App\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class GoogleDriveController extends Controller
{
    private $drive;
    public function __construct(Google_client $client){
        $this->middleware(function ($request, $next) use ($client){
            $client->refreshToken(SocialNetwork()->where('user_id', Auth::user()->id)->select('refreshToken')->get());
            $this->drive = new Google_Service_Drive($client);
            return $next($request); 
        });
    }
    public function getFolders(){
        $this->ListFolders('root');
    }
    public function ListFolders($id){
        $query = "mimeType='application/vnd.google-apps.folder' and '".$id."' in parents and trashed=false";
        $optParams = [
            'fields' => 'files(id, name)',
            'q' => $query
        ];
        $results = $this->drive->files->ListFiles($optParams);
        $list = $results->getFiles();
        return compact('list');
    }
    function uploadFile(Request $request){
        $lista = $this->getFolders();
        if($lista->firstWhere('name', 'practiceblog')->isEmpty()){
            $this->createFolder('practiceblog');
        }
        if($request->isMethod('GET')){
            return view('upload');
        }else{
            $this->createFile($request->file('file'), 'practiceblog');
        }
    }
 
    function createStorageFile($storage_path){
        $this->createFile($storage_path);
    }
 
    function createFile($file, $parent_id = null){
        $name = gettype($file) === 'object' ? $file->getClientOriginalName() : $file;
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $name,
            'parent' => $parent_id ? $parent_id : 'root'
        ]);
 
        $content = gettype($file) === 'object' ?  File::get($file) : Storage::get($file);
        $mimeType = gettype($file) === 'object' ? File::mimeType($file) : Storage::mimeType($file);
 
        $file = $this->drive->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);
    }
 
    function deleteFileOrFolder($id){
        try {
            $this->drive->files->delete($id);
        } catch (Exception $e) {
            return false;
        }
    }
 
    function createFolder($folder_name){
        $folder_meta = new Google_Service_Drive_DriveFile(array(
            'name' => $folder_name,
            'mimeType' => 'application/vnd.google-apps.folder'));
        $folder = $this->drive->files->create($folder_meta, array(
            'fields' => 'id'));
        return $folder->id;
    }

    public function doUpload(Post $post)
    {
        $this->validate(post(),[
    		'photo' => 'required|image|max:2048'
    	]);
        if ($post->hasFile('file')) {

            $file = $post->file('file');

            $mime_type = $file->getMimeType();
            $title = $file->getClientOriginalName();
            $description = $post->input('description');

            $drive_file = new \Google_Service_Drive_DriveFile();
            $drive_file->setName($title);
            $drive_file->setDescription($description);
            $drive_file->setMimeType($mime_type);

            try {
                $createdFile = $this->drive->files->create($drive_file, [
                    'data' => $file,
                    'mimeType' => $mime_type,
                    'uploadType' => 'multipart'
                ]);

                $file_id = $createdFile->getId();
                $post->photos()->create([

                    'url' => $file_id,
                ]);
        
                return redirect('/upload')
                    ->with('message', [
                        'type' => 'success',
                        'text' => "File was uploaded with the following ID: {$file_id}"
                ]);

            } catch (Exception $e) {

                return redirect('/upload')
                    ->with('message', [
                        'type' => 'error',
                        'text' => 'An error occurred while trying to upload the file'
                    ]);

            }
        }

    }
}
