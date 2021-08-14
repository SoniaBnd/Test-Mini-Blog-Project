<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;


use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\Ticket as TicketResource;
use Illuminate\Http\Request;

class TicketController extends BaseController
{
     public function index(Request $request)
    {
		
        $tickets = Ticket::all();
        return $this->sendResponse(TicketResource::collection($tickets), 'Tickets fetched.');
		
    }
	
	  public function mytickets()
    {
		$authUser = Auth::user();
		$tickets = DB::table('tickets')
            ->where('author', $authUser->id)
            ->get();
        return $this->sendResponse(TicketResource::collection($tickets), 'My Tickets fetched.');
    }

    
    public function store(Request $request)
    {
		$ticket= new Ticket();
         $input = $request->all();
		$authUser = Auth::user();
		$ticket->title= $request->input('title');
		$ticket->author= $authUser->id;
		$ticket->description= $request->input('description');
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        // $ticket = Ticket::create($input);
		$ticket->save();
        return $this->sendResponse(new TicketResource($ticket), 'Ticket created.');
    }

   
    public function show($id)
    {
        $ticket = Ticket::find($id);
        if (is_null($ticket)) {
            return $this->sendError('Ticket does not exist.');
        }
        return $this->sendResponse(new TicketResource($ticket), 'Ticket fetched.');
    }
    

    public function update(Request $request, Ticket $ticket)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $ticket->title = $input['title'];
        $ticket->description = $input['description'];
        $ticket->save();
        
        return $this->sendResponse(new TicketResource($ticket), 'Ticket updated.');
    }
   
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return $this->sendResponse([], 'Ticket deleted.');
    }
}
