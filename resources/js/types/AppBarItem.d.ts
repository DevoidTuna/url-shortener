import { Router } from 'vue-router'

interface AppBarItemCallback {
  (): Promise<Router> | boolean | void
}

interface AppBarItem {
  label: string
  icon: string
  callback: AppBarItemCallback
  condition: boolean
}

export { AppBarItem, AppBarItemCallback }
