<script setup>
import { ref, nextTick } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
  stations: Array,
  canLogin: Boolean,
  canRegister: Boolean,
});

const audioPlayer = ref(null);
const isPlaying = ref(false);
const currentTitle = ref('---');
const playerVisible = ref(false);
const activeStation = ref(null);
const currentVolume = ref(0.5);

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
      isPlaying.value = true;
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
    isPlaying.value = false;
        audioPlayer.value.pause();
    // console.log('pause');
};
const stop = () => {
    isPlaying.value = false;
        audioPlayer.value.pause();
        audioPlayer.value.currentTime = 0
    // console.log('stop');
};
const start = () => {
    isPlaying.value = true;
        audioPlayer.value.play();
    // console.log('start');
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary shadow-sm">
      <div class="container">
        <Link class="navbar-brand font-weight-bold text-warning" href="/">📻 Radio Collection</Link>
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
        <div class="col" v-for="station in stations" :key="station.id">

          <!-- ДОБАВЛЕНО: Клик по карточке запускает основной канал. cursor-pointer делает карточку кликабельной -->
            <div
            @click="playMainChannel(station)"
            class="card h-100 text-white border-secondary shadow station-card position-relative overflow-hidden"
            :class="{ 'active': activeStation === station.id }"
            >
                <!-- СЛОЙ 1: Задний размытый фон (заполняет всю карточку без пустот) -->
                <img
                    :src="getLogoUrl(station.logo)"
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
                    class="card-footer bg-transparent border-top-0 p-3 pt-0 station-content"
                >
                    <details class="channels-dropdown text-center" @click.stop>
                    <summary class="text-uppercase tracking-wider text-warning small mb-2 cursor-pointer fw-bold text-shadow">
                        каналы ({{ station.channels.length }})
                    </summary>
                    <div class="d-grid gap-2 mt-2">
                        <button
                        v-for="channel in station.channels"
                        :key="channel.id"
                        @click="playRadio(channel.stream_url, `${station.name} (${channel.name})`)"
                        class="btn btn-dark btn-sm d-flex justify-content-between align-items-center text-start border-secondary opacity-90"
                        >
                        <span>{{ channel.name }}</span>
                        <span class="badge bg-primary text-white">▶ Поток</span>
                        </button>
                    </div>
                    </details>
                </div>
            </div>
        </div>
      </div>
    </main>

    <!-- Панель плеера -->
    <footer v-show="playerVisible" class="bg-secondary border-top border-dark p-3 sticky-bottom shadow-lg">
      <div class="container d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
        <div class="d-flex align-items-center">
          <div class="spinner-grow spinner-grow-sm text-success me-2" role="status" v-if="isPlaying"></div>
          <span class="small">Сейчас играет: <strong class="text-warning">{{ currentTitle }}</strong></span>
        </div>
        <div style="display:none;">
          <audio ref="audioPlayer" controls @play="isPlaying = true" @pause="isPlaying = false"></audio>
        </div>
        <div class="d-flex gap-2">
                <!-- <div>
                    <label>Громкость</label>
                    <input
                        type="range"
                        min="0"
                        max="1"
                        step="0.05"
                        :value="currentVolume"
                        @input="changeVolume"
                    />
                </div> -->
                  <div class="volume-control d-flex align-items-center gap-2" style="max-width: 200px;">
                        <!-- Иконка громкости (Bootstrap Icons для примера) -->
                        <i class="bi bi-volume-up-fill"></i>
                        <!-- Сам ползунок -->
                        <input
                        type="range"
                        class="form-range custom-volume"
                        min="0"
                        max="1"
                        step="0.01"
                        :value.number="currentVolume"
                        @input="changeVolume"
                        :style="{ '--volume-progress': currentVolume * 100 + '%' }"
                        />
                    </div>
            <button @click="stop" class="image-btn" aria-label="кнопка stop">
                <img src="/img/btn_img/circle-stop-solid-full.svg" alt="изображение кнопка stop">
            </button>
            <button @click="pause" class="image-btn" aria-label="кнопка pause">
                <img src="/img/btn_img/circle-pause-solid-full.svg" alt="изображение кнопка stop">
            </button>
            <button @click="start" class="image-btn" aria-label="кнопка play">
                <img src="/img/btn_img/circle-play-solid-full.svg" alt="изображение кнопка stop">
            </button>
        </div>
      </div>
    </footer>
  </div>
</template>

<style scoped>
/* Добавляем стили для улучшения UI взаимодействия */
.station-card {
  cursor: pointer;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.station-card.active {
  background-color: #7b848c !important;

  box-shadow: 0 0 15px rgba(255, 193, 7, 0.8) !important;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.station-card:hover {
  transform: translateY(-3px);

  background-color: #7b848c !important;

  box-shadow: 0 0 15px rgba(255, 193, 7, 1.4) !important;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

/* Стилизация раскрывающегося списка */
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

.station-card {
  position: relative;
  overflow: hidden;
  min-height: 200px; /* Немного увеличим высоту для лучшего баланса */
  cursor: pointer;
  background-color: #1a1d20; /* Темный фон на случай, если картинка долго грузится */
}

/* СЛОЙ 1: Размытый задний план */
.station-bg-blur {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover; /* Заполняет всё пространство */
  object-position: center;
  filter: blur(12px) brightness(0.6); /* Размываем и слегка приглушаем яркость */
  transform: scale(1.1); /* Слегка увеличиваем, чтобы скрыть белые края от размытия */
  z-index: 1;
  transition: transform 0.5s ease;
}

/* Контейнер для основного логотипа (ограничивает его размеры с отступами) */
.station-logo-container {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  padding: 15px; /* Задает отступы от краев карточки, чтобы логотип не прилипал */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2;
}

/* СЛОЙ 2: Главный четкий логотип */
.station-bg-main {
  max-width: 90%;
  max-height: 85%;
  object-fit: contain; /* ВАЖНО: сохраняет пропорции и ПОМЕЩАЕТСЯ целиком, хоть квадрат, хоть прямоугольник */
  object-position: center;
  transition: transform 0.4s ease-in-out;
}

/* СЛОЙ 3: Общее затемнение (градиент) поверх всего фона для текста */
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

/* --- АНИМАЦИИ ПРИ НАВЕДЕНИИ КУРСОРА --- */

/* При наведении на карточку плавно увеличиваем размытый фон */
.station-card:hover .station-bg-blur {
  transform: scale(1.2) rotate(1deg); /* Эффект легкого смещения фона */
}

/* И ОДНОВРЕМЕННО аккуратно увеличиваем сам центральный логотип */
.station-card:hover .station-bg-main {
  transform: scale(1.06);
}
/* стили для кнопок плеера */
.image-btn {
  background: none;    /* Убираем стандартный серый фон кнопки */
  border: none;        /* Убираем рамку */
  padding: 0;          /* Удаляем внутренние отступы */
  cursor: pointer;     /* Меняем курсор при наведении на «палец» */
}
.image-btn img {
  display: block;      /* Убираем лишние нижние отступы у картинки */
  width: 35px;        /* Задайте нужную вам ширину */
  height: auto;        /* Высота подстроится автоматически */
  transition: transform 0.2s, opacity 0.2s; /* Плавный эффект для анимации */
  border-radius: 50%;
}

/* Эффект при наведении (кнопка станет чуть прозрачнее) */
.image-btn:hover img {
  opacity: 0.8;
}

/* Эффект при клике (кнопка визуально уменьшится) */
.image-btn:active img {
  transform: scale(0.95);
  box-shadow:  0 0 15px rgba(0, 0, 0, 0.8) !important;
}

/* стили для регулеровки громкости */
/* 1. Обновляем базовый класс ползунка */
.custom-volume {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  width: 100%;
  height: 6px;
  border-radius: 3px;
  cursor: pointer;

  /* Убедитесь, что здесь цвет фона прозрачный, чтобы градиент был виден */
  background: transparent;
}

/* 2. ДОБАВЛЯЕМ: Стилизация дорожки специально для Chrome, Safari и Edge */
.custom-volume::-webkit-slider-runnable-track {
  width: 100%;
  height: 6px;
  border-radius: 3px;
  /* Переносим градиент именно сюда, внутрь вебкит-трека */
  background: linear-gradient(
    to right,
    var(--bs-primary) 0%,
    var(--bs-primary) var(--volume-progress),
    var(--bs-gray-300) var(--volume-progress),
    var(--bs-gray-300) 100%
  );
  transition: background 0.1s ease;
}

/* 3. ДОБАВЛЯЕМ: Стилизация дорожки для Firefox (для полной кроссбраузерности) */
.custom-volume::-moz-range-track {
  width: 100%;
  height: 6px;
  border-radius: 3px;
  background: linear-gradient(
    to right,
    var(--bs-primary) 0%,
    var(--bs-primary) var(--volume-progress),
    var(--bs-gray-300) var(--volume-progress),
    var(--bs-gray-300) 100%
  );
}

</style>
