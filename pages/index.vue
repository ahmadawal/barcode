<template>
  <v-layout
    column
    justify-center
    align-left
  >
    <v-flex >
      <template>
        <!-- <v-alert type="success">
          {{ alert }}
        </v-alert> -->
        <v-form v-model="valid" ref="form" lazy-validation>
          <v-row>
            <v-col
              cols="3"
            >
              <v-text-field
                label="Nomor OP"
                v-model="op"
                :rules="opRules"
                :counter="6"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="4">
              <v-btn
                @click="searchOP"
                color="primary"
                rounded
                elevation-2
                pr3
                :disabled="!op"
              >
                <v-icon dark>mdi-magnify</v-icon>
                &nbsp;
                Cari Data
              </v-btn>
              <v-btn
                @click="tableToExcel('table', 'DataBarcode')"
                rounded
                dark
                class="ml-s"
                color="info"
                :disabled="excelBtn"
              >
              <v-icon dark>mdi-file-excel</v-icon> 
              &nbsp;
              Export Excel
              </v-btn>
            </v-col>
          </v-row>
        </v-form>
      </template>
    </v-flex>
    <v-responsive>  <!--:style="{ 'visibility': display }"-->
      <v-simple-table dense>
        <table id="cablesTable" ref="table" summary="Data kabel" rules="groups" frame="hsides" border="1">
          <thead>
            <tr>
              <!-- <th v-for="c in cols" :key="c.key">{{c.name}}</th> -->
              <th>ID Barcode</th>
              <th>ID Number</th>
              <th>Length</th>
              <th>OP Number</th>
              <th>Customer</th>
              <th>SO Number</th>
              <th>SO Line</th>
              <th>Item Description</th>
              <th>Generated</th>
            </tr>
          </thead>
          <tbody>
            <!-- <tr v-for="(r, key) in data" :key="key">
              <td v-for="c in cols" :key="c.key">{{ r[c.key] }}</td>
            </tr> -->
            <tr v-for="item in data" :key="item.IdNo">
              <td>{{ item.IDBarcode }}</td>
              <td>{{ item.IdNo }}</td>
              <td>{{ item.Length }}</td>
              <td>{{ item.OPNo }}</td>
              <td>{{ item.Customer }}</td>
              <td>{{ item.SONo }}</td>
              <td>{{ item.SOLine }}</td>
              <td>{{ item.ItemDesc }}</td>
              <td>{{ item.GenerateDate }}</td>
            </tr>
          </tbody>
        </table>
      </v-simple-table>
    </v-responsive>
  </v-layout>
</template>
<script>

export default {
  components: {
  },
  data: () => ({
    // display: 'hidden',
    excelBtn: true,
    valid: true,
    alert: "",
    op: "",
    opRules: [v => !!v || "OP tidak boleh kosong !", v => (v && v.length <= 6) || "Nomor OP harus 6(enam) digit !"],
    search: '',
    itemsPerPage: 100,
    uri: 'data:application/vnd.ms-excel;base64,',
    template:'<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
    base64: function(s){ return window.btoa(unescape(encodeURIComponent(s))) },
    format: function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) },
    data: [],
  }),
  watch: {
    dialog (val) {
      if (!val) return

      setTimeout(() => (this.dialog = false), 4000)
    },
  },
  created () {
    // this.test();
    // const table = this.$refs.table
    // table.classList.add('hidden')
  },
  methods: {
    tableToExcel(table, name){
      if (!table.nodeType) table = this.$refs.table
      var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
      window.location.href = this.uri + this.base64(this.format(this.template, ctx))
    },
    async searchOP () {
      // this.$set(this.$data, 'display', 'show')
      this.$axios.$get(`http://localhost/tracer/public/api/cables/${this.op}`)
      .then(response => {
        this.data = response.data;
        this.excelBtn = false
        console.log('success');
      })
      .catch(function (error) {
        console.log(error);
      });
    },
    // changeLocale () {
    //   this.$vuetify.lang.current = 'en'
    // }
  }
};
</script>

<style lang="css">
.container {
  width: 100vw !important;
}
@media (min-width: 1264px) {
  .container {
    max-width: 100vw !important;
  }
}
</style>