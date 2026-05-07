( function ( wp ) {
	if ( ! wp || ! wp.blocks || ! wp.blockEditor || ! wp.components || ! wp.element ) {
		return;
	}

	const { __ } = wp.i18n;
	const { registerBlockType } = wp.blocks;
	const { Fragment, createElement: el } = wp.element;
	const { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } = wp.blockEditor;
	const { PanelBody, Button, BaseControl } = wp.components;

	const normalizeImages = function ( mediaItems ) {
		const items = Array.isArray( mediaItems ) ? mediaItems : mediaItems ? [ mediaItems ] : [];

		return items
			.filter( function ( item ) {
				return item && item.url;
			} )
			.map( function ( item ) {
				return {
					id: item.id || 0,
					url: item.url || "",
					alt: item.alt || "",
					title: item.title || "",
				};
			} );
	};

	registerBlockType( "lvl-neva/gallery-slider", {
		apiVersion: 2,
		title: __( "Слайдер галереи", "lvl-neva" ),
		description: __( "Галерея в стиле проектного слайдера.", "lvl-neva" ),
		icon: "images-alt2",
		category: "lvl-neva",
		attributes: {
			sliderId: {
				type: "string",
				default: "",
			},
			images: {
				type: "array",
				default: [],
			},
		},
		edit: function ( props ) {
			const { attributes, setAttributes, clientId } = props;
			const images = Array.isArray( attributes.images ) ? attributes.images : [];
			const selectedImageIds = images
				.map( function ( image ) {
					return image && image.id ? image.id : 0;
				} )
				.filter( Boolean );

			if ( ! attributes.sliderId ) {
				setAttributes( {
					sliderId: "lvl-neva-gallery-slider-" + String( clientId || "" ).replace( /-/g, "" ).slice( 0, 8 ),
				} );
			}

			const blockProps = useBlockProps( {
				className: "lvl-neva-gallery-slider-block",
			} );

			const onSelectImages = function ( mediaItems ) {
				setAttributes( {
					images: normalizeImages( mediaItems ),
				} );
			};

			const onClearImages = function () {
				setAttributes( { images: [] } );
			};

			const onRemoveImage = function ( indexToRemove ) {
				setAttributes( {
					images: images.filter( function ( image, index ) {
						return index !== indexToRemove;
					} ),
				} );
			};

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{
							title: __( "Настройки слайдера", "lvl-neva" ),
							initialOpen: true,
						},
						el(
							BaseControl,
							{ label: __( "Изображения галереи", "lvl-neva" ) },
							el(
								MediaUploadCheck,
								null,
								el( MediaUpload, {
									onSelect: onSelectImages,
									allowedTypes: [ "image" ],
									multiple: true,
									gallery: true,
									value: selectedImageIds,
									render: function ( mediaUploadProps ) {
										return el(
											Button,
											{
												variant: "secondary",
												onClick: mediaUploadProps.open,
											},
											images.length
												? __( "Изменить галерею", "lvl-neva" )
												: __( "Выбрать изображения", "lvl-neva" )
										);
									},
								} )
							),
							images.length
								? el(
										"p",
										{ className: "lvl-neva-gallery-slider-block__editor-panel-note" },
										__( "Слайдов в галерее:", "lvl-neva" ) + " " + images.length
								  )
								: null,
							images.length
								? el(
										Button,
										{
											variant: "tertiary",
											onClick: onClearImages,
											style: { marginTop: "12px" },
										},
										__( "Очистить галерею", "lvl-neva" )
								  )
								: null
						)
					)
				),
				el(
					"div",
					blockProps,
					el(
						"div",
						{ className: "lvl-neva-gallery-slider-block__editor-shell border-radius" },
						el(
							"div",
							{ className: "lvl-neva-gallery-slider-block__editor-toolbar" },
							el(
								"div",
								{ className: "lvl-neva-gallery-slider-block__editor-toolbar-meta" },
								el(
									"span",
									{ className: "lvl-neva-gallery-slider-block__editor-toolbar-title" },
									__( "Слайдер галереи", "lvl-neva" )
								),
								el(
									"span",
									{ className: "lvl-neva-gallery-slider-block__editor-toolbar-count" },
									images.length
										? __( "Слайдов:", "lvl-neva" ) + " " + images.length
										: __( "Изображения не выбраны", "lvl-neva" )
								)
							),
							el(
								"div",
								{ className: "lvl-neva-gallery-slider-block__editor-toolbar-actions" },
								el(
									MediaUploadCheck,
									null,
									el( MediaUpload, {
										onSelect: onSelectImages,
										allowedTypes: [ "image" ],
										multiple: true,
										gallery: true,
										value: selectedImageIds,
										render: function ( mediaUploadProps ) {
											return el(
												Button,
												{
													variant: "secondary",
													onClick: mediaUploadProps.open,
												},
												images.length
													? __( "Изменить", "lvl-neva" )
													: __( "Выбрать", "lvl-neva" )
											);
										},
									} )
								),
								images.length
									? el(
											Button,
											{
												variant: "tertiary",
												isDestructive: true,
												onClick: onClearImages,
											},
											__( "Очистить", "lvl-neva" )
									  )
									: null
							)
						),
						images.length
							? el(
									"div",
									{ className: "lvl-neva-gallery-slider-block__editor-grid" },
									images.map( function ( image, index ) {
										return el(
											"div",
											{
												className: "lvl-neva-gallery-slider-block__editor-grid-item",
												key: "manage-" + ( image.id || image.url || index ),
											},
											el(
												"div",
												{ className: "lvl-neva-gallery-slider-block__editor-grid-image-wrap" },
												el( "img", {
													src: image.url,
													alt: image.alt || "",
													className: "lvl-neva-gallery-slider-block__editor-grid-image",
												} ),
												el(
													"span",
													{ className: "lvl-neva-gallery-slider-block__editor-grid-index" },
													index + 1
												)
											),
											el(
												"div",
												{ className: "lvl-neva-gallery-slider-block__editor-grid-footer" },
												el(
													"span",
													{ className: "lvl-neva-gallery-slider-block__editor-grid-title" },
													image.title || __( "Изображение", "lvl-neva" )
												),
												el(
													Button,
													{
														isDestructive: true,
														variant: "tertiary",
														className: "lvl-neva-gallery-slider-block__editor-grid-remove",
														onClick: function () {
															onRemoveImage( index );
														},
													},
													__( "Удалить", "lvl-neva" )
												)
											)
										);
									} )
							  )
							: el(
									"div",
									{ className: "lvl-neva-gallery-slider-block__placeholder border-radius" },
									__( "Выберите изображения для слайдера", "lvl-neva" )
							  )
					)
				)
			);
		},
		save: function () {
			return null;
		},
	} );
} )( window.wp );
