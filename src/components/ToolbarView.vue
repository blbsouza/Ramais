<script setup>
import { useAppStore } from '@/stores/app'
import { utils, writeFile } from 'xlsx'
//
const store = useAppStore()
//
async function export_data() {
  const raw_data = await (await fetch(store.url+'data.php')).json();
  const rows = raw_data.map(row => ({
    ramal: row.rml,
    desc: row.dsc,
    tipo: row.tipo === 1 ? 'Fixo' : 'Móvel'
  }))
  const worksheet = utils.json_to_sheet(rows);
  /* generate worksheet and workbook */
  const workbook = utils.book_new();
  utils.book_append_sheet(workbook, worksheet, "Ramais");

  /* fix headers */
  utils.sheet_add_aoa(worksheet, [["RAMAL", "DESCRIÇÃO", "TIPO"]], { origin: "A1" });

  /* calculate column width */
  // const max_width = raw_data.reduce((w, r) => Math.max(w, r.name.length), 10);
  // worksheet["!cols"] = [ { wch: max_width } ];

  /* create an XLSX file and try to save to Presidents.xlsx */
  writeFile(workbook, "Ramais.xlsx", { compression: true });
}
</script>

<template>
  <v-toolbar
    density="compact"
    flat
    color="transparent"
  >
    <dialog-view />
    <v-spacer />
    <v-btn
      icon
      @click="export_data()"
      color="#1D6F42"
    >
      <v-icon size="large">mdi-file-excel</v-icon>
      <v-tooltip activator="parent">Gerar planilha de Ramais em excel</v-tooltip>
    </v-btn>
    <div class="w-25">
      <v-text-field
        placeholder="Pesquisar Ramal..."
        density="compact"
        color="deep-orange"
        variant="outlined"
        prepend-inner-icon="mdi-magnify"
        clearable
        hide-details
        @click:clear="store.refresh = true"
        v-model="store.search"
      />
    </div>
  </v-toolbar>
</template>