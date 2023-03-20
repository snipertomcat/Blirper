<?php

namespace Tests\Unit;

use App\Services\BooksApiService;
use Tests\TestCase;

class ApiServiceTest extends TestCase
{
    private BooksApiService $booksApiService;

    public function setUp(): void
    {
        $this->booksApiService = new BooksApiService();
    }

    public function test_can_get_token_using_book_service()
    {
        $data = $this->booksApiService->index();
        dd($data);
    }
}
