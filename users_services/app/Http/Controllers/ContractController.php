<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ContractResource;
use App\Http\Resources\ContractCollection;

class ContractController extends Controller
{
    /**
     * Display a listing of contracts.
     */
    public function index()
    {
        $contracts = Contract::with('user')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => new ContractCollection($contracts)
        ]);
    }

    /**
     * Store a newly created contract.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:draft,active,expired,terminated',
            'amount' => 'required|numeric|min:0',
            'terms' => 'nullable|string',
            'contract_file_path' => 'nullable|string'
        ]);

        $contract = Contract::create($validated);

        return response()->json([
            'success' => true,
            'data' => new ContractResource($contract->load('user'))
        ], 201);
    }

    /**
     * Display the specified contract.
     */
    public function show($id)
    {
        $contract = Contract::with('user')->find($id);

        if (!$contract) {
            return response()->json([
                'success' => false,
                'message' => 'Contract not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new ContractResource($contract)
        ]);
    }

    /**
     * Update the specified contract.
     */
    public function update(Request $request, $id)
    {
        $contract = Contract::find($id);

        if (!$contract) {
            return response()->json([
                'success' => false,
                'message' => 'Contract not found'
            ], 404);
        }

        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
            'status' => 'sometimes|in:draft,active,expired,terminated',
            'amount' => 'sometimes|numeric|min:0',
            'terms' => 'nullable|string',
            'contract_file_path' => 'nullable|string'
        ]);

        $contract->update($validated);

        return response()->json([
            'success' => true,
            'data' => new ContractResource($contract->fresh()->load('user'))
        ]);
    }

    /**
     * Remove the specified contract.
     */
    public function destroy($id)
    {
        $contract = Contract::find($id);

        if (!$contract) {
            return response()->json([
                'success' => false,
                'message' => 'Contract not found'
            ], 404);
        }

        $contract->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contract deleted successfully'
        ]);
    }

    /**
     * Get contracts by status.
     */
    public function byStatus($status)
    {
        $validStatuses = ['draft', 'active', 'expired', 'terminated'];

        if (!in_array($status, $validStatuses)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid contract status'
            ], 400);
        }

        $contracts = Contract::with('user')
            ->where('status', $status)
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => new ContractCollection($contracts)
        ]);
    }
}
