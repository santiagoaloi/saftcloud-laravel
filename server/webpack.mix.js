const path = require('path');
const fs = require('fs-extra');
const mix = require('laravel-mix');
const { VuetifyLoaderPlugin } = require('vuetify-loader');

const publicDir = 'C:/xampp/htdocs/saftcloud/public';

/*
|---------------------------------------------------------------------
| Disable compile notifications.
|---------------------------------------------------------------------
*/

mix.disableNotifications();

/*
|---------------------------------------------------------------------
| Inject Vuetify variables in SASS
|---------------------------------------------------------------------
*/
Mix.listen('configReady', (config) => {
  const scssRule = config.module.rules.find((r) => r.test.toString() === /\.scss$/.toString());

  scssRule.oneOf.forEach((ruleset) => {
    const scssOptions = ruleset.use.find((l) => l.loader.includes('sass-loader')).options;
    scssOptions.additionalData = "@import './resources/sass/vuetify/variables';";
  });

  const sassRule = config.module.rules.find((r) => r.test.toString() === /\.sass$/.toString());

  sassRule.oneOf.forEach((ruleset) => {
    const sassOptions = ruleset.use.find((l) => l.loader.includes('sass-loader')).options;

    sassOptions.additionalData = "@import './resources/sass/vuetify/variables'";
  });
});

/*
|---------------------------------------------------------------------
| Load the Vuetify Loader Plugin
|---------------------------------------------------------------------
*/
mix.extend(
  'vuetify',
  new (class {
    webpackConfig(config) {
      config.plugins.push(new VuetifyLoaderPlugin());
    }
  })(),
);

mix.vuetify();

if (mix.inProduction()) {
  mix.version();
} else {
  mix.sourceMaps();
}

/*
|---------------------------------------------------------------------
| Build and copy Vue application assets to 'public/dist' folder
|---------------------------------------------------------------------
*/

mix.setPublicPath('../public/');
mix
  .js('resources/js/app.js', 'public/dist/js')
  .extract()
  .vue()
  // .sass('resources/sass/app.scss', 'public/dist/css')

  .webpackConfig({
    devServer: {
      client: {
        overlay: {
          errors: true,
          warnings: false,
        },
      },
    },

    stats: {
      warnings: false,
    },

    resolve: {
      extensions: ['.js', '.vue', '.json'],
      alias: {
        'vue$': 'vue/dist/vue.esm.js',
        '@': path.join(__dirname, './resources/js'),
        '~': path.join(__dirname, './resources/js'),
      },
    },
    output: {
      chunkFilename: 'dist/js/[name].js',
      path: 'C:/xampp/htdocs/saftcloud/public/build',
      // publicPath: process.env.APP_URL
      publicPath: mix.inProduction() ? process.env.APP_URL : undefined,
    },
  });

function publishAssets() {
  if (mix.inProduction()) {
    const dist = path.join(publicDir, 'dist');

    // clean dist folder
    if (fs.existsSync(dist)) fs.removeSync(dist);
  }

  if (fs.existsSync(path.join(publicDir, 'build', 'dist')))
    fs.copySync(path.join(publicDir, 'build', 'dist'), path.join(publicDir, 'dist'));
  // if (fs.existsSync(path.join(publicDir, "build", "images")))
  //   fs.copySync(
  //     path.join(publicDir, "build", "images"),
  //     path.join(publicDir, "images")
  //   );
  if (fs.existsSync(path.join(publicDir, 'build'))) fs.removeSync(path.join(publicDir, 'build'));
}

mix.then(() => {
  process.nextTick(publishAssets);
});
