<?php

namespace App\Http\Controllers\Backend;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class BackendContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       // ជម្រើសសម្រាប់ទំហំនៃការបង្ហាញទិន្នន័យក្នុងមួយទំព័រ
        $perPageOptions = [10, 30, 50, 100];

        // យកតម្លៃ per_page ពី Request ឬកំណត់ default 10
        $perPage = $request->input('per_page', 10);

        // 💡 ផ្លាស់ប្តូរទៅ Contact Model
        $data = Contact::orderBy('id', 'desc')->paginate($perPage)->withQueryString();

        // 💡 ផ្លាស់ប្តូរ View ទៅកាន់ទីតាំងត្រឹមត្រូវសម្រាប់ Contact (ឧ. contacts.index)
    return view('backend.contact.index', compact('data', 'perPage', 'perPageOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // // View សម្រាប់ Admin បង្កើត Contact ថ្មី (ឧទាហរណ៍៖ កត់ត្រាការទំនាក់ទំនងតាមទូរស័ព្ទ)
        // return view('backend.contact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            Contact::create([
                'name'      => $validatedData['name'],
                'email'     => $validatedData['email'],
                'phone'     => $validatedData['phone'],
                'subject'   => $validatedData['subject'],
                'message'   => $validatedData['message'],

                // Sets 'created_by' to user ID if logged in, otherwise null.
                'created_by' => Auth::check() ? Auth::id() : null,
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Your message has been sent successfully.');

        } catch (\Exception $e) {
            DB::rollback();

            // Redirect back with a general error and sticky data
            return redirect()->back()
                ->withInput()
                ->withErrors(['submission' => 'Failed to send message. Please try again later.']);
        }
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
        // {
        //     $contact = Contact::findOrFail($id);
        //     return view('backend.contact.edit', compact('contact'));
        // }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // // 1. ស្វែងរក Contact
        // $contact = Contact::findOrFail($id);

        // // 💡 ព្រមាន៖ មិនមាន Validation ទេ ដូច្នេះទិន្នន័យមិនត្រឹមត្រូវអាចត្រូវបានបញ្ចូល
        // // (ខ្ញុំបានលុប $request->validate() ចេញតាមសំណើរបស់អ្នក)

        // DB::beginTransaction();

        // try {
        //     // 2. រៀបចំទិន្នន័យដោយប្រើ Field Names របស់ Contact
        //     $data = $request->all();

        //     $contact->update([
        //         'name'    => $request->name,
        //         'email'   => $request->email,
        //         'phone'   => $request->phone,
        //         'subject' => $request->subject,
        //         'message' => $request->message,
        //     ]);

        //     // 3. បន្ថែម Field សម្រាប់ Updated By
        //     // 💡 ប្រើ Auth::id() គឺងាយស្រួលជាង Auth::user()->id
        //     $data['updated_by'] = Auth::id();

        //     // 4. Update Contact
        //     $contact->update($data); // ប្រើ $contact ដែលបានរកឃើញ

        //     // Commit Transaction
        //     DB::commit();
        //     Toastr::success('Updated Conact successfully.','Success');

        //     return redirect('/admins/backend-contact');

        // } catch (\Exception $e) {
        //     DB::rollback();
        //     Toastr::error('Updated Contact fail','Error');
        //     return redirect()->back();
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
