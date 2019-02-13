<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Template extends Model
{
    //
    public static function listNames()
    {
		$files = Storage::disk('certificados')->files('templates');

		foreach ($files as $key => $file) {
			$fullName = explode('/', $file);
			$name = explode('.', $fullName[count($fullName)-1])[0];
			$files[$key] = $name;
		}

		return $files;
    }
    public function getFile($template)
    {
        $exists = Storage::disk('certificados')->exists('templates/' . $template . '.png');
        if(!$exists) return false;
        else $file = Storage::disk('certificados')->get('templates/' . $template . '.png');
        
        $file = base64_encode($file);

        return $file;
    }

    public static function getPaths()
    {
        $files = Storage::disk('certificados')->files('templates');
        
        //dd($files);

        $paths = [];

        foreach ($files as $key => $path) {

            $withFormat = explode('/', $path)[1];
            $name = explode('.', $withFormat)[0];
            $paths[$key] = ['name' => $name, 'withFormat' => $withFormat];
        }
        //dd($paths);

        return $paths;

        /*$files = [];
        foreach ($paths as $key => $path) {
            $file = Storage::disk('certificados')->get($path);

            $fileName = explode('/', $path)[1];
            $fileName = explode('.', $fileName)[0];

            $files[$key] = ['name' => $fileName, 'data' => base64_encode($file)];
        }

        return $files;*/

    }

}
