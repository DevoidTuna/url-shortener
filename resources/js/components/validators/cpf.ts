export const cpfValidator = (value: string) => {
  value = value.replaceAll('-', '').replaceAll('.', '')

  let sum: number = 0
  let remainder: number

  if (value == '00000000000') return false

  for (let i = 1; i <= 9; i++) sum = sum + parseInt(value.substring(i - 1, i)) * (11 - i)
  remainder = (sum * 10) % 11

  if (remainder == 10 || remainder == 11) remainder = 0
  if (remainder != parseInt(value.substring(9, 10))) return false

  sum = 0
  for (let i = 1; i <= 10; i++) sum = sum + parseInt(value.substring(i - 1, i)) * (12 - i)
  remainder = (sum * 10) % 11

  if (remainder == 10 || remainder == 11) remainder = 0
  if (remainder != parseInt(value.substring(10, 11))) return false
  return true
}
