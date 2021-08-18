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

export default useSisGutenberg;
