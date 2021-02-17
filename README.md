# science-in-school

This is a collection of WordPress themes and plugins that integrate with the [Visual Framework](https://stable.visual-framework.dev/). They build atop the [vf-wp parent theme and plugins](github.com/visual-framework/vf-wp/).

Code and planning for the new SiS website

## Development

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

To launch local development of the above with a `watch` task.

```sh
gulp vf-gutenberg
```

To compile the Gutenberg React blocks.