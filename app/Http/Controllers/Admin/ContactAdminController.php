<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactAdminController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);
        return view('admin.contact.index', compact('messages'));
    }

    public function show(int $id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => true]);
        return view('admin.contact.show', compact('message'));
    }

    public function reply(Request $request, int $id)
    {
        $data    = $request->validate(['admin_reply' => 'required|string']);
        $message = ContactMessage::findOrFail($id);
        $message->update(['admin_reply' => $data['admin_reply'], 'replied_at' => now()]);
        return back()->with('success','Balasan berhasil disimpan.');
    }

    public function destroy(int $id)
    {
        ContactMessage::findOrFail($id)->delete();
        return back()->with('success','Pesan dihapus.');
    }
}
