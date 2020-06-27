<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::get();
        return response() -> json( $posts );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "title"    => " required | min:4 | max:50  " ,
            "body"     => " required | min:4 | max:500 " ,
        ];
        $validator = Validator::make(  $request->all() , $rules  ); 

        if( $validator -> fails()) { 
            
            return response() -> json([
                "status" => "error",
                "errors" => $validator->errors()  // return errors validator in array 
            ]);
            
        }else{

            Post::create([  
                'title'      => $request -> title ,  
                'body'       => $request -> body , 
            ]);

            return response() -> json([
                "status" => "saved"
            ]);       
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id )
    {

        $rules = [
            "title"    => " required | min:4 | max:50  " ,
            "body"     => " required | min:4 | max:500 " ,
        ];
        $validator = Validator::make(  $request->all() , $rules  ); 

        if( $validator -> fails()) { 
            
            return response() -> json([
                "status" => "error",
                "errors" => $validator->errors()  // return errors validator in array 
            ]);
            
        }

        $post = Post::find($id);
        
        $post-> update([
            'title'      => $request -> title ,  
            'body'       => $request -> body , 
        ]);
        return response() -> json([
            "status" => "saved"
        ]);       
        


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        $post = Post::find($id);
        $post-> delete();
        return response() -> json([
            "status" => "deleted"
        ]); 
    }
}
