require('dotenv').config();

const path = require('path');
const glob = require('glob');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

// Auto-detect TS entries.
const entries = {};
glob.sync('./src/**/*.{ts,js}', { ignore: './src/**/*.d.ts' }).forEach(file => {
  const srcPath = file.replace(/\\/g,'/');
  const destPath = srcPath.replace('src/', '');
  const key = destPath.split('.');
  key.splice(key.length - 1, 1);
  entries[key] = `./${srcPath}`;
});

module.exports = (env, argv) => {
  const isProduction = argv.mode === 'production';

  // Update sass-loader options.
  defaultConfig.module.rules[4].use[3].options['implementation'] = require('sass');

  return {
    ...defaultConfig,
    mode: argv.mode || 'development',
    entry: entries,
    output: {
      path: path.resolve(__dirname, 'build'),
      filename: '[name].js',
      clean: true,
    },
    module: {
      rules: [
        ...defaultConfig.module.rules,
        {
          test: /\.tsx?$/,
          use: 'ts-loader',
          exclude: /node_modules/,
        },
        {
          test: /\.svg$/,
          include: path.resolve(__dirname, 'src/assets/svg/'),
          loader: 'svg-sprite-loader',
          options: {
            extract: true,
            spriteFilename: 'assets/svg/sprite.svg',
            esModule: false,
          }
        }
      ],
    },
    resolve: {
      alias: {
        '@styles': path.resolve(__dirname, 'src/styles/'),
      },
    },
    plugins: [
      ...defaultConfig.plugins,
      new CopyWebpackPlugin({
        patterns: [
          {
            from: 'src/blocks/**/block.json',
            to({ context, absoluteFilename }) {
              return absoluteFilename.replace(
                path.resolve(context, 'src/'), 
                path.resolve(context, 'build/') + '/'
              );
            },
          },
          {
            from: 'src/blocks/**/render.php',
            to({ context, absoluteFilename }) {
              return absoluteFilename.replace(
                path.resolve(context, 'src/'), 
                path.resolve(context, 'build/') + '/'
              );
            },
          },
          {
            from: 'src/blocks/blocks-manifest.php',
            to: 'blocks/blocks-manifest.php',
          },
          {
            from: 'src/assets/images/',
            to: 'assets/images/',
          },
        ],
      }),
      new BrowserSyncPlugin(
        {
          host: 'localhost',
          port: 3000,
          proxy: process.env.WP_PROXY_URL || 'http://localhost/wp-site/',
          files: ["build/*/**/*.*", "**/*.php"],
          logPrefix: "Wordpress Block Theme Boilerplate",
          open: true,
          cors: true,
          injectChanges: true,
        }
      ),
      new SpriteLoaderPlugin(),
    ],
    devtool: isProduction ? false : 'source-map',
  };
};
