<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Photo;
use Croppa;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\GoogleDriveController;
use App\Http\Controllers\Controller;


class PhotosController extends Controller
{
    public function store(Request $request)
    {   

       // FileUploader itself
        $fileupload = new FileUpload\FileUpload($_FILES['files'], $_SERVER);
       // Doing the deed
        list($files, $headers) = $fileupload->processAll();
        $googleDrive = new GoogleDriveController();        

        foreach($files as $file){
            //Remember to check if the upload was completed
            if ($file->completed) {

                // set some data
                $googleDrive->createFile($file);
               
                // save data
                $photo= $request->post->photo()->create([
                    'url' => 'https://drive.google.com/open?id='. $googleDrive->file_id,
                ]);
                
                // prepare response
                $data[] = [
                    'size' => $file->size,
                    'name' => $filename,
                    'url' => $url,
                    'thumbnailUrl' => Croppa::url($url, 80, 80, ['resize']),
                    'deleteType' => 'DELETE',
                    'deleteUrl' => route('photos/', $photo->id),
                ];
                
                // output uploaded file response
                return response()->json(['files' => $data]);
            }
        }
        // errors, no uploaded file
        return response()->json(['files' => $files]);
    }

    public function destroy(Photo $photo)
    {

        Croppa::delete($photo->url); // delete file and thumbnail(s)
        $photo->delete(); // delete db record
        return response()->json([$photo->url]);
    }
}

/* jpeg, png, bmp, gif, o svg, el maximo en kilobytes, tambien se pueden validar dimensioes con: 
dimensions:min_width=500,max_width=1500,min_height=100,laravel convierte a $photo = request()->file('photo') en una instancia de la clase Uploatedfile para luego usar el metodo storage que guarda el archivo en la carpeta storage

*/