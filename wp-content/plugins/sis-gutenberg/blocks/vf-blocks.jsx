/**!
 * VF Gutenberg blocks
 */
import {registerBlockType} from '@wordpress/blocks';
import useSisGutenberg from './hooks/use-vf-gutenberg';

// Import Visual Framework core component settings

import sisInfoBoxColumn from './vf-core/sis-info-box-column';
import sisInfoBox from './vf-core/sis-info-box';

// Get "localized" global script settings
const {coreOptin} = useSisGutenberg();

// Register VF Core blocks
if (parseInt(coreOptin) === 1) {
  const coreBlocks = [
    sisInfoBoxColumn,
    sisInfoBox
  ];
  coreBlocks.forEach(settings => registerBlockType(settings.name, settings));
}

// Register experimental preview block
import vfPlugin from './vf-core/vf-plugin';
registerBlockType('sis/plugin', vfPlugin);

// Handle iframe preview resizing globally
// TODO: remove necessity from `useVFIFrame`
window.addEventListener('message', ({data}) => {
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
