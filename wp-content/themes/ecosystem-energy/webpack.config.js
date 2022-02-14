const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
var path = require('path');

// Used for hot-reload css
const localDomain = 'http://ecosystem.local';

// Build all page scripts as separate files
const pages = require('glob')
  // Fetch all page-specific script files
  .sync(__dirname + "/assets/scripts/pages/*.js")
  // Build an entry object for each file, to be chained inside webpack
  .reduce((files, f) => {
    const file = f.split('/').pop().slice(0, -3);
    return { ...files, [file]: { import: '/assets/scripts/pages/' + file + '.js', filename: 'scripts/pages/[name].js' } }
  }, {});

// Main webpack builder
module.exports = {
  entry: {
    'app': ['./assets/scripts/main.js', './assets/styles/main.scss'],
    'editor': './assets/scripts/editor.js',
    ...pages
  },
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: 'scripts/[name].js',
    clean: true
  },
  plugins: [
    // Minify css
    new MiniCssExtractPlugin({
      filename: 'styles/[name].css',
    }),
    // Css hot-reload
    new BrowserSyncPlugin({
      proxy: localDomain,
      files: [ 'dist/*.scss' ],
      injectCss: true,
    }, { reload: false, }),
  ],
  module: {
    rules: [
      {
        test: /\.s?[c]ss$/i,
        use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader']
      },
    ]
  },
};