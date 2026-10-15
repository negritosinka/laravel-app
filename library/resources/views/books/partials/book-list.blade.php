<table class="w-full border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-100">
            <th class="border border-gray-300 px-4 py-2">Nosaukums</th>
            <th class="border border-gray-300 px-4 py-2">Autors</th>
            <th class="border border-gray-300 px-4 py-2">Gads</th>
            <th class="border border-gray-300 px-4 py-2">Kategorija</th>
            <th class="border border-gray-300 px-4 py-2">Darbības</th>
        </tr>
    </thead>
    <tbody>
        @forelse($books as $book)
            <tr id="book-row-{{ $book->id }}">
                <td class="border border-gray-300 px-4 py-2">{{ $book->title }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $book->author }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $book->year }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $book->category->name ?? '-' }}</td>
                <td class="border border-gray-300 px-4 py-2 text-center">
                    <a href="{{ route('books.show', $book) }}" class="text-blue-500 mr-2">Skatīt</a>
                    <a href="{{ route('books.edit', $book) }}" class="text-yellow-500 mr-2">Labot</a>
                    <button class="text-red-500 delete-btn" data-id="{{ $book->id }}">Dzēst (AJAX)</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">Nav atrasta neviena grāmata.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $books->links() }}
</div>