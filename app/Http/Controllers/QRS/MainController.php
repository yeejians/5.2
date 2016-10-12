<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use Cache;
use DB;

use App\Http\Controllers\CP\AttachmentTrait;
use App\Http\Controllers\QRS\NotificationTrait;

use App\Models\QRS\Complaint;
use App\Models\QRS\Master;
use App\Models\QRS\Member;
use App\Models\QRS\Person;
use App\Models\QRS\Site;

use Libraries\Helper;

class MainController extends Controller
{
	use AttachmentTrait;
	use NotificationTrait;

	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('selectdb');
    }

	public function index(Request $request)
	{
		$request->session()->put('redirect', url()->full());

		$status	= DB::table('complaint_search')->select('status_id', 'status')->distinct()->orderBy('status_id')->get();
		$user	= Person::find(auth()->user()->id);
		$sites	= Site::all();
		$lists	= [];
		$past	= [];
		$record	= '';

		$search	= $request->input('search');
		$filter	= $request->input('filter');
		$find	= $search ? $search : $filter;

		if ($find)
		{
			$past	= $request->session()->get('past', $past);
			$db		= $request->session()->has('lists') ? DB::table('complaint_search')->whereIn('id', $request->session()->get('lists')) : DB::table('complaint_search');
			$lists	= $db->where(function($query) use ($find){
							$query->where('refno', 'like', '%'.$find.'%')
									->orWhere('date', 'like', '%'.$find.'%')
									->orWhere('customer', 'like', '%'.$find.'%')
									->orWhere('subject', 'like', '%'.$find.'%')
									->orWhere('caseleader', 'like', '%'.$find.'%')
									->orWhere('status', 'like', '%'.$find.'%');
						})->lists('id');

			if (count($past) <= 0 || (count($past) > 0 && $past[count($past)-1] != $find))
			{
				array_push($past, $find);
			}

			$request->session()->put('past', $past);
			$request->session()->put('lists', $lists);

			$record	= implode(' <strong>AND</strong> ', $past);
		}
		else
		{
			$request->session()->forget('past');
			$request->session()->forget('lists');
		}

		$all	= Complaint::orderBy('created_at', 'desc');
		$part	= $user->complaints();

		if (count($past) > 0)
		{
			$all	= Complaint::whereIn('id', $lists)->orderBy('created_at', 'desc');
			$part	= $user->complaints()->whereIn('id', $lists);
		}

		$view	= $user->CanViewAll() ? $all : $part;
		$result	= $view->paginate();

		if ($find)
		{
			$result	= $search ? $view->paginate()->appends(['search' => $find]) : $view->paginate()->appends(['filter' => $find]);
		}

		return view('qrs.main.index', compact('result', 'sites', 'record', 'status'));
	}

	public function flushcache()
	{
		Cache::tags('qrs')->flush();

		return redirect()->route('qrs.index');
	}

	public function create($id)
	{
		if ($site = Site::find($id))
		{
			$refno		= Helper::GetIndex('QR'.strtoupper($site->shortname));
			$user		= Person::find(auth()->user()->id);
			$saleslist	= Person::user()->get();
			$countries	= Master::country()->get();
			$packing	= Master::packing()->get();
			$stuffing	= Master::stuffing()->get();

			return view('qrs.main.create', compact('refno', 'site', 'user', 'saleslist', 'countries', 'packing', 'stuffing'));
		}

		abort(404);
	}

	public function createPost(Request $request, $id)
	{
		$this->validate($request, [
			'date'				=> 'required|date_format:d/m/Y',
			'country_id'		=> 'required',
			'customer_id'		=> 'required',
			'customer_name'		=> 'required',
			'sono'				=> 'required',
			'batch'				=> 'required',
			'outbound'			=> 'required',
			'production_at'		=> 'required',
			'dispatch_at'		=> 'required',
			'arrival_at'		=> 'required',
			'incoterm'			=> 'required',
			'product_caiscode'	=> 'required',
			'product_name'		=> 'required',
			'product_category'	=> 'required',
			'reefer'			=> 'required',
			'container'			=> 'required',
			'quantity'			=> 'required|numeric',
			'size'				=> 'required|numeric',
			'pack_id'			=> 'required',
			'stuff_id'			=> 'required',
			'nature'			=> 'required',
			'response'			=> 'required',
		]);

		$date = date_create_from_format('d/m/Y', $request->input('date'));

		$model						= new Complaint;
		$model->site_id				= $id;
		$model->refno				= $request->input('refno');
		$model->date				= $date->format('Y-m-d');
		$model->country_id			= $request->input('country_id');
		$model->pack_id				= $request->input('pack_id');
		$model->stuff_id			= $request->input('stuff_id');
		$model->sono				= $request->input('sono');
		$model->customer_id			= $request->input('customer_id');
		$model->customer_name		= $request->input('customer_name');
		$model->production_at		= $request->input('production_at');
		$model->dispatch_at			= $request->input('dispatch_at');
		$model->arrival_at			= $request->input('arrival_at');
		$model->incoterm			= $request->input('incoterm');
		$model->product_category	= $request->input('product_category');
		$model->product_caiscode	= $request->input('product_caiscode');
		$model->product_name		= $request->input('product_name');
		$model->batch				= $request->input('batch');
		$model->container			= $request->input('container');
		$model->outbound			= $request->input('outbound');
		$model->reefer				= $request->input('reefer');
		$model->size				= $request->input('size');
		$model->quantity			= $request->input('quantity');
		$model->nature				= $request->input('nature');
		$model->response			= $request->input('response');

		if ($model->save())
		{
			$saleslist	= $request->input('saleslist');
			$member		= Member::where('name', 'QR.DefaultQA')->first();

			if (is_array($saleslist))
			{
				foreach ($saleslist as $id)
				{
					$model->cclist()->create([
						'user_id'	=> $id,
						'cctype'	=> 'sales']);
				}
			}

			foreach ($member->user as $key)
			{
				$model->defaultqa()->attach([$key->id => ['cctype' => 'defaultqa']]);
			}
		}

		return redirect()->route('qrs.show', $model->getKey());
	}

	public function edit($id)
	{
		if ($result	= Complaint::find($id))
		{
			if (($result->IsInitiator() || $result->IsSalesCc()) && $result->IsNotLock())
			{
				$result->tab = 'initiation';

				$countries	= Master::country()->get();
				$packing	= Master::packing()->get();
				$stuffing	= Master::stuffing()->get();
				$lists		= $result->sales()->lists('user_id');
				$saleslist	= $lists ? Person::user()->whereNotIn('id', $lists)->get() : Person::user()->get();

				return view('qrs.main.edit', compact('result', 'saleslist', 'countries', 'packing', 'stuffing'));
			}

			abort(403);
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request, [
			'date'				=> 'required|date_format:d/m/Y',
			'country_id'		=> 'required',
			'customer_id'		=> 'required',
			'customer_name'		=> 'required',
			'sono'				=> 'required',
			'batch'				=> 'required',
			'outbound'			=> 'required',
			'production_at'		=> 'required',
			'dispatch_at'		=> 'required',
			'arrival_at'		=> 'required',
			'incoterm'			=> 'required',
			'product_caiscode'	=> 'required',
			'product_name'		=> 'required',
			'product_category'	=> 'required',
			'reefer'			=> 'required',
			'container'			=> 'required',
			'quantity'			=> 'required|numeric',
			'size'				=> 'required|numeric',
			'pack_id'			=> 'required',
			'stuff_id'			=> 'required',
			'nature'			=> 'required',
			'response'			=> 'required',
		]);

		$date = date_create_from_format('d/m/Y', $request->input('date'));

		$model						= Complaint::find($id);
		$model->date				= $date->format('Y-m-d');
		$model->country_id			= $request->input('country_id');
		$model->pack_id				= $request->input('pack_id');
		$model->stuff_id			= $request->input('stuff_id');
		$model->sono				= $request->input('sono');
		$model->customer_id			= $request->input('customer_id');
		$model->customer_name		= $request->input('customer_name');
		$model->production_at		= $request->input('production_at');
		$model->dispatch_at			= $request->input('dispatch_at');
		$model->arrival_at			= $request->input('arrival_at');
		$model->incoterm			= $request->input('incoterm');
		$model->product_category	= $request->input('product_category');
		$model->product_caiscode	= $request->input('product_caiscode');
		$model->product_name		= $request->input('product_name');
		$model->batch				= $request->input('batch');
		$model->container			= $request->input('container');
		$model->outbound			= $request->input('outbound');
		$model->reefer				= $request->input('reefer');
		$model->size				= $request->input('size');
		$model->quantity			= $request->input('quantity');
		$model->nature				= $request->input('nature');
		$model->response			= $request->input('response');

		if ($model->save())
		{
			$remove		= $request->input('remove');
			$saleslist	= $request->input('saleslist');

			if (is_array($remove))
			{
				$model->cclist()->where('cctype', 'sales')->whereIn('user_id', $remove)->get()->each(function($list){$list->delete();});
			}

			if (is_array($saleslist))
			{
				foreach ($saleslist as $id)
				{
					$model->cclist()->create([
						'user_id'	=> $id,
						'cctype'	=> 'sales']);
				}
			}
		}

		return redirect()->route('qrs.show', $model->id);
	}

	public function show($id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->CanView())
			{
				$result->tab = 'initiation';

				return view('qrs.main.show', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function attachment($id)
	{
		if ($result = Complaint::find($id))
		{
			if (($result->IsInitiator() || $result->IsSalesCc()) && $result->IsNotLock())
			{
				$data['refno']		= $result->refno;
				$data['uploader']	= route('qrs.attachment.post', $result->id);

				return view('home.upload', compact('data'));
			}

			abort(403);
		}

		abort(404);
	}

	public function attachmentPost(Request $request, $id)
	{
		$file	= $request->file('Filedata');

		if ($result = Complaint::find($id))
		{
			if ($file->isValid())
			{
				$path	= 'attachments/qrs/'.$result->refno.'/initiation/';
				$id		= $this->fileUpload($file, $path);

				if ($id)
				{
					$result->attachment()->attach($id, ['section' => 'initiation']);

					return response('SUCCESS', 200);
				}

				return response('ERROR', 500);
			}

			return response('ACCESS DENIED', 403);
		}

		return response('NOT FOUND', 404);
	}

	public function notify($id)
	{
		if ($result = Complaint::find($id))
		{
			if (($result->IsInitiator() || $result->IsSalesCc()) && $result->IsNotLock())
			{
				$result->tab		= 'initiation';
				$data['url']		= route('qrs.send', $result->id);
				$data['previous']	= url()->previous();

				return view('qrs.main.notify', compact('result', 'data'));
			}

			abort(403);
		}

		abort(404);
	}

	public function send(Request $request, $id)
	{
		if ($request->ajax())
		{
			if ($result = Complaint::find($id))
			{
				$status	= $this->notification($result, 'initiation');

				return response($status['message'], $status['code']);
			}

			abort(404);
		}

		abort(403);
	}
}