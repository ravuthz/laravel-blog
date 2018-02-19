<?php

namespace App\Traits;

use App;
use Validator;
use Exception;
use Illuminate\Http\Request;

trait CrudsControllerTrait {
    
    protected $data = [];
    protected $model = null;
    
    protected $siteTitle = null;
    protected $pageTitle = null;

    protected $crudSize = 10;
    
    private function initialize() {
        $fields = ['itemName', 'listName', 'modelPath', 'viewPrefix', 'routePrefix'];
        foreach($fields as $field) {
            if (empty($this->{$field})) {
                throw new Exception("The $" . $field . " is required in " . __CLASS__);
            }
        }
        
        $this->model = App::make($this->modelPath);
        $this->renderData();
    }
    
    private function renderTitle($action) {
        if (!$this->siteTitle) {
            $this->siteTitle = $this->listName . ' ' . $action;
        }
        
        if (!$this->pageTitle) {
            $this->pageTitle = $this->itemName . ' '. $action;
        }
        
        $this->data['site_title'] = $this->siteTitle;
        $this->data['page_title'] = $this->pageTitle;
    }
    
    private function renderData() {
        $this->data['item_name'] = $this->itemName;
        $this->data['list_name'] = $this->listName;
        
        $this->data['crud_size'] =  $this->crudSize;
        
        $this->data['model_path'] = $this->modelPath;
        $this->data['view_prefix'] = $this->viewPrefix;
        $this->data['route_prefix'] = $this->routePrefix;
        
        $this->data['view_include_form'] = $this->viewPrefix . '.form';
        $this->data['view_include_table'] = $this->viewPrefix . '.table';
        $this->data['view_include_search'] = $this->viewPrefix . '.search';
    }
    
    public function getFilterData($request) {
        return $this->model->paginate($this->crudSize);
    }
    
    public function getSingleData($id = null) {
        if ($id) {
            return $this->model->findOrFail($id);
        }
        return null;
    }
    
    public function renderView($name) {
        return view()->first([
            $this->viewPrefix . $name, 
            'crud.' . $name
        ], $this->data);
    }
    
    /**
     * Display a listing of the resource.
     *
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
     * @param  int  $id
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
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->model = new $this->model();
        
        if ($this->model::$createValidateRules) {
            $this->model::$validateRules = $this->model::$createValidateRules;
        }
        
        if ($this->model::$validateRules) {
            $validator = Validator::make($request->all(), $this->model::$validateRules);
            if ($validator->fails()) {   
                return redirect()->route($this->routePrefix . '.create')
                    ->withErrors($validator)->withInput();
            }
        }
        
        $this->model->saveOrUpdate($request);
        
        return redirect()->route($this->routePrefix . '.index')
            ->with('success', trans('crud.item.updated', ['item' => $this->itemName]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->model = $this->getSingleData($id);
        
        if ($this->model::$updateValidateRules) {
            $this->model::$validateRules = $this->model::$updateValidateRules;
        }
        
        if ($this->model::$validateRules) {
            $validator = Validator::make($request->all(), $this->model::$validateRules);
            if ($validator->fails()) {
                return redirect()->route($this->routePrefix . '.edit', $id)
                    ->withErrors($validator)->withInput();
            }
        }
        
        $this->model->saveOrUpdate($request);
        
        return redirect()->route($this->routePrefix . '.index')
            ->with('success', trans('crud.item.created', ['item' => $this->itemName]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->model = $this->getSingleData($id);
        
        $this->model->delete();
        
        return redirect()->route($this->routePrefix . '.index')
            ->with('success', trans('crud.item.deleted', ['item' => $this->itemName]));
    }
    
}