<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function markAsProcessed($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update([
            'is_processed' => true,
            'processed_by' => auth()->id(),
            'processed_at' => now()
        ]);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Đã xác nhận xử lý liên hệ thành công');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Đã xóa liên hệ thành công');
    }
}
