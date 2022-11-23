<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


    class PostControlller extends Controller{
//-----------USE--Trait--API-------
    use ApiResponse;


    public function index(){
        $posts = PostResource::collection(Post::get());

        return $this->ApiResponse($posts,'ok',200);
    }


//--------------SHOW--------

    public function show($id)
    {
        $post = Post::find($id);

        if($post){
            return $this->ApiResponse(new PostResource($post),'ok',200);
        }

        return $this->ApiResponse(null,'this post not found',401);
    }


//---------------STORE------------


    public function store(Request $request){

        return $this->Validation($request);

        $post = Post::create($request->all());
        if($post){
            return $this->ApiResponse(new PostResource($post),'the post saved',201);  //new created obj take 201
        }
        return $this->ApiResponse(null,'this post not found',400);   //400 bad request 401 unauthorized
    }


//------------------update--------------


    public function update(Request $request , $id){

        // return $this->UpdateVali($request);
        $validator = Validator::make($request->all(),[
            'title'=>'required|max:200',
            'body'=>'required',
        ]);
        if($validator->fails()){
            return $this->ApiResponse(null,$validator->errors(),400);
        }

        // return $this->update($request,$id);

        $post = Post::find($id);

        if(!$post){
            return $this->ApiResponse(null,'The post Not found',401); //new created obj take 201
        }

        $post->update($request->all());

        if($post){
            return $this->ApiResponse(new PostResource($post),'The post updated',201); //new created obj take 201
        }
    }

//------------DESTROY-------------

    public function destroy($id){

        $post = Post::find($id);
        if(!$post){
            return $this->ApiResponse(null,'The post Not found',404);
        }
        $post->delete($id);
        if($post){
            return $this->ApiResponse(null,'The post Deleted',200);
        }
    }
}
