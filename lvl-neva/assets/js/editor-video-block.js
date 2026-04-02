( function ( wp ) {
	if ( ! wp || ! wp.blocks || ! wp.blockEditor || ! wp.components || ! wp.element ) {
		return;
	}

	const { __ } = wp.i18n;
	const { registerBlockType } = wp.blocks;
	const { Fragment, createElement: el } = wp.element;
	const { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } = wp.blockEditor;
	const { PanelBody, Button, TextControl, BaseControl } = wp.components;

	const playIcon = el(
		"svg",
		{
			width: "2.4rem",
			height: "2.4rem",
			viewBox: "0 0 24 24",
			fill: "none",
			xmlns: "http://www.w3.org/2000/svg",
		},
		el( "path", {
			d: "M18.4473 11.1055V12.8945L8.44727 17.8945L7 17V7L8.44727 6.10547L18.4473 11.1055Z",
			stroke: "var(--Primary, #31572C)",
			strokeWidth: "2",
			strokeLinejoin: "bevel",
		} )
	);

	registerBlockType( "lvl-neva/video-player", {
		apiVersion: 2,
		title: __( "Видео-плеер", "lvl-neva" ),
		description: __(
			"Блок видео с превью-изображением и запуском по клику.",
			"lvl-neva"
		),
		icon: "format-video",
		category: "lvl-neva",
		attributes: {
			videoUrl: {
				type: "string",
				default: "",
			},
			previewId: {
				type: "number",
				default: 0,
			},
			previewUrl: {
				type: "string",
				default: "",
			},
			previewAlt: {
				type: "string",
				default: "",
			},
		},
		edit: function ( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps( {
				className: "div flex-direction-vertical size-width-full video-player-block",
			} );

			const onSelectImage = function ( media ) {
				setAttributes( {
					previewId: media && media.id ? media.id : 0,
					previewUrl: media && media.url ? media.url : "",
					previewAlt: media && media.alt ? media.alt : "",
				} );
			};

			const onRemoveImage = function () {
				setAttributes( {
					previewId: 0,
					previewUrl: "",
					previewAlt: "",
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
							title: __( "Настройки видео", "lvl-neva" ),
							initialOpen: true,
						},
						el( TextControl, {
							label: __( "Ссылка на видео", "lvl-neva" ),
							help: __(
								"Поддерживаются YouTube, Rutube, VK Video и прямые ссылки на mp4/webm.",
								"lvl-neva"
							),
							value: attributes.videoUrl || "",
							onChange: function ( value ) {
								setAttributes( { videoUrl: value } );
							},
						} ),
						el(
							BaseControl,
							{ label: __( "Превью-изображение", "lvl-neva" ) },
							el(
								MediaUploadCheck,
								null,
								el( MediaUpload, {
									onSelect: onSelectImage,
									allowedTypes: [ "image" ],
									value: attributes.previewId,
									render: function ( mediaUploadProps ) {
										return el(
											Button,
											{
												variant: "secondary",
												onClick: mediaUploadProps.open,
											},
											attributes.previewUrl
												? __( "Заменить изображение", "lvl-neva" )
												: __( "Выбрать изображение", "lvl-neva" )
										);
									},
								} )
							),
							attributes.previewUrl
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
					el(
						"div",
						{ className: "div video-player-block__frame border-radius" },
						el(
							"div",
							{ className: "image size-full-percentage video-player-block__preview-wrap" },
							attributes.previewUrl
								? el( "img", {
										src: attributes.previewUrl,
										alt: attributes.previewAlt || "",
										className: "image__img video-player-block__preview",
								  } )
								: el(
										"div",
										{ className: "video-player-block__placeholder" },
										__( "Выберите изображение-превью", "lvl-neva" )
								  )
						),
						el(
							"button",
							{
								type: "button",
								className: "video-player-block__play border-radius",
								"aria-label": __( "Воспроизвести видео", "lvl-neva" ),
								disabled: true,
							},
							playIcon
						),
						el( "div", { className: "video-player-block__embed-wrap" } )
					),
					! attributes.videoUrl
						? el(
								"p",
								{ className: "video-player-block__editor-help" },
								__(
									"Добавьте ссылку на видео в настройках блока.",
									"lvl-neva"
								)
						  )
						: null
				)
			);
		},
		save: function () {
			return null;
		},
	} );
} )( window.wp );
