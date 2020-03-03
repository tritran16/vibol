<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsCategoryRequest;
use App\Models\News;
use App\Models\NewsCategory;
use App\Repositories\NewsCategoryRepository;
use App\Repositories\VideoCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsCategoriesController extends Controller
{
    private $newsCategoryRepository;

    public function __construct(NewsCategoryRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->newsCategoryRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        if ($keyword) {
            // $categories = $this->newsCategoryRepository->findWhere(['name', 'LIKE', $request->get('keyword') ])->paginate(20);
        }
        else {
            $categories = NewsCategory::paginate(20);
//            ->select('news_categories.id', 'news_category_translations.name')
//            ->join('news_category_translations', 'news_category_translations.news_category_id', '=', 'news_categories.id')
//            ->groupBy('news_categories.id', 'news_category_translations.name')
//                ->paginate(20);
        }

        //dd($categories);

        return view('admin.news.categories.index')->with('news_categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsCategoryRequest $request)
    {
        $data = [
            'en' => [
                'name'       => $request->input('name_en'),
                'description' => $request->input('description_en'),
            ],
            'kh' => [
                'name'       => $request->input('name_kh'),
                'description' => $request->input('description_kh'),
            ],
        ];
        NewsCategory::create($data);

        return redirect(route('news_categories.index'))->with('success', 'Created News Category successfully!');//
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = NewsCategory::findOrFail($id);
        return view('admin.news.categories.edit')->with('news_category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsCategoryRequest $request, $id)
    {
        $category = NewsCategory::findOrFail($id);
        //NewsCategory::where('id', $id)->update($request->only(['name', 'description']));
        $data = [
            'en' => [
                'name'       => $request->input('name_en'),
                'description' => $request->input('description_en'),
            ],
            'kh' => [
                'name'       => $request->input('name_kh'),
                'description' => $request->input('description_kh'),
            ],
        ];
        $category->update($data);
        return redirect(route('news_categories.index'))->with('success', 'Update New Category successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = NewsCategory::find($id);
        if ($category) {
            $news = News::where('category_id', $id)->get();
            if ($news && count($news) > 0) {
                return redirect(route('news_categories.index'))->with('error', 'Please delete all news of this category!');
            }
            NewsCategory::where('id', $id)->delete();
            return redirect(route('news_categories.index'))->with('success', 'Deleted News Category Successful!');
        }
        else {
            return redirect(route('news_categories.index'))->with('error', 'Not found News Category!');
        }
    }
}
