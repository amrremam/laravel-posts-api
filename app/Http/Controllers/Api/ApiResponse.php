<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;


trait ApiResponse{

    public function ApiResponse($data = null,$message = null,$status = null)
    {
        $array = [
        'data' => $data,
        'status' => $status,
        'message'=>$message
        ];
        return response($array,$status);

    }

//------------Validation----------

    public function Validation( $request){
        $validator = Validator::make($request->all(),[
            'title'=>'required|max:200',
            'body'=>'required',
        ]);
        if($validator->fails()){
            return $this->ApiResponse(null,$validator->errors(),400);
        }
    }


    public function UpdateVali( $request){
        $validator = Validator::make($request->all(),[
            'title'=>'required|max:200',
            'body'=>'required',
        ]);
        if($validator->fails()){
            return $this->ApiResponse(null,$validator->errors(),400);
        }
    }

//----------Update---------

    public function update(Request $request,$id){
        $post = Post::find($id);

        if(!$post){
            return $this->ApiResponse(null,'The post Not found',401); //new created obj take 201
        }

        $post->update($request->all());

        if($post){
            return $this->ApiResponse(new PostResource($post),'The post updated',201); //new created obj take 201
        }
    }

//-----------Destroy----------

    public function destroy($id){

        $post = Post::find($id);
        if(!$post){
            return $this->ApiResponse(null,'The post Not found',404);
        }
        $post->delete($id);
        if($post){
            return $this->ApiResponse(null,'The post Deleted',201);
        }
    }

}

