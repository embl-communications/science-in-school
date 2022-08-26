/**
Block Name: Grid
*/
import React, {useCallback, useEffect} from 'react';
import {createBlock} from '@wordpress/blocks';
import {
  InnerBlocks,
  InspectorControls,
  useBlockProps,
} from '@wordpress/block-editor';
import {PanelBody, Placeholder} from '@wordpress/components';
import {useDispatch, useSelect} from '@wordpress/data';
import {__} from '@wordpress/i18n';
import useVFDefaults from '../hooks/use-vf-defaults';
import ColumnsControl from '../components/columns-control';
import InfoBoxControl from '../components/info-box-control';
import {fromColumns} from './transforms/grid';

const defaults = useVFDefaults();

const MIN_COLUMNS = 1;
const MAX_COLUMNS = 6;

const settings = {
  ...defaults,
  name: 'sis/info-box',
  title: __('SiS Info box layout'),
  category: 'vf/core',
  description: __('Visual Framework (core)'),
  supports: {
    ...defaults.supports,
    lightBlockWrapper: true
  },
  attributes: {
    ...defaults.attributes,
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

const GridControl = props => <ColumnsControl {...props} />;

const InfoBoxControlWrapper = props => <InfoBoxControl {...props} />;

settings.save = (props) => {
  const {columns, boxtype, placeholder} = props.attributes;
  if (placeholder === 1) {
    return null;
  }
  const className = `vf-grid vf-grid__col-${columns} | vf-box sis-${boxtype}`;
  const blockProps = useBlockProps.save({ className });
  return (
    <div {...blockProps}>
      <InnerBlocks.Content />
    </div>
  );
};

settings.edit = (props) => {
  const {clientId} = props;
  const {dirty, columns, boxtype, placeholder} = props.attributes;

  // console.log('boxtype', boxtype)

  // Turn on setup placeholder if no columns are defined
  useEffect(() => {
    if (columns === 0) {
      props.setAttributes({placeholder: 1});
      props.setAttributes({boxtype: "infoBox"});
    }
  }, [clientId]);

  const {replaceInnerBlocks} = useDispatch('core/block-editor');

  const {setColumns, updateColumns, setInfoType} = useSelect(
    (select) => {
      const {getBlocks, getBlockAttributes} = select('core/block-editor');

      // Return total number of columns accounting for spans
      const countSpans = (blocks) => {
        let count = 0;
        blocks.forEach((block) => {
          const {span} = block.attributes;
          if (Number.isInteger(span) && span > 0) {
            count += span;
          } else {
            count++;
          }
        });
        return count;
      };

      // Append new columns
      const addColumns = (maxSpans) => {
        const innerColumns = getBlocks(clientId);
        while (countSpans(innerColumns) < maxSpans) {
          innerColumns.push(createBlock('sis/info-box-column', {}, []));
        }
        replaceInnerBlocks(clientId, innerColumns, false);
      };

      // Remove columns by merging their inner blocks
      const removeColumns = (maxSpans) => {
        let innerColumns = getBlocks(clientId);
        let mergeBlocks = [];
        while (innerColumns.length > 1 && countSpans(innerColumns) > maxSpans) {
          mergeBlocks = mergeBlocks.concat(innerColumns.pop().innerBlocks);
        }
        replaceInnerBlocks(
          innerColumns[innerColumns.length - 1].clientId,
          mergeBlocks.concat(innerColumns[innerColumns.length - 1].innerBlocks),
          false
        );
        replaceInnerBlocks(
          clientId,
          getBlocks(clientId).slice(0, innerColumns.length),
          false
        );
      };

      const setColumns = (newColumns) => {
        props.setAttributes({columns: newColumns, placeholder: 0});
        const innerColumns = getBlocks(clientId);
        const count = countSpans(innerColumns);
        if (newColumns < count) {
          removeColumns(newColumns);
        }
        if (newColumns > count) {
          addColumns(newColumns);
        }
      };

      const setInfoType = (newType) => {
        props.setAttributes({boxtype: newType, placeholder: 0});
      };

      const updateColumns = () => {
        const {columns} = getBlockAttributes(clientId);
        setColumns(columns);
        props.setAttributes({dirty: 0});
      };

      return {
        setInfoType,
        setColumns,
        updateColumns
      };
    },
    [clientId]
  );

  useEffect(() => {
    if (dirty > 0) {
      updateColumns();
    }
  }, [dirty]);

  // Return setup placeholder
  if (placeholder === 1) {
    const blockProps = useBlockProps({
      className: 'vf-block vf-block--placeholder'
    });
    return (
      <>
        <div {...blockProps}>
          <Placeholder label={__('SiS Info Box')} icon={'admin-generic'}>
            <InfoBoxControlWrapper
              value={boxtype}
              onChange={useCallback((value) => setInfoType(value))}
            />
            <hr/>
            <GridControl
              value={columns}
              min={MIN_COLUMNS}
              max={MAX_COLUMNS}
              onChange={useCallback((value) => setColumns(value))}
            />
          </Placeholder>
        </div>
      </>
    );
  }

  const className = `vf-grid vf-grid__col-${columns} | vf-box sis-${boxtype} `;

  const styles = {
    ['--block-columns']: columns
  };

  const blockProps = useBlockProps({
    className,
    style: styles
  });
  // Return inner blocks and inspector controls
  return (
    <>
      <InspectorControls>
        <PanelBody title={__('Advanced Settings')} initialOpen>
          <InfoBoxControlWrapper
            value={boxtype}
            onChange={useCallback((value) => setInfoType(value))}
          />
          <hr/>
          <GridControl
            value={columns}
            min={MIN_COLUMNS}
            max={MAX_COLUMNS}
            onChange={useCallback((value) => setColumns(value))}
            help={__('Content may be reorganised when columns are reduced.')}
          />
        </PanelBody>
      </InspectorControls>
      <div {...blockProps}>
        <InnerBlocks allowedBlocks={['sis/info-box-column']} templateLock='all' />
      </div>
    </>
  );
};

// Block transforms
settings.transforms = {
  from: [
    fromColumns('core/columns', 'sis/info-box', MIN_COLUMNS, MAX_COLUMNS),
    fromColumns('vf/embl-grid', 'sis/info-box', MIN_COLUMNS, MAX_COLUMNS)
  ]
};

export default settings;
