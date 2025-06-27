<?php

namespace App\Http\Controllers;

use App\Services\MemberService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
    protected MemberService $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $credentials = $request->validate([
                'username' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'number' => 'required|integer|unique:users,number|min:10',
            ]);

            $member = $this->memberService->createAccountMember($credentials);

            return response()->json([
                'message' => "Member account with name $member->username has been created",
                'data' => $member
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'failed to create a member account',
                'error' => $e->errors()
            ], 500);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
