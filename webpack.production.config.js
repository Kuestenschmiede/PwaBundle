var path = require('path');
var config = {
  entry: './Resources/public/js/PushSubscription.js',
  mode: "production",
  output: {
    filename: 'PushSubscription.js',
    path: path.resolve('./Resources/public/build/')
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: [{
          loader: "babel-loader",
        }],
        include: [
          path.resolve('.'),
          path.resolve('./../CoreBundle')
        ],
      }
    ]
  }
};

module.exports = config;