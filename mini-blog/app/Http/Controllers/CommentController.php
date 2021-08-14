<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use App\Models\Comment;
use App\Models\User;
use Validator;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class CommentController extends BaseController
{
	
	public function show($ticket_id)
    {
      /*  $ticket = Ticket::find($id);
        if (is_null($ticket)) {
            return $this->sendError('Ticket does not exist.');
        }
        return $this->sendResponse(new TicketResource($ticket), 'Ticket fetched.');
		*/
		$comments = DB::table('comments')
            ->where('ticket_id', $ticket_id)
            ->get();
        return $this->sendResponse($comments, 'Comments of ticket $ticket_id fetched.');
    }
	
     public function store(Request $request, $ticket_id)
    {
		$comment= new Comment();
        $input = $request->all();
		$authUser = Auth::user();
		$comment->comment= $request->input('comment');
		$comment->author_id= $authUser->id;
		$comment->author_name= $authUser->name;
		$comment->approved= false;
		$ticket = Ticket::find($ticket_id);
        $validator = Validator::make($input, [
            'comment' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        // $ticket = Ticket::create($input);
		// $ticket->save();
		$ticket->comment()->save($comment);
        return $this->sendResponse($comment, 'Comment created.');
    }
	
	public function destroy(Comment $comment)
    {
        $comment->delete();
        return $this->sendResponse([], 'Comment deleted.');
    }
}
