const path = require('path');
var webpack = require("webpack");
var glob = require('glob');
const TerserJSPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const LiveReloadPlugin = require('webpack-livereload-plugin');
module.exports = {

    // optimization: {
    //   minimize: true,
    //   minimizer: [
    //     new TerserJSPlugin({
    //       extractComments: 'all',
    //     }),
    //     new CssMinimizerPlugin(),
    //   ],
    // },

    mode: "development",
    watch: true,
    entry: glob.sync('./assets/dynamic/js/**.js').reduce(function(obj, el){
      obj[path.parse(el).name] = el;
      return obj
    },{}),

    output: {
      path: path.resolve(__dirname, './dist'),
      filename: 'js/[name].js'
    },

    module: {
      rules: [
        {
          test: /.s?css$/,
          use: [
            MiniCssExtractPlugin.loader,
            "css-loader",
            "postcss-loader",
            "sass-loader"
          ],
        },
        {
          test: /\.(woff(2)?|ttf|eot|svg)$/,
          type: 'asset/resource',
          generator: {
              filename: './fonts/[name][ext]',
          },
        },      
      ],
    },

    plugins: [
      new MiniCssExtractPlugin({
        filename: 'css/[name].css',
        chunkFilename: '[id].css',
      }),
      new LiveReloadPlugin(),
    ],

}

