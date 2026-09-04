<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;

class ExpenseController extends Controller
{
    // GET /api/expenses
    public function index(): JsonResponse
    {
        $expenses = Expense::orderBy('date', 'desc')->get();

        return response()->json(
            ExpenseResource::collection($expenses)
        );
    }

    // POST /api/expenses
    public function store(StoreExpenseRequest $request): JsonResponse
    {
        $expense = Expense::create($request->validated());

        return response()->json(new ExpenseResource($expense), 201);
    }

    // GET /api/expenses/{expense}
    public function show(Expense $expense): JsonResponse
    {
        // Laravel resolves {expense} to a model automatically (route model binding).
        // If the id doesn't exist, Laravel auto-returns a 404 before this method even runs.
        return response()->json(new ExpenseResource($expense));
    }

    // PUT/PATCH /api/expenses/{expense}
    public function update(UpdateExpenseRequest $request, Expense $expense): JsonResponse
    {
        $expense->update($request->validated());

        return response()->json(new ExpenseResource($expense));
    }

    // DELETE /api/expenses/{expense}
    public function destroy(Expense $expense): JsonResponse
    {
        $expense->delete();

        return response()->json(null, 204);
    }
}