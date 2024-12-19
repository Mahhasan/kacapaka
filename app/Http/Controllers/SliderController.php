<?php

namespace App\Http\Controllers;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        // Fetch all sliders and sort by position in ascending order
        $sliders = Slider::orderBy('position')->get();

        // Return the view with the sliders data
        return view('admin.sliders', compact('sliders'));
    }
    // Store a new slider/banner
    public function store(Request $request)
    {
        $request->validate([
            'media_type' => 'required|string|in:image,video,link',
            'media_url' => 'nullable|string', // Only for 'link' media type
            'media_file' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm|max:10240', // Validate file upload
            'link' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'position' => 'nullable|integer',
            'created_by' => 'required|exists:users,id',
        ]);

        // Get the next position (last position + 1)
        $lastPosition = Slider::max('position');
        $nextPosition = $lastPosition + 1;

        // Handle media file upload
        $mediaFilePath = null;
        if ($request->hasFile('media_file')) {
            $file = $request->file('media_file');
            $mediaFileName = time() . '.' . $file->getClientOriginalExtension();
            $mediaFilePath = 'uploads/sliders/' . $mediaFileName;
            $file->move(public_path('uploads/sliders'), $mediaFileName); // Store the file in the public folder
        }

        // Create the slider entry
        $slider = new Slider();
        $slider->media_type = $request->media_type;
        $slider->media_url = $request->media_url;
        $slider->media_file_path = $mediaFilePath;
        $slider->link = $request->link;
        $slider->is_active = $request->is_active ?? true;
        $slider->position = $nextPosition; // Set the position to the next available position
        $slider->created_by = $request->created_by;
        $slider->save();

        return redirect()->route('web-sliders.index')->with('success', 'Slider created successfully.');
    }

    // Update an existing slider/banner
    public function update(Request $request, $id)
    {
        $request->validate([
            'media_type' => 'required|string|in:image,video,link',
            'media_url' => 'nullable|string', // For link-type media (e.g., YouTube URL)
            'media_file' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm|max:10240', // Validate new file upload
            'link' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'position' => 'nullable|integer',
        ]);

        $slider = Slider::findOrFail($id);

        // If a new media file is uploaded, remove the old file
        if ($request->hasFile('media_file')) {
            // Delete the old file from the public folder
            if ($slider->media_file_path && file_exists(public_path($slider->media_file_path))) {
                unlink(public_path($slider->media_file_path));
            }

            // Store the new file
            $file = $request->file('media_file');
            $mediaFileName = time() . '.' . $file->getClientOriginalExtension();
            $slider->media_file_path = 'uploads/sliders/' . $mediaFileName;
            $file->move(public_path('uploads/sliders'), $mediaFileName); // Store the file in the public folder
        }

        // Update other fields
        $slider->media_type = $request->media_type;
        $slider->media_url = $request->media_url;
        $slider->link = $request->link;
        $slider->is_active = $request->is_active ?? true;
        $slider->position = $request->position ?? $slider->position; // If no position is set, keep current one
        $slider->save();

        return redirect()->route('web-sliders.index')->with('success', 'Slider updated successfully.');
    }

    // Delete a slider/banner
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        // Delete the associated media file from the public folder
        if ($slider->media_file_path && file_exists(public_path($slider->media_file_path))) {
            unlink(public_path($slider->media_file_path));
        }

        $slider->delete();

        return redirect()->route('web-sliders.index')->with('success', 'Slider deleted successfully.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);
        $slider->update(['is_active' => $request->is_active]);

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }
}
