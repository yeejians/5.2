<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CP\Person;
use App\Models\CP\Group;
use App\Models\CP\Menu;
use Libraries\Builder;
use Libraries\Helper;
use Cache;
use DB;

class MenuController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('access');
    }

	public function index($id = null)
	{
		$parent	= Menu::find($id);
		$nav	= [];

		if (is_null($parent))
		{
			$result	= Menu::where('parent_id', 0)->orderBy('sequence')->paginate();
		}
		else
		{
			$result	= $parent->child()->paginate();
			$nav	= Helper::GetMap($parent);
		}

		return view('cp.menu.index', compact('result', 'parent', 'nav'));
	}

	public function create($id = null)
	{
		$parent = Menu::find($id);
		$nav	= [];

		if (is_null($parent))
		{
			$parent	= Menu::select(DB::raw('0 AS id, MAX(sequence)+1 AS sequence'))->where('root_id', 0)->first();
		}
		else
		{
			$parent->sequence	= $parent->sequence + $parent->child->count() + 1;
			$nav				= Helper::GetMap($parent);
		}

		return view('cp.menu.create', compact('parent', 'nav'));
	}

	public function createPost(Request $request, $id = null)
	{
		$this->validate($request, [
			'label'		=> 'required',
			'route'		=> 'required|unique:menu',
			'sequence'	=> 'required|integer',
		]);

		$model				= new Menu;
		$model->label		= $request->input('label');
		$model->route		= $request->input('route');
		$model->sequence	= $request->input('sequence', 1);
		$model->publicity	= $request->input('publicity', 0);

		if ($id)
		{
			$parent				= Menu::find($request->input('parent_id'));

			$model->root_id		= $parent->GetRoot();
			$model->parent_id	= $parent->id;
			$model->hide		= $request->input('hide', 0);
			$model->search		= $request->input('search', 0);
			$model->map			= empty($parent->map) ? $parent->id : $parent->map.'-'.$parent->id;
		}

		$model->save();

		return $id ? redirect()->route('cp.menu.show', $parent->id) : redirect()->route('cp.menu.index');
	}

	public function edit($id = null)
	{
		if ($result = Menu::find($id))
		{
			$nav	= Helper::GetMap($result);

			return view('cp.menu.edit', compact('result', 'nav'));
		}

		abort(404);
	}

	public function editPost(Request $request, $id = null)
	{
		$this->validate($request, [
			'label'		=> 'required',
			'route'		=> 'required|unique:menu,route,'.$id,
			'sequence'	=> 'required|integer',
		]);

		$model				= Menu::find($id);
		$model->label		= $request->input('label');
		$model->route		= $request->input('route');
		$model->sequence	= $request->input('sequence', 1);
		$model->publicity	= $request->input('publicity', 0);

		if ($model->parent_id)
		{
			$parent				= Menu::find($request->input('parent_id'));

			$model->parent_id	= $parent->id;
			$model->hide		= $request->input('hide', 0);
			$model->search		= $request->input('search', 0);
			$model->map			= empty($parent->map) ? $parent->id : $parent->map.'-'.$parent->id;
		}

		$model->save();

		return redirect()->route('cp.menu.show', $model->id);
	}

	public function assign($id = null)
	{
		if ($result = Menu::find($id))
		{
			$nav	= Helper::GetMap($result);
			$users	= Person::whereNotIn('id', $result->users()->lists('user_id'))->get();
			$groups	= Group::whereNotIn('id', $result->groups()->lists('group_id'))->get();

			return view('cp.menu.assign', compact('result', 'nav', 'users', 'groups'));
		}

		abort(404);
	}

	public function assignPost(Request $request, $id = null)
	{
		$model	= Menu::find($id);
		$route	= $model->root_id ? $model->root->route : $model->route;
		$add	= $request->input('add');
		$remove	= $request->input('remove');
		$addG	= $request->input('addG');
		$remG	= $request->input('remG');

		if (is_array($add))
		{
			foreach ($add as $addUser)
			{
				$model->users()->attach($addUser);
			}
		}

		if (is_array($remove))
		{
			foreach ($remove as $removeUser)
			{
				$model->users()->detach($removeUser);
			}
		}

		if (is_array($addG))
		{
			foreach ($addG as $addGroup)
			{
				$model->groups()->attach($addGroup);
			}
		}

		if (is_array($remG))
		{
			foreach ($remG as $removeGroup)
			{
				$model->groups()->detach($removeGroup);
			}
		}

		if ($model->users->count() > 0 or $model->groups->count() > 0)
		{
			$model->publicity = 0;
			$model->save();
		}

		Cache::tags($route)->flush();

		return redirect()->route('cp.menu.assign', $model->id);
	}

	public function delete($id)
	{
		if ($result = Menu::find($id))
		{
			$parent	= $result->GetParent();

			if ($result->child->count() >= 1)
			{
				return redirect()->route('cp.menu.show', $id)->with('error', 'Sub menu existed, cannot delete.');
			}

			$result->delete();

			return $parent == $id ? redirect()->route('cp.menu.index') : redirect()->route('cp.menu.show', $parent);
		}

		abort(404);
	}

	public function tree($id = null)
	{
		if ($result = Menu::find($id))
		{
			$root = $result->root_id ? $result->root : $result;
			$tree = Builder::GetTree($root, $id);

			return view('cp.menu.tree', compact('result', 'tree'));
		}

		abort(404);
	}

	public function refresh()
	{
		Helper::RefreshMenuMap();

		return redirect()->route('cp.menu.index')->with('success', 'Menu Map Refresh Successfully.');
	}
}