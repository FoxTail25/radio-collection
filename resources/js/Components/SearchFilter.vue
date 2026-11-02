<script setup>
// defineModel автоматически создает реактивную связь с v-model родителя.
// Больше не нужны props, emits, локальный ref и watch!
const searchQuery = defineModel({ type: String, default: '' })
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
