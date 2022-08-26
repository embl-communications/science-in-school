(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('@wordpress/blocks'), require('react'), require('@wordpress/block-editor'), require('@wordpress/components'), require('@wordpress/data'), require('@wordpress/i18n'), require('@wordpress/hooks')) :
  typeof define === 'function' && define.amd ? define(['@wordpress/blocks', 'react', '@wordpress/block-editor', '@wordpress/components', '@wordpress/data', '@wordpress/i18n', '@wordpress/hooks'], factory) :
  (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global.wp.blocks, global.React, global.wp.blockEditor, global.wp.components, global.wp.data, global.wp.i18n, global.wp.hooks));
})(this, (function (blocks, React, blockEditor, components, data, i18n, hooks) { 'use strict';

  function _interopDefaultLegacy (e) { return e && typeof e === 'object' && 'default' in e ? e : { 'default': e }; }

  var React__default = /*#__PURE__*/_interopDefaultLegacy(React);

  /**
   * Return VF Gutenberg settings provided by the `vfGutenberg` global object
   * `wp_localize_script` defines this when enqueueing "sis-blocks.js"
   */
  // Default properties
  const vfGutenberg = {
    renderPrefix: '',
    renderSuffix: '',
    postId: 0,
    nonce: ''
  };

  const useSisGutenberg = () => {
    const vf = window.vfGutenberg || {};

    for (let [key, value] of Object.entries(vfGutenberg)) {
      if (!vf.hasOwnProperty(key)) {
        vf[key] = value;
      }
    }

    return vf;
  };

  /**
   * Icon (component)
   * VF Gutenberg block icon
   */
  var Icon = wp.element.createElement(components.SVG, {
    viewBox: "0 0 24 24",
    xmlns: "http://www.w3.org/2000/svg"
  }, wp.element.createElement(components.Path, {
    d: "M19 7h-1V5h-4v2h-4V5H6v2H5c-1.1 0-2 .9-2 2v10h18V9c0-1.1-.9-2-2-2zm0 10H5V9h14v8z"
  }), wp.element.createElement(components.Path, {
    d: "M10.943 16c.522-1.854.972-3.726 1.386-5.58h-1.323a126.482 126.482 0 01-.918 4.383h-.081c-.342-1.44-.657-2.988-.936-4.428l-1.35.09c.414 1.854.873 3.681 1.395 5.535h1.827zm5.161-2.169H14.16V16h-1.332v-5.58h3.636v1.098H14.16v1.296h1.944v1.017z"
  }));

  /**
   * Return default Gutenberg block settings for a VF block
   */

  const useVFDefaults = () => ({
    icon: Icon,
    keywords: [i18n.__('VF'), i18n.__('Visual Framework'), i18n.__('EMBL')],
    attributes: {
      ver: {
        type: 'string'
      }
    },
    supports: {
      align: false,
      className: false,
      customClassName: false,
      html: false
    },
    edit: () => null,
    save: () => null
  });

  /**
  Block Name: Grid Column
  */
  const defaults$2 = useVFDefaults();
  const settings$1 = { ...defaults$2,
    name: 'sis/info-box-column',
    title: i18n.__('SiS Info Box Column'),
    category: 'vf/core',
    description: i18n.__('Visual Framework (core)'),
    parent: ['sis/info-box'],
    supports: { ...defaults$2.supports,
      inserter: false,
      lightBlockWrapper: true
    },
    attributes: { ...defaults$2.attributes,
      span: {
        type: 'integer',
        default: 1
      }
    }
  };

  settings$1.save = props => {
    const {
      span
    } = props.attributes;
    const classes = [];

    if (Number.isInteger(span) && span > 1) {
      classes.push(`vf-grid__col--span-${span}`);
    }

    const rootAttr = {};

    if (classes.length) {
      rootAttr.className = classes.join(' ');
    }

    return wp.element.createElement("div", rootAttr, wp.element.createElement(blockEditor.InnerBlocks.Content, null));
  };

  settings$1.edit = props => {
    const {
      clientId
    } = props;
    const {
      span
    } = props.attributes;
    const {
      updateBlockAttributes
    } = data.useDispatch('core/block-editor');
    const {
      hasChildBlocks,
      hasSpanSupport,
      rootClientId
    } = data.useSelect(select => {
      const {
        getBlockName,
        getBlockOrder,
        getBlockRootClientId
      } = select('core/block-editor');
      const rootClientId = getBlockRootClientId(clientId);
      const hasChildBlocks = getBlockOrder(clientId).length > 0;
      const hasSpanSupport = getBlockName(rootClientId) === 'sis/info-box';
      return {
        rootClientId,
        hasChildBlocks,
        hasSpanSupport
      };
    }, [clientId]);
    React.useEffect(() => {
      if (!hasSpanSupport && span !== 1) {
        props.setAttributes({
          span: 1
        });
      }
    }, [clientId]);
    const onSpanChange = React.useCallback(value => {
      if (span !== value) {
        props.setAttributes({
          span: value
        });
        updateBlockAttributes(rootClientId, {
          dirty: Date.now()
        });
      }
    }, [span, clientId, rootClientId]);
    const rootAttr = {};
    const classes = [];

    if (hasSpanSupport) {
      if (Number.isInteger(span) && span > 1) {
        classes.push(`vf-grid__col--span-${span}`);
      }
    }

    if (classes.length) {
      rootAttr.className = classes.join(' ');
    }

    return wp.element.createElement(React__default["default"].Fragment, null, hasSpanSupport && wp.element.createElement(blockEditor.InspectorControls, null, wp.element.createElement(components.PanelBody, {
      title: i18n.__('Advanced Settings'),
      initialOpen: true
    }, wp.element.createElement(components.RangeControl, {
      label: i18n.__('Column span'),
      help: i18n.__('Columns may be merged to fit.'),
      value: Number.isInteger(span) ? span : 1,
      onChange: onSpanChange,
      allowReset: true,
      step: 1,
      min: 1,
      max: 6
    }))), wp.element.createElement(blockEditor.__experimentalBlock.div, rootAttr, wp.element.createElement(blockEditor.InnerBlocks, {
      templateLock: false,
      renderAppender: hasChildBlocks ? undefined : () => wp.element.createElement(blockEditor.InnerBlocks.ButtonBlockAppender, null)
    })));
  };

  /**
   * Columns (component)
   * Wrapper for `ButtonGroup` to select number of columns
   */

  const ColumnsControl = props => {
    const {
      value,
      min,
      max,
      onChange
    } = props;
    const control = {
      label: i18n.__('Number of Columns'),
      className: 'components-vf-control'
    };

    if (props.help) {
      control.help = props.help;
    }

    const isPressed = i => i + min === value;

    return wp.element.createElement(components.BaseControl, control, wp.element.createElement(components.ButtonGroup, {
      "aria-label": control.label
    }, Array(max - min + 1).fill().map((x, i) => wp.element.createElement(components.Button, {
      key: i,
      isPrimary: isPressed(i),
      "aria-pressed": isPressed(i),
      onClick: () => onChange(i + min)
    }, i + min))));
  };

  /**
   * Columns (component)
   * Wrapper for `ButtonGroup` to select number of columns
   */

  const infoBoxControl = props => {
    const {
      value,
      onChange
    } = props;
    const control = {
      label: i18n.__('Type of info box'),
      className: 'components-vf-control'
    };

    if (props.help) {
      control.help = props.help;
    }

    const isPressed = i => i === value;

    const buttonValueInfoBox = "information-box";
    const buttonValueSafetyMan = "safety-box";
    return wp.element.createElement(components.BaseControl, control, wp.element.createElement(components.ButtonGroup, {
      "aria-label": control.label
    }, wp.element.createElement(components.Button, {
      key: buttonValueInfoBox,
      isPrimary: isPressed(buttonValueInfoBox),
      "aria-pressed": isPressed(buttonValueInfoBox),
      onClick: () => onChange(buttonValueInfoBox)
    }, "Info box"), wp.element.createElement(components.Button, {
      key: buttonValueSafetyMan,
      isPrimary: isPressed(buttonValueSafetyMan),
      "aria-pressed": isPressed(buttonValueSafetyMan),
      onClick: () => onChange(buttonValueSafetyMan)
    }, "Safety man")));
  };

  /**
   * Block transforms for: `sis/info-box`, `vf/embl-grid`, and `core/columns`
   */
  // New columns are appended to match minimum
  // End columns are merged to match maximum

  const fromColumns = (fromBlock, toBlock, min, max) => {
    return {
      type: 'block',
      blocks: [fromBlock],
      // Match function (ignore initial placeholder state)
      isMatch: attributes => attributes.placeholder !== 1,
      // Transform function
      transform: (attributes, innerBlocks) => {
        // Map column props
        let innerProps = innerBlocks.map(block => ({
          attributes: { ...block.attributes
          },
          innerBlocks: [...block.innerBlocks]
        })); // Fill empty props to match min number of columns

        while (innerProps.length < min) {
          innerProps.push({});
        } // Merge end props to match max number of columns


        while (innerProps.length > max) {
          const mergeProps = innerProps.pop();
          innerProps[innerProps.length - 1].innerBlocks.push(...mergeProps.innerBlocks);
        } // Return new grid block with inner columns


        return blocks.createBlock(toBlock, {
          columns: innerProps.length
        }, innerProps.map(props => blocks.createBlock('sis/info-box-column', props.attributes || {}, props.innerBlocks || [])));
      }
    };
  };

  /**
  Block Name: Grid
  */
  const defaults$1 = useVFDefaults();
  const MIN_COLUMNS = 1;
  const MAX_COLUMNS = 6;
  const settings = { ...defaults$1,
    name: 'sis/info-box',
    title: i18n.__('SiS Info box layout'),
    category: 'vf/core',
    description: i18n.__('Visual Framework (core)'),
    supports: { ...defaults$1.supports,
      lightBlockWrapper: true
    },
    attributes: { ...defaults$1.attributes,
      placeholder: {
        type: 'integer',
        default: 0
      },
      columns: {
        type: 'integer',
        default: 0
      },
      boxtype: {
        type: 'string',
        default: 'infoBox'
      },
      dirty: {
        type: 'integer',
        default: 0
      }
    }
  };

  const GridControl = props => wp.element.createElement(ColumnsControl, props);

  const InfoBoxControlWrapper = props => wp.element.createElement(infoBoxControl, props);

  settings.save = props => {
    const {
      columns,
      boxtype,
      placeholder
    } = props.attributes;

    if (placeholder === 1) {
      return null;
    }

    const className = `vf-grid vf-grid__col-${columns} | vf-box sis-${boxtype}`;
    const blockProps = blockEditor.useBlockProps.save({
      className
    });
    return wp.element.createElement("div", blockProps, wp.element.createElement(blockEditor.InnerBlocks.Content, null));
  };

  settings.edit = props => {
    const {
      clientId
    } = props;
    const {
      dirty,
      columns,
      boxtype,
      placeholder
    } = props.attributes; // console.log('boxtype', boxtype)
    // Turn on setup placeholder if no columns are defined

    React.useEffect(() => {
      if (columns === 0) {
        props.setAttributes({
          placeholder: 1
        });
        props.setAttributes({
          boxtype: "infoBox"
        });
      }
    }, [clientId]);
    const {
      replaceInnerBlocks
    } = data.useDispatch('core/block-editor');
    const {
      setColumns,
      updateColumns,
      setInfoType
    } = data.useSelect(select => {
      const {
        getBlocks,
        getBlockAttributes
      } = select('core/block-editor'); // Return total number of columns accounting for spans

      const countSpans = blocks => {
        let count = 0;
        blocks.forEach(block => {
          const {
            span
          } = block.attributes;

          if (Number.isInteger(span) && span > 0) {
            count += span;
          } else {
            count++;
          }
        });
        return count;
      }; // Append new columns


      const addColumns = maxSpans => {
        const innerColumns = getBlocks(clientId);

        while (countSpans(innerColumns) < maxSpans) {
          innerColumns.push(blocks.createBlock('sis/info-box-column', {}, []));
        }

        replaceInnerBlocks(clientId, innerColumns, false);
      }; // Remove columns by merging their inner blocks


      const removeColumns = maxSpans => {
        let innerColumns = getBlocks(clientId);
        let mergeBlocks = [];

        while (innerColumns.length > 1 && countSpans(innerColumns) > maxSpans) {
          mergeBlocks = mergeBlocks.concat(innerColumns.pop().innerBlocks);
        }

        replaceInnerBlocks(innerColumns[innerColumns.length - 1].clientId, mergeBlocks.concat(innerColumns[innerColumns.length - 1].innerBlocks), false);
        replaceInnerBlocks(clientId, getBlocks(clientId).slice(0, innerColumns.length), false);
      };

      const setColumns = newColumns => {
        props.setAttributes({
          columns: newColumns,
          placeholder: 0
        });
        const innerColumns = getBlocks(clientId);
        const count = countSpans(innerColumns);

        if (newColumns < count) {
          removeColumns(newColumns);
        }

        if (newColumns > count) {
          addColumns(newColumns);
        }
      };

      const setInfoType = newType => {
        props.setAttributes({
          boxtype: newType,
          placeholder: 0
        });
      };

      const updateColumns = () => {
        const {
          columns
        } = getBlockAttributes(clientId);
        setColumns(columns);
        props.setAttributes({
          dirty: 0
        });
      };

      return {
        setInfoType,
        setColumns,
        updateColumns
      };
    }, [clientId]);
    React.useEffect(() => {
      if (dirty > 0) {
        updateColumns();
      }
    }, [dirty]); // Return setup placeholder

    if (placeholder === 1) {
      const blockProps = blockEditor.useBlockProps({
        className: 'vf-block vf-block--placeholder'
      });
      return wp.element.createElement(React__default["default"].Fragment, null, wp.element.createElement("div", blockProps, wp.element.createElement(components.Placeholder, {
        label: i18n.__('SiS Info Box'),
        icon: 'admin-generic'
      }, wp.element.createElement(InfoBoxControlWrapper, {
        value: boxtype,
        onChange: React.useCallback(value => setInfoType(value))
      }), wp.element.createElement("hr", null), wp.element.createElement(GridControl, {
        value: columns,
        min: MIN_COLUMNS,
        max: MAX_COLUMNS,
        onChange: React.useCallback(value => setColumns(value))
      }))));
    }

    const className = `vf-grid vf-grid__col-${columns} | vf-box sis-${boxtype} `;
    const styles = {
      ['--block-columns']: columns
    };
    const blockProps = blockEditor.useBlockProps({
      className,
      style: styles
    }); // Return inner blocks and inspector controls

    return wp.element.createElement(React__default["default"].Fragment, null, wp.element.createElement(blockEditor.InspectorControls, null, wp.element.createElement(components.PanelBody, {
      title: i18n.__('Advanced Settings'),
      initialOpen: true
    }, wp.element.createElement(InfoBoxControlWrapper, {
      value: boxtype,
      onChange: React.useCallback(value => setInfoType(value))
    }), wp.element.createElement("hr", null), wp.element.createElement(GridControl, {
      value: columns,
      min: MIN_COLUMNS,
      max: MAX_COLUMNS,
      onChange: React.useCallback(value => setColumns(value)),
      help: i18n.__('Content may be reorganised when columns are reduced.')
    }))), wp.element.createElement("div", blockProps, wp.element.createElement(blockEditor.InnerBlocks, {
      allowedBlocks: ['sis/info-box-column'],
      templateLock: "all"
    })));
  }; // Block transforms


  settings.transforms = {
    from: [fromColumns('core/columns', 'sis/info-box', MIN_COLUMNS, MAX_COLUMNS), fromColumns('vf/embl-grid', 'sis/info-box', MIN_COLUMNS, MAX_COLUMNS)]
  };

  /**
   * Object Hashsum
   * https://github.com/bevacqua/hash-sum
   */
  function pad(hash, len) {
    while (hash.length < len) {
      hash = '0' + hash;
    }

    return hash;
  }

  function fold(hash, text) {
    var i;
    var chr;
    var len;

    if (text.length === 0) {
      return hash;
    }

    for (i = 0, len = text.length; i < len; i++) {
      chr = text.charCodeAt(i);
      hash = (hash << 5) - hash + chr;
      hash |= 0;
    }

    return hash < 0 ? hash * -2 : hash;
  }

  function foldObject(hash, o, seen) {
    return Object.keys(o).sort().reduce(foldKey, hash);

    function foldKey(hash, key) {
      return foldValue(hash, o[key], key, seen);
    }
  }

  function foldValue(input, value, key, seen) {
    var hash = fold(fold(fold(input, key), toString(value)), typeof value);

    if (value === null) {
      return fold(hash, 'null');
    }

    if (value === undefined) {
      return fold(hash, 'undefined');
    }

    if (typeof value === 'object' || typeof value === 'function') {
      if (seen.indexOf(value) !== -1) {
        return fold(hash, '[Circular]' + key);
      }

      seen.push(value);
      var objHash = foldObject(hash, value, seen);

      if (!('valueOf' in value) || typeof value.valueOf !== 'function') {
        return objHash;
      }

      try {
        return fold(objHash, String(value.valueOf()));
      } catch (err) {
        return fold(objHash, '[valueOf exception]' + (err.stack || err.message));
      }
    }

    return fold(hash, value.toString());
  }

  function toString(o) {
    return Object.prototype.toString.call(o);
  }

  function sum(o) {
    return pad(foldValue(0, o, '', []).toString(16), 8);
  }

  /**
   * Misc hooks
   */
  /**
   * Return a unique hash of any object
   */

  const useHashsum = obj => sum(obj);

  /**
  Block Name: Plugin
  Notes:
    * This is not actually a VF component
    * It's named `vf/plugin` to avoid breaking existing usage
    * VF_Block and VF_Container plugins have default content, e.g.:

    <!-- wp:vf/plugin {"ref":"vf_masthead"} /-->

    */
  const defaults = useVFDefaults();
  const renderStore = {};

  const Edit = props => {
    const [acfId] = React.useState(acf.uniqid('block_'));
    const [isFetching, setFetching] = React.useState(true);
    const [isLoading, setLoading] = React.useState(true);
    const [render, setRender] = React.useState('');
    const [script, setScript] = React.useState(null);
    const ref = React.useRef(null);
    const {
      clientId
    } = props;
    const onMessage = React.useCallback(ev => {
      const {
        id
      } = ev.data;

      if (id && id.includes(acfId)) {
        clearTimeout(window[`${id}_onMessage`]);
        window[`${id}_onMessage`] = setTimeout(() => {
          window.removeEventListener('message', onMessage);
          setLoading(false);
        }, 100);
      }
    }, [clientId]);
    React.useEffect(() => {
      setLoading(true);
      setFetching(true);
      window.removeEventListener('message', onMessage);
      window.addEventListener('message', onMessage);

      const fetch = async () => {
        let render;
        const fields = {
          is_plugin: 1,
          ...props.transient.fields
        };
        const renderHash = useHashsum(fields);

        if (renderStore.hasOwnProperty(renderHash)) {
          render = await new Promise(resolve => setTimeout(() => {
            resolve(renderStore[renderHash]);
          }, 1));
        } else {
          const response = await wp.ajax.post('acf/ajax/fetch-block', {
            query: {
              preview: true
            },
            nonce: acf.get('nonce'),
            post_id: acf.get('post_id'),
            block: JSON.stringify({
              id: acfId,
              name: props.attributes.ref,
              data: fields,
              align: '',
              mode: 'preview'
            })
          });

          if (response && response.preview) {
            render = response.preview;
            renderStore[renderHash] = render;
          }
        }

        if (render) {
          const html = render.split(/<script[^>]*?>/)[0];
          const script = render.match(/<script[^>]*?>(.*)<\/script>/ms);
          setScript(Array.isArray(script) ? script[1] : null);
          setRender(html);
          setFetching(false);
        }
      };

      fetch();
    }, [clientId, props.attributes.__acfUpdate]);
    React.useEffect(() => {
      if (isFetching) {
        return;
      }

      ref.current.innerHTML = render;

      if (script) {
        const el = document.createElement('script');
        el.type = 'text/javascript';
        el.innerHTML = script;
        ref.current.appendChild(el);
      }
    }, [isFetching]); // add DOM attributes for styling

    const rootAttrs = {
      className: `vf-block ${props.className}`,
      'data-ver': props.attributes.ver,
      'data-name': props.name,
      'data-editing': false,
      'data-loading': isLoading,
      style: {}
    };

    if (isLoading) {
      rootAttrs.style.minHeight = '100px';
    }

    const viewStyle = {};

    if (isLoading) {
      viewStyle.visibility = 'hidden';
    }

    return wp.element.createElement("div", rootAttrs, isLoading && wp.element.createElement(components.Spinner, null), wp.element.createElement("div", {
      ref: ref,
      style: viewStyle,
      className: "vf-block__view"
    }));
  };

  const withACFUpdates = Edit => {
    const transient = {
      fields: {}
    };
    return props => {
      const {
        clientId
      } = props;
      React.useEffect(() => {
        if (hooks.hasAction('vf_plugin_acf_update', 'vf_plugin')) {
          return;
        }

        hooks.addAction('vf_plugin_acf_update', 'vf_plugin', data => {
          transient.fields[data.name] = data.value;
          props.setAttributes({
            __acfUpdate: Date.now()
          });
        });
      }, [clientId]);
      return Edit({ ...props,
        transient: { ...(props.transient || {}),
          ...transient
        }
      });
    };
  };
  var vfPlugin = { ...defaults,
    name: 'sis/plugin',
    title: i18n.__('Preview'),
    category: 'vf/wp',
    description: '',
    attributes: { ...defaults.attributes,
      ref: {
        type: 'string'
      }
    },
    supports: { ...defaults.supports,
      inserter: false,
      reusable: false
    },
    edit: withACFUpdates(Edit),
    save: () => null
  };

  /**!
   * VF Gutenberg blocks
   */

  const {
    coreOptin
  } = useSisGutenberg(); // Register VF Core blocks

  if (parseInt(coreOptin) === 1) {
    const coreBlocks = [settings$1, settings];
    coreBlocks.forEach(settings => blocks.registerBlockType(settings.name, settings));
  } // Register experimental preview block
  blocks.registerBlockType('sis/plugin', vfPlugin); // Handle iframe preview resizing globally
  // TODO: remove necessity from `useVFIFrame`

  window.addEventListener('message', _ref => {
    let {
      data
    } = _ref;

    if (data !== Object(data) || !/^vfwp_/.test(data.id)) {
      return;
    }

    const iframe = document.getElementById(data.id);

    if (!iframe || !iframe.vfActive) {
      return;
    }

    window.requestAnimationFrame(() => {
      iframe.style.height = `${data.height}px`;
    });
  });

}));
