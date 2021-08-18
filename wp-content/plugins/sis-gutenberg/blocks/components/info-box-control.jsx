/**
 * Columns (component)
 * Wrapper for `ButtonGroup` to select number of columns
 */
import React, {Fragment} from 'react';
import {__} from '@wordpress/i18n';
import {BaseControl, Button, ButtonGroup} from '@wordpress/components';

const infoBoxControl = props => {
  const {value, onChange} = props;
  const control = {
    label: __('Type of info box'),
    className: 'components-vf-control'
  };
  if (props.help) {
    control.help = props.help;
  }
  const isPressed = i => i === value;
  const buttonValueInfoBox = "infoBox";
  const buttonValueSafetyMan = "safetyMan";
  return (
    <BaseControl {...control}>
      <ButtonGroup aria-label={control.label}>
        <Button
          key={buttonValueInfoBox}
          isPrimary={isPressed(buttonValueInfoBox)}
          aria-pressed={isPressed(buttonValueInfoBox)}
          onClick={() => onChange(buttonValueInfoBox)}
          >
          Info box
        </Button>
        <Button
          key={buttonValueSafetyMan}
          isPrimary={isPressed(buttonValueSafetyMan)}
          aria-pressed={isPressed(buttonValueSafetyMan)}
          onClick={() => onChange(buttonValueSafetyMan)}
          >
          Safety man
        </Button>
      </ButtonGroup>
    </BaseControl>
  );
};

export default infoBoxControl;
