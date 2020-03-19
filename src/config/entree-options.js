const entreeOptions = {
  bases: [
    { name: "White Rice Bowl", price: 9.99 },
    { name: "Purple Rice Bowl", price: 9.99 },
    //{ name: "Noodles", price: 9.79 },
    { name: "Korrito", price: 9.49 },
    { name: "Salad", price: 9.89 }
  ],
  options: [
    {
      type: "proteins",
      label: "Pick your protein",
      max: 1,
      cartLabel: "Proteins",
      choices: [
        { name: "Beef", price: 1.99, selected: false },
        { name: "Chicken", price: 0, selected: false },
        { name: "Spicy Pork", price: 0, selected: false },
        { name: "Tofu", price: 0, selected: false }
      ]
    },
    {
      type: "extraProteins",
      label: "Would you like to add double protein?",
      cartLabel: "Double Proteins",
      max: 1,
      choices: [
        { name: "Beef", price: 2.99, selected: false },
        { name: "Chicken", price: 2.99, selected: false },
        { name: "Spicy Pork", price: 2.99, selected: false },
        { name: "Tofu", price: 2.99, selected: false }
      ]
    },
    {
      type: "veggies",
      label: "Pick your veggies",
      cartLabel: "Veggies",
      max: 7,
      choices: [
        { name: "Corn", price: 0, selected: false },
        { name: "Carrots", price: 0, selected: false },
        { name: "Kimchi", price: 0, selected: false },
        { name: "Kale", price: 0, selected: false },
        { name: "Cucumbers", price: 0, selected: false },
        { name: "Korean Radish", price: 0, selected: false },
        { name: "Bean Sprouts", price: 0, selected: false }
      ]
    },
    {
      type: "sauces",
      label: "Pick your sauces",
      cartLabel: "Sauces",
      max: 2,
      choices: [
        { name: "Korean Hot Sauce", price: 0, selected: false },
        { name: "Creamy Sriracha", price: 0, selected: false },
        { name: "Ginger-Carrot", price: 0, selected: false },
        { name: "Cilantro-Lime Ranch", price: 0, selected: false }
      ]
    },
    {
      type: "toppings",
      label: "Pick your toppings",
      cartLabel: "Toppings",
      max: 6,
      choices: [
        { name: "Crispy Garlic", price: 0, selected: false },
        { name: "Cilantro", price: 0, selected: false },
        { name: "Sesame Oil", price: 0, selected: false },
        { name: "Scallions", price: 0, selected: false },
        { name: "Sesame Seeds", price: 0, selected: false },
        { name: "Fire Powder", price: 0, selected: false }
      ]
    },
    {
      type: "extras",
      label: "Extras?",
      cartLabel: "Extras",
      max: 6,
      choices: [
        { name: "The Egg", price: 1.99, selected: false },
        { name: "Avocado", price: 1.59, selected: false }
      ]
    }
  ],
  getOption(type) {
    return this.options.find(option => option.type === type);
  }
};

export default entreeOptions;
