const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

const isDevelopment = process.env.ENV !== 'production'
const isWatching = process.env.WATCH !== 'false'

module.exports = {
  mode: isDevelopment ? 'development' : 'production',
  watch: isWatching,
  entry: {
    front: './assets/src/js/front.js',
    admin: './assets/src/js/admin.js',
  },
  output: {
    filename: 'js/[name].js',
    path: path.resolve(__dirname, '../assets/dist'),
    clean: true,
  },
  devtool: 'inline-source-map',
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'css/[name].css',
    })
  ],
  module: {
    rules: [
      {
        // Javascript
        test: /\.jsx?$/,
        use: 'babel-loader',
        exclude: /node_modules/
      }, {
        // (S)CSS
        test: /\.(sa|sc|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader, 
          'css-loader', 
          {
            loader: 'sass-loader',
            options: { sourceMap: isDevelopment },
          }
        ],
      }
    ],
  },
  // @see https://webpack.js.org/configuration/resolve/#resolveextensions
  resolve: {
    extensions: ['.js', '.jsx', '.scss']
  },
};
