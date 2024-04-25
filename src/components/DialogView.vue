<script setup>
import { useAppStore } from '@/stores/app'
import axios from 'axios'
import { ref } from 'vue'
// refs
const dialog = ref(false)
const rml = ref(null)
const dsc = ref('')
const switcher = ref(true)
const form = ref()
const valid = ref(false)
const toast = ref()
const loading = ref(false)
//
const store = useAppStore()
const sizeLength = [
  v => !!v || 'Precisa preencher o Número',
  v => (v && v.length <= 15) || 'Máximo de 15 caracteres atingido...',
]
const sizeLengthDsc = [
  v => !!v || 'Precisa preencher a descrição',
  v => (v && v.length <= 50) || 'Máximo de 50 caracteres atingido...',
]
// functions
const saveAdd = async () => {
  loading.value = true
  if ( valid.value === true ) {
    let typ = switcher.value ? 2 : 1
    await axios.get(store.url+'cad.php?rml='+rml.value+'&dsc='+dsc.value+'&typ='+typ)
      .then(r => {
        if ( r.data.typ == 0 ) {
          toast.value.show({m: 'Este ramal já existe', t: 2})
        } else {
          toast.value.show({m: 'Ramal '+ rml.value +' adcionado com sucesso!'})
          rml.value = null
          dsc.value = ''
          dialog.value = false
          store.refresh = true
        }
      })
      .catch(e => toast.value.show({t: 2, m:"ERRO: Não foi possível salvar no momento. ERROR: "+e}))
  }
  loading.value = false
}
</script>

<template>
  <v-dialog
    transition="dialog-bottom-transition"
    max-width="600"
    v-model="dialog"
  >
    <v-card>
      <v-toolbar
        color="deep-orange"
        density="compact"
      >
        <v-card-title>CADASTRAR RAMAL</v-card-title>
      </v-toolbar>
      <v-card-text class="pt-2">
        <v-form ref="form" v-model="valid">
          <v-text-field
            v-model="rml"
            label="Ramal"
            placeholder="Digite o número do ramal (ex.: 7815)"
            type="number"
            color="deep-orange"
            :counter="15"
            clearable
            variant="outlined"
            :rules="sizeLength"
          />
          <v-text-field
            v-model="dsc"
            label="Descrição"
            placeholder="Digite a descrição do ramal (ex.: CPD)"
            color="deep-orange"
            :counter="50"
            clearable
            variant="outlined"
            :rules="sizeLengthDsc"
          />
          <v-switch
            v-model="switcher"
            :label="`Tipo: Ramal ${switcher ? 'Móvel' : 'Fixo'}`"
            color="deep-orange"
          ></v-switch>
        </v-form>
        <v-btn
          class="bg-success"
          @click="saveAdd()"
          :disabled="!valid"
          :loading="loading"
        >SALVAR</v-btn>
      </v-card-text>
      <v-card-actions class="justify-end">
        <v-btn
          text
          @click="dialog = false"
        >FECHAR</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  <v-btn
    color="deep-orange"
    icon
    @click="dialog = true"
  >
    <v-icon size="x-large">mdi-plus-circle</v-icon>
    <v-tooltip activator="parent" location="bottom">Adicionar Ramal</v-tooltip>
  </v-btn>
  <app-alert ref="toast" />
</template>