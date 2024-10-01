<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = $request->input('category');
        $title = $request->input('title');
        $author = $request->input('author');
        $item_perpage = $request->input('item_perpage');
        $response = $this->bookService->allBook($category, $title, $author, $item_perpage);
        return response()->json($response, $response['status'] == 'success' ? 200 : 400);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $validatedData = $request->validated();
        $response = $this->bookService->storeBook($validatedData);
        return response()->json($response, $response['status'] == 'success' ? 200 : 400);
    }

    /**
     * Display the specified resource.
     */
    public function show($bookId)
    {
        $response = $this->bookService->showBook($bookId);
        return response()->json($response, $response['status'] == 'success' ? 200 : ($response['message'] == 'book not found' ? 404 : 400));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, $bookId)
    {
        $validatedDate = $request->validationData();
        // dd($validatedDate);
        $response = $this->bookService->updateBook($validatedDate, $bookId);
        return response()->json($response, $response['status'] == 'success' ? 200 : ($response['message'] == 'book not found' ? 404 : 400));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bookId)
    {
        $response = $this->bookService->deleteBook($bookId);
        return response()->json($response, $response['status'] == 'success' ? 200 : ($response['message'] == 'book not found' ? 404 : 400));

    }
}
