( function ( wp ) {
	if ( ! wp || ! wp.blocks || ! wp.blockEditor || ! wp.components || ! wp.element ) {
		return;
	}

	const { __ } = wp.i18n;
	const { registerBlockType } = wp.blocks;
	const { Fragment, createElement: el } = wp.element;
	const { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } = wp.blockEditor;
	const { PanelBody, Button, BaseControl } = wp.components;

	registerBlockType( "lvl-neva/equipment-image", {
		apiVersion: 2,
		title: __( "Фото", "lvl-neva" ),
		description: __( "Изображение в стиле статьи.", "lvl-neva" ),
		icon: "format-image",
		category: "lvl-neva",
		attributes: {
			imageId: {
				type: "number",
				default: 0,
			},
			imageUrl: {
				type: "string",
				default: "",
			},
			imageAlt: {
				type: "string",
				default: "",
			},
		},
		edit: function ( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps( {
				className: "lvl-neva-equipment-image-block",
			} );

			const onSelectImage = function ( media ) {
				setAttributes( {
					imageId: media && media.id ? media.id : 0,
					imageUrl: media && media.url ? media.url : "",
					imageAlt: media && media.alt ? media.alt : "",
				} );
			};

			const onRemoveImage = function () {
				setAttributes( {
					imageId: 0,
					imageUrl: "",
					imageAlt: "",
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
							title: __( "Настройки фото", "lvl-neva" ),
							initialOpen: true,
						},
						el(
							BaseControl,
							{ label: __( "Изображение", "lvl-neva" ) },
							el(
								MediaUploadCheck,
								null,
								el( MediaUpload, {
									onSelect: onSelectImage,
									allowedTypes: [ "image" ],
									value: attributes.imageId,
									render: function ( mediaUploadProps ) {
										return el(
											Button,
											{
												variant: "secondary",
												onClick: mediaUploadProps.open,
											},
											attributes.imageUrl
												? __( "Заменить изображение", "lvl-neva" )
												: __( "Выбрать изображение", "lvl-neva" )
										);
									},
								} )
							),
							attributes.imageUrl
								? el(
										Button,
										{
											variant: "tertiary",
											onClick: onRemoveImage,
											style: { marginTop: "12px" },
										},
										__( "Удалить изображение", "lvl-neva" )
								  )
								: null
						)
					)
				),
				el(
					"div",
					blockProps,
					attributes.imageUrl
						? el( "img", {
								className: "equipment-article__image border-radius",
								src: attributes.imageUrl,
								alt: attributes.imageAlt || "",
						  } )
						: el(
								"div",
								{ className: "lvl-neva-equipment-image-block__placeholder border-radius" },
								__( "Выберите изображение", "lvl-neva" )
						  )
				)
			);
		},
		save: function () {
			return null;
		},
	} );
} )( window.wp );
