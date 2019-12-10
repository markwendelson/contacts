<?php

namespace App\Http\Controllers;

use App\Contacts;
use Illuminate\Http\Request;

class ContactsController extends Controller
{

    public function index()
    {
        $contacts = Contacts::paginate(2);
        return view('welcome',compact('contacts'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $contact = new Contacts();
        $contact->firstname = $request->firstname;
        $contact->lastname = $request->lastname;
        $contact->email = $request->email;
        $contact->contact_no = $request->contact_no;
        $contact->save();

        return $contact;
    }

    public function show($id)
    {
        $contact = Contacts::find($id);
        return $contact;
    }

    public function update(Request $request, $id)
    {
        $contact = Contacts::find($id);
        $contact->firstname = $request->firstname;
        $contact->lastname = $request->lastname;
        $contact->email = $request->email;
        $contact->contact_no = $request->contact_no;
        $contact->save();
    }

    public function destroy($id)
    {
        $contact = Contacts::find($id);
        $contact->delete();
    }
}
