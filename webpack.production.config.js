/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @author con4gis contributors (see "authors.md")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2026, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */

var path = require('path');
var config = {
  entry: './src/Resources/public/js/PushSubscription.js',
  mode: "production",
  output: {
    filename: 'PushSubscription.js',
    path: path.resolve('./src/Resources/public/build/')
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