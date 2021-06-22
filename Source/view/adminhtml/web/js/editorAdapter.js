define([
    'jquery',
    'underscore',
    'Wamoco_EditorJS/js/editorFactory',
    'mage/translate',
    'prototype',
    'mage/adminhtml/events',
    'jquery/ui'
], function (jQuery, _, createEditor) {

    var editor = Class.create();

    var instances = [];

    // let editor = window.tinyMceEditors.get('cms_page_form_content').editorJSInstance;
    // let blocks = editor.blocks;
    // let activeBlock = blocks.getBlockByIndex(blocks.getCurrentBlockIndex());

    window.tinyMceEditors = {
        get: function(id) {
            return instances[id];
        }
    };


    editor.prototype = {
        imageBrowserTransferInput: null,
        id: null,
        config: null,
        editorJSInstance: null,

        /**
         * @param {*} htmlId
         * @param {Object} config
         */
        initialize: function (htmlId, config) {
            this.id = htmlId;
            this.config = config;

            imageBrowserTransferInput = document.createElement('input');
            imageBrowserTransferInput.id = htmlId + '_media';
            imageBrowserTransferInput.style.display = 'none';
            imageBrowserTransferInput.setAttribute('data-force_static_path', '1');

            var textArea = this.getTextArea();
            var targetNode = textArea.parentNode;
            targetNode.insert(imageBrowserTransferInput);

            jQuery("#"+htmlId+"_media").change(function() {
                var imageUrl = jQuery("#"+imageBrowserTransferInput.id).val();
                // make it empty, because this callback gets triggered multiple times
                jQuery("#"+imageBrowserTransferInput.id).val("")
                if (imageUrl != "") {
                    var blocks = window.EditorJSPlugin.getCurrentEditor().blocks;
                    var activeBlock = blocks.getBlockByIndex(this.currentBlockIndex || blocks.getCurrentBlockIndex());

                    if (activeBlock) {
                        activeBlock.call("selectFile", imageUrl );
                    } else {
                        blocks.insert("image", {file: {url: imageUrl }}, {}, blocks.getBlocksCount()+1);
                    }

                    window.EditorJSPlugin.restoreLayoutDialog();
                }
            }.bind(this));

            instances[htmlId] = this;
        },

        insertNewBlock: function() {
            var blocks = window.EditorJSPlugin.getCurrentEditor().blocks;
            blocks.insert("paragraph", {}, {}, blocks.getBlocksCount()+1);
        },

        initEditor: function() {
            var self = this;
            var data = {};

            try {
                if (this.getTextArea().value != "") {
                    data = JSON.parse(this.getTextArea().value);
                }

                this.editorJSInstance = createEditor(this, data, function() {
                    // document.getElementsByClassName("codex-editor__redactor")[0].addEventListener('click', self.insertNewBlock.bind(self));
                });
            } catch (err) {
                console.error(err);
            }
        },

        getEditorPane: function() {
            var editorPane = document.getElementById(this.id + '_editorjs');
            return editorPane;
        },

        getTextArea: function() {
            var textArea = document.getElementById(this.id);
            return textArea;
        },

        onChange: function() {
            this.updateTextArea();
        },

        getWindowUrl: function() {
            var magentowidget = _.filter(this.config.plugins, function(plugin) { return plugin.name == "magentowidget"})[0];
            if (magentowidget) {
                return magentowidget.options.window_url;
            }
        },

        /**
         * @param {*} mode
         */
        setup: function (mode) {
            this.initEditor();
            this.turnOn();
        },

        /**
         * Insert content to active editor.
         *
         * @param {String} content
         * @param {Boolean} ui
         */
        insertContent: function (content, ui) {
            var activeBlock = window.EditorJSPlugin.getActiveBlock();
            var widgetData= jQuery(content).attr('title');

            if (!activeBlock) {
                blocks.insert("magentoWidget", {}, {}, blocks.getBlocksCount()+1);
                activeBlock = blocks.getBlockByIndex(blocks.getBlocksCount()-1);
            }

            if (activeBlock) {
                activeBlock.call('decodeWidgetCode', widgetData);
            }
            window.EditorJSPlugin.restoreLayoutDialog();
        },

        /**
         * @param {Object} o
         */
        openFileBrowser: function (o) {
        },

        /**
         * Encodes the content so it can be inserted into the wysiwyg
         * @param {String} content - The content to be encoded
         *
         * @returns {*} - The encoded content
         */
        updateContent: function (content) {
        },

        /**
         * On form validation.
         */
        onFormValidation: function () {
        },

        /**
         * @param {String} id
         */
        get: function (id) {
            return instances[id];
        },

        /**
         * @return {Object}
         */
        activeEditor: function () {
            var instance = window.EditorJSPlugin.getCurrentEditor();
            var blocks      = instance.blocks;
            var activeBlock = blocks.getBlockByIndex(blocks.getCurrentBlockIndex());

            instance.getBookmark = function () {
                return null;
            };
            instance.moveToBookmark = function () {
                return instance;
            };
            instance.setContent = function (content) {
                var widgetData= jQuery(content).attr('title');
                if (activeBlock) {
                    activeBlock.call('decodeWidgetCode', widgetData);
                }
                window.EditorJSPlugin.restoreLayoutDialog();
            }
            instance.getNode = function () {
                var id = null;
                if (activeBlock) {
                    // FIXME data access
                    id = activeBlock.holder.getElementsByClassName("ce-block__content")[0].childElements()[0].id
                }

                return {localName: null, firstElementChild: null, id: id};
            };
            instance.select    = function(){};
            instance.selection = instance;
            return instance;
        },

        /**
         * @param {*} mode
         * @return {tinyMceWysiwygSetup}
         */
        turnOn: function (mode) {
            try {
                this.editorJSInstance.blocks.render(JSON.parse(this.getTextArea().value));
            } catch (err) {
                console.log('parse failed: ', err)
            }

            if (this.getEditorPane()) {
                this.getTextArea().style.display   = 'none';
                this.getEditorPane().style.display = 'block';
                this.getPluginButtons().show();
            }

            return this;
        },

        /**
         * @return {tinyMceWysiwygSetup}
         */
        turnOff: function () {
            this.updateTextArea();
            this.getTextArea().style.display   = 'block';
            this.getEditorPane().style.display = 'none';
            this.getPluginButtons().hide();
            return this;
        },

        getPluginButtons: function () {
            return jQuery(".action-add-widget.plugin,.action-add-image.plugin,.action-add-block.plugin");
        },

        /**
         * Retrieve directives URL with substituted directive value.
         *
         * @param {String} directive
         */
        makeDirectiveUrl: function (directive) {

        },

        /**
         * @param {Object} content
         * @return {*}
         */
        encodeDirectives: function (content) {

        },

        /**
         * @param {Object} content
         * @return {*}
         */
        encodeWidgets: function (content) {

        },

        /**
         * @param {Object} content
         * @return {*}
         */
        decodeDirectives: function (content) {

        },

        /**
         * @param {Object} content
         * @return {*}
         */
        decodeWidgets: function (content) {

        },

        /**
         * @param {Object} attributes
         * @return {Object}
         */
        parseAttributesString: function (attributes) {

        },

        /**
         * Update text area.
         */
        updateTextArea: function () {
            var textArea = this.getTextArea();
            this.editorJSInstance.save().then(function (outputData) {
                jQuery(textArea).val(JSON.stringify(outputData)).trigger('change');
            }).catch(function (error) {
                console.log('Update failed: ', error)
            });
        },

        setCaretOnElement: function (targetElement) {
            this.activeEditor().selection.select(targetElement);
            this.activeEditor().selection.collapse();
        },

        /**
         * @param {Object} content
         * @return {*}
         */
        decodeContent: function (content) {

        },

        /**
         * @return {Boolean}
         */
        toggle: function () {
            if (this.getTextArea().style.display == 'block') {
                this.turnOn();
            } else {
                this.turnOff();
            }
        },

        /**
         * @param {Object} content
         * @return {*}
         */
        encodeContent: function (content) {

        },

        /**
         * @param {Object} o
         */
        beforeSetContent: function (o) {

        },

        /**
         * @param {Object} o
         */
        saveContent: function (o) {

        },

        /**
         * @returns {Object}
         */
        getAdapterPrototype: function () {
            return editor;
        },

        /**
         * Return the content stored in the WYSIWYG field
         * @param {String} id
         * @return {String}
         */
        getContent: function (id) {

        },

        focus: function() {
            // adminhtml/Magento/backend/en_US/mage/adminhtml/wysiwyg/widget.js
        },

        // pseudo
        fire: function(event) {
            // adminhtml/Magento/backend/en_US/mage/adminhtml/wysiwyg/widget.js
        },

        getMediaBrowserOpener: function () {
            return { closed: null, document: document };
        },

        getMediaBrowserTargetElementId: function () {
            return imageBrowserTransferInput.id;
        },
    };

    return editor.prototype;
});
