<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

// Принимаем данные (props) из контроллера Laravel
defineProps({
    stations: Array,
    canLogin: Boolean,
    canRegister: Boolean,
});

// Реактивные переменные для управления аудиоплеером
const audioPlayer = ref(null);
const isPlaying = ref(false);
const currentTitle = ref('---');
const playerVisible = ref(false);

// Функция запуска потока радиостанции
const playRadio = (url, title) => {
    playerVisible.value = true;
    currentTitle.value = title;

    if (audioPlayer.value) {
        audioPlayer.value.src = url;
        audioPlayer.value.play()
            .then(() => {
                isPlaying.value = true;
            })
            .catch(error => {
                console.error("Ошибка потока:", error);
                alert("Не удалось запустить поток. Возможно, ссылка устарела.");
            });
    }
};
</script>

<template>
    <Head title="Сборник Радиостанций" />

    <div class="min-vh-screen bg-dark text-white d-flex flex-column justify-content-between">

        <!-- Шапка (Navbar Bootstrap) -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary shadow-sm">
            <div class="container">
                <Link class="navbar-brand font-weight-bold text-warning" href="/">📻 Radio Collection</Link>

                <!-- Блок авторизации пользователей -->
                <div class="d-flex border-none">
                    <div v-if="$page.props.auth.user">
                        <Link :href="route('dashboard')" class="btn btn-outline-light btn-sm">Личный кабинет</Link>
                    </div>
                    <div v-else class="gap-2 d-flex">
                        <Link v-if="canLogin" :href="route('login')" class="btn btn-outline-light btn-sm me-2">Войти</Link>
                        <Link v-if="canRegister" :href="route('register')" class="btn btn-warning btn-sm">Регистрация</Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Основная сетка радиостанций -->
        <main class="container my-5 flex-grow-1">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <div class="col" v-for="station in stations" :key="station.id">
                    <div class="card h-100 bg-secondary text-white border-secondary shadow">

                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <!-- Логотип: проверяем тип пути -->
                                <img :src="station.logo.startsWith('http') ? station.logo : (station.logo.startsWith('img/') ? '/' + station.logo : '/storage/' + station.logo)"
                                     :alt="station.name"
                                     class="img-thumbnail bg-dark border-dark me-3"
                                     style="width: 64px; height: 64px; object-fit: contain;">
                                <h5 class="card-title mb-0">{{ station.name }}</h5>
                            </div>
                            <p class="card-text text-light small" v-if="station.description">{{ station.description }}</p>
                        </div>

                        <!-- Кнопки каналов потока -->
                        <div class="card-footer bg-transparent border-top-0 pt-0">
                            <h6 class="text-uppercase tracking-wider text-muted small mb-2">Доступные потоки:</h6>
                            <div class="d-grid gap-2">
                                <button v-for="channel in station.channels" :key="channel.id"
                                        @click="playRadio(channel.stream_url, station.name + ' (' + channel.name + ')')"
                                        class="btn btn-primary btn-sm d-flex justify-content-between align-items-center text-start">
                                    <span>{{ channel.name }}</span>
                                    <span class="badge bg-dark text-warning">▶ Слушать</span>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>

        <!-- Панель плеера (Фиксированная внизу экрана) -->
        <footer v-if="playerVisible" class="bg-secondary border-top border-dark p-3 sticky-bottom shadow-lg">
            <div class="container d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center">
                    <div class="spinner-grow spinner-grow-sm text-success me-2" role="status" v-if="isPlaying"></div>
                    <span class="small">Сейчас играет: <strong class="text-warning">{{ currentTitle }}</strong></span>
                </div>
                <div>
                    <!-- HTML5 Аудио тег привязанный через ref к Vue -->
                    <audio ref="audioPlayer" controls class="w-100" @play="isPlaying = true" @pause="isPlaying = false"></audio>
                </div>
            </div>
        </footer>

    </div>
</template>

<style scoped>
/* Локальные стили, если понадобятся дополнительные мелкие правки */
</style>
