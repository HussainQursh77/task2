<?php

namespace App\Services;
use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Log;
class BookService
{
    public function allBook($category, $title, $author, $item_perpage = 5)
    {
        try {
            $books = Book::byCategory($category)->byTitle($title)->byAuthor($author)->orderBy('created_at', 'DESC')->paginate($item_perpage);
            $formattedBooks = $books->map(function ($book) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'published_at' => $book->published_at,
                    'is_active' => $book->is_active,
                    'category_name' => $book->category ? $book->category->name : null, // Return category name, if available
                ];
            });
            return [
                'status' => 'success',
                'message' => 'all books',
                'data' => $formattedBooks
            ];
        } catch (\Exception $e) {
            log::error('Error featch all book' . $e->getMessage());
            return [
                'status' => 'faild',
                'message' => 'some error occuer when featching all books',
                'data' => null
            ];
        }
    }

    public function storeBook($data)
    {
        try {
            $book = Book::create([
                'title' => $data['title'],
                'author' => $data['author'],
                'published_at' => $data['published_at'],
                'is_active' => $data['is_active'],
                'category_id' => $data['category_id'],
            ]);
            return [
                'status' => 'success',
                'message' => 'store book successfuly',
                'data' => $book
            ];
        } catch (\Exception $e) {
            log::error('Error store book' . $e->getMessage());
            return [
                'status' => 'faild',
                'message' => 'fail store book',
                'data' => null
            ];
        }
    }

    public function showBook($id)
    {
        try {
            $book = Book::findOrFail($id);
            return [
                'status' => 'success',
                'message' => 'featch book',
                'data' => $book
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'status' => 'faild',
                'message' => 'book not found',
                'data' => null
            ];
        } catch (\Exception $e) {
            log::error('Error featch book' . $e->getMessage());
            return [
                'status' => 'faild',
                'message' => 'some error occered whene featch book',
                'data' => null,
            ];
        }
    }

    public function updateBook($data, $id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->update([
                'title' => $data['title'] ?? $book->title,
                'author' => $data['author'] ?? $book->author,
                'published_at' => $data['published_at'] ?? $book->published_at,
                'is_active' => $data['is_active'] ?? $book->is_active,
                'category_id' => $data['category_id'] ?? $book->category_id,
            ]);

            return [
                'status' => 'success',
                'message' => 'updated book successfuly',
                'data' => $book
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'status' => 'faild',
                'message' => 'book not found',
                'data' => null
            ];
        } catch (\Exception $e) {
            log::error('Error update book' . $e->getMessage());
            return [
                'status' => 'faild',
                'message' => 'some error occered whene updating book',
                'data' => null,
            ];
        }
    }

    public function deleteBook($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            return [
                'status' => 'success',
                'message' => 'book deleted succesfuly',
                'data' => null,
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'status' => 'faild',
                'message' => 'book not found',
                'data' => null
            ];
        } catch (\Exception $e) {
            log::error('Error delete book' . $e->getMessage());
            return [
                'status' => 'faild',
                'message' => 'some error occered whene deleting book',
                'data' => null,
            ];
        }
    }
}
