export const formValidation = (object: { [key: string]: boolean }): boolean => {
  if (!object) return false

  for (const chave in object) {
    if (!object[chave]) {
      return false
    }
  }
  return true
}
