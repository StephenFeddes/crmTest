<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tickets.index', [
            'user'=>auth()->user()
        ]);
    }

    public function fetchTickets() {
        $tickets = Ticket::all();
        $ticketsList = [];
        foreach ($tickets as $ticket) {
            $assignedEmployee = DB::select("SELECT id, first_name, last_name, department_name  FROM employee WHERE id = $ticket->assigned_to_id")[0];
            $ticketsList[] = [$ticket, $assignedEmployee];
        }

        return response()->json([
            'tickets'=>$ticketsList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
