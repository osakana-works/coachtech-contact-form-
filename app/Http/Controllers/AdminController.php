<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexContactRequest;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;

class AdminController extends Controller
{
    public function index(IndexContactRequest $request)
    {
        $categories = Category::all();
        $contacts = Contact::with(['category', 'tags'])
            ->filter($request->validated())
            ->orderBy('created_at', 'desc')
            ->paginate(7);

        $tags = Tag::all();

        return view('admin.index', compact('categories', 'contacts', 'tags'));
    }

    public function show($id)
    {
        $contact = Contact::with('tags', 'category')->findOrFail($id);

        return view('admin.show', compact('contact'));
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect('/admin');
    }
}
