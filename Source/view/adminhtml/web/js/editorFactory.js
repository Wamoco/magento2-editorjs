define([
    'Wamoco_EditorJS/js/editorjs/dist/main',
    'Wamoco_EditorJS/js/editorWrapper',
], function (EditorMain, Wrapper) {

    return function(editorAdapter, data, onReady) {
        var EditorJS = Wrapper;

        var tools = {
            hyperlink: {
                class: EditorMain.Hyperlink,
                config: {
                    shortcut: 'CMD+L',
                    target: '_blank',
                    rel: 'nofollow',
                    availableTargets: ['_blank', '_self'],
                    availableRels: ['author', 'noreferrer'],
                    validate: false,
                }
            },
            delimiter: {
                class: EditorMain.Delimiter
            },
            header: {
                class: EditorMain.Header
            },
            list: {
                class: EditorMain.List
            },
            image: {
                class: EditorMain.ImageTool,
                config: {
                    endpoints: {
                        byFile: editorAdapter.config.image_upload_url,
                        byUrl: editorAdapter.config.image_upload_url,
                    },
                    onSelectFile: function() {
                        window.EditorJSPlugin.hideLayoutDialog();

                        var blocks = window.EditorJSPlugin.getCurrentEditor().blocks;
                        editorAdapter.currentBlockIndex = blocks.getCurrentBlockIndex();
                        MediabrowserUtility.openDialog(editorAdapter.config.files_browser_window_url, null, null, null, {targetElementId: editorAdapter.id});
                    }.bind(editorAdapter)
                }
            },
            raw: {
                class: EditorMain.RawTool
            },
            magentoWidget: {
                class: EditorMain.MagentoWidget,
                config: {
                    windowUrl: editorAdapter.getWindowUrl(),
                    editorId: editorAdapter.id
                }
            },

        };

        var editorJSConfig = {
            tools: tools
        };

        return new EditorJS({
            holder: editorAdapter.getEditorPane().id,
            readOnly: false,
            tools: {
                hyperlink: {
                    class: EditorMain.Hyperlink,
                    config: {
                        shortcut: 'CMD+L',
                        target: '_blank',
                        rel: 'nofollow',
                        availableTargets: ['_blank', '_self'],
                        availableRels: ['author', 'noreferrer'],
                        validate: false,
                    }
                },
                delimiter: {
                    class: EditorMain.Delimiter
                },
                header: {
                    class: EditorMain.Header
                },
                list: {
                    class: EditorMain.List
                },
                image: {
                    class: EditorMain.ImageTool,
                    config: {
                        endpoints: {
                            byFile: editorAdapter.config.image_upload_url,
                            byUrl: editorAdapter.config.image_upload_url,
                        },
                        onSelectFile: function() {
                            var blocks = window.EditorJSPlugin.getCurrentEditor().blocks;
                            editorAdapter.currentBlockIndex = blocks.getCurrentBlockIndex();
                            MediabrowserUtility.openDialog(editorAdapter.config.files_browser_window_url, null, null, null, {targetElementId: editorAdapter.id});
                        }.bind(editorAdapter)
                    }
                },
                raw: {
                    class: EditorMain.RawTool
                },
                magentoWidget: {
                    class: EditorMain.MagentoWidget,
                    config: {
                        windowUrl: editorAdapter.getWindowUrl(),
                        editorId: editorAdapter.id
                    }
                },
                twoColumns: {
                    class: EditorMain.EditorJSLayout.LayoutBlockTool,
                    config: {
                        EditorJS,
                        editorJSConfig,
                        readOnly: false,
                        enableLayoutEditing: false,
                        enableLayoutSaving: false,
                        initialData: {
                            itemContent: {
                                1: {
                                    blocks: [],
                                },
                                2: {
                                    blocks: [],
                                },
                            },
                            layout: {
                                type: "container",
                                id: "",
                                className: "",
                                style:
                                "border: 1px solid #000000; display: flex; justify-content: space-around; padding: 16px; ",
                                children: [
                                    {
                                        type: "item",
                                        id: "",
                                        className: "",
                                        style: "border: 1px solid #000000; padding: 8px; ",
                                        itemContentId: "1",
                                    },
                                    {
                                        type: "item",
                                        id: "",
                                        className: "",
                                        style: "border: 1px solid #000000; padding: 8px; ",
                                        itemContentId: "2",
                                    },
                                ],
                            },
                        },
                    },
                    shortcut: "CMD+2",
                    toolbox: {
                        icon: `
                      <svg xmlns='http://www.w3.org/2000/svg' width="16" height="16" viewBox='0 0 512 512'>
                        <rect x='128' y='128' width='336' height='336' rx='57' ry='57' fill='none' stroke='currentColor' stroke-linejoin='round' stroke-width='32'/>
                        <path d='M383.5 128l.5-24a56.16 56.16 0 00-56-56H112a64.19 64.19 0 00-64 64v216a56.16 56.16 0 0056 56h24' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/>
                      </svg>
                    `,
                        title: "2 columns",
                    },
                },
            },
            onChange: editorAdapter.onChange.bind(editorAdapter),
            onReady: onReady,
            data: data
        });
    };
})
