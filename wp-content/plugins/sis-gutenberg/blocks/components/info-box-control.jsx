/**
 * Columns (component)
 * Wrapper for `ButtonGroup` to select number of columns
 */
import React, {Fragment} from 'react';
import {__} from '@wordpress/i18n';
import {BaseControl, Button, ButtonGroup} from '@wordpress/components';

const infoBoxControl = props => {
  // const {value, onChange} = props;
  const control = {
    label: __('Type of info box'),
    className: 'components-vf-control'
  };
  if (props.help) {
    control.help = props.help;
  }
  // const isPressed = i => i === value;
  return (
    <BaseControl {...control}>
      <ButtonGroup aria-label={control.label}>
        <Button
          key="infoBox"
          // isPrimary={isPressed(i)}
          // aria-pressed={isPressed(i)}
          // onClick={() => onChange(i)}
          >
          Info box
        </Button>
        <Button
          key="safetyMan"
          // isPrimary={isPressed(i)}
          // aria-pressed={isPressed(i)}
          // onClick={() => onChange(i)}
          >
          Safety man
        </Button>
      </ButtonGroup>
    </BaseControl>
  );
};

export default infoBoxControl;
