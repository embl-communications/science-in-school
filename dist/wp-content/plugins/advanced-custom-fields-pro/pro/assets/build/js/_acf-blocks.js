(function($, undefined){
	
	// Dependencies.
	const { BlockControls, InspectorControls, InnerBlocks } = wp.blockEditor;
	const { Toolbar, IconButton, Placeholder, Spinner } = wp.components;
	const { Fragment } = wp.element;
	const { Component } = React;
	const { withSelect } = wp.data;
	const { createHigherOrderComponent } = wp.compose;

	/**
	 * Storage for registered block types.
	 *
	 * @since 5.8.0
	 * @var object
	 */
	const blockTypes = {};
	
	/**
	 * Returns a block type for the given name.
	 *
	 * @date	20/2/19
	 * @since	5.8.0
	 *
	 * @param	string name The block name.
	 * @return	(object|false)
	 */
	function getBlockType( name ) {
		return blockTypes[ name ] || false;
	}

	/**
	 * Returns true if a block exists for the given name.
	 *
	 * @date	20/2/19
	 * @since	5.8.0
	 *
	 * @param	string name The block name.
	 * @return	bool
	 */
	function isBlockType( name ) {
		return !!( blockTypes[ name ] );
	}

	/**
	 * Returns true if the provided block is new.
	 *
	 * @date	31/07/2020
	 * @since	5.9.0
	 *
	 * @param	object props The block props.
	 * @return	bool
	 */
	function isNewBlock( props ) {
		return !props.attributes.id;
	}

	/**
	 * Returns true if the provided block is a duplicate:
	 * True when there are is another block with the same "id", but a different "clientId".
	 * 
	 * @date	31/07/2020
	 * @since	5.9.0
	 *
	 * @param	object props The block props.
	 * @return	bool
	 */
	function isDuplicateBlock( props ) {
		return getBlocks()
			.filter( block => (block.attributes.id === props.attributes.id) )
			.filter( block => (block.clientId !== props.clientId) )
			.length;
	}

	/**
	 * Registers a block type.
	 *
	 * @date	19/2/19
	 * @since	5.8.0
	 *
	 * @param	object blockType The block type settings localized from PHP.
	 * @return	object The result from wp.blocks.registerBlockType().
	 */
	function registerBlockType( blockType ) {

		// Bail ealry if is excluded post_type.
		var allowedTypes = blockType.post_types || [];
		if( allowedTypes.length ) {
			
			// Always allow block to appear on "Edit reusable Block" screen.
			allowedTypes.push('wp_block');
			
			// Check post type.
			var postType = acf.get('postType');
			if( allowedTypes.indexOf(postType) === -1 ) {
				return false;
			}
		}
		
		// Handle svg HTML.
		if( typeof blockType.icon === 'string' && blockType.icon.substr(0, 4) === '<svg' ) {
			const iconHTML = blockType.icon;
			blockType.icon = <Div>{iconHTML}</Div>;
		}
		
		// Remove icon if empty to allow for default "block".
		// Avoids JS error preventing block from being registered.
		if( !blockType.icon ) {
			delete blockType.icon;
		}
		
		// Check category exists and fallback to "common".
		var category = wp.blocks.getCategories().filter( cat => (cat.slug === blockType.category) ).pop();
		if( !category ) {
			//console.warn( `The block "${blockType.name}" is registered with an unknown category "${blockType.category}".` );
			blockType.category = 'common';
		}

		// Define block type attributes.
		// Leave default undefined to allow WP to serialize attributes in HTML comments.
		// See https://github.com/WordPress/gutenberg/issues/7342
		let attributes = {
			id: { 
				type: 'string'
			},
			name: { 
				type: 'string'
			},
			data: { 
				type: 'object'
			},
			align: {
				type: 'string'
			},
			mode: {
				type: 'string'
			}
		};

		// Append edit and save functions.
		let ThisBlockEdit = BlockEdit;
		let ThisBlockSave = BlockSave;

		// Apply align_text functionality.
		if( blockType.supports.align_text ) {
			attributes = withAlignTextAttributes( attributes );
			ThisBlockEdit = withAlignTextComponent( ThisBlockEdit, blockType );
		}

		// Apply align_content functionality.
		if( blockType.supports.align_content ) {
			attributes = withAlignContentAttributes( attributes );
			ThisBlockEdit = withAlignContentComponent( ThisBlockEdit, blockType );
		}
		
		// Merge in block settings.
		blockType = acf.parseArgs(blockType, {
			title: '',
			name: '',
			category: '',
			attributes: attributes,
			edit: function( props ){
				return (
					<ThisBlockEdit {...props} />
				);
			},
			save: function( props ){
				return (
					<ThisBlockSave {...props} />
				);
			}
		});

		// Add to storage.
		blockTypes[ blockType.name ] = blockType;
		
		// Register with WP.
		var result = wp.blocks.registerBlockType( blockType.name, blockType );
		
		// Fix bug in 'core/anchor/attribute' filter overwriting attribute.
		// See https://github.com/WordPress/gutenberg/issues/15240
		if( result.attributes.anchor ) {
			result.attributes.anchor = {
				type: 'string'
			}
		}
		
		// Return result.
		return result;
	}

	/**
	 * Returns the wp.data.select() response with backwards compatibility.
	 *
	 * @date	17/06/2020
	 * @since	5.9.0
	 *
	 * @param	string selector The selector name.
	 * @return	mixed
	 */
	function select( selector ) {
		if( selector === 'core/block-editor' ) {
			return ( wp.data.select( 'core/block-editor' ) || wp.data.select( 'core/editor' ) );
		}
		return wp.data.select( selector );
	}

	/**
	 * Returns the wp.data.dispatch() response with backwards compatibility.
	 *
	 * @date	17/06/2020
	 * @since	5.9.0
	 *
	 * @param	string selector The selector name.
	 * @return	mixed
	 */
	function dispatch( selector ) {
		return wp.data.dispatch( selector );
	}

	/**
	 * Returns an array of all blocks for the given args.
	 *
	 * @date	27/2/19
	 * @since	5.7.13
	 *
	 * @param	object args An object of key=>value pairs used to filter results.
	 * @return	array.
	 */
	function getBlocks( args ) {
		
		// Get all blocks (avoid deprecated warning).
		let blocks = select( 'core/block-editor' ).getBlocks();
		
		// Append innerBlocks.
		let i = 0;
		while( i < blocks.length ) {
			blocks = blocks.concat( blocks[i].innerBlocks );
			i++;
		}
		
		// Loop over args and filter.
		for( var k in args ) {
			blocks = blocks.filter( block => (block.attributes[k] === args[k]) );
		}
		
		// Return results.
		return blocks;
	}

	// Data storage for AJAX requests.
	const ajaxQueue = {};

	/**
	 * Fetches a JSON result from the AJAX API.
	 *
	 * @date	28/2/19
	 * @since	5.7.13
	 *
	 * @param	object block The block props.
	 * @query	object The query args used in AJAX callback.
	 * @return	object The AJAX promise.
	 */
	function fetchBlock( args ) {
		const { 
			attributes = {},
			query = {},
			delay = 0
		} = args;
		
		// Use storage or default data.
		const { id } = attributes;
		const data = ajaxQueue[ id ] || {
			query: {},
			timeout: false,
			promise: $.Deferred()
		};

		// Append query args to storage.
		data.query = { ...data.query, ...query };

		// Set fresh timeout.
		clearTimeout( data.timeout );
		data.timeout = setTimeout(function(){
			$.ajax({
				url: acf.get('ajaxurl'),
				dataType: 'json',
				type: 'post',
				cache: false,
				data: acf.prepareForAjax({
					action:	'acf/ajax/fetch-block',
					block: JSON.stringify( attributes ),
					query: data.query
				})
			})
			.always(function(){
				// Clean up queue after AJAX request is complete.
				ajaxQueue[ id ] = null;
			})
			.done(function() {
				data.promise.resolve.apply( this, arguments );
			})
			.fail(function() {
				data.promise.reject.apply( this, arguments );
			});
		}, delay);

		// Update storage.
		ajaxQueue[ id ] = data;

		// Return promise.
		return data.promise;
	}

	/**
	 * Returns true if both object are the same.
	 *
	 * @date	19/05/2020
	 * @since	5.9.0
	 *
	 * @param	object obj1
	 * @param	object obj2
	 * @return	bool
	 */
	function compareObjects( obj1, obj2 ) {
		return ( JSON.stringify( obj1 ) === JSON.stringify( obj2 ) );
	}
	
	/**
	 * Converts HTML into a React element.
	 *
	 * @date	19/05/2020
	 * @since	5.9.0
	 *
	 * @param	string html The HTML to convert.
	 * @return	object Result of React.createElement().
	 */
	acf.parseJSX = function( html ) {
		return parseNode( $( html )[0] );
	};
	
	/**
	 * Converts a DOM node into a React element.
	 *
	 * @date	19/05/2020
	 * @since	5.9.0
	 *
	 * @param	DOM node The DOM node.
	 * @return	object Result of React.createElement().
	 */
	function parseNode( node ) {
		
		// Get node name.
		var nodeName = parseNodeName( node.nodeName.toLowerCase() );
		if( !nodeName ) {
			return null;
		}
		
		// Get node attributes in React friendly format.
		var nodeAttrs = {};
		acf.arrayArgs( node.attributes ).map( parseNodeAttr ).forEach(function( attr ){
			nodeAttrs[ attr.name ] = attr.value;
		});
		
		// Define args for React.createElement().
		var args = [
			nodeName,
			nodeAttrs
		];
		acf.arrayArgs( node.childNodes ).forEach(function( child ){
			if( child instanceof Text ) {
				var text = child.textContent.trim();
				if( text ) {
					args.push( text );
				}			
			} else {
				args.push( parseNode(child) );
			}
		});
		
		// Return element.
		return React.createElement.apply( this, args );
	};

	/**
	 * Converts the given name into a React friendly name or component.
	 *
	 * @date	19/05/2020
	 * @since	5.9.0
	 *
	 * @param	string name The node name in lowercase.
	 * @return	mixed
	 */
	function parseNodeName( name ) {
		switch( name ) {
			case 'innerblocks':
				return InnerBlocks;
			case 'script':
				return Script;
			case '#comment':
				return null;
		}
		return name;
	}

	/**
	 * Converts the given attribute into a React friendly name and value object.
	 *
	 * @date	19/05/2020
	 * @since	5.9.0
	 *
	 * @param	obj nodeAttr The node attribute.
	 * @return	obj
	 */
	function parseNodeAttr( nodeAttr ) {
		var name = nodeAttr.name;
		var value = nodeAttr.value;
		switch( name ) {
			
			// Class.
			case 'class':
				name = 'className';
				break;

			// Style.
			case 'style':
				var css = {};
				value.split(';').forEach(function( s ){
					var pos = s.indexOf(':');
					if( pos > 0 ) {
						var ruleName = s.substr( 0, pos ).trim();
						var ruleValue = s.substr( pos+1 ).trim();

						// Rename core properties, but not CSS variables.
						if( ruleName.charAt(0) !== '-' ) {
							ruleName = acf.strCamelCase( ruleName );
						}
						css[ ruleName ] = ruleValue;
					}
				});
				value = css;
				break;
			
			// Default.
			default:
				
				// No formatting needed for "data-x" attributes.
				if( name.indexOf('data-') === 0 ) {
					break;
				}
				
				// Replace names for JSX counterparts.
				var replace = acf.get('jsxAttributes');
				if( replace[ name ] ) {
					name = replace[ name ];
				}

				// Covert JSON values.
				var c1 = value.charAt( 0 );
				if( c1 === '[' || c1 === '{' ) {
					value = JSON.parse( value );
				}
				
				// Convert bool values.
				if( value === 'true' || value === 'false' ) {
					value = ( value === 'true' );
				}
				break;

		}
		return {
			name: name,
			value: value
		};
	}

	/**
	 * Higher Order Component used to set default block attribute values.
	 * 
	 * By modifying block attributes directly, instead of defining defaults in registerBlockType(), 
	 * WordPress will include them always within the saved block serialized JSON.
	 *
	 * @date	31/07/2020
	 * @since	5.9.0
	 *
	 * @param	Component BlockListBlock The BlockListBlock Component.
	 * @return	Component
	 */
	var withDefaultAttributes = createHigherOrderComponent( function( BlockListBlock ) {
		return class WrappedBlockEdit extends Component {
			constructor( props ) {
				super( props );

				// Extract vars.
				const { name, attributes } = this.props;

				// Only run on ACF Blocks.
				const blockType = getBlockType( name );
				if( !blockType ) {
					return;
				}

				// Set unique ID and default attributes for newly added blocks.
				if( isNewBlock(props) ) {
					attributes.id = acf.uniqid('block_');
					for( let attribute in blockType.attributes ) {
						if( attributes[ attribute ] === undefined && blockType[ attribute ] !== undefined ) {
							attributes[ attribute ] = blockType[ attribute ];
						}
					}
					return;
				}

				// Generate new ID for duplicated blocks.
				if( isDuplicateBlock(props) ) {
					attributes.id = acf.uniqid('block_');
					return;
				}
			}
			render() {
				return (
					<BlockListBlock { ...this.props } />
				);
			}
		}
	}, 'withDefaultAttributes' );
	wp.hooks.addFilter( 'editor.BlockListBlock', 'acf/with-default-attributes', withDefaultAttributes );

	/**
	 * The BlockSave functional component.
	 *
	 * @date	08/07/2020
	 * @since	5.9.0
	 */
	function BlockSave(){
		return (
			<InnerBlocks.Content />
		);
	}

	/**
	 * The BlockEdit component.
	 *
	 * @date	19/2/19
	 * @since	5.7.12
	 */
	class BlockEdit extends Component {

		constructor( props ) {
			super( props );
			this.setup();
		}
		
		setup() {
			const { name, attributes } = this.props;
			const blockType = getBlockType( name );
			
			// Restrict current mode.
			function restrictMode( modes ) {
				if( modes.indexOf(attributes.mode) === -1 ) {
					attributes.mode = modes[0];
				}
			}
			switch( blockType.mode ) {
				case 'edit':
					restrictMode( ['edit', 'preview'] );
					break;
				case 'preview':
					restrictMode( ['preview', 'edit'] );
					break;
				default:
					restrictMode( ['auto'] );
					break;
			}
		}
		
		render() {
			const { name, attributes, setAttributes } = this.props;
			const { mode } = attributes;
			const blockType = getBlockType( name );
			
			// Show toggle only for edit/preview modes.
			let showToggle = blockType.supports.mode;
			if( mode === 'auto' ) {
				showToggle = false;
			}
			
			// Configure toggle variables.
			const toggleText = ( mode === 'preview' ) ? acf.__('Switch to Edit') : acf.__('Switch to Preview');
			const toggleIcon = ( mode === 'preview' ) ? 'edit' : 'welcome-view-site';
			function toggleMode() {
				setAttributes({ 
					mode: ( mode === 'preview' ) ? 'edit' : 'preview'
				});
			}
			
			// Return template.
			return (
				<Fragment>
				
					<BlockControls>
						{ showToggle &&
							<Toolbar>
								<IconButton
									className="components-icon-button components-toolbar__control"
									label={ toggleText }
									icon={ toggleIcon }
									onClick={ toggleMode }
								 />
							</Toolbar>
						}
					</BlockControls>
					
					<InspectorControls>
						{ mode === 'preview' &&
							<div className="acf-block-component acf-block-panel">
								<BlockForm {...this.props} />
							</div>
						}
					</InspectorControls>
					
					<BlockBody {...this.props} />
					
				</Fragment>
	        );
		}
	}

	/**
	 * The BlockBody component.
	 *
	 * @date	19/2/19
	 * @since	5.7.12
	 */
	class _BlockBody extends Component {
		render() {
			const { attributes, isSelected } = this.props;
			const { mode } = attributes;
			return (
				<div className="acf-block-component acf-block-body">
					{ mode === 'auto' && isSelected ?
						<BlockForm {...this.props} />
					: mode === 'auto' && !isSelected ?
						<BlockPreview {...this.props} />
					: mode === 'preview' ? 
						<BlockPreview {...this.props} />
					:
						<BlockForm {...this.props} />
					}
				</div>
			);
		}
	}

	// Append blockIndex to component props.
	const BlockBody = withSelect( function( select, ownProps ) {
		const { clientId } = ownProps;
		// Use optional rootClientId to allow discoverability of child blocks.
		const rootClientId = select('core/block-editor').getBlockRootClientId( clientId );
		const index = select('core/block-editor').getBlockIndex( clientId, rootClientId );
		return {
			index
		};
	} )( _BlockBody );
		
	/**
	 * A react component to append HTMl.
	 *
	 * @date	19/2/19
	 * @since	5.7.12
	 *
	 * @param	string children The html to insert.
	 * @return	void
	 */
	class Div extends Component {
		render() {
			return <div dangerouslySetInnerHTML={ { __html: this.props.children } } />
		}
	}

	/**
	 * A react Component for inline scripts.
	 * 
	 * This Component uses a combination of React references and jQuery to append the
	 * inline <script> HTML each time the component is rendered.
	 *
	 * @date	29/05/2020
	 * @since	5.9.0
	 *
	 * @param	type Var Description.
	 * @return	type Description.
	 */
	class Script extends Component {
		render() {
			return <div ref={ el => this.el = el } />
		}
		setHTML( html ) {
			$( this.el ).html( `<script>${html}</script>` );
		}
		componentDidUpdate() {
			this.setHTML( this.props.children );
		}
		componentDidMount() {
			this.setHTML( this.props.children );
		}
	}

	// Data storage for DynamicHTML components.
	const store = {};
	
	/**
	 * DynamicHTML Class.
	 *
	 * A react componenet to load and insert dynamic HTML.
	 *
	 * @date	19/2/19
	 * @since	5.7.12
	 *
	 * @param	void
	 * @return	void
	 */
	class DynamicHTML extends Component {
		constructor( props ) {
			super( props );

			// Bind callbacks.
			this.setRef = this.setRef.bind( this );

			// Define default props and call setup().
			this.id = '';
			this.el = false;
			this.subscribed = true;
			this.renderMethod = 'jQuery';
			this.setup( props );

			// Load state.
			this.loadState();
		}
		
		setup( props ){
			// Do nothing.
		}
		
		fetch() {
			// Do nothing.
		}

		loadState() {
			this.state = store[ this.id ] || {};
		}
		
		setState( state ) {
			store[ this.id ] = { ...this.state, ...state };

			// Update component state if subscribed.
			// - Allows AJAX callback to update store without modifying state of an unmounted component.
			if( this.subscribed ) {
				super.setState( state );
			}
		}
		
		setHtml( html ) {
			html = html ? html.trim() : '';
			
			// Bail early if html has not changed.
			if( html === this.state.html ) {
				return;
			}
			
			// Update state.
			var state = {
				html: html
			};
			if( this.renderMethod === 'jsx' ) {
				state.jsx = acf.parseJSX( html );
				state.$el = $( this.el );
			} else {
				state.$el = $( html );
			}
			this.setState( state );
		}

		setRef( el ) {
			this.el = el;
		}
		
		render() {
			
			// Render JSX.
			if( this.state.jsx ) {
				return (
					<div ref={ this.setRef }>
						{ this.state.jsx }
					</div>
				);
			}

			// Return HTML.
			return (
				<div ref={ this.setRef }>
					<Placeholder>
						<Spinner />
					</Placeholder>
				</div>
			);
		}

		shouldComponentUpdate( nextProps, nextState ) {
			if( nextProps.index !== this.props.index ) {
				this.componentWillMove();
			}
			return ( nextState.html !== this.state.html );
		}

		display( context ) {
			
			// This method is called after setting new HTML and the Component render.
			// The jQuery render method simply needs to move $el into place.
			if( this.renderMethod === 'jQuery' ) {
				var $el = this.state.$el;
				var $prevParent = $el.parent();
				var $thisParent = $( this.el );

				// Move $el into place.
				$thisParent.html( $el );

				// Special case for reusable blocks.
				// Multiple instances of the same reusable block share the same block id.
				// This causes all instances to share the same state (cool), which unfortunately
				// pulls $el back and forth between the last rendered reusable block.
				// This simple fix leaves a "clone" behind :)
				if( $prevParent.length && $prevParent[0] !== $thisParent[0] ) {
					$prevParent.html( $el.clone() );
				}
			}

			// Call context specific method.
			switch( context ) {
				case 'append':
					this.componentDidAppend();
					break;
				case 'remount':
					this.componentDidRemount();
					break;
			}
		}
		
		componentDidMount() {
			
			// Fetch on first load.
			if( this.state.html === undefined ) {
				//console.log('componentDidMount', this.id);
				this.fetch();
			
			// Or remount existing HTML.
			} else {
				this.display( 'remount' );
			}
		}

		componentDidUpdate( prevProps, prevState ) {
			
			// HTML has changed.
			this.display( 'append' );
		}
		
		componentDidAppend() {
			acf.doAction( 'append', this.state.$el );
		}

		componentWillUnmount() {
			acf.doAction( 'unmount', this.state.$el );

			// Unsubscribe this component from state.
			this.subscribed = false;
		}

		componentDidRemount() {
			this.subscribed = true;

			// Use setTimeout to avoid incorrect timing of events.
			// React will unmount and mount components in DOM order.
			// This means a new component can be mounted before an old one is unmounted.
			// ACF shares $el across new/old components which is un-React-like.
			// This timout ensures that unmounting occurs before remounting.
			setTimeout(() => {
				acf.doAction( 'remount', this.state.$el );
			});
		}

		componentWillMove() {
			acf.doAction( 'unmount', this.state.$el );
			setTimeout(() => {
				acf.doAction( 'remount', this.state.$el );
			});
		}
	}
	
	/**
	 * BlockForm Class.
	 *
	 * A react componenet to handle the block form.
	 *
	 * @date	19/2/19
	 * @since	5.7.12
	 *
	 * @param	string id the block id.
	 * @return	void
	 */
	class BlockForm extends DynamicHTML {
		
		setup( props ) {
			this.id = `BlockForm-${props.attributes.id}`;
		}
		
		fetch() {

			// Extract props.
			const { attributes } = this.props;

			// Request AJAX and update HTML on complete.
			fetchBlock({
				attributes: attributes,
				query: {
					form: true
				}
			}).done( ( json ) => {
				this.setHtml( json.data.form );
			} );
		}
		
		componentDidAppend() {
			super.componentDidAppend();
			
			// Extract props.
			const { attributes, setAttributes } = this.props;
			const { $el } = this.state;
			
			// Callback for updating block data.
			function serializeData( silent = false ) {
				const data = acf.serialize( $el, `acf-${attributes.id}` );
				if( silent ) {
					attributes.data = data;
				} else {
					setAttributes({
						data: data
					});
				}
			}
			
			// Add events.
			var timeout = false;
			$el.on( 'change keyup', function(){
				clearTimeout( timeout );
				timeout = setTimeout( serializeData , 300 );
			});
			
			// Ensure newly added block is saved with data.
			// Do it silently to avoid triggering a preview render.
			if( !attributes.data ) {
				serializeData( true );
			}
		}
	}
	
	/**
	 * BlockPreview Class.
	 *
	 * A react componenet to handle the block preview.
	 *
	 * @date	19/2/19
	 * @since	5.7.12
	 *
	 * @param	string id the block id.
	 * @return	void
	 */
	class BlockPreview extends DynamicHTML {

		setup( props ) {
			this.id = `BlockPreview-${props.attributes.id}`;
			var blockType = getBlockType( props.name );
			if( blockType.supports.jsx ) {
				this.renderMethod = 'jsx';
			}
			//console.log('setup', this.id);
		}
		
		fetch( args = {} ) {
			const { 
				attributes = this.props.attributes,
				delay = 0
			} = args;

			// Remember attributes used to fetch HTML.
			this.setState({
				prevAttributes: attributes
			});
			
			// Try preloaded data first.
			if( this.state.html === undefined ) {
				const preloadedBlocks = acf.get('preloadedBlocks');
				if( preloadedBlocks && preloadedBlocks[ attributes.id ] ) {
					this.setHtml( preloadedBlocks[ attributes.id ] );
					return;
				}
			}

			// Request AJAX and update HTML on complete.
			fetchBlock({
				attributes: attributes,
				query: {
					preview: true
				},
				delay: delay
			}).done( ( json ) => {
				this.setHtml( json.data.preview );
			} );
		}

		componentDidAppend() {
			super.componentDidAppend();
			
			// Extract props.
			const { attributes } = this.props;
			const { $el } = this.state;

			// Generate action friendly type.
			const type = attributes.name.replace('acf/', '');
			
			// Do action.
			acf.doAction( 'render_block_preview', 				$el, attributes );
			acf.doAction( `render_block_preview/type=${type}`, 	$el, attributes );
		}
		
		shouldComponentUpdate( nextProps, nextState ) {
			const nextAttributes = nextProps.attributes;
			const thisAttributes = this.props.attributes;

			// Update preview if block data has changed.
			if( !compareObjects( nextAttributes, thisAttributes ) ) {
				let delay = 0;

				// Delay fetch when editing className or anchor to simulate conscistent logic to custom fields.
				if( nextAttributes.className !== thisAttributes.className ) {
					delay = 300;
				}
				if( nextAttributes.anchor !== thisAttributes.anchor ) {
					delay = 300;
				}
				
				this.fetch({
					attributes: nextAttributes,
					delay: delay
				});
			}
			return super.shouldComponentUpdate( nextProps, nextState );
		}

		componentDidRemount() {
			super.componentDidRemount();

			// Update preview if data has changed since last render (changing from "edit" to "preview").
			if( !compareObjects( this.state.prevAttributes, this.props.attributes ) ) {
				//console.log('componentDidRemount', this.id);
				this.fetch();
			}
		}
	}
	
	/**
	 * Initializes ACF Blocks logic and registration.
	 *
	 * @since 5.9.0
	 */
	function initialize() {

		// Add support for WordPress versions before 5.2.
		if( !wp.blockEditor ) {
			wp.blockEditor = wp.editor;
		}

		// Register block types.
		var blockTypes = acf.get('blockTypes');
		if( blockTypes ) {
			blockTypes.map( registerBlockType );
		}
	}
	
	// Run the initialize callback during the "prepare" action.
	// This ensures that all localized data is available and that blocks are registered before the WP editor has been instantiated.
	acf.addAction( 'prepare', initialize );

	/**
	 * Returns a valid vertical alignment.
	 *
	 * @date	07/08/2020
	 * @since	5.9.0
	 *
	 * @param	string align A vertical alignment.
	 * @return	string
	 */
	function validateVerticalAlignment( align ) {
		const ALIGNMENTS = [ 'top', 'center', 'bottom' ];
		const DEFAULT = 'top';
		return ALIGNMENTS.includes( align ) ? align : DEFAULT;
	}

	/**
	 * Returns a valid horizontal alignment.
	 *
	 * @date	07/08/2020
	 * @since	5.9.0
	 *
	 * @param	string align A horizontal alignment.
	 * @return	string
	 */
	function validateHorizontalAlignment( align ) {
		const ALIGNMENTS = [ 'left', 'center', 'right' ];
		const DEFAULT = acf.get('rtl') ? 'right' : 'left';
		return ALIGNMENTS.includes( align ) ? align : DEFAULT;
	}

	/**
	 * Returns a valid matrix alignment.
	 *
	 * Written for "upgrade-path" compatibility from vertical alignment to matrix alignment. 
	 * 
	 * @date	07/08/2020
	 * @since	5.9.0
	 *
	 * @param	string align A matrix alignment.
	 * @return	string
	 */
	function validateMatrixAlignment( align ) {
		const DEFAULT = 'center center';
		if( align ) {
			const [ y, x ] = align.split(' ');
			return validateVerticalAlignment( y ) + ' ' + validateHorizontalAlignment( x );
		}
		return DEFAULT;
	}

	// Dependencies.
	const { AlignmentToolbar, BlockVerticalAlignmentToolbar } = wp.blockEditor;
	const BlockAlignmentMatrixToolbar = ( wp.blockEditor.__experimentalBlockAlignmentMatrixToolbar || wp.blockEditor.BlockAlignmentMatrixToolbar );
	// Gutenberg v10.x begins transition from Toolbar components to Control components.
	const BlockAlignmentMatrixControl = ( wp.blockEditor.__experimentalBlockAlignmentMatrixControl || wp.blockEditor.BlockAlignmentMatrixControl );

	/**
	 * Appends extra attributes for block types that support align_content.
	 *
	 * @date	08/07/2020
	 * @since	5.9.0
	 *
	 * @param	object attributes The block type attributes.
	 * @return	object
	 */
	function withAlignContentAttributes( attributes ) {
		attributes.align_content = {
			type: 'string'
		};
		return attributes;
	}

	/**
	 * A higher order component adding align_content editing functionality.
	 *
	 * @date	08/07/2020
	 * @since	5.9.0
	 *
	 * @param	component OriginalBlockEdit The original BlockEdit component.
	 * @param	object blockType The block type settings.
	 * @return	component
	 */
	function withAlignContentComponent( OriginalBlockEdit, blockType ) {

		// Determine alignment vars
		let type = blockType.supports.align_content;
		let AlignmentComponent, validateAlignment;
		switch( type ) {
			case 'matrix':
				AlignmentComponent = ( BlockAlignmentMatrixControl || BlockAlignmentMatrixToolbar );
				validateAlignment = validateMatrixAlignment;
				break;
			default:
				AlignmentComponent = BlockVerticalAlignmentToolbar;
				validateAlignment = validateVerticalAlignment;
				break;
		}

		// Ensure alignment component exists.
		if( AlignmentComponent === undefined ) {
			console.warn( `The "${type}" alignment component was not found.` );
			return OriginalBlockEdit;
		}
		
		// Ensure correct block attribute data is sent in intial preview AJAX request.
		blockType.align_content = validateAlignment( blockType.align_content );

		// Return wrapped component.
		return class WrappedBlockEdit extends Component {
			render() {
				const { attributes, setAttributes } = this.props;
				const { align_content } = attributes;
				function onChangeAlignContent( align_content ) {
					setAttributes({ 
						align_content: validateAlignment(align_content)
					});
				}
				return ( 
					<Fragment>
						<BlockControls group="block">
							<AlignmentComponent
								label={ acf.__( 'Change content alignment' ) }
								value={ validateAlignment(align_content) }
								onChange={ onChangeAlignContent }
							/>
						</BlockControls>
						<OriginalBlockEdit {...this.props} />
					</Fragment>
				);
			}
		}
	}

	/**
	 * Appends extra attributes for block types that support align_text.
	 *
	 * @date	08/07/2020
	 * @since	5.9.0
	 *
	 * @param	object attributes The block type attributes.
	 * @return	object
	 */
	function withAlignTextAttributes( attributes ) {
		attributes.align_text = {
			type: 'string'
		};
		return attributes;
	}

	/**
	 * A higher order component adding align_text editing functionality.
	 *
	 * @date	08/07/2020
	 * @since	5.9.0
	 *
	 * @param	component OriginalBlockEdit The original BlockEdit component.
	 * @param	object blockType The block type settings.
	 * @return	component
	 */
	function withAlignTextComponent( OriginalBlockEdit, blockType ) {
		const validateAlignment = validateHorizontalAlignment;

		// Ensure correct block attribute data is sent in intial preview AJAX request.
		blockType.align_text = validateAlignment( blockType.align_text );

		// Return wrapped component.
		return class WrappedBlockEdit extends Component {
			render() {
				const { attributes, setAttributes } = this.props;
				const { align_text } = attributes;

				function onChangeAlignText( align_text ) {
					setAttributes({ 
						align_text: validateAlignment(align_text)
					});
				}

				return (
					<Fragment>
						<BlockControls>
							<AlignmentToolbar
								value={ validateAlignment(align_text) }
								onChange={ onChangeAlignText }
							/>
						</BlockControls>
						<OriginalBlockEdit {...this.props} />
					</Fragment>
				);
			}
		}
	}

})(jQuery);