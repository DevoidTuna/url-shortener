import 'vuetify/styles'
import { ThemeDefinition, createVuetify } from 'vuetify'
import { md2 } from 'vuetify/blueprints'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'

const lightTheme: ThemeDefinition = {
  dark: true,
  colors: {
    background: "#eee",
    surface: '#FFFFFF',
    primary: "#2196F3",
    secondary: "#0D47A1",
    tertiary: "#BBDEFB",
    accent: "#2962FF",
    error: '#F44336',
    info: '#1976D2',
    success: '#0D47A1',
    warning: '#F57C00',
    body: "#D4D4D4"
  },
}

export default createVuetify({
  blueprint: md2,
  theme: {
    defaultTheme: 'lightTheme',
    themes: {
      lightTheme,
    }
  },
  icons: {
    defaultSet: 'mdi',
  },
  components,
  directives,
})
