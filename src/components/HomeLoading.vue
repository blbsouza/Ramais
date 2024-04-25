<script setup>
import { useAppStore } from '@/stores/app'
//
const store = useAppStore()
</script>

<template>
  <div v-if="store.initialLoading" class="d-flex align-center justify-center bg-white position-absolute w-100 h-100">
    <v-progress-circular
      :size="90"
      :width="7"
      color="#ff4500"
      indeterminate
    >
      <template v-slot:default>
        <v-img src="@/assets/rama.svg" width="30" />
      </template>
    </v-progress-circular>
  </div>
</template>