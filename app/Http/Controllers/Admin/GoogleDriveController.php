<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use App\SocialNetwork;
use App\Post;
use App\Photo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class GoogleDriveController extends Controller
{
    private $drive;
    public function __construct(Google_client $client){
        $this->middleware(function ($request, $next) use ($client){
            $client->refreshToken(SocialNetwork::where('user_id', Auth::user()->id)->select('refresh_token')->get());
            $this->drive = new Google_Service_Drive($client);
            return $next($request);     
        });
    }
    public function getDrive(){
        $this->ListFolders('root');
    }
 
    public function ListFolders($id){
 
        $query = "mimeType='application/vnd.google-apps.folder' and '".$id."' in parents and trashed=false";
 
        $optParams = [
            'fields' => 'files(id, name)',
            'q' => $query
        ];
 
        $results = $this->drive->files->listFiles($optParams);
 
        if (count($results->getFiles()) == 0) {
            print "No files found.\n";
        } else {
            print "Files:\n";
            foreach ($results->getFiles() as $file) {
                dump($file->getName(), $file->getID());
            }
        }
    }
 
    function uploadFile(Request $request){
        if($request->isMethod('GET')){
            return view('upload');
        }else{
            $this->createFile($request->file('file'));
        }
    }
 
    function createStorageFile($storage_path){
        $this->createFile($storage_path);
    }

    function createFolder($folder_name){
        $folder_meta = new Google_Service_Drive_DriveFile(array(
            'name' => $folder_name,
            'mimeType' => 'application/vnd.google-apps.folder'));
        $folder = $this->drive->files->create($folder_meta, array(
            'fields' => 'id'));
        return $folder->id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Post $post){
        $this->validate(request(),[
    		'photo' => 'required|image|max:2048'
    	]);
        dd($post);
        
    	// return request()->file('photo')->store('posts','public');
        // $photoUrl = Storage::url($photo);
        $parent_id= 'practiceblog';
        foreach($post->photos() as $photo){
            $file= $request()->file('photo');
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
            $photo->url= 'https://drive.google.com/open?id='.$file->id;
        }    
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        try {
            $this->drive->files->delete($photo->id);
            $photo->delete(); // delete db record
            return back()->with('flash','Foto eliminada');
        } catch (Exception $e) {
            return false;
        }    
    }
}
/* jpeg, png, bmp, gif, o svg, el maximo en kilobytes, tambien se pueden validar dimensioes con: 
dimensions:min_width=500,max_width=1500,min_height=100,laravel convierte a $photo = request()->file('photo') en una instancia de la clase Uploatedfile para luego usar el metodo storage que guarda el archivo en la carpeta storage
*/
