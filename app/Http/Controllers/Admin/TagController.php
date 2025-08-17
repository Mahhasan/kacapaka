<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('position', 'asc')->get();
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $request->validate(['tag_name' => 'required|string|unique:tags|max:255']);
        $position = $request->position ?? (Tag::max('position') + 1);
        Tag::create([
            'tag_name' => $request->tag_name,
            'slug' => Str::slug($request->tag_name),
            'position' => $position,
            'created_by' => Auth::id(),
        ]);
        return redirect()->route('admin.tags.index')->with('success', 'Tag created successfully.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate(['tag_name' => 'required|string|unique:tags,tag_name,' . $tag->id . '|max:255']);
        $tag->update([
            'tag_name' => $request->tag_name,
            'slug' => Str::slug($request->tag_name),
            'position' => $request->position ?? $tag->position,
            'is_active' => $request->has('is_active'),
        ]);
        return redirect()->route('admin.tags.index')->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag deleted successfully.');
    }
}
