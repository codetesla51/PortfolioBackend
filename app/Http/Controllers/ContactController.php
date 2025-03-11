<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
  /**
   * Store a new contact message.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      "name" => "required|string|max:255",
      "email" => "required|email|max:255",
      "inquiry" => "required|string|max:255",
      "message" => "required|string",
    ]);

    $contact = Contact::create($validated);

    return response()->json(
      [
        "message" => "Inquiry submitted successfully",
        "data" => $contact,
      ],
      201
    );
  }

  /**
   * Get all contact inquiries.
   */
  public function index()
  {
    $contacts = Contact::latest()->get();

    return response()->json([
      "message" => "Contacts retrieved successfully",
      "data" => $contacts,
    ]);
  }

  /**
   * Get a single contact inquiry.
   */
  public function show($id)
  {
    $contact = Contact::findOrFail($id);

    return response()->json([
      "message" => "Contact retrieved successfully",
      "data" => $contact,
    ]);
  }

  /**
   * Mark a contact inquiry as read.
   */
  public function update($id)
  {
    $contact = Contact::findOrFail($id);
    $contact->update(["is_read" => true]);

    return response()->json([
      "message" => "Contact marked as read",
      "data" => $contact,
    ]);
  }

  /**
   * Delete a contact inquiry.
   */
  public function destroy($id)
  {
    $contact = Contact::findOrFail($id);
    $contact->delete();

    return response()->json([
      "message" => "Contact deleted successfully",
    ]);
  }
}
