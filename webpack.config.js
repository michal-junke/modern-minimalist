/* jshint esversion:6 */

const path = require('path');
// JS minification
const TerserPlugin = require('terser-webpack-plugin');
// Css minification
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const cssnano = require('cssnano');
// Extracting CSS to another file
const MiniCssExctractPlugin = require('mini-css-extract-plugin');

module.exports = {
  entry:  './src/index.js',
  output: {
    filename: 'main.min.js',
    path: path.resolve(__dirname, './')
  },
  module: {
      rules: [
        {
            // JS transcript and minify
            test: /\.js$/,
            exclude: /(node_modules|bower_components)/,
            use: {
                loader: 'babel-loader',
                options: {
                    presets: ['@babel/preset-env']
                }
            }
        },
        {
            // SCSS process to CSS (import globally variables and mixins) -> add prefixes -> minify -> Exctract to files
            test: /\.s[ca]ss$/,
            use: [
                MiniCssExctractPlugin.loader,
                {
                    loader:'css-loader',
                    options: {
                        importLoaders: 2,
                    },
                },
                {
                    //Prefixing CSS
                    loader: 'postcss-loader',
                    options: {
                      ident: 'postcss',
                      plugins: [
                        require('autoprefixer')({})
                      ]
                    }
                },
                'sass-loader',
                { 
                    loader: 'sass-resources-loader',
                    options: {
                    sourceMap: true,
                    resources: [
                        './src/scss/helpers/_variables.scss',
                        './src/scss/helpers/_mixins.scss',
                        './src/scss/helpers/_functions.scss'
                        ]
                    }
                }
            ],
            exclude: /editor.scss$/
        },
        {
            // SCSS process to CSS (import globally variables and mixins) -> add prefixes -> minify -> Exctract to files
            test: /editor.scss$/,
            use: [
                {
                    loader: 'file-loader',
                    options: {
                        name: 'editor.css',
                        context: './',
                        outputPath: '/css',
                        publicPath: '/css'
                    }
                },
                "extract-loader",
                {
                    loader:'css-loader',
                    options: {
                        importLoaders: 2,
                    },
                },
                {
                    //Prefixing CSS
                    loader: 'postcss-loader',
                    options: {
                      ident: 'postcss',
                      plugins: [
                        require('autoprefixer')({})
                      ]
                    }
                },
                'sass-loader',
                { 
                    loader: 'sass-resources-loader',
                    options: {
                    sourceMap: true,
                    resources: [
                        './src/scss/helpers/_variables.scss',
                        './src/scss/helpers/_mixins.scss',
                        './src/scss/helpers/_functions.scss'
                        ]
                    }
                }
            ],
        },
        {
            // Fallback for css files without sass-loader
            test: /\.css$/,
            use: [
                MiniCssExctractPlugin.loader,
                'css-loader',
                {
                    //Prefixing CSS
                    loader: 'postcss-loader',
                    options: {
                      ident: 'postcss',
                      plugins: [
                        require('autoprefixer')({})
                      ]
                    }
                }
            ]
        },
        {
            // Importing images to our files
            test: /\.(png|svg|jpg|gif|jpeg)$/,
            use: [
              { loader : 'file-loader',
                options: {
                    outputPath: 'img',
                    name: '[name].[ext]'
                }
            }
            ]
          }
      ]
  },
  optimization: {
      minimizer: [
          // Minification of JS files
          new TerserPlugin(),
          // Minification of CSS files
          new OptimizeCSSAssetsPlugin({
            cssProcessor: cssnano,
            cssProcessorOptions: {                
                discardComments: {
                  removeAll: true,
                },
                // Run cssnano in safe mode to avoid
                // potentially unsafe transformations.
                safe: true,
              },
            canPrint: false,
          })
        ]
  },
  plugins: [
      // Exctracting CSS to seperate file
      new MiniCssExctractPlugin({
          filename: 'main.min.css',
          chunkFilename: 'main.chunk.min.css'
      })
  ]
};