<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use App\SocialNetwork;
use App\Post;
use App\Photo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Image;


class GoogleDriveController extends Controller
{
    private $drive;
    public function __construct(Google_client $client){
        $this->middleware(function ($request, $next) use ($client){
            $client->refreshToken(Auth::user()->refresh_token);
            $this->drive = new Google_Service_Drive($client);
            return $next($request);     
        });
    }
    public function getDrive(){
        $folderInRoot =$this->listFolders('root');
        return $folderInRoot;
    }


    /**
     * 
     */
    public function listFolders($id){
        $query = "mimeType='application/vnd.google-apps.folder' and '".$id."' in parents and trashed=false";
 
        $optParams = [
            'fields' => 'files(id, name)',
            'q' => $query
        ];
 
        $results = $this->drive->files->listFiles($optParams);

        return $results->getFiles();
             
    }

 
    function createFolder($folder_name, $parent_id=null ){
        $folder_meta = new Google_Service_Drive_DriveFile([
            'name' => $folder_name,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => [$parent_id]]);
        $folder = $this->drive->files->create($folder_meta, [
            'fields' => 'id']);
        return $folder->id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        //Buscar o crear practicefolder
        //dd($request->params);
        $listFoldersRoot=$this->getDrive();
        if (count($listFoldersRoot) == 0) {
            $parent_id= $this->createFolder('practicefolder');
        } else {
            
            foreach($listFoldersRoot as $file){
                if($file->getName() == 'practicefolder'){
                    $existFileInDrive=true;
                    $parent_id = $file->getID();
                    break;
                }else{
                    $existFileInDrive=false;
                }
            }
            
            if(!$existFileInDrive){
                $parent_id= $this->createFolder('practicefolder');
            }
        }
        
        //Buscar o crear post
        
        $post_id = $request->input('post_id');;
        
        $postFolderIdDrive = Post::find($post_id);
        if( $postFolderIdDrive->folder_id == '' ){
            $folderPostId = $this->createFolder($post_id, $parent_id);
            $postFolderIdDrive->folder_id = $folderPostId;
            $postFolderIdDrive->save();
        }else{
            $folderPostId = $postFolderIdDrive->folder_id;
        }
        $file= $request->file('image');
        $name = gettype($file) === 'object' ? $file->getClientOriginalName() : $file;
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $name,
            'parents' => [$folderPostId]
        ]);
        
        $content = gettype($file) === 'object' ?  File::get($file) : Storage::get($file);
        $mimeType = gettype($file) === 'object' ? File::mimeType($file) : Storage::mimeType($file);
        $file = $this->drive->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);
        $this->permissionShareFilesDomain($file->id,'reader');
        Photo::create(['post_id'=> $post_id,'file_id'=>$file->id]);
        return back();

    }
    /**
     * 
     */
    public function permissionShareFilesDomain($fileId, $role){
        $this->drive->getClient()->setUseBatch(true);
        try {
            $batch = $this->drive->createBatch();
            $userPermission = new Google_Service_Drive_Permission(array(
                'type' => 'anyone',
                'role' => $role
            ));
            $request = $this->drive->permissions->create(
                $fileId, $userPermission, array('fields' => 'id'));
            $batch->add($request, 'anyone');
            $results = $batch->execute();
        } finally {
            $this->drive->getClient()->setUseBatch(false);
        }
    }
    /**
     * 
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/')->with('message', ['type' => 'success', 'text' => 'You are now logged out']);
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
            //dd($photo->id);
            $this->drive->files->delete($photo->file_id);
            
        } catch (Exception $e) {
            return false;
        }   
        $photo->delete(); // delete db record
        return back()->with('flash','Foto eliminada'); 
    }
}
/* jpeg, png, bmp, gif, o svg, el maximo en kilobytes, tambien se pueden validar dimensioes con: 
dimensions:min_width=500,max_width=1500,min_height=100,laravel convierte a $photo = request()->file('photo') en una instancia de la clase Uploatedfile para luego usar el metodo storage que guarda el archivo en la carpeta storage
*/
