<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pievienot jaunu grāmatu</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Вывод ошибок валидации -->
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('books.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Nosaukums</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="border rounded w-full px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Autors</label>
                        <input type="text" name="author" value="{{ old('author') }}" class="border rounded w-full px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Izdošanas gads</label>
                        <input type="number" name="year" value="{{ old('year') }}" class="border rounded w-full px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Kategorija</label>
                        <select name="category_id" class="border rounded w-full px-3 py-2" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Saglabāt</button>
                    <a href="{{ route('books.index') }}" class="ml-2 text-gray-600">Atcelt</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>