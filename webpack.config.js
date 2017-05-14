// Компиляция файла статистики ::: webpack --json --profile > stats.json ------ webpack.github.io/analyse
const NODE_ENV = process.env.NODE_ENV || 'development'
const webpack = require('webpack')
const path = require('path')
const WebpackNotifierPlugin = require('webpack-notifier')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const ModernizrWebpackPlugin = require('modernizr-webpack-plugin')
const autoprefixer = require('autoprefixer')
const StyleLintPlugin = require('stylelint-webpack-plugin') // Docs: https://github.com/JaKXz/stylelint-webpack-plugin
const sourcePath = path.join(__dirname, './client')

// Docs: https://www.npmjs.com/package/modernizr-webpack-plugin
const ModernizrConfig = {
  'options': [
    'setClasses'
  ],
  'feature-detects': [
    //'canvas',
    //'css/animations',
    //'css/boxshadow',
    //'css/calc',
    //'css/pointerevents',
    //'css/transforms3d',
    //'css/textshadow',
    //'css/transforms',
    //'css/transitions',
    'css/vhunit',
    'css/vwunit',
    //'event/deviceorientation-motion',
    //'forms/validation',
    //'network/xhr2',
    //'network/xhr-responsetype-blob',
    //'notification',
    //'geolocation',
    //'fullscreen-api',
    'svg',
    //'svg/asimg',
    'touchevents'
  ]
}

module.exports = function (env) {
  const nodeEnv = env && env.prod ? 'production' : 'development'
  const isProd = nodeEnv === 'production'
  const plugins = [
    new ModernizrWebpackPlugin(ModernizrConfig),
    new webpack.EnvironmentPlugin({
      NODE_ENV: nodeEnv
    }),
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery',
      Tether: 'tether',
      'window.Tether': 'tether',
      Carousel: 'exports-loader?Carousel!bootstrap/js/dist/carousel',
      Modal: 'exports-loader?Modal!bootstrap/js/dist/modal',
      Scrollspy: 'exports-loader?Scrollspy!bootstrap/js/dist/scrollspy',
      Tab: 'exports-loader?Tab!bootstrap/js/dist/tab',
      Util: 'exports-loader?Util!bootstrap/js/dist/util'
    }),
    new WebpackNotifierPlugin({
      title: 'Webpack',
      alwaysNotify: true
    }),
    new ExtractTextPlugin({ filename: './client/css/[name].css', disable: false, allChunks: true }),
    new StyleLintPlugin({ // Docs: https://github.com/JaKXz/stylelint-webpack-plugin
      context: './client/scss',
      syntax: 'scss',
      failOnError: false
    })
  ]

  if (isProd) {
    plugins.push(
      new webpack.LoaderOptionsPlugin({
        minimize: true,
        debug: false
      }),
      new webpack.optimize.UglifyJsPlugin({
        compress: {
          warnings: false,
          screw_ie8: true,
          conditionals: true,
          unused: true,
          comparisons: true,
          sequences: true,
          dead_code: true,
          evaluate: true,
          if_return: true,
          join_vars: true
        },
        output: {
          comments: false
        }
      })
    )
  } else {
    plugins.push(
      //new webpack.HotModuleReplacementPlugin() //uncoment for dev server
    )
  }

  return {
    devtool: isProd ? 'source-map' : 'eval',
    context: __dirname,
    entry: {
      index: ['bootstrap-loader', './client/js/dev/index.es6'],
      style: './client/scss/base.scss'
    },
    output: {
      path: __dirname + '/client/js/build/',
      publicPath: 'client/js/build/',
      filename: '[name].js'
    },
    watch: NODE_ENV == 'development',
    watchOptions: { aggregateTimeout: 100, ignored: /node_modules/ },
    module: {
      rules: [
        {
          test: /\.es6$|\.js$/,
          exclude: /\/node_modules\/(vivus|jquery|bootstrap|tether|owl\.carousel)/,
          use: [
            { loader: 'babel-loader', options: { presets: ['es2015', 'stage-0', 'stage-1'] } },
            { loader: 'jshint-loader', options: { asi: true, lastsemic: false, esversion: 6, camelcase: true, emitErrors: false, failOnHint: false } }
          ]
        },
        {
          test: /\.css$/,
          exclude: /(node_modules|bower_components)/,
          use: [
            'style-loader',
            { loader: 'css-loader', options: { modules: true, importLoaders: 1 } },
            { loader: 'postcss-loader' }
          ]
        },
        {
          test: /\.(sass|scss)$/,
          exclude: /(node_modules|bower_components)/,
          use: [
            'style-loader',
            { loader: 'css-loader' },
            { loader: 'postcss-loader'},
            // { loader: 'resolve-url' },
            { loader: 'sass-loader', options: { sourceMap: true, outputStyle: 'expanded', sourceMapContents: true } }
          ]
        },
        {
          test: /\.woff2?$|\.ttf$|\.eot$/,
          use: [
            { loader: 'file-loader' }
          ]
        },
        {
          test: /bootstrap\/dist\/js\/umd\//, // Docs: https://github.com/shakacode/bootstrap-loader
          use: [
            { loader: 'imports-loader?jQuery=jquery' }
          ]
        }
      ]
    },
    resolve: {
      extensions: ['.webpack-loader.js', '.web-loader.js', '.loader.js', '.js', '.jsx'],
      modules: [
        path.resolve(__dirname, 'node_modules'),
        sourcePath
      ]
    },
    plugins,
    //performance: isProd && {
    //  maxAssetSize: 100,
    //  maxEntrypointSize: 300,
    //  hints: 'warning'
    //},
    stats: {
      colors: {
        green: '\u001b[32m'
      }
    },
    devServer: {
      // contentBase: './client',
      historyApiFallback: true,
      port: 3000,
      compress: isProd,
      inline: !isProd,
      hot: !isProd,
      stats: {
        assets: true,
        children: false,
        chunks: false,
        hash: false,
        modules: false,
        publicPath: false,
        timings: true,
        version: false,
        warnings: true,
        colors: {
          green: '\u001b[32m'
        }
      }
    }
  }
}
