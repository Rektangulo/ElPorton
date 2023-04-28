<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Log;
use App\Http\Controllers\Controller;

class ContactMessageController extends Controller
{
	public function index(Request $request)
    {
		$messages = ContactMessage::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.messages', ['messages' => $messages]);
    }
	
    public function toggleImportant(Request $request)
	{
		$messageId = $request->input('messageId');
		$message = ContactMessage::withTrashed()->find($messageId);
		if ($message) {
			$message->important = !$message->important;
			$message->save();
			return response()->json(['isImportant' => $message->important]);
		}
	}

	public function toggleRead(Request $request)
	{
		$messageId = $request->input('messageId');
		$message = ContactMessage::withTrashed()->find($messageId);
		Log::debug($message);
		if ($message) {
			$message->read = !$message->read;
			$message->save();
			return response()->json(['isRead' => $message->read]);
		}
	}

	public function toggleDelete(Request $request)
	{
		$messageId = $request->input('messageId');
		$message = ContactMessage::withTrashed()->find($messageId);
		if ($message) {
			if ($message->trashed()) {
				$message->restore();
			} else {
				$message->delete();
			}
			return response()->json(['isDeleted' => $message->trashed()]);
		}
	}
	
	public function showAll()
	{
		$messages = ContactMessage::orderBy('created_at', 'desc')->get();
		$view = view('admin.messageRender', ['messages' => $messages])->render();
		return response()->json(['view' => $view]);
	}
	
	public function showRead()
	{
		$messages = ContactMessage::where('read', true)->orderBy('created_at', 'desc')->get();
		$view = view('admin.messageRender', ['messages' => $messages])->render();
		return response()->json(['view' => $view]);
	}
	
	public function showImportant()
	{
		$messages = ContactMessage::where('important', true)->orderBy('created_at', 'desc')->get();
		$view = view('admin.messageRender', ['messages' => $messages])->render();
		return response()->json(['view' => $view]);
	}
	
	public function showDeleted()
	{
		$messages = ContactMessage::onlyTrashed()->orderBy('created_at', 'desc')->get();
		$view = view('admin.messageRender', ['messages' => $messages])->render();
		return response()->json(['view' => $view]);
	}
}
