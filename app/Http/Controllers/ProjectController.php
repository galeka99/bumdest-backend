<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\ProjectStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $projects = Project::where('bumdes_id', auth()->user()->bumdes->id)
            ->orderBy('status_id', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);

        return view('dashboard.products.index', compact('projects'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'target' => 'required|numeric',
            'start_offer' => 'required|date',
            'end_offer' => 'required|date',
            'proposal' => 'file|max:25600',
            'images' => 'required|array',
            'images.*' => 'image|max:5120',
        ]);

        $project = Project::create([
            'title' => $request->post('title'),
            'description' => $request->post('description'),
            'invest_target' => $request->post('target', 0),
            'offer_start_date' => $request->post('start_offer', Carbon::now()),
            'offer_end_date' => $request->post('end_offer', Carbon::now()),
            'bumdes_id' => auth()->user()->bumdes->id,
            'status_id' => 1,
        ]);

        if ($request->hasFile('proposal') && $request->file('proposal')->isValid()) {
            $path = Helper::uploadFile('public/proposal', $request->file('proposal'));
            $project->proposal_path = $path;
            $project->save();
        }

        foreach ($request->file('images', []) as $image) {
            $path = Helper::uploadFile('public/images', $image);
            ProjectImage::create([
                'image_path' => $path,
                'project_id' => $project->id,
            ]);
        }

        return redirect('/products')->with('success', 'Product added successfully');
    }

    public function edit(Request $request, int $id)
    {
        $product = Project::where('id', '=', $id)->where('bumdes_id', '=', auth()->user()->bumdes->id)->first();
        if (!$product) return redirect('/products')->with('error', 'Product not found');

        $statuses = ProjectStatus::all();
        return view('dashboard.products.edit', compact(['product', 'statuses']));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|numeric',
            'target' => 'required|numeric',
            'start_offer' => 'required|date',
            'end_offer' => 'required|date',
            'proposal' => 'file|max:25600',
            'images.*' => 'image|max:5120',
        ]);

        $product = Project::where('id', '=', $id)->where('bumdes_id', '=', auth()->user()->bumdes->id)->first();
        if (!$product) return redirect('/products')->with('error', 'Product not found');

        $product->title = $request->post('title', $product->title);
        $product->description = $request->post('description', $product->description);
        $product->status_id = $request->post('status', $product->status_id);
        $product->invest_target = $request->post('target', $product->invest_target);
        $product->offer_start_date = $request->post('start_offer', $product->offer_start_date);
        $product->offer_end_date = $request->post('end_offer', $product->offer_end_date);

        if ($request->hasFile('proposal') && $request->file('proposal')->isValid()) {
            $path = Helper::uploadFile('public/proposal', $request->file('proposal'));
            $product->proposal_path = $path;
        }
        $product->save();

        foreach ($request->file('images', []) as $image) {
            $path = Helper::uploadFile('public/images', $image);
            ProjectImage::create([
                'image_path' => $path,
                'project_id' => $product->id,
            ]);
        }

        return redirect('/products')->with('success', 'Product updated successfully');
    }

    public function delete_proposal(int $id)
    {
        $product = Project::where('id', '=', $id)->where('bumdes_id', '=', auth()->user()->bumdes->id)->first();
        if (!$product) return redirect('/products')->with('error', 'Product not found');

        Helper::deleteFile($product->proposal_path);
        $product->proposal_path = null;
        $product->save();

        return redirect('products/'.$id)->with('success', 'Proposal deleted successfully');
    }

    public function delete_image(Request $request, int $id)
    {
        $request->validate(['image_id' => 'required|numeric']);

        $product = Project::where('id', '=', $id)->where('bumdes_id', '=', auth()->user()->bumdes->id)->first();
        if (!$product) return redirect('/products')->with('error', 'Product not found');
        
        $image = ProjectImage::where('id', '=', $request->post('image_id'))->where('project_id', '=', $product->id)->first();
        if (!$image) return redirect('products/'.$id)->with('error', 'Image not found');

        Helper::deleteFile($image->image_path);
        $image->delete();
        return redirect('products/'.$id)->with('success', 'Image deleted successfully');
    }
}
