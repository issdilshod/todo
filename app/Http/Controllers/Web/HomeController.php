<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardResource;
use App\Models\Card;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $data['cards'] = CardResource::collection(Card::orderBy('updated_at', 'desc')->where('user_id', auth()->user()->id)->paginate(20))->resolve();

        return view('pages.home', $data);
    }

    public function getList()
    {
        $cards = CardResource::collection(Card::orderBy('updated_at')->where('user_id', auth()->user()->id)->paginate(20))->resolve();
        return $cards;
    }

    public function getCard(Request $request, $id)
    {
        $card = new CardResource(Card::where('id', $id)->first());
        $card = $card->resolve();
        return $card;
    }

    public function createCard(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'img' => 'nullable|image|max:10240'
        ]);
        $validated['user_id'] = auth()->user()->id;

        if (isset($validated['img'])){
            $time = time();
            $filename = $validated['user_id'].'/'.$time.$request->file('img')->getClientOriginalName();
            $path = $request->file('img')->storeAs('images', $filename, 'public');
            $validated['img'] = '/storage/'.$path;
        }

        $card = new CardResource(Card::create($validated));
        $card = $card->resolve();

        return $card;
    }

    public function updateCard(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'img' => 'nullable|image|max:10240'
        ]);
        
        $card = Card::where('id', $id)->first();

        if (isset($validated['img'])){
            $time = time();
            $filename = auth()->user()->id.'/'.$time.$request->file('img')->getClientOriginalName();
            $path = $request->file('img')->storeAs('images', $filename, 'public');
            $validated['img'] = '/storage/'.$path;
        }

        $card->update($validated);

        $card = new CardResource($card);
        $card = $card->resolve();

        return $card;
    }

}
