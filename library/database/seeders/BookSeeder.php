<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::create([
            'title' => 'Clean Code',
            'author' => 'Robert C. Martin',
            'year' => 2008,
            'category_id' => 3 // Programmēšana
        ]);

        Book::create([
            'title' => 'Laravel: Up and Running',
            'author' => 'Matt Stauffer',
            'year' => 2019,
            'category_id' => 3 // Programmēšana
        ]);

        Book::create([
            'title' => 'Gredzenu pavēlnieks',
            'author' => 'Dž. R. R. Tolkīns',
            'year' => 1954,
            'category_id' => 1 // Fantastika
        ]);
    }
}