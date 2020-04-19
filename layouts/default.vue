<template>
  <v-app light>
    <v-app-bar
      :clipped-left="clipped"
      fixed
      app
    >
      <v-btn
        icon
      >
        <v-icon>mdi-barcode</v-icon>
      </v-btn>
      <v-toolbar-title v-text="title" />
      <v-spacer />
    </v-app-bar>
    <v-content>
      <v-container>
        <nuxt />
      </v-container>
    </v-content>
    <v-footer
      :fixed="fixed"
      app
    >
      <span>Jembo Web Developer &copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  data () {
    return {
      clipped: false,
      drawer: false,
      fixed: false,
      items: [
        {
          icon: 'mdi-cloud-search',
          title: 'Cable Data',
          to: '/'
        }
      ],
      miniVariant: false,
      rightDrawer: false,
      right: true,
      title: 'Jembo Cable Traceablity'
    }
  }
}
</script>
