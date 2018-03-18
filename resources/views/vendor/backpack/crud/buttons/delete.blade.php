@if ($crud->hasAccess('delete'))
	@if (Auth::user()->hasRole('admin'))
		<a href="{{ url($crud->route.'/'.$entry->getKey()) }}" class="btn btn-xs btn-default" data-button-type="delete"><i class="fa fa-trash"></i> {{ trans('backpack::crud.delete') }}</a>
	@endif
@endif