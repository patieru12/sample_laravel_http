<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class CloneStudentController extends Controller
{
    //
    public function clone_Student(Request $request){
        //Get the list index based on the selected level type
        if(request("level_type")){
            $response = Http::get(env("SDMS_DEV_LINK")."/sdms/hec/students?levelType=" . request('level_type'));

            if($response->ok()){
                //Here make sure to send request one student by one
                $index_numbers = $response->collect();
                $i = 1;
                foreach($index_numbers AS $index){
                    //return response()->json($index);
                    $student_data = Http::get($query = env("SDMS_DEV_LINK")."/sdms/hec/student?indexNumber=" . $index);

                    if($student_data->ok()){
                        var_dump($student_data->json(), $student_data->status(), $query);
                    } else {
                        var_dump($student_data->body(), $student_data->status(), $query);
                    }
                    if($i++ >= 100){
                        break;
                    }
                }
                return response()->json(["success" => true, "student" => count($index_numbers)]);
            }

            return response()->json(["success" => false, "message" => "un error occured"]);
        }
    }
}
