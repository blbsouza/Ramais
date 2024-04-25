// Utilities
import { defineStore } from 'pinia'

export const useAppStore = defineStore('app', {
  state: () => ({
    //
    prod: false,
    url: "https://srvsave158/ramais/php/",
    json: {},
    initialLoading: true,
    desserts: [],
    refresh: false,
    search: null,
    version: 2.0
  })
})
