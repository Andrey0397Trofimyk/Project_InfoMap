<?php


namespace App\Http\Controllers\LocationMap;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Location;
use App\Comment;
use App\Image;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = new Location;
        $comments = new Comment;
        $images = new Image;

        // return view('layouts.adminLayouts.adminPage',compact('locations','comments','images'));
        return view('layouts.adminLayouts.adminPage',compact('locations','comments','images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('admin.map');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = new Location;

        $location->fill([
            'user_id'=>Auth::id(),
            'title'=>$request->title,
            'text'=>$request->text,
            'marker'=>$request->marker
        ]);
        $location->save();

        

        foreach ($request->image_url as $key => $value) {
            $image = new Image;
            $image->fill(
                [
                    'location_id'=>$location->id,
                    'image_url'=>$value
                ]
            );
            $image->save();
        }
        return $location;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return redirect()->route('admin.map');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->route('admin.map');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $image = new Image;
        
        foreach($request->old_image_url as $value) {
            if($image->where('image_url',$value)->first()['image_url']) {
                Image::destroy($image->where('image_url',$value)->first()['id']);
            }
        }
        foreach ($request->image_url as $value) {
            $image = new Image;
            $image->fill(
                [
                    'location_id'=>$id,
                    'image_url'=>$value
                ]);
            $image->save();
        }

        $location = Location::find($id);
        $location->title = $request->title;
        $location->text = $request->text;
        $location->marker = $request->marker;
        $location->save();
        return $location;
        // return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Location::destroy($id);
    }
    /**
     * Storage new images
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     */
    public function uploads(Request $request) {
        $path = $request->file('image')->store('location_images','public');
        return $path;
    }
}
