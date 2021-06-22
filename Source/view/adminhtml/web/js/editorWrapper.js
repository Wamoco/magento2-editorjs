define([
    'Wamoco_EditorJS/js/editorjs/dist/main',
], function (EditorMain) {

    window.EditorJSPlugin = {
        instances: [],
        layoutDialogHidden: false,
        insertBlock: function(element) {
            var editor = tinyMceEditors.get(element.id);
            editor.insertNewBlock.bind(editor)();
        },
        getCurrentEditor: function() {
            let instances = window.EditorJSPlugin.instances;
            for (let i=0;i<instances.length;i++) {
                let editor = instances[instances.length-1-i];
                if (!editor.configuration.readOnly) {
                    return editor;
                }
            }
            return null;
        },
        getActiveBlock: function() {
            let editor = window.EditorJSPlugin.getCurrentEditor();
            if (!editor) {
                return null;
            }
            let activeBlock = editor.blocks.getBlockByIndex(editor.blocks.getCurrentBlockIndex());
            return activeBlock;
        },
        addInstance: function(instance) {
            window.EditorJSPlugin.instances.push(instance);
        },
        destroyLatestInstance: function() {
            window.EditorJSPlugin.instances.pop();
        },
        hideLayoutDialog: function() {
            window.EditorJSPlugin.layoutDialogHidden = true;
            jQuery('dialog').hide();
        },
        restoreLayoutDialog: function() {
            if (window.EditorJSPlugin.layoutDialogHidden) {
                jQuery('dialog').show();
                window.EditorJSPlugin.layoutDialogHidden = false;
            }
        }
    }

    const oldProto = EditorMain.EditorJS.prototype;
    const editor = function(...a) {
        let promise = EditorMain.EditorJS.prototype.constructor.bind(this)(...a);

        window.EditorJSPlugin.addInstance(this);

        this.isReady.then(function() {
            const originalFunction = this.destroy;
            this.destroy = function() {
                window.EditorJSPlugin.destroyLatestInstance();
                return originalFunction();
            }
        }.bind(this));
    }
    editor.prototype = oldProto;
    return editor;
});
