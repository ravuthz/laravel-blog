<?php

namespace App\Traits;

use App;
use Exception;
use Illuminate\Http\Request;
use Validator;

trait CrudsControllerTrait
{
    use HtmlPageTrait;

    protected $data = [];
    protected $model = null;
    protected $crudSize = 10;

    private function initialize()
    {
        $fields = ['itemName', 'listName', 'modelPath', 'viewPrefix', 'routePrefix'];
        foreach ($fields as $field) {
            if (empty($this->{$field})) {
                throw new Exception("The $" . $field . " is required in " . __CLASS__);
            }
        }

        $this->model = App::make($this->modelPath);
        $this->renderData();
    }

    private function renderData()
    {
        $this->data['item_name'] = $this->itemName;
        $this->data['list_name'] = $this->listName;

        $this->data['crud_size'] = $this->crudSize;

        $this->data['model_path'] = $this->modelPath;
        $this->data['view_prefix'] = $this->viewPrefix;
        $this->data['route_prefix'] = $this->routePrefix;

        $this->data['view_include_form'] = $this->viewPrefix . '.form';
        $this->data['view_include_table'] = $this->viewPrefix . '.table';
        $this->data['view_include_search'] = $this->viewPrefix . '.search';
    }

    public function renderTitle($title)
    {
        $this->data['site_title'] = $this->getSiteTitle() . ' ' . $title;
        $this->data['page_title'] = $this->getPageTitle() . ' ' . $title;
    }

    public function getFilterData($request = null)
    {
        return $this->model->paginate($this->crudSize);
    }

    public function getSingleData($id = null)
    {
        return $id ? $this->model->findOrFail($id) : null;
    }

    public function renderView($name)
    {
        return view()->first([
            $this->viewPrefix . $name,
            'crud.' . $name
        ], $this->data);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->data[$this->listName] = $this->getFilterData($request);
        $this->renderTitle('listing');
        return $this->renderView('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data[$this->itemName] = $this->getSingleData(null);
        $this->renderTitle('create');
        return $this->renderView('create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data[$this->itemName] = $this->getSingleData($id);
        $this->renderTitle('detail');
        return $this->renderView('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data[$this->itemName] = $this->getSingleData($id);
        $this->renderTitle('update');
        return $this->renderView('edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->model = new $this->model();
        $this->validate($request, $this->model->getCreateValidationRules());
        $this->model->saveOrUpdate($request);

        return redirect()->route($this->routePrefix . '.index')
            ->with('success', trans('crud.item.updated', ['item' => $this->getPageTitle()]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->model = $this->getSingleData($id);
        $this->validate($request, $this->model->getUpdateValidationRules());
        $this->model->saveOrUpdate($request);

        return redirect()->route($this->routePrefix . '.index')
            ->with('success', trans('crud.item.created', ['item' => $this->getPageTitle()]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->model = $this->getSingleData($id);
        $this->model->delete();
        return redirect()->route($this->routePrefix . '.index')
            ->with('success', trans('crud.item.deleted', ['item' => $this->getPageTitle()   ]));
    }

}