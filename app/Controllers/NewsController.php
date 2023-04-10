<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\News;
use \Hermawan\DataTables\DataTable;

class NewsController extends BaseController
{
    public function index()
    {
        return view('news/index', [
            'title' => 'News'
        ]);
    }

    public function getDatatables()
    {
        // $news = model(News::class)->findAll();
        $news = db_connect()->table('news')->select(['id', 'title']);

        return DataTable::of($news)
            ->add('action', function($row){
                $action = '';
                if (has_permission('news-edit')) {
                    $action .= '
                    <a href="' . route_to('news_edit', $row->id) . '" class="btn btn-info btn-sm">
                        Edit
                    </a>';
                }

                if (has_permission('news-delete')) {
                    $action .= '
                    <form class="d-inline" action="' . route_to('news_destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Are you sure?\')">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger btn-sm">
                            Delete
                        </button>
                    </form>
                    ';
                }

                return $action;
            }, 'last')
            ->toJson(true);
    }

    public function create()
    {
        return view('news/create', [
            'title' => 'Create News'
        ]);
    }

    public function store()
    {
        $request = $this->request->getPost(['title', 'body']);
        $news_model = model(News::class);

        if (!$this->validate($news_model->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $news_model->save([
            'title' => $request['title'],
            'slug'  => url_title($request['title'], '-', true),
            'body'  => $request['body'],
        ]);

        return redirect()->route('news_index')->with('message', 'News was created');
    }

    public function edit(int $id)
    {
        return view('news/edit', [
            'title' => 'Edit News',
            'news' => model(News::class)->find($id)
        ]);
    }

    public function update(int $id)
    {
        $request = $this->request->getPost(['title', 'body']);
        $news_model = model(News::class);

        if (!$this->validate($news_model->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $news_model->update($id, [
            'title' => $request['title'],
            'slug'  => url_title($request['title'], '-', true),
            'body'  => $request['body'],
        ]);

        return redirect()->route('news_index')->with('message', 'News was updated');
    }

    public function destroy(int $id)
    {
        model(News::class)->delete($id);

        return redirect()->route('news_index')->with('message', 'News was deleted');
    }
}
