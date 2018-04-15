<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TeamRequest as StoreRequest;
use App\Http\Requests\TeamRequest as UpdateRequest;

class TeamCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Team');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/team');
        $this->crud->setEntityNameStrings('team', 'teams');

        // $this->crud->removeButton( 'delete' );

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // $this->crud->setFromDb();

        $this->crud->allowAccess('reorder');
        $this->crud->enableReorder('name', 2);

        $this->crud->addColumn([
                                'name' => 'name',
                                'label' => 'Name',
                                'type' => 'text',
                                // 'attributes' => [
                                //     'placeholder' => 'Enter Project Team Name'
                                //   ],
                            ]);
        $this->crud->addColumn([
                                'name' => 'project_id',
                                'label' => 'Project Id',
                            ]);
        // $this->crud->addColumn([
        //                         'name' => 'updateprogress',
        //                         'label' => 'Update Progress',
        //                     ]);
        $this->crud->addColumn([
                                'name' => 'created_by',
                                'label' => 'Created By',
                            ]);
        $this->crud->addColumn([
                                'name' => 'type',
                                'label' => 'Type',
                            ]);

        // $this->crud->addColumn([
        //                         'label' => 'Client',
        //                         // 'type' => 'select',
        //                         'name' => 'parent_id',
        //                         'entity' => 'parent',
        //                         'attribute' => 'name',
        //                         'model' => "\App\Models\MenuItem",
        //                     ]);

        
        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'label' => "Name",
            'type' => 'text',
            'name' => 'name', // the method that defines the relationship in your Model
            'attributes' => [
                'placeholder' => 'Edit Project Team Name'
              ],
        ], 'update');

        // $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
        //     'label' => "Update Progress",
        //     'type' => 'select',
        //     'name' => 'updateprogress', // the method that defines the relationship in your Model
        //     'attributes' => [
        //         'placeholder' => 'Choose Yes or No',
        //         'default' => 'no'
        //       ],
        // ], 'update');

        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'label' => "Created By",
            'type' => 'number',
            'name' => 'created_by', // the method that defines the relationship in your Model
            'attributes' => [
                'disabled'  => 'disabled'
            ],
            'entity' => 'users',
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\User",
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ], 'update');

        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'label' => "Project Id",
            'type' => 'text',
            'name' => 'project_id', // the method that defines the relationship in your Model
            'attributes' => [
                'disabled'  => 'disabled'
            ],
            'entity' => 'projects',
            'attribute' => 'title', // foreign key attribute that is shown to user
            'model' => "App\Models\Project",
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ], 'update');

        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'label' => "Type",
            'type' => 'select',
            'name' => 'type', // the method that defines the relationship in your Model
            'model' => "App\Models\Team", // foreign key model
            'attributes' => [
                'placeholder' => 'Set team to either be of type client or organization'
              ],
        ], 'update');

        // $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
        //     'label' => "Articles",
        //     'type' => 'select2_multiple',
        //     'name' => 'articles', // the method that defines the relationship in your Model
        //     'entity' => 'articles', // the method that defines the relationship in your Model
        //     'attribute' => 'title', // foreign key attribute that is shown to user
        //     'model' => "App\Models\Article", // foreign key model
        //     'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        // ], 'update');

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
