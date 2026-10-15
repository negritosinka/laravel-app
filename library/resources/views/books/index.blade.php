<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Grāmatu bibliotēka
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('books.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        + Pievienot grāmatu
                    </a>
                    
                    <!-- Поле поиска для AJAX -->
                    <div>
                        <input type="text" id="search" placeholder="Meklēt grāmatu..." class="border rounded px-3 py-2">
                    </div>
                </div>

                <!-- Таблица с книгами -->
                <div id="book-table-container">
                    @include('books.partials.book-list')
                </div>

            </div>
        </div>
    </div>

    <!-- AJAX скрипт для удаления и поиска -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');

            // Живой поиск (AJAX)
            searchInput.addEventListener('input', function () {
                let query = this.value;

                fetch(`{{ route('books.index') }}?search=${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('book-table-container').innerHTML = html;
                    attachDeleteListeners();
                });
            });

            // Функция для привязки событий удаления к кнопкам
            function attachDeleteListeners() {
                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        if (!confirm('Vai tiešām vēlaties dzēst šo grāmatu?')) return;

                        let bookId = this.dataset.id;
                        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        fetch(`/books/${bookId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Удаляем строку из таблицы без перезагрузки
                                document.getElementById(`book-row-${bookId}`).remove();
                            }
                        });
                    });
                });
            }

            attachDeleteListeners();
        });
    </script>
</x-app-layout>