<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request){

        $existe = $this->existeUsuario($request);
        if($existe){
            return response()->json([
                "success" => false,
                "message" => "El usuario ya existe"
            ],400);
        }else{
            try{
                //$date = date('Y-m-d H:i:s');
                //Imagen de Perfil


                $image = $request->image;
                $filename = $request->filename;

                $realImage = base64_decode($image);
                file_put_contents($filename, $realImage );


                //Json para el login

                $user = User::create([
                    "name" => $request->name,
                    "direction" => $request->direction,
                    "telephone" => $request->telephone,
                    "email" => $request->email,
                    "password" => bcrypt($request->password),
                    "profile_photo" => $request->filename
                    //"profile_photo_path" => "vacio"
                    //"created" => $date
                ]);

//                $credentials = $request->only('email', 'password');
//                $token = auth()->attempt($credentials);
//                dd($token);
                return response()->json([
                    'success' => true,
                    'message' => 'Registro con exito',
                    'usuario' => $user
                ], 200);

            }catch (\Exception $e){
                return response()->json([
                    'success' => false,
                    'message' => 'Registro fallido'
                ], 400);

            }
        }

    }

    public function existeUsuario(Request $request){
        $email = $request->email;

        try{
            $buscar = User::where('email', $email)->get()->first();
            if($email==$buscar->email){
                return 1;
            }else{
                return 0;
            }
        }catch (\Exception $e){
            return 0;
        }

    }

    public function imagen(Request $request){
        return response()->download(storage_path('cat.jpg'), 'User Image');
        //$ubicacion = $request->filename
        //return response()->download(public_path('194ee02b-f016-430e-8e1e-5e2fae5cd6c87975771721453762413.jpg'), 'User Image');
    }

    /*public function imagenSave(Request $request){
        $fileName = "user_image.jpg";
        $path = $request->file('photo')->move(storage_path('/'), $fileName);
        $photoURL = url('/'.$fileName);
        return response()->json(['url' => $photoURL],200);

    }*/

    public function imagenSave(Request $request){
        $image = $request->image;
        $filename = $request->filename;

        $realImage = base64_decode($image);
        //$path = $request->file('photo')->move(storage_path('/'), $fileName);
        file_put_contents($filename, $realImage );
        //move_uploaded_file($name, storage_path('/'.$name));

        $photoURL = url('/'.$filename);
        return response()->json(['url' => $photoURL],200);

    }
}
