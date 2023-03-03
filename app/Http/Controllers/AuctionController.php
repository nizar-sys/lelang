<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestStoreAuction;
use App\Http\Requests\RequestStoreOrUpdateAuction;
use App\Models\Auction;
use App\Models\HistoryAuction;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auctions = Auction::orderByDesc('id');
        $auctions = $auctions->paginate(50);

        return view('dashboard.auctions.index', compact('auctions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::whereItemStatus('0')->orderByDesc('id')->select(['id', 'item_name'])->get();

        return view('dashboard.auctions.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestStoreOrUpdateAuction $request)
    {
        $validated = $request->validated();

        $newAuction = Auction::create($validated);

        return redirect(route('auctions.index'))->with('success', 'Data lelang berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function show(Auction $auction)
    {
        return view('dashboard.auctions.show', compact('auction'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auction $auction)
    {
        $auction->delete();

        return redirect(route('auctions.index'))->with('success', 'Data lelang berhasil dihapus.');
    }

    public function createAuction($auctionId)
    {
        $auction = Auction::findOrFail($auctionId);

        return view('dashboard.auctions.tawar.create', compact('auction'));
    }

    public function storeAuction(RequestStoreAuction $request, $auctionId)
    {
        $auction = Auction::findOrFail($auctionId);
        $auction->historyAuctions()->create([
            'auction_id' => $auctionId,
            'price_quote' => $request->price_qoute,
        ]);

        return redirect(route('auctions.show', $auction->id))->with('success', 'Berhasil menambah penawaran barang.');
    }

    public function deleteAuction($auctionId, $historyAuction)
    {
        $history = HistoryAuction::findOrFail($historyAuction);
        $history->delete();

        return redirect(route('auctions.show', $auctionId))->with('success', 'Berhasil menghapus penawaran barang.');
    }

    public function setStatusAuction($auctionId, $historyAuction)
    {
        $auction = Auction::findOrFail($auctionId);
        $historyAuction = HistoryAuction::findOrFail($historyAuction);

        $auction->update([
            'final_price' => (int) $historyAuction->final_price,
            'status' => 'ditutup',
            'updated_at' => now(),
        ]);

        $historyAuction->update([
            'status' => 'accepted',
            'updated_at' => now(),
        ]);

        $auction->item()->update([
            'item_status' => '1',
            'updated_at' => now(),
        ]);

        return redirect(route('auctions.show', $auctionId))->with('success', 'Berhasil menerima penawaran barang.');
    }
}
