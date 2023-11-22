function createDateFromDMY(dateString: string): Date | null {
  // Check if the date format is d/m/Y
  const dmYDate = /^\d{2}\/\d{2}\/\d{4}$/
  if (!dmYDate.test(dateString)) {
    return null
  }

  const parts = dateString.split('/')
  if (parts.length !== 3) return null

  const day = parseInt(parts[0], 10)
  const month = parseInt(parts[1], 10) - 1
  const year = parseInt(parts[2], 10)

  if (isNaN(day) || isNaN(month) || isNaN(year)) return null

  const date = new Date(year, month, day)

  if (date.getFullYear() !== year || date.getMonth() !== month || date.getDate() !== day) {
    return null
  }

  return date
}

export const birthDateValidator = (value: string) => {
  const birthDate = createDateFromDMY(value)
  const today = new Date()

  if (!birthDate || (birthDate && birthDate > today)) {
    return false
  }

  return true
}
