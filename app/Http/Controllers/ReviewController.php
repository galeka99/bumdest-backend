<?php

namespace App\Http\Controllers;

use App\Models\Bumdes;
use App\Models\Review;
use App\Models\Visitor;
use Illuminate\Http\Request;
use stdClass;

class ReviewController extends Controller
{

    public function review(Request $request, string $bumdes_code)
    {
        $bumdes = Bumdes::where('code', $bumdes_code)->first();
        if (!$bumdes) return redirect('/login')->with('error', 'BUMDes not found');

        $reviews = Review::where('bumdes_id', $bumdes->id)->orderBy('updated_at', 'DESC')->take(10)->get();

        return view('review', compact('bumdes', 'reviews'));
    }

    public function submit_review(Request $request, string $code)
    {
        $request->validate([
            'google_id' => 'numeric|required',
            'image_url' => 'string|required',
            'name' => 'string|required',
            'email' => 'email|required',
            'rating' => 'numeric|required|min:1|max:5',
            'review' => 'string|nullable'
        ]);

        $bumdes = Bumdes::where('code', $code)->first();
        if (!$bumdes) return redirect($request->headers->get('referer'))->with('error', 'BUMDes not found');

        $visitor = Visitor::where('google_id', $request->post('google_id'))->first();
        if (!$visitor) {
            $visitor = Visitor::create([
                'google_id' => $request->post('google_id'),
                'email' => $request->post('email'),
                'name' => $request->post('name'),
                'image_url' => $request->post('image_url'),
            ]);
        } else {
            $visitor->name = $request->post('name');
            $visitor->image_url = $request->post('image_url');
            $visitor->save();
        }

        $review = Review::where('visitor_id', $visitor->id)->where('bumdes_id', $bumdes->id)->first();
        if (!$review) {
            Review::create([
                'visitor_id' => $visitor->id,
                'bumdes_id' => $bumdes->id,
                'rating' => $request->post('rating'),
                'description' => $request->post('review'),
            ]);
        } else {
            $review->rating = $request->post('rating');
            $review->description = $request->post('review');
            $review->save();
        }

        return redirect($request->headers->get('referer'))->with('success', 'Success reviewed '.$bumdes->name);
    }
}
