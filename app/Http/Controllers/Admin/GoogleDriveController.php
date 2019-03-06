<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use App\SocialNetwork;
use App\Post;
use App\Photo;
use Croppa;
use File;
use FileUpload;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
    public function formulario(Post $post){
        
        return view('admin.posts.upload',['post_id'=>$post->id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        // get all photos
        $photos = Photo::all();
        
        // add properties to photos
        $photos->map(function ($photo) {
            $photo['size'] = File::size(public_path($photo['url']));
            $photo['thumbnailUrl'] = Croppa::url($photo['url'], 80, 80, ['resize']);
            $photo['deleteType'] = 'DELETE';
            $photo['deleteUrl'] = route('admin.photos.destroy', $photo->id);
            return $photo;
        });
        
        // show all photos
        return response()->json(['files' => $photos]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        dd($request);
        $file= $request->file('file'); 
        
        $parent_id = 'practiceblog';
        
        $fileupload = new FileUpload\FileUpload($_FILES['files'], $_SERVER);
       // Doing the deed
        list($files, $headers) = $fileupload->processAll();
        foreach($files as $file){
            //Remember to check if the upload was completed
            if ($file->completed) {
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
                // save data

                //$photo= $request->post->photo()->create([
                //    'url' => 'https://drive.google.com/open?id='. $file->id,
                //]);
                $photo= Photo::create(['post_id' => $request->post->id(), 
                    'url' =>'https://drive.google.com/open?id='. $file->id ]);
                // prepare response
                $data[] = [
                    'size' => $file->size,
                    'name' => $filename,
                    'url' => $url,
                    'thumbnailUrl' => Croppa::url($url, 80, 80, ['resize']),
                    'deleteType' => 'DELETE',
                    'deleteUrl' => route('admin.photos.destroy', $photo->id),
                ];
                
                // output uploaded file response
                return response()->json(['files' => $data]);
            }
        }
        // errors, no uploaded file
        return response()->json(['files' => $files]);
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        Croppa::delete($photo->url); // delete file and thumbnail(s)
        $photo->delete(); // delete db record
        return response()->json([$photo->url]);
    }

}
