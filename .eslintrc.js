module.exports = {
  "extends": [
    "eslint:recommended",
    'plugin:vue/vue3-recommended', // Use this if you are using Vue.js 3.x.
    // "plugin:vue/recommended"
  ],
  "parser": "vue-eslint-parser",
  "parserOptions": {
    "ecmaVersion": 2021,
    "sourceType": "module",
    "ecmaFeatures": {
      "jsx": true
    }
  },
  "plugins": [
    "vue"
  ],
  "rules": {
    "vue/html-indent": [
      "error",
      4,
      {
        "attribute": 1,
        "baseIndent": 1,
        "closeBracket": 0,
        "alignAttributesVertically": true,
        "ignores": []
      }
    ],
    "vue/html-closing-bracket-spacing": [
      "error",
      {
        "selfClosingTag": "never"
      }
    ],
    "vue/script-indent": [
      "error",
      4,
      {
        "baseIndent": 0,
        "switchCase": 0,
        "ignores": []
      }
    ],
    "vue/max-attributes-per-line": 0,
    "key-spacing": "error"
  }
};
