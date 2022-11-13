<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagsResource;
use App\Http\Requests\Api\Tags\StoreRequest;
use App\Http\Requests\Api\Tags\UpdateRequest;

class TagsController extends Controller
{
    private $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = TagsResource::collection($this->tag->get());
        return successMessageWithData('تم ارجاع الداتا بنجاح', $tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreRequest  $request
     * @return \Illuminate\Http\StoreRequest
     */
    public function store(StoreRequest $request)
    {
        Tag::create($request->validated());
        return successMessage('تم انشاء التاج بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $tag = new TagsResource($tag);
        return successMessageWithData('تم ارجاع الداتا بنجاح', $tag);
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Tag $tag)
    {
        $tag->update($request->validated());
        return successMessage('تم تعديل التاج بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return successMessage('تم حذف التاج بنجاح');
    }
}
