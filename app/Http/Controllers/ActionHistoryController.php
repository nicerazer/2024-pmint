<?php

namespace App\Http\Controllers;

use App\Models\ActionHistory;
use App\Http\Requests\StoreActionHistoryRequest;
use App\Http\Requests\UpdateActionHistoryRequest;

class ActionHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actionHistory = ActionHistory::latest()->paginate();

        return view('action-history.index', [
            'actionHistory' => $actionHistory
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ActionHistory $actionHistory)
    {
        return view('action-history.show', $actionHistory);
    }
}
