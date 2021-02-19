# science-in-school

Code and planning for the new SiS website

This is a collection of WordPress themes and plugins that integrate with the [Visual Framework](https://stable.visual-framework.dev/). They build atop the [vf-wp parent theme and plugins](github.com/visual-framework/vf-wp/).

## Development

### Site development

Setup: 

1. Ensure you have Docker installed
1. To set up an instance on your localhost  you'll need to make sure your project's git submodules are up to date: 
    - `git submodule update --init --recursive`

Use any of the below variation of command to build the site

    ##### Run command

    - `bin/dev quick_group` - to build WordPress website with basic Visual Framework default configuration - Plugin/themes enabled
    - `bin/dev quick_group_bootstrap` - to build WordPress website setup with Visual Framework dummy microsite bootstrap version
    - `bin/dev launch` - to launch browser
    - `bin/dev login`  - to login in wordpress admin

    ##### Diagnostics

    - `bin/dev logs`    - tail logs from containers
    - `bin/dev pma`     - launch phpMyAdmin to view database
    - `bin/dev down`   - to spin down docker containers

Note: Default variables including CSS/JS version, site title, admin password are configured in `.env`

### Theme development


Contributing to this repository requires command line tools:

* Git
* Node
* Gulp (optional)

To start:

```bash
# Install dev dependencies
yarn install
```

This project makes use of [Visual Framework components](https://visual-framework.github.io/vf-welcome) to build its CSS and JavaScript.

These scripts and tasks are available:

```sh
yarn run update-components
```

To interactively update the Visual Framework components (and other npm packages).

```sh
gulp build
```

* to build `vf-components/vf-componenet-rollup/index.scss`
  - to make `wp-content/themes/vf-wp-science-in-school/assets/css/styles.css`
* to build `vf-components/vf-componenet-rollup/scripts.scss`
  - to make `wp-content/themes/vf-wp-science-in-school/assets/scripts/scripts.js`

Note: [the CI](https://github.com/embl-communications/science-in-school/blob/master/.github/workflows/build.js.yml) will run `gulp build` on commit to `master`.

```sh
gulp default
```
