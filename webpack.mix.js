let mix = require("laravel-mix");

// mix.js('src/main.js', 'assets/admin/admin.js').vue({ version: 3 }).sourceMaps().sass('src/main.scss', 'assets/admin/admin.css')
mix.setPublicPath("assets");
mix.setResourceRoot("../../wp-content/plugins/vue_wp_practice/assets");
mix
  .js("src/main.js", "assets/admin/admin.js")
  .js("src/custom.js", "assets/admin/custom.js")
  .vue({ version: 3 })
  .sourceMaps(false);
