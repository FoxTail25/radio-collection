<script setup>
import { ref, nextTick, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import SearchFilter from '@/Components/SearchFilter.vue';

const props = defineProps({
  stations: {
    type: Array,
    default: () => []
  },
  canLogin: Boolean,
  canRegister: Boolean,
});

const audioPlayer = ref(null);    // тег audio
const isPlaying = ref(false);     // проигрывание идёт?
const currentTitle = ref('---');  // наименование активной станции и потока
const playerVisible = ref(false); // показывает/скрывает проигрыватель
const activeStation = ref(null);  // выбранная станция
const currentVolume = ref(0.5);   // громкость.
const searchQuery = ref('');      // текст для фильтрации станций
const isModalOpen = ref(false);   // Модальное окно открыто?
const modalStation = ref(null);   // объект с данными станции в модальном окне

// Отфильтрованные станции для отображения
const filteredStations = computed(() => {
  if (!props.stations) return [];

  const queryText = searchQuery.value.trim().toLowerCase();
  if (!queryText) return props.stations;

  return props.stations.filter((station) =>
    station.name?.toLowerCase().includes(queryText)
  );
});

// Функция для открытия модального окна
const openChannelsModal = (station) => {
  modalStation.value = station;
  isModalOpen.value = true;
};
// Функция для закрытия модального окна
const closeModal = () => {
  isModalOpen.value = false;
  modalStation.value = null;
};

const getLogoUrl = (logo) => {
  if (!logo) return '/img/default-logo.png';
  if (logo.startsWith('http')) return logo;
  if (logo.startsWith('img/')) return '/' + logo;
  return '/storage/' + logo;
};

// Функция запуска конкретного канала
const playRadio = async (url, title) => {
  if (!url) {
    alert("Ссылка на поток отсутствует.");
    return;
  }

  playerVisible.value = true;
  currentTitle.value = title;

  await nextTick();

  if (audioPlayer.value) {
    try {
      audioPlayer.value.src = url;
      audioPlayer.value.volume = currentVolume.value;
      await audioPlayer.value.play();
    } catch (error) {
      console.error("Ошибка воспроизведения потока:", error);
      alert("Не удалось запустить поток. Возможно, ссылка устарела.");
    }
  }
};

// 1) Функция для запуска основного (первого) канала при клике на карточку
const playMainChannel = (station) => {
  if (station.channels && station.channels.length > 0) {
    // Ищем канал с флагом is_main == 1, либо берем первый, если флаг не найден
    const mainChannel = station.channels.find(channel => channel.is_main == 1) || station.channels[0];

    playRadio(mainChannel.stream_url, `${station.name} (${mainChannel.name})`);
    // записываем id карточки в активную
    activeStation.value = station.id;
  } else {
    alert("У этой станции нет доступных каналов.");
  }
};

// функции для дополнительных кнопок управления плеером
const pause = () => {
    audioPlayer.value?.pause();
};
const stop = () => {
    if (audioPlayer.value) {
    audioPlayer.value.pause();
    audioPlayer.value.currentTime = 0;
    }
};
const start = () => {
    audioPlayer.value?.play();
};
const changeVolume = (event) => {
  // event.target.value содержит текущее значение ползунка
  const newVolume = Number(event.target.value);
  currentVolume.value = newVolume;
  if (audioPlayer.value) {
    audioPlayer.value.volume = newVolume;
  }
}
</script>

<template>
    <Head title="Сборник Радиостанций" />

    <div class="min-vh-100 bg-dark text-white d-flex flex-column justify-content-between">
        <!-- Шапка -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <Link class="navbar-brand font-weight-bold text-warning" href="/">📻 Radio Collection</Link>
                <SearchFilter v-model="searchQuery"/>
                <!-- <div class="d-flex border-none">
                <div v-if="$page.props.auth.user">
                    <Link :href="route('dashboard')" class="btn btn-outline-light btn-sm">Личный кабинет</Link>
                </div>
                <div v-else class="gap-2 d-flex">
                    <Link v-if="canLogin" :href="route('login')" class="btn btn-outline-light btn-sm me-2">Войти</Link>
                    <Link v-if="canRegister" :href="route('register')" class="btn btn-warning btn-sm">Регистрация</Link>
                </div>
                </div> -->
            </div>
        </nav>

        <!-- Основная сетка радиостанций -->
        <main class="container my-5 flex-grow-1">
            <div class="row row-cols-2 row-cols-sm-3  row-cols-md-4 row-cols-lg-5 row-cols-xl-5 g-1 g-md-4">
                <div class="col" v-for="station in filteredStations" :key="station.id">

                    <!-- ДОБАВЛЕНО: Клик по карточке запускает основной канал. cursor-pointer делает карточку кликабельной -->
                    <div
                    @click="playMainChannel(station)"
                    class="card h-100 text-white border-secondary shadow station-card position-relative overflow-hidden"
                    :class="{ 'active': activeStation === station.id }"
                    >
                        <!-- СЛОЙ 1: Задний размытый фон (заполняет всю карточку без пустот) -->
                        <img
                            :src="getLogoUrl(station.logo)"
                            loading="lazy"
                            :alt="station.name"
                            class="station-bg-blur"
                        >

                        <!-- СЛОЙ 2: Четкий оригинальный логотип (помещается ЦЕЛИКОМ, не обрезается) -->
                        <div class="station-logo-container">
                            <img
                            :src="getLogoUrl(station.logo)"
                            :alt="station.name"
                            class="station-bg-main"
                            >
                        </div>

                        <!-- СЛОЙ 3: Затемняющая подложка для читаемости текста -->
                        <div class="station-overlay"></div>

                        <!-- СЛОЙ 4: Контент (текст и кнопки) -->
                        <div class="card-body p-3 station-content d-flex flex-column justify-content-between">
                            <div class="d-flex flex-column align-items-center justify-content-center mb-1 text-center">
                            <h5 class="card-title mb-2 fw-bold text-shadow">{{ station.name }}</h5>
                            <p class="card-text text-light small text-shadow" v-if="station.description">
                                {{ station.description }}
                            </p>
                            </div>
                        </div>

                        <!-- Блок каналов -->
                        <div
                            v-if="station.channels && station.channels.length > 1"
                            class="card-footer bg-transparent border-top-0 p-3 pt-0 station-content text-center"
                        >
                            <!-- @click.stop обязателен, чтобы не сработал запуск главного канала карточки -->
                            <button
                                @click.stop="openChannelsModal(station)"
                                class="btn btn-link text-uppercase tracking-wider text-warning small fw-bold text-shadow p-0 text-decoration-none"
                            >
                                каналы ({{ station.channels.length }}) ▾
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    <!-- Панель плеера -->
        <Transition name="fade-player">
            <div v-show="playerVisible" class="bg-dark border-top border-secondary p-3 sticky-bottom shadow-lg">
                <div class="container d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center">
                        <div class="spinner-grow spinner-grow-sm text-success me-2" role="status" v-if="isPlaying"></div>
                        <span class="small">Сейчас играет: <strong class="text-warning">{{ currentTitle }}</strong></span>
                    </div>

                    <div style="display:none;">
                        <audio ref="audioPlayer" controls @play="isPlaying = true" @pause="isPlaying = false"></audio>
                    </div>

                    <div class="d-flex gap-2">
                        <div class="volume-control d-flex align-items-center gap-2" style="max-width: 200px;">
                            <i class="bi bi-volume-up-fill"></i>
                            <input
                            type="range"
                            class="form-range custom-volume"
                            min="0"
                            max="1"
                            step="0.01"
                            v-model.number="currentVolume"
                            @input="changeVolume"
                            :style="{ '--volume-progress': currentVolume * 100 + '%' }"
                            />
                        </div>

                        <button @click="stop" class="image-btn" aria-label="Остановить поток">
                            <img src="/img/btn_img/circle-stop-solid-full.svg" alt="Стоп">
                        </button>

                        <button v-if="isPlaying" @click="pause" class="image-btn" aria-label="Поставить на паузу">
                            <img src="/img/btn_img/circle-pause-solid-full.svg" alt="Пауза">
                        </button>

                        <button v-else @click="start" class="image-btn" aria-label="Воспроизвести">
                            <img src="/img/btn_img/circle-play-solid-full.svg" alt="Старт">
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
        <footer class="text-center p-2 border-top border-secondary text-muted small">
            <p class="mb-0">
            Разработано:
            <a href="https://foxtail25.ru" target="_blank" rel="noopener" class="text-warning text-decoration-none fw-bold hover-underline">
                foxtail25
            </a>
            <span class="mx-2">|</span>
            <a href="https://github.com/FoxTail25" target="_blank" rel="noopener" class="text-white hover-opacity ms-1" aria-label="GitHub профиль">
                <i class="bi bi-github fs-5 align-middle"></i>
            </a>
            </p>
        </footer>
        <!-- Модальное окно со списком каналов -->
        <Transition name="fade-modal">
        <div v-if="isModalOpen && modalStation" class="custom-modal-overlay" @click="closeModal">
            <div class="custom-modal-content bg-dark border border-secondary shadow-lg p-4" @click.stop>

            <!-- Шапка модалки -->
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary pb-2">
                <h5 class="m-0 text-warning fw-bold">
                📻 {{ modalStation.name }} — Каналы
                </h5>
                <button @click="closeModal" class="btn-close btn-close-white" aria-label="Закрыть"></button>
            </div>

            <!-- Список каналов с прокруткой, если их больше 6-7 -->
            <div class="modal-channels-list pe-1" style="max-height: 350px; overflow-y: auto;">
                <div class="d-grid gap-2">
                <button
                    v-for="channel in modalStation.channels"
                    :key="channel.id"
                    @click="playRadio(channel.stream_url, `${modalStation.name} (${channel.name})`); closeModal();"
                    class="btn btn-secondary d-flex justify-content-between align-items-center text-start border-secondary py-2"
                >
                    <span class="fw-bold">{{ channel.name }}</span>
                    <span class="badge bg-primary text-white">▶ Слушать</span>
                </button>
                </div>
            </div>

            </div>
        </div>
        </Transition>
    </div>
</template>

<style scoped>



/* --- КАРТОЧКА СТАНЦИИ --- */
.station-card {
  position: relative;
  overflow: hidden;
  min-height: 200px; /* Баланс высоты */
  cursor: pointer;
  background-color: #1a1d20; /* Темный фон на время загрузки картинки */
  transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
}

.station-card.active {
  background-color: #7b848c !important;
  box-shadow: 0 0 15px rgba(255, 193, 7, 0.8) !important;
}

.station-card:hover {
  transform: translateY(-3px);
  background-color: #7b848c !important;
  box-shadow: 0 0 15px rgba(255, 193, 7, 1.4) !important;
}

/* --- СЛОИ ЛОГОТИПОВ И ФОНА --- */
/* СЛОЙ 1: Размытый задний план */
.station-bg-blur {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  filter: blur(12px) brightness(0.6);
  transform: scale(1.1); /* Скрываем белые края размытия */
  z-index: 1;
  transition: transform 0.5s ease;
}

/* Контейнер для основного логотипа */
.station-logo-container {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  padding: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2;
}

/* СЛОЙ 2: Главный четкий логотип */
.station-bg-main {
  max-width: 90%;
  max-height: 85%;
  object-fit: contain;
  object-position: center;
  transition: transform 0.4s ease-in-out;
}

/* СЛОЙ 3: Общее затемнение (градиент) */
.station-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(180deg, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.75) 100%);
  z-index: 3;
}

/* СЛОЙ 4: Текст и элементы поверх фонов */
.station-content {
  position: relative;
  z-index: 4;
}

.text-shadow {
  text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.9);
}

.opacity-90 {
  background-color: rgba(33, 37, 41, 0.95) !important;
}

/* --- АНИМАЦИИ ПРИ НАВЕДЕНИИ --- */
.station-card:hover .station-bg-blur {
  transform: scale(1.2) rotate(1deg);
}

.station-card:hover .station-bg-main {
  transform: scale(1.06);
}

/* --- РАСКРЫВАЮЩИЙСЯ СПИСОК КАНАЛОВ --- */
.channels-dropdown summary {
  list-style: none;
  outline: none;
  user-select: none;
}
.channels-dropdown summary::-webkit-details-marker {
  display: none;
}
.channels-dropdown summary::after {
  content: ' ▾';
}
.channels-dropdown[open] summary::after {
  content: ' ▴';
}

/* --- КНОПКИ ПЛЕЕРА --- */
.image-btn {
  background: none;
  border: none;
  padding: 0;
  cursor: pointer;
}
.image-btn img {
  display: block;
  width: 35px;
  height: auto;
  transition: transform 0.2s, opacity 0.2s;
  border-radius: 50%;
}
.image-btn:hover img {
  opacity: 0.8;
}
.image-btn:active img {
  transform: scale(0.95);
  box-shadow: 0 0 8px rgba(0, 0, 0, 0.6) !important;
}

/* --- РЕГУЛИРОВКА ГРОМКОСТИ --- */
.custom-volume {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  width: 100%;
  height: 6px;
  border-radius: 3px;
  cursor: pointer;
  background: transparent;
}

/* Дорожка для Chrome, Safari, Edge */
.custom-volume::-webkit-slider-runnable-track {
  width: 100%;
  height: 6px;
  border-radius: 3px;
  background: linear-gradient(
    to right,
    var(--bs-warning) 0%,
    var(--bs-warning) var(--volume-progress),
    var(--bs-gray-300) var(--volume-progress),
    var(--bs-gray-300) 100%
  );
  transition: background 0.1s ease;
}

/* ИСПРАВЛЕНО: Бегунок (круг) для Chrome, Safari, Edge — теперь он не исчезнет */
.custom-volume::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  margin-top: -4px; /* Центрируем круг относительно дорожки ( (6px - 14px) / 2 ) */
  height: 14px;
  width: 14px;
  border-radius: 50%;
  background: var(--bs-warning); /* цвет ползунка */
  border: none;
  transition: transform 0.1s ease;
}
.custom-volume:active::-webkit-slider-thumb {
  transform: scale(1.2);
}

/* Дорожка для Firefox */
.custom-volume::-moz-range-track {
  width: 100%;
  height: 6px;
  border-radius: 3px;
  background: linear-gradient(
    to right,
    var(--bs-warning) 0%,
    var(--bs-warning) var(--volume-progress),
    var(--bs-gray-300) var(--volume-progress),
    var(--bs-gray-300) 100%
  );
}

/* Бегунок для Firefox */
.custom-volume::-moz-range-thumb {
  height: 14px;
  width: 14px;
  border-radius: 50%;
  background: var(--bs-warning); /* цвет ползунка */
  border: none;
  transition: transform 0.1s ease;
}
.custom-volume:active::-moz-range-thumb {
  transform: scale(1.2);
}

/* --- АНИМАЦИЯ ПЛЕЕРА --- */

.fade-player-enter-active,
.fade-player-leave-active {
  transition: transform 0.4s ease, opacity 0.4s ease;
}

/* Состояние до появления и после исчезновения */
.fade-player-enter-from,
.fade-player-leave-to {
  opacity: 0;
  transform: translateY(100%); /* Плеер плавно выезжает снизу */
}
/* --- СТИЛИ ДЛЯ ССЫЛОК В ПОДВАЛЕ --- */
.hover-underline:hover {
  text-decoration: underline !important;
}

.hover-opacity {
  transition: opacity 0.2s ease;
}
.hover-opacity:hover {
  opacity: 0.8;
}
/* --- МОДАЛЬНОЕ ОКНО --- */
.custom-modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6); /* Полупрозрачный темный фон за окном */
  backdrop-filter: blur(4px); /* Легкое размытие заднего плана сайта */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050; /* Поверх плеера и всего остального */
}

.custom-modal-content {
  width: 100%;
  max-width: 450px; /* Оптимальная ширина для списка */
  border-radius: 12px;
  animation: modalSlideUp 0.3s ease;
}

/* Кастомный скроллбар для длинных списков каналов (10 и более) */
.modal-channels-list::-webkit-scrollbar {
  width: 6px;
}
.modal-channels-list::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.05);
  border-radius: 3px;
}
.modal-channels-list::-webkit-scrollbar-thumb {
  background: var(--bs-secondary);
  border-radius: 3px;
}

/* --- АНИМАЦИИ МОДАЛКИ --- */
.fade-modal-enter-active,
.fade-modal-leave-active {
  transition: opacity 0.3s ease;
}
.fade-modal-enter-from,
.fade-modal-leave-to {
  opacity: 0;
}

@keyframes modalSlideUp {
  from {
    transform: translateY(20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}
</style>
