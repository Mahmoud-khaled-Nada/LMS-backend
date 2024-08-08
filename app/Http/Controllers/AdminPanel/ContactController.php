<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Requests\AdminPanel\CreateContactRequest;
use App\Http\Requests\AdminPanel\UpdateContactRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;
use Flash;

class ContactController extends AppBaseController
{
    private $contactRepository;
    public function __construct(ContactRepository $contactRepo)
    {
        $this->contactRepository = $contactRepo;
        $this->middleware('permission:View Contact|Create Course|Update Course|Delete Course', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create Contact', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update Contact', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Contact', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $contacts = $this->contactRepository->all();
        return view('AdminPanel.contacts.index' , get_defined_vars() );
    }

    public function create()
    {
        return view('AdminPanel.contacts.create');
    }

    public function store(CreateContactRequest $request)
    {
        $input = $request->all();

        $contact = $this->contactRepository->create($input);

        return redirect(route('contacts.index'));
    }

    // public function show($id)
    // {
    //     $contact = $this->contactRepository->find($id);

    //     if (empty($contact)) {
    //         return redirect(route('contacts.index'));
    //     }

    //     return view('contacts.show')->with('contact', $contact);
    // }

    public function edit($id)
    {
        $contact = $this->contactRepository->find($id);
        if (empty($contact)) {
            return redirect(route('contacts.index'));
        }
        return view('AdminPanel.contacts.edit' , get_defined_vars() );
    }

    public function update($id, UpdateContactRequest $request)
    {
        $contact = $this->contactRepository->find($id);

        if (empty($contact)) {
            return redirect(route('contacts.index'));
        }

        $contact = $this->contactRepository->update($request->all(), $id);
        return redirect(route('contacts.index'))->with('success' , __('lang.updated'));
    }

    public function destroy($id)
    {
        $contact = $this->contactRepository->find($id);

        if (empty($contact)) {
            return redirect(route('contacts.index'));
        }

        $this->contactRepository->delete($id);
        return redirect(route('contacts.index'))->with('success' , __('lang.deleted'));
    }
}
