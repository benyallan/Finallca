const dictionary = {
    pt_BR: {
      messages: {
        required: (field) => `O campo ${field} é obrigatório.`,
        date_format: (field) => `O campo ${field} não é uma data válida.`,
        min_value: (field, value) => `O campo ${field} deve ser maior ou igual a ${value}.`
      }
    }
  }
  export default dictionary