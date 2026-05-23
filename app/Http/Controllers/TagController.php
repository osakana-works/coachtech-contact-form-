<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    public function store(StoreTagRequest $request)
    {
        $validated = $request->validated();

        $tag = Tag::create([
            'name' => $validated['name'],
        ]);

        return redirect('/admin');
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);

        return view('admin.tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, $id)
    {
        $validated = $request->validated();

        $tag = Tag::findOrFail($id);

        $tag->update([
            'name' => $validated['name'],
        ]);

        return redirect('/admin');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect('/admin');
    }
}
