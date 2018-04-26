<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'file';

    protected $guarded = [];

    public function getPath($id){

        $path = File::find($id);

        if (!$path){
            return '';
        }
        return $path->path;
    }

    public function downloadRecord($id){

        $record = File::find($id);

        if ($record){

            $record->down = $record->down + 1;

            $record->save();
        }
    }

    public function addFile($path){

        $obj = File::create(['path' => $path]);

        return $obj;
    }
}
