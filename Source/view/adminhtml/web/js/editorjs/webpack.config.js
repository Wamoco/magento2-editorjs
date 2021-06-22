const path = require('path');

module.exports = {
  entry: './src/index.js',
  mode: 'development',
  module: {
      rules: [{ test: /\.svg$/, use: 'svg-inline-loader?removeSVGTagAttrs=false' }],
  },
  output: {
    filename: 'main.js',
    library: {
      type: 'umd',
      name: 'editorjs',
    },
    globalObject: 'this',
    path: path.resolve(__dirname, 'dist'),
  },
};
