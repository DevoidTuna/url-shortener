import 'vuetify/styles'
import { ThemeDefinition, createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

import { mdi } from 'vuetify/iconsets/mdi'

const lightTheme: ThemeDefinition = {
  dark: false,
  colors: {
    background: "#eee",
    surface: '#FFFFFF',
    primary: "#EA8300",
    secondary: "#494949",
    error: '#B00020',
    info: '#2196F3',
    success: '#4CAF50',
    warning: '#FB8C00',
    tertiary: "#83CC6F",
    heading: "#fff",
    body: "#D4D4D4"
  },
}

export default createVuetify({
  theme: {
    defaultTheme: 'lightTheme',
    themes: {
      lightTheme,
    }
  },
  icons: {
    defaultSet: 'mdi',
    sets: {
      mdi,
    },
  },
  components: {
    ...components,
  },
  directives,
})
