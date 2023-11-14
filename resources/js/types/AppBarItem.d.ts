import { Router } from 'vue-router'
import { Badge } from './BottomNav'

interface AppBarItemCallback {
  (): Promise<Router> | boolean | void
}

interface AppBarItem {
  label: string
  icon: string
  callback: AppBarItemCallback
  condition: boolean
  badge: null | Badge
}

export { AppBarItem, AppBarItemCallback }
