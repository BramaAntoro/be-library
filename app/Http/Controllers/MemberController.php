<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MemberService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    public function index(Request $request)
    {
        try {

            $search = $request->query('search');

            if ($search) {
                $members = $this->memberService->searchMember($search);

                return response()->json([
                    "message" => "Search result",
                    'data' => $members
                ], 200);
            }

            $members = $this->memberService->getAllMembers();

            return response()->json([
                "message" => "Data members",
                'data' => $members
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "failed to retrieve member data",
                'error' => $e->getMessage()
            ], 500);
        }
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
                'errors' => $e->errors()
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
        try {

            $credentials = $request->validate([
                'username' => 'string',
                'email' => 'email|unique:users,email',
                'password' => 'min:6',
                'number' => 'integer|unique:users,number|min:10',
            ]);

            $updatedMember = $this->memberService->UpdateMember($id, $credentials);

            return response()->json([
                "message" => "Member $updatedMember->username successfully updated",
                "data" => $updatedMember
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'failed to update a member account',
                'error' => $e->errors()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $this->memberService->deleteMember($id);

            return response()->json([
                'message' => 'Member successfully deleted'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                "message" => "member not found",
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Member failed to delete",
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
