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
                class="card h-100 bg-secondary text-white border-secondary shadow station-card"
                :class="{ 'active': activeStation === station.id }"
            >
                <div class="card-body p-2">
                    <div class="d-flex flex-column align-items-center justify-content-center mb-1">
                        <img
                        :src="getLogoUrl(station.logo)"
                        :alt="station.name"

                        class="img-thumbnail bg-dark border-dark"
                        style="width: 64px; height: 64px; object-fit: contain;"
                        >
                        <h5 class="card-title mb-0">{{ station.name }}</h5>
                    </div>
                    <p class="card-text text-light small" v-if="station.description">
                        {{ station.description }}
                    </p>
                </div>

                <!-- 2) Блок каналов (отображается только если каналов > 1) -->
                <div
                v-if="station.channels && station.channels.length > 1"
                class="card-footer bg-transparent border-top-0 p-0"
                >
                <!-- Используем HTML5 тег <details> для чистого раскрывающегося списка без лишнего JS -->
                <!-- @click.stop останавливает всплытие клика, чтобы при раскрытии списка не перезапускалось основное радио -->
                    <details class="channels-dropdown text-center" @click.stop>
                        <summary class="text-uppercase tracking-wider text-warning small mb-2 cursor-pointer">
                        каналы ({{ station.channels.length }})
                        </summary>
                        <div class="d-grid gap-2 mt-2">
                            <button
                                v-for="channel in station.channels"
                                :key="channel.id"
                                @click="playRadio(channel.stream_url, `${station.name} (${channel.name})`)"
                                class="btn btn-dark btn-sm d-flex justify-content-between align-items-center text-start border-secondary"
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
                <div>
                <label>Громкость</label>
                <input
                    type="range"
                    min="0"
                    max="1"
                    step="0.05"
                    :value="currentVolume"
                    @input="changeVolume"
                />
                </div>
            <button @click="stop">
                &#9209; stop
            </button>
            <button @click="pause">
                &#9208; pause
            </button>
            <button @click="start">
                ▶ play
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


.cursor-pointer {
  cursor: pointer;
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


</style>
