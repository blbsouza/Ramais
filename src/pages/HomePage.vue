<script setup>
import { useAppStore } from '@/stores/app'
import axios from 'axios'
import { ref } from 'vue'
//
const store = useAppStore()
const edit = ref()
const confirm = ref()
const toast = ref()
//
const deleting = async (rml) => {
  if ( await confirm.value.open('Exclusão', 'Deseja excluir o ramal '+rml+'?') === true ) {
    await axios.get(store.url+'delete.php?rml='+rml)
      .then(() => {
        toast.value.show({m: 'Deletado com sucesso!'})
        store.refresh = true
      })
  }
}
</script>

<style scoped>
.icon {
  color: #ddd !important
}
.icon:hover {
  color: #666 !important
}
</style>

<template>
  <home-loading />
  <div v-if="!store.initialLoading">
    <AppBar />
    <v-col>
      <toolbar-view />
      <app-alert ref="toast" />
      <edit-dialog ref="edit" />
      <confirm-view ref="confirm" />
      <v-row
        dense
        class="flex-wrap justify-space-between py-3"
        style="overflow-y: auto !important;height: 83vh;"
        v-if="store.desserts.length > 0"
      >
        <v-card
          v-for="v in store.desserts"
          :key="v.rml"
          class="mt-2 mr-2 py-2"
          style="width: 19%;height: fit-content;"
          elevation="4"
        >
          <v-row dense>
            <v-card-title class="py-0 pl-3 text-deep-orange font-weight-bold text-title-1">{{ v.rml }}</v-card-title>
            <v-spacer />
            <v-icon color="grey-lighten-2 mr-2">mdi-{{ v.tipo == 2 ? 'cellphone-basic' : 'phone-classic' }}</v-icon>
          </v-row>
          <span class="pl-3 text-grey text-caption">{{v.dsc}}</span>
          <v-divider />
          <v-row dense class="justify-end pt-2 pr-2">
            <v-btn
              size="x-small"
              class="mr-2"
              icon
              @click="edit.open({rml: v.rml, dsc: v.dsc, typ: v.tipo})"
            >
              <v-icon size="large" class="icon">mdi-pencil</v-icon>
              <v-tooltip activator="parent" location="bottom">Editar ramal {{ v.rml }}</v-tooltip>
            </v-btn>
            <v-btn
              size="x-small"
              icon
              @click="deleting(v.rml)"
            >
              <v-icon size="large" class="icon">mdi-delete</v-icon>
              <v-tooltip activator="parent" location="bottom">Excluir ramal {{ v.rml }}</v-tooltip>
            </v-btn>
          </v-row>
        </v-card>
      </v-row>
      <v-row
        v-else
        dense
        class="justify-center"
      >
        <v-car-title>Nenhum Ramal encontrado</v-car-title>
      </v-row>
    </v-col>
  </div>
</template>
