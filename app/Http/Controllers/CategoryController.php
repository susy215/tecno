<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CreateCategoryRequest;
use Illuminate\Http\RedirectResponse;
use App\Policies\CategoryPolicy;
use Illuminate\Support\Facades\Gate;
use App\Models\Notification;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $categorys = Category::all();

        return Inertia::render('Admin/Categorys/CategoryIndex',
        [
            'notifications' =>Notification::get(),
            'contnitification' =>Notification::count(),
            'categorys' =>CategoryResource::collection($categorys),
        ]);

    }

    public function create(): Response
    {
        Gate::authorize('create', Category::class);
        return Inertia::render('Admin/Categorys/Create');
    }

    public function store(CreateCategoryRequest $request): RedirectResponse
    {
        Gate::authorize('create', Category::class);
        Category::create([
            'category' => $request->category,
            'description' => $request->description,
        ]);
        return to_route('categorys.index')->with('success','¡Categoría creada exitosamente!');

    }
    public function edit(Category $category):Response
    {
        Gate::authorize('update', $category);
        return Inertia::render('Admin/Categorys/Edit', [
            'category' => new CategoryResource($category),
            'description' => new CategoryResource($category)
        ]);
    }

    public function update(CreateCategoryRequest $request, Category $category):RedirectResponse
    {
        // $category->update($request->validated());
        Gate::authorize('update', $category);
        $category->update([
            'category' => $request->category,
            'description' => $request->description,
        ]);
        return to_route('categorys.index')->with('success','¡Categoría actualizada exitosamente!');;
    }

    public function destroy(Category $category)
    {
        Gate::authorize('delete', $category);
        $category->delete();
        return back()->with('dsuccess','¡Categoría eliminada exitosamente!');
    }
}
