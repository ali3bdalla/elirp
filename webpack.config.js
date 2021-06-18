const path = require('path');

module.exports = {
     module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          'vue-style-loader',
          'css-loader',
          'sass-loader'
        ]
      }
    ]
  },
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
};
