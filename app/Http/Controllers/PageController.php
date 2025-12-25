<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the landing/home page
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        return view('landing');
    }

    /**
     * Display the about us page
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Display the contact page
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Handle contact form submission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitContact(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string',
            'message' => 'required|string|max:1000',
        ]);

        // TODO: Implementasi pengiriman email atau simpan ke database
        // Contoh: Mail::to('admin@optimove.id')->send(new ContactMessage($validated));

        // Untuk sementara, return success response
        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dikirim! Kami akan menghubungi Anda segera.'
        ], 200);
    }
}
