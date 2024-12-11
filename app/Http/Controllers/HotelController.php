<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Hotel;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $hotels = Hotel::with(['rooms'])->orderByDesc('id')->paginate('10');
        return view('admin.hotels.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $cities = City::orderByDesc('id')->get();
        $countries = Country::orderByDesc('id')->get();
        return view('admin.hotels.create', compact('cities', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request)
    {
        // dd($request->all()); // Debug semua data request

        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            // Tambahkan nilai city_id
            $validated['city_id'] = $request->input('city_id');

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath =
                    $request->file('thumbnail')->store('thumbnails/' . date('Y/m/d'), 'public');
                $validated['thumbnail'] = $thumbnailPath;
            }

            $validated['slug'] = Str::slug($validated['name']);

            // Insert data ke tabel hotels
            $hotel = Hotel::create($validated);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $photoPath = $photo->store('photos/' . date('Y/m/d'), 'public');
                    $hotel->photos()->create([
                        'photo' => $photoPath
                    ]);
                }
            }
        });

        return redirect()->route('admin.hotels.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        //
        $latestPhotos = $hotel->photos()->orderBydesc('id')->take(3)->get();
        return view('admin.hotels.show', compact('hotel', 'latestPhotos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        //
        $cities = City::orderByDesc('id')->get();
        $countries = Country::orderByDesc('id')->get();
        $latestPhotos = $hotel->photos()->orderByDesc('id')->take(3)->get();
        return view('admin.hotels.edit', compact('hotel', 'countries', 'cities', 'latestPhotos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        //
        DB::transaction(function () use ($request, $hotel) {
            $validated = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath =
                    $request->file('thumbnail')->store('thumbnail/' . date('y/m/d'), 'public');
                $validated['thumbnail'] = $thumbnailPath;
            }

            $validated['slug'] = Str::slug($validated['name']);

            $hotel->update($validated);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $photoPath = $photo->store('photos/' . date('y/m/d'), 'public');
                    $hotel->photos()->create([
                        'photo' => $photoPath
                    ]);
                }
            }
        });

        return redirect()->route('admin.hotels.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        //
        DB::transaction(function () use ($hotel) {
            $hotel->delete();
        });

        return redirect()->route('admin.hotels.index');
    }
}
