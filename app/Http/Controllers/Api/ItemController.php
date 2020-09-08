<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;

class ItemController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Item::all();

        return response()->json([
            'status' => 'ok',
            'totalResults' => count($items),
            'items' => ItemResource::collection($items)
        ]);
        //return ItemResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
                "codeno"=>'required|min:4',
                "name"=>'required',

                "price"=>'required',
                "discount"=>'required',
                "description"=>'required',
                "photo"=>'required|mimes:jpg,jpeg,png',
                "brand"=>'required',
                "subcategory"=>'required'
            ]);

        // if include file,upload file
            $imageName=time().'.'.$request->photo->extension();

            $request->photo->move(public_path('backend/itemimg'),$imageName);//file upload

            $path= 'backend/itemimg/'.$imageName;
        //datainsert
          $item=new Item;

          $item->codeno=$request->codeno;
          $item->name=$request->name;
         
          $item->photo=$path;

          $item->price=$request->price;
          $item->discount=$request->discount;
          $item->description=$request->description;

         $item->brand_id=$request->brand;
         $item->subcategory_id=$request->subcategory;
         $item->save();

         return new ItemResource($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        
        return new ItemResource($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
         $request->validate([
                "codeno"=>'required|min:4',
                "name"=>'required',
                "price"=>'required',
                "discount"=>'required',
                "description"=>'required',
                "photo"=>'sometimes|mimes:jpg,jpeg,png',
                "oldphoto"=>'required',
                "brand"=>'required',
                "subcategory"=>'required'
             ]);
        //  upload file
            if($request->hasFile('photo')){

                $imageName=time().'.'.$request->photo->extension();

                $request->photo->move(public_path('backend/itemimg'),$imageName);//file upload

                $path= 'backend/itemimg/'.$imageName;

            }else{
                $path=$request->oldphoto;
            }
        //  data update
            $item->codeno=$request->codeno;
            $item->name=$request->name;
         
            $item->photo=$path;

            $item->price=$request->price;
            $item->discount=$request->discount;
            $item->description=$request->description;

            $item->brand_id=$request->brand;
            $item->subcategory_id=$request->subcategory;
            $item->save();

            return new ItemResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
        $item->delete();
        return new ItemResource($item);
    }
}
