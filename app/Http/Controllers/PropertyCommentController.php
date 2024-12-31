<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storeproperty_commentRequest;
use App\Http\Requests\Updateproperty_commentRequest;
use App\Models\property_comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PropertyCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = property_comment::with('property')
            ->where('user_id', Auth::id())
            ->get();

        return view('view.property_comment.index', [
            'comments' => $comments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('view.property_comment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storeproperty_commentRequest $request)
    {
        $validated = $request->validated();

        property_comment::create([
            'id_property' => $validated['property_id'],
            'id_user' => Auth::id(),
            'id_rent' => $validated['id_rent'],
            'comment' => $validated['comment_text'],
            'rating' => $validated['rating'],
        ]);

        return redirect()->route('property_comment.index')
            ->with('success', 'Comment added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(property_comment $property_comment): View
    {
        $this->authorizeUser($property_comment);

        return view('view.property_comment.show', [
            'property_comment' => $property_comment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(property_comment $property_comment): View
    {
        $this->authorizeUser($property_comment);

        return view('view.property_comment.edit', [
            'property_comment' => $property_comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateproperty_commentRequest $request, property_comment $property_comment)
    {
        $this->authorizeUser($property_comment);

        $validated = $request->validated();

        $property_comment->update([
            'comment' => $validated['comment_text'],
            'rating' => $validated['rating'],
        ]);

        return redirect()->route('property_comment.index')
            ->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(property_comment $property_comment)
    {
        $this->authorizeUser($property_comment);

        $property_comment->delete();

        return redirect()->route('property_comment.index')
            ->with('success', 'Comment deleted successfully.');
    }

    /**
     * Authorize user access for the given property_comment.
     */
    private function authorizeUser(property_comment $property_comment)
    {
        if ($property_comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
