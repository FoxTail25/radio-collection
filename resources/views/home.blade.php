<html lang="ru">
    <x-head />

    <body class="bg-gray-900 text-white min-h-screen flex flex-col justify-between">

        <!-- Шапка -->

        <x-header />

        <!-- Основной контент -->
        <main class="container mx-auto p-4 flex-grow">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($stations as $station)
                    <div
                        class="bg-gray-800 rounded-xl p-5 shadow-md hover:shadow-xl transition flex flex-col justify-between border border-gray-700">
                        <div>
                            <div class="flex items-center space-x-4 mb-4">
                                <!-- Логотип радиостанции -->
                                <img src="{{ Str::startsWith($station->logo, ['http://', 'https://'])
                                                ? $station->logo
                                                : (Str::startsWith($station->logo, 'img/')
                                                    ? asset($station->logo)
                                                    : asset('storage/' . $station->logo)) }}"
                                    alt="{{ $station->name }}"
                                    class="w-16 h-16 object-contain bg-gray-700 rounded-lg p-1">
                                <h2 class="text-xl font-semibold">{{ $station->name }}</h2>
                            </div>
                        </div>

                        <!-- Список каналов/потоков -->
                        <div class="space-y-2">
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Доступные потоки:</p>
                            @foreach ($station->channels as $channel)
                                <button
                                    onclick="playRadio('{{ $channel->stream_url }}', '{{ $station->name }} ({{ $channel->name }})')"
                                    class="w-full bg-indigo-600 hover:bg-indigo-500 text-left py-2 px-3 rounded-lg text-sm font-medium flex justify-between items-center transition">
                                    <span>{{ $channel->name }}</span>
                                    <span class="text-xs bg-indigo-800 px-2 py-0.5 rounded text-indigo-200">▶ Слушать</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </main>

        <!-- Фиксированная панель плеера внизу экрана -->
        <footer id="player-bar"
            class="hidden sticky bottom-0 left-0 right-0 bg-gray-800 border-t border-gray-700 p-4 shadow-2xl flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                <p class="text-sm font-medium">Сейчас играет: <span id="current-title"
                        class="text-indigo-400 font-bold">---</span></p>
            </div>

            <!-- Скрытый HTML5 тег audio и элементы управления -->
            <div class="flex items-center space-x-4 w-full sm:w-auto justify-end">
                <audio id="audio-player" controls class="h-10 rounded-lg bg-gray-950 text-white"></audio>
            </div>
        </footer>

        <!-- Простой и надежный JS скрипт плеера -->
        <script>
            const player = document.getElementById('audio-player');
            const playerBar = document.getElementById('player-bar');
            const currentTitle = document.getElementById('current-title');

            function playRadio(url, title) {
                // Показываем панель плеера, если она была скрыта
                playerBar.classList.remove('hidden');

                // Обновляем название текущей станции
                currentTitle.textContent = title;

                // Меняем аудио-поток и запускаем воспроизведение
                player.src = url;
                player.play().catch(error => {
                    console.error("Ошибка воспроизведения потока:", error);
                    alert("Не удалось запустить этот аудиопоток. Возможно, ссылка устарела.");
                });
            }
        </script>
    </body>

</html>
