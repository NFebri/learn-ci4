<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\News;
use CodeIgniter\API\ResponseTrait;
use \Hermawan\DataTables\DataTable;

class NewsController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('news/index', [
            'title' => 'News'
        ]);
    }

    public function getDatatables()
    {
        // $news = model(News::class)->findAll();
        $news = db_connect()->table('news')->select(['id', 'title', 'body']);

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
                        <button type="button" class="btn btn-danger btn-sm" onClick="deleteNews(`'.$row->id.'`)">
                            Delete
                        </button>
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
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $news_model->save([
            'title' => $request['title'],
            'slug'  => url_title($request['title'], '-', true),
            'body'  => $request['body'],
        ]);

        return $this->respondCreated([
            'status' => true,
            'messages' => 'Data news berhasil ditambahkan.'
        ]);
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
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $news_model->update($id, [
            'title' => $request['title'],
            'slug'  => url_title($request['title'], '-', true),
            'body'  => $request['body'],
        ]);

        return $this->respond([
            'status'   => true,
            'messages' => 'Data news berhasil diubah.'
        ]);
    }

    public function destroy(int $id)
    {
        model(News::class)->delete($id);

        return $this->respondDeleted([
            'status'   => 200,
            'error'    => null,
            'messages' => 'Data News berhasil dihapus.'
        ]);
    }
}
