<script setup>
import { ref, watch } from 'vue'

// Принимаем начальное значение (опционально)
const props = defineProps({
  modelValue: String
})

// Объявляем событие обновления значения для v-model
const emit = defineEmits(['update:modelValue'])

const searchQuery = ref(props.modelValue || '')

// Следим за вводом и сразу отправляем данные родителю
watch(searchQuery, (newValue) => {
  emit('update:modelValue', newValue)
})
</script>

<template>
  <div class="search-container my-2">
    <div class="input-group shadow-sm rounded-pill overflow-hidden">
      <span class="input-group-text bg-white border-end-0 ps-3">
        <i class="bi bi-search text-muted"></i>
      </span>
      <input
        v-model="searchQuery"
        type="text"
        class="form-control border-start-0 px-2 py-2"
        placeholder="Поиск радиостанций..."
      />
    </div>
  </div>
</template>

<style scoped>
.input-group:focus-within {
  box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}
.form-control:focus {
  box-shadow: none;
}
</style>
